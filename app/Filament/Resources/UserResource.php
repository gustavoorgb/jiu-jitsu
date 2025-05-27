<?php

namespace App\Filament\Resources;

use App\Enums\BeltsEnum;
use App\Enums\UserStatusEnum;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'icon-user';

    public static function getSlug(): string
    {
        return 'usuario';
    }

    public static function getLabel(): ?string
    {
        return 'Usúario';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required(),

                        TextInput::make('email')
                            ->label('E-Mail')
                            ->required()
                            ->unique(User::class, 'email', ignoreRecord: true)
                            ->email(),

                        TextInput::make('phone')
                            ->label('Telefone')
                            ->required()
                            ->tel()
                            ->mask('(99) 99999-9999')
                            ->stripCharacters(['(', ')', ' ', '-'])
                            ->dehydrateStateUsing(fn ($state) => is_string($state) ? preg_replace('/\D/', '', $state) : null)
                            ->afterStateHydrated(function ($state, $component) {
                                if (strlen($state) === 11) {
                                    $component->state(
                                        preg_replace(
                                            '/(\d{2})(\d{5})(\d{4})/',
                                            '($1) $2-$3',
                                            $state),
                                    );
                                }
                            })
                            ->unique(User::class, 'phone', ignoreRecord: true),

                        TextInput::make('password')
                            ->label('Senha')
                            ->required()
                            ->password()
                            ->minLength(8)
                            ->revealable()
                            ->rule('regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/')
                            ->helperText('Mínimo 8 caracteres, com letras maiúsculas, minúsculas e números')
                            ->confirmed(),

                        TextInput::make('password_confirmation')
                            ->label('Confirmar Senha')
                            ->required()
                            ->revealable()
                            ->minLength(8)
                            ->password(),

                        Select::make('belt')
                            ->label('Faixa')
                            ->required()
                            ->options(collect(BeltsEnum::cases())
                                ->mapWithKeys(fn ($belt) => [$belt->value => $belt->label()])
                            )
                            ->enum(BeltsEnum::class),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#'),
                TextColumn::make('name')->searchable()->label('Nome'),
                TextColumn::make('email')->searchable()->label('E-Mail'),
                TextColumn::make('phone')->label('Telefone'),
                TextColumn::make('belt')
                    ->label('Faixa')
                    ->badge()
                    ->formatStateUsing(function ($state) {
                        $enum = $state instanceof BeltsEnum ? $state : BeltsEnum::tryFrom($state);

                        return $enum->label();
                    })
                    ->icon('icon-belt')
                    ->iconColor(function ($state) {
                        $enum = $state instanceof BeltsEnum ? $state : BeltsEnum::tryFrom($state);

                        return $enum->color();
                    })
                    ->Color(function ($state) {
                        $enum = $state instanceof BeltsEnum ? $state : BeltsEnum::tryFrom($state);

                        return $enum->color();
                    }),
                ToggleColumn::make('is_active')
                    ->label('Ativo')
                    ->onColor('success')
                    ->offColor('danger')
                    ->afterStateUpdated(function ($record, $state) {
                        Notification::make()
                            ->title('Situação de ativo atualizada com sucesso!')
                            ->success()
                            ->send();
                    }),

            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->label('Ativo')
                    ->options(UserStatusEnum::class)
                    ->attribute('is_active'),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

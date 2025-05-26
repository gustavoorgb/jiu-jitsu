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
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
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
                        TextInput::make('name')->label('Nome')->required(),
                        TextInput::make('email')->label('E-Mail')->required()->email(),
                        TextInput::make('phone')->label('Telefone')->required()->tel(),
                        TextInput::make('password')->label('Senha')->required()->password()->confirmed(),
                        TextInput::make('password_confirmation')->label('Confirmar Senha')->required()->password(),
                        Select::make('belt')->label('Faixa')->required()
                            ->options(collect(BeltsEnum::cases())
                                ->mapWithKeys(fn($belt) => [$belt->value => $belt->label()])
                    ),
                ])
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
                    ->formatStateUsing(function ($state){
                        $enum = $state instanceof BeltsEnum ? $state : BeltsEnum::tryFrom($state);
                        return $enum->label();
                    })
                    ->icon('icon-belt')
                    ->iconColor(function($state){
                        $enum = $state instanceof BeltsEnum ? $state : BeltsEnum::tryFrom($state);
                        return $enum->color();
                    })
                    ->Color(function($state){
                        $enum = $state instanceof BeltsEnum ? $state : BeltsEnum::tryFrom($state);
                        return $enum->color();
                    }),
                TextColumn::make('is_active')->label('Ativo')
                    ->badge()
                    ->formatStateUsing(function ($state){
                        $enum = $state instanceof UserStatusEnum ? $state : UserStatusEnum::tryFrom($state);
                        return $enum->label();
                    })
                    ->color(function ($state){
                        $enum = $state instanceof UserStatusEnum ? $state : UserStatusEnum::tryFrom($state);
                        return $enum::ATIVADO ? 'success' : 'danger';
                    }),

            ])
            ->filters([
                //
            ])
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

<?php

namespace App\Filament\Resources;

use App\Enums\BeltsEnum;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                        Select::make('belt')->required()
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
                //
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

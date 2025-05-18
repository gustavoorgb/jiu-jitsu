<?php

namespace App\Filament\Resources;

use App\Enums\Roles;
use App\Filament\Resources\UserRoleResource\Pages;
use App\Filament\Resources\UserRoleResource\RelationManagers;
use App\Models\Academy;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserRoleResource extends Resource {
    protected static ?string $model = UserRole::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getSlug(): string {
        return 'usuario-funcao';
    }

    public static function form(Form $form): Form {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Usúario')
                    ->required()
                    ->options(User::pluck('name', 'id')),

                Select::make('academy_id')
                    ->label('Academia')
                    ->required()
                    ->options(Academy::pluck('name', 'id')),

                Select::make('role_id')
                    ->label('Papel na Academia')
                    ->required()
                    ->options(
                        collect(Roles::cases())
                            ->mapWithKeys(fn($role) => [$role->value => $role->label()])
                            ->toArray()
                    ),
            ]);
    }

    public static function table(Table $table): Table {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Usúario'),
                TextColumn::make('academy.name')->label('Academia'),
                TextColumn::make('role.role_label')->label('Papel')
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

    public static function getRelations(): array {
        return [
            //
        ];
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListUserRoles::route('/'),
            'create' => Pages\CreateUserRole::route('/create'),
            'edit' => Pages\EditUserRole::route('/{record}/edit'),
        ];
    }
}

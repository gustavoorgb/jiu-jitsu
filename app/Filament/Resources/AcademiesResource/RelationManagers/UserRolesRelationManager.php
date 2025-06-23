<?php

namespace App\Filament\Resources\AcademiesResource\RelationManagers;

use App\Enums\BeltsEnum;
use App\Enums\RolesEnum;
use App\Models\User;
use Closure;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class UserRolesRelationManager extends RelationManager
{
    protected static string $relationship = 'userRoles';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return 'Vínculos';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Usúario')
                    ->required()
                    ->visible(fn (string $context) => $context !== 'edit')
                    ->options(function () {
                        return User::whereDoesntHave('userRoles')
                            ->pluck('name', 'id')
                            ->toArray();
                    }),

                Select::make('role_id')
                    ->label('Papel na Academia')
                    ->required()
                    ->options(
                        collect(RolesEnum::cases())
                            ->mapWithKeys(fn ($role) => [$role->value => $role->label()])
                            ->toArray())
                    ->enum(RolesEnum::class)
                    ->rules([
                        fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                            $userId = $get('user_id');
                            $user = User::find($userId);
                            if (! $user) {
                                $fail('Usuário não encontrado.');
                            }
                            if (intval($value) === RolesEnum::INSTRUCTOR->value) {
                                $beltsForInstructor = [
                                    BeltsEnum::ROXA->value,
                                    BeltsEnum::MARROM->value,
                                    BeltsEnum::PRETA->value,
                                ];
                                if (! in_array($user->belt, $beltsForInstructor) && $value) {
                                    $fail("Aluno(a) {$user->name} não tem graduação suficiente para ser instrutor!");
                                }
                            }
                        },
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordAction(null)
            ->columns([
                TextColumn::make('user.name')->label('Usúario'),
                TextColumn::make('role.role_label')->label('Papel'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Adicionar Vínculo'),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

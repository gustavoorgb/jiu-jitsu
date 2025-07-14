<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcademiesResource\Pages;
use App\Filament\Resources\AcademiesResource\RelationManagers\AcademyAdressesRelationManager;
use App\Filament\Resources\AcademiesResource\RelationManagers\BranchesRelationManager;
use App\Filament\Resources\AcademiesResource\RelationManagers\LessonRelationManager;
use App\Filament\Resources\AcademiesResource\RelationManagers\UserRolesRelationManager;
use App\Models\Academy;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AcademiesResource extends Resource
{
    protected static ?string $model = Academy::class;

    protected static ?string $navigationIcon = 'icon-martial-arts';

    public static function getSlug(): string
    {
        return 'academias';
    }

    public static function getLabel(): string
    {
        return 'Academia';
    }

    public static function getRecordTitle(?Model $record): string|null|Htmlable
    {
        return $record?->name;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Nome da academia'),

                        Forms\Components\TextInput::make('confederation')
                            ->maxLength(255)
                            ->label('Confederação'),
                        Forms\Components\TextInput::make('description')
                            ->maxLength(255)
                            ->label('Descrição'),
                        Forms\Components\Hidden::make('parent_academy_id')
                            ->default(request('parent_academy_id')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->modifyQueryUsing(function (Builder $query) {
                $parentId = request()->query('parent_academy_id');

                return $query
                    ->when($parentId, fn ($q) => $q->where('parent_academy_id', $parentId))
                    ->when(is_null($parentId), fn ($q) => $q->whereNull('parent_academy_id'));
            })
            ->columns([
                TextColumn::make('name')->searchable()->label('Nome'),
                TextColumn::make('confederation')->searchable()->label('Confederação'),
                TextColumn::make('description')->searchable()->label('Descrição'),
                TextColumn::make('created_at')->dateTime()->label('Dt_Cadastro'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                        ->label('Editar'),
                    Tables\Actions\ViewAction::make(),

                    DeleteAction::make()->label('Deletar')
                        ->modalHeading('Confirmar exclusão')
                        ->modalDescription('Tem certeza que deseja deletar esta academia? Esta ação não pode ser desfeita.')
                        ->modalSubmitActionLabel('Deletar')
                        ->modalCancelActionLabel('Cancelar'),
                ]),

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
            AcademyAdressesRelationManager::class,
            LessonRelationManager::class,
            UserRolesRelationManager::class,
            BranchesRelationManager::class,
        ];
    }

    // protected function getAllRelationManagers(): array
    // {
    //     return [
    //         AcademyAdressesRelationManager::class,
    //         LessonRelationManager::class,
    //         UserRolesRelationManager::class,
    //         BranchesRelationManager::class,
    //     ];
    // }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAcademies::route('/'),
            'create' => Pages\CreateAcademies::route('/adicionar'),
            'view' => Pages\ViewAcademy::route('/{record}'),
            'edit' => Pages\EditAcademies::route('/{record}/editar'),
        ];
    }
}

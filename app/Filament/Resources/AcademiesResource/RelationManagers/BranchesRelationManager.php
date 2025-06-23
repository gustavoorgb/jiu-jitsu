<?php

namespace App\Filament\Resources\AcademiesResource\RelationManagers;

use App\Filament\Resources\AcademiesResource\Pages\ViewAcademy;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BranchesRelationManager extends RelationManager
{
    protected static string $relationship = 'branches';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return 'Filiais';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nome da academia'),

                TextInput::make('confederation')
                    ->maxLength(255)
                    ->label('Confederação'),
                TextInput::make('description')
                    ->maxLength(255)
                    ->label('Descrição'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->recordAction(null)
            ->columns([
                TextColumn::make('name')->searchable()->label('Nome'),
                TextColumn::make('confederation')->searchable()->label('Confederação'),
                TextColumn::make('description')->searchable()->label('Descrição'),
                TextColumn::make('created_at')->dateTime()->label('Dt_Cadastro'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()->label('Adicionar filial'),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                        ->label('Editar'),
                    ViewAction::make()->url(fn (Model $record) => ViewAcademy::getUrl(['record' => $record->id])),
                    DeleteAction::make()->label('Deletar')
                        ->modalHeading('Excluir filial')
                        ->modalDescription('Tem certeza que deseja excluir esta filial?')
                        ->modalSubmitActionLabel('Sim, excluir')
                        ->modalCancelActionLabel('Cancelar'),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

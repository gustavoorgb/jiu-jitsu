<?php

namespace App\Filament\Resources\AcademiesResource\RelationManagers;

use App\Enums\BeltsEnum;
use App\Filament\Resources\ClassSchedulesResource\Pages\EditClassSchedules;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class LessonRelationManager extends RelationManager
{
    protected static string $relationship = 'lessons';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return 'Aulas';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Aula')->placeholder('Ex: Aula infantil')->required(),
                TextInput::make('description')->label('Descrição')->nullable(),
                Select::make('min_belt')->label('Faixa mínima')->nullable()->options(collect(BeltsEnum::cases())
                    ->mapWithKeys(fn ($belt) => [$belt->value => $belt->label()])
                )
                    ->enum(BeltsEnum::class)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->recordAction(null)
            ->columns([
                TextColumn::make('name')->label('Aula'),
                TextColumn::make('description')->label('Descrição'),
                TextColumn::make('min_belt')->label('Faixa mínima')->formatStateUsing(function ($state) {
                    $enum = $state instanceof BeltsEnum ? $state : BeltsEnum::tryFrom($state);

                    return $enum->label();
                }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Adicionar Aula'),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->url(fn ($record) => route('filament.admin.resources.aula.edit', $record)),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // protected function getTableColumns(): array
    // {
    //     $columns = [
    //         TextColumn::make('name')->url(EditClassSchedules::getUrl()),
    //     ];

    //     return $columns;
    // }
}

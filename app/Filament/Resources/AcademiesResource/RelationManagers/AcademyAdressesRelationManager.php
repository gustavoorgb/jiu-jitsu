<?php

namespace App\Filament\Resources\AcademiesResource\RelationManagers;

use App\Models\City;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class AcademyAdressesRelationManager extends RelationManager
{
    protected static string $relationship = 'address';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return 'Endereços';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('street')->required()->label('Bairro')->maxLength(255),
                TextInput::make('cep')->label('CEP')->required()->mask('99999-999')->placeholder('00000-000')->maxLength(9)->dehydrateStateUsing(fn ($state) => preg_replace('/[^0-9]/', '', $state)),
                TextInput::make('number')->required()->label('Número')->maxLength(255),
                TextInput::make('complement')->label('Complemento')->maxLength(255),
                Select::make('city_id')->required()->label('Cidade')
                    ->searchable()
                    ->getSearchResultsUsing(function ($search) {
                        return City::where('city', 'like', "%{$search}%")
                            ->limit(10)->pluck('city', 'id');
                    })
                    ->getOptionLabelUsing(fn ($value) => City::find($value)->city),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordAction(null)
            ->columns([
                TextColumn::make('street')->label('Bairro'),
                TextColumn::make('number')->label('Número'),
                TextColumn::make('complement')->label('Complemento'),
                TextColumn::make('cep')->label('CEP')->formatStateUsing(fn ($state) => preg_replace('/(\d{5})(\d{3})/', '$1-$2', $state)),
                TextColumn::make('city.city')->label('Cidade'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Adicionar Endereço'),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()->label('Deletar')
                        ->modalHeading('Excluir endereço')
                        ->modalDescription('Tem certeza que deseja excluir este endereço?')
                        ->modalSubmitActionLabel('Sim, excluir')
                        ->modalCancelActionLabel('Cancelar'), ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

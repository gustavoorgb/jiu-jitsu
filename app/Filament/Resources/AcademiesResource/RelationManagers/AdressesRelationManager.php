<?php

namespace App\Filament\Resources\AcademiesResource\RelationManagers;

use App\Models\Academies;
use App\Models\City;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdressesRelationManager extends RelationManager {
    protected static string $relationship = 'adresses';
    protected static ?string $title = 'Endereços';

    public function form(Form $form): Form {
        return $form
            ->schema([
                TextInput::make('street')->required()->label('Bairro')->maxLength(255),
                TextInput::make('cep')->label('CEP')->mask('99999-999')->placeholder('00000-000')->maxLength(9)->dehydrateStateUsing(fn($state) => preg_replace('/[^0-9]/', '', $state)),
                TextInput::make('number')->required()->label('Número')->maxLength(255),
                TextInput::make('complement')->label('Complemento')->maxLength(255),
                Select::make('city_id')->label('Cidade')
                    ->searchable()
                    ->getSearchResultsUsing(function ($search) {
                        return City::where('city', 'like', "%{$search}%")
                            ->limit(10)->pluck('city', 'id');
                    })
                    ->getOptionLabelUsing(fn($value) => City::find($value)->name),
            ]);
    }

    public function table(Table $table): Table {
        return $table
            ->recordTitleAttribute('address')
            ->columns([
                TextColumn::make('street')->label('Bairro'),
                TextColumn::make('number')->label('Número'),
                TextColumn::make('complement')->label('Complemento'),
                TextColumn::make('cep')->label('CEP')->formatStateUsing(fn($state) => preg_replace('/(\d{5})(\d{3})/', '$1-$2', $state)),
                TextColumn::make('city.city')->label('Cidade'),
                TextColumn::make('academy.name')->label('Academia'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('adicionar')
                    ->modalHeading('Adicionar')
                    ->createAnother(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

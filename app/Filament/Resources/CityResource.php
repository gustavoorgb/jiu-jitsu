<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CityResource\Pages;
use App\Filament\Resources\CityResource\RelationManagers;
use App\Models\City;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CityResource extends Resource {
    protected static ?string $model = City::class;

    protected static ?string $navigationIcon = 'icon-city';

    public static function getSlug(): string {
        return 'cidade';
    }

    public static function getLabel(): string {
        return 'Cidades';
    }

    public static function form(Form $form): Form {
        return $form
            ->schema([
                Forms\Components\Select::make('state')
                    ->options(State::pluck('uf', 'id'))
                    ->rules(['required']),
                Forms\Components\TextInput::make('city')
                    ->required()
                    ->maxLength(255)
                    ->label('Cidade'),
                Forms\Components\TextInput::make('coordinate')
                    ->label('Coordenadas (lat,lng)')
                    ->rule('regex:/^-?\d{1,2}\.\d+,-?\d{1,3}\.\d+$/')
                    ->placeholder('Ex: -23.55052,-46.633308'),
            ]);
    }

    public static function table(Table $table): Table {
        return $table
            ->defaultPaginationPageOption(10)
            ->paginationPageOptions([10, 25, 50])
            ->columns([
                TextColumn::make('id')->label('#'),
                TextColumn::make('city')->searchable()->label('Cidade'),
                TextColumn::make('state.state')->label('Estado')->searchable(),
                TextColumn::make('coordinate')->searchable()->label('Coordenadas'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->label('Deletar'),
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
            'index' => Pages\ListCities::route('/listar'),
            'create' => Pages\CreateCity::route('/adicionar'),
            'edit' => Pages\EditCity::route('/{record}/editar'),
        ];
    }
}

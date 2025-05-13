<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcademyAddressResource\Pages;
use App\Filament\Resources\AcademyAddressResource\RelationManagers;
use App\Models\Academies;
use App\Models\AcademyAddress;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AcademyAddressResource extends Resource {
    protected static ?string $model = AcademyAddress::class;

    protected static ?string $navigationIcon = 'heroicon-s-map';

    public static function form(Form $form): Form {
        return $form
            ->schema([
                TextInput::make('street')->required()->label('Bairro')->maxLength(255),
                TextInput::make('cep')->label('CEP')->mask('99999-999')->placeholder('00000-000')->maxLength(9)->dehydrateStateUsing(fn($state) => preg_replace('/[^0-9]/', '', $state)),
                TextInput::make('number')->required()->label('Número')->maxLength(255),
                TextInput::make('complement')->label('Complemento')->maxLength(255),
                Select::make('academy.academy')->options(Academies::pluck('name', 'id'))->rules(['required']),

            ]);
    }

    public static function table(Table $table): Table {
        return $table
            ->columns([
                TextColumn::make('cep')->label('CEP')->formatStateUsing(fn($state) => preg_replace('/(\d{5})(\d{3})/', '$1-$2', $state)),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array {
        return [];
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListAcademyAddress::route('/'),
            'create' => Pages\CreateAcademyAddress::route('/adicionar'),
            'edit' => Pages\EditAcademyAddress::route('/{record}/editar'),
        ];
    }

    public static function getEloquentQuery(): Builder {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

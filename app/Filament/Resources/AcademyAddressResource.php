<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcademyAddressResource\Pages;
use App\Filament\Resources\AcademyAddressResource\RelationManagers;
use App\Filament\Traits\HasParentResource;
use App\Models\Academy;
use App\Models\AcademyAddress;
use App\Models\City;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class AcademyAddressResource extends Resource {
    protected static ?string $model = AcademyAddress::class;

    protected static ?string $navigationLabel = null;

    protected static bool $shouldRegisterNavigation = false;

     public static string $parentResource = AcademiesResource::class;

    public static function getRecordTitle(?Model $record): string|null|Htmlable
    {
        return $record?->street ?? 'Endereço';
    }

    public static function getNavigationItems(): array {
        return [];
    }

    public static function getSlug(): string {
        return 'academia-endereco';
    }

    public static function getLabel(): string {
        return 'Endereço';
    }

    public static function form(Form $form): Form {
        return $form
            ->schema([
                TextInput::make('street')->required()->label('Bairro')->maxLength(255),
                TextInput::make('cep')->label('CEP')->required()->mask('99999-999')->placeholder('00000-000')->maxLength(9)->dehydrateStateUsing(fn($state) => preg_replace('/[^0-9]/', '', $state)),
                TextInput::make('number')->required()->label('Número')->maxLength(255),
                TextInput::make('complement')->label('Complemento')->maxLength(255),
                Select::make('city_id')->required()->label('Cidade')
                    ->searchable()
                    ->getSearchResultsUsing(function ($search) {
                        return City::where('city', 'like', "%{$search}%")
                            ->limit(10)->pluck('city', 'id');
                    })
                    ->getOptionLabelUsing(fn($value) => City::find($value)->city),
                Hidden::make('academy_id')
                    ->default(fn ($livewire) => $livewire->parent?->id)
                    ->required()
            ]);
    }

    public static function table(Table $table): Table {
        return $table
            ->columns([
                TextColumn::make('street')->label('Bairro'),
                TextColumn::make('number')->label('Número'),
                TextColumn::make('complement')->label('Complemento'),
                TextColumn::make('cep')->label('CEP')->formatStateUsing(fn($state) => preg_replace('/(\d{5})(\d{3})/', '$1-$2', $state)),
                TextColumn::make('city.city')->label('Cidade'),
                TextColumn::make('academy.name')->label('Academia'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->url(
                        fn (Pages\ListAcademyAddress $livewire, Model $record): string => static::$parentResource::getUrl('academia-endereco.edit', [
                            'record' => $record,
                            'parent' => $livewire->parent,
                        ])
                    ),
                Tables\Actions\DeleteAction::make()->label('Deletar')
                    ->modalHeading('Excluir endereço')
                    ->modalDescription('Tem certeza que deseja excluir este endereço?')
                    ->modalSubmitActionLabel('Sim, excluir')
                    ->modalCancelActionLabel('Cancelar'),
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

    // public static function getPages(): array {
    //     return [
    //         'index' => Pages\ListAcademyAddress::route('/{academy}'),
    //         'create' => Pages\CreateAcademyAddress::route('/adicionar/{academy}'),
    //         'edit' => Pages\EditAcademyAddress::route('/{academy}/editar'),
    //     ];
    // }

    // public static function getEloquentQuery(): Builder {
    //    return parent::getEloquentQuery()->where('academy_id', request('academy'));
    // }
}

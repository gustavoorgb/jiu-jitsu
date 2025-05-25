<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AcademiesResource\Pages;
use App\Filament\Resources\AcademyAddressResource\Pages\CreateAcademyAddress;
use App\Filament\Resources\AcademyAddressResource\Pages\EditAcademyAddress;
use App\Filament\Resources\AcademyAddressResource\Pages\ListAcademyAddress;
use Filament\Facades\Filament;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use App\Models\Academy;
use App\Models\AcademyAddress;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AcademiesResource extends Resource {
    protected static ?string $model = Academy::class;

    protected static ?string $navigationIcon = 'icon-martial-arts';

    public static function getSlug(): string {
        return 'academias';
    }

    public static function getLabel(): string {
        return 'Academia';
    }

    public static function getRecordTitle(?Model $record): string|null|Htmlable
    {
        return $record->name;
    }

    public static function getNavigationBadge(): ?string {
        return static::getModel()::count() . ' Academias';
    }

    public static function form(Form $form): Form {
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

                    ])
            ]);
    }

    public static function table(Table $table): Table {
        return $table
            ->columns([
                TextColumn::make('id')->label('#'),
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

                    Action::make('enderecos')
                        ->label('Endereços')
                        ->icon('heroicon-o-building-office-2')
                        ->url(fn (Academy $record) => static::getUrl('academia-endereco.index', ['parent' => $record->id]))
                        ->color('secondary'),

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

    public static function getPages(): array {
        return [
            'index' => Pages\ListAcademies::route('/'),
            'create' => Pages\CreateAcademies::route('/adicionar'),
            'edit' => Pages\EditAcademies::route('/{record}/editar'),

             // addresses
            'academia-endereco.index' => ListAcademyAddress::route('/{parent}/academia-endereco'),
            'academia-endereco.create' => CreateAcademyAddress::route('/{parent}/academia-endereco/adicionar'),
            'academia-endereco.edit' => EditAcademyAddress::route('/{parent}/academia-endereco/{record}/editar')
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassAttendanceResource\Pages;
use App\Models\ClassAttendance;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClassAttendanceResource extends Resource
{
    protected static ?string $model = ClassAttendance::class;

    protected static ?string $navigationLabel = null;

    protected static bool $shouldRegisterNavigation = false;

    public static function getNavigationItems(): array
    {
        return [];
    }

    public static function getSlug(): string
    {
        return 'aluno-frequencia';
    }

    public static function getLabel(): string
    {
        return 'Frequência';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClassAttendances::route('/frequencia'),
            'create' => Pages\CreateClassAttendance::route('/adicionar'),
            'edit' => Pages\EditClassAttendance::route('/{record}/editar'),
        ];
    }
}

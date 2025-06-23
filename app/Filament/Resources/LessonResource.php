<?php

namespace App\Filament\Resources;

use App\Enums\BeltsEnum;
use App\Filament\Resources\LessonResource\Pages\CreateLesson;
use App\Filament\Resources\LessonResource\Pages\EditLesson;
use App\Filament\Resources\LessonResource\Pages\ListLesson;
use App\Filament\Resources\LessonResource\RelationManagers\ClassScheduleRelationManager;
use App\Filament\Resources\LessonResource\RelationManagers\ClassUserRelationManager;
use App\Models\Lesson;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static ?string $navigationLabel = null;

    protected static bool $shouldRegisterNavigation = false;

    public static function getSlug(): string
    {
        return 'aula';
    }

    public static function getLabel(): string
    {
        return 'Aula';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')->label('Aula')->placeholder('Ex: Aula infantil')->required(),
                        TextInput::make('description')->label('Descrição')->nullable(),
                        Select::make('min_belt')->label('Faixa mínima')->nullable()->options(collect(BeltsEnum::cases())
                            ->mapWithKeys(fn ($belt) => [$belt->value => $belt->label()])
                        )
                            ->enum(BeltsEnum::class)
                            ->required(),
                    ]),

            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->modifyQueryUsing(function (Builder $query) {
                $academyId = request()->query('academy_id');

                return $query
                    ->when($academyId, fn ($q) => $q->where('academy_id', $academyId));

            })
            ->columns([
                TextColumn::make('academy.name')->label('Academia'),
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
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
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
            ClassScheduleRelationManager::class,
            ClassUserRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            // 'index' => ListLesson::route('/'),
            // 'create' => CreateLesson::route('/adicionar'),
            'edit' => EditLesson::route('/{record}/editar'),
        ];
    }
}

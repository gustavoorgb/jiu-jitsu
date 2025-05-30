<?php

namespace App\Filament\Resources;

use App\Enums\BeltsEnum;
use App\Filament\Resources\ClassSchedulesResource\Pages\CreateClassSchedules;
use App\Filament\Resources\ClassSchedulesResource\Pages\EditClassSchedules;
use App\Filament\Resources\ClassSchedulesResource\Pages\ListClassSchedules;
use App\Filament\Resources\JiuJitsuClassResource\Pages\CreateLesson;
use App\Filament\Resources\JiuJitsuClassResource\Pages\EditLesson;
use App\Filament\Resources\JiuJitsuClassResource\Pages\ListLesson;
use App\Models\Lesson;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static ?string $navigationLabel = null;

    protected static bool $shouldRegisterNavigation = false;

    public static string $parentResource = AcademiesResource::class;

    public static function getRecordTitle(?Model $record): string|null|Htmlable
    {
        return $record?->name;
    }

    public static function getNavigationItems(): array
    {
        return [];
    }

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
                        Hidden::make('academy_id')->default(fn ($livewire) => $livewire->parent?->id),
                        TextInput::make('name')->label('Aula')->placeholder('Ex: Aula infantil')->required(),
                        TextInput::make('description')->label('Descrição')->nullable(),
                        Select::make('min_belt')->label('Faixa mínima')->nullable()->options(collect(BeltsEnum::cases())
                            ->mapWithKeys(fn ($belt) => [$belt->value => $belt->label()])
                        )
                            ->enum(BeltsEnum::class),
                    ]),

            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
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
                    Action::make('horarios')
                        ->label('Horário de aulas')
                        ->icon('heroicon-o-clock')
                        ->url(fn (Lesson $record) => static::getUrl('aula-horario.index', [
                            'parent' => $record->id,
                        ]))
                        ->color('primary'),
                ]),
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
            'index' => ListLesson::route('/'),
            'create' => CreateLesson::route('/criar'),
            'edit' => EditLesson::route('/{record}/editar'),
            // horario de aulas
            'aula-horario.index' => ListClassSchedules::route('/{parent}/aula-horario'),
            'aula-horario.create' => CreateClassSchedules::route('/{parent}/aula-horario/adicionar'),
            'aula-horario.edit' => EditClassSchedules::route('/{parent}/aula-horario/{record}/editar'),
        ];
    }
}

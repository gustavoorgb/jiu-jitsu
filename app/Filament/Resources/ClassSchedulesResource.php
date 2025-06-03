<?php

namespace App\Filament\Resources;

use App\Enums\DayOfWeekEnum;
use App\Filament\Traits\HasParentResource;
use App\Models\ClassSchedule;
use App\Models\Lesson;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class ClassSchedulesResource extends Resource
{
    use HasParentResource;

    protected static ?string $model = ClassSchedule::class;

    protected static ?string $navigationLabel = null;

    protected static bool $shouldRegisterNavigation = false;

    public static string $parentResource = LessonResource::class;

    public static function getRecordTitle(?Model $record): string|null|Htmlable
    {
        return $record?->name ?? 'Horário';
    }

    public static function getNavigationItems(): array
    {
        return [];
    }

    public static function getSlug(): string
    {
        return 'aula-horario';
    }

    public static function getLabel(): string
    {
        return 'Horário';
    }

    // public static function getBreadcrumb(): string
    // {
    //     $lessonId = static::$parent->id;
    //     $academyId = Lesson::find($lessonId)?->academy_id;

    //     return route('filament.admin.resources.aula.index', [
    //         'parent' => $academyId,
    //     ]);
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Hidden::make('lesson_id')
                            ->default(fn ($livewire) => $livewire->parent?->id)
                            ->required(),
                        Hidden::make('academy_id')
                            ->default(function ($livewire) {
                                $lessonId = $livewire->parent?->id;

                                return Lesson::find($lessonId)?->academy_id;
                            })
                            ->required(),
                        Select::make('day_of_week')->label('Dia da semana')
                            ->required()
                            ->options(collect(DayOfWeekEnum::cases())
                                ->mapWithKeys(fn ($day) => [$day->value => $day->label()])),
                        TimePicker::make('start_time')
                            ->label('Início')
                            ->required()
                            ->datalist([
                                '09:00',
                                '09:30',
                                '10:00',
                                '10:30',
                                '11:00',
                                '11:30',
                                '12:00',
                            ])
                            ->locale('pt_BR')
                            ->seconds(false)
                            ->format('H:i')
                            ->displayFormat('H:i')
                            ->timezone('America/Sao_Paulo'),

                        TimePicker::make('end_time')
                            ->label('Término')
                            ->required()
                            ->datalist([
                                '09:00',
                                '09:30',
                                '10:00',
                                '10:30',
                                '11:00',
                                '11:30',
                                '12:00',
                            ])
                            ->locale('pt_BR')
                            ->seconds(false)
                            ->format('H:i')
                            ->displayFormat('H:i')
                            ->timezone('America/Sao_Paulo'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(null)
            ->columns([
                Tables\Columns\TextColumn::make('day_of_week')
                    ->label('Dia da Semana')
                    ->formatStateUsing(function ($state) {
                        $enum = $state instanceof DayOfWeekEnum ? $state : DayOfWeekEnum::tryFrom($state);

                        return $enum->label();
                    }),

                Tables\Columns\TextColumn::make('start_time')
                    ->label('Início')
                    ->dateTime('H:i')
                    ->timezone('America/Sao_Paulo'),

                Tables\Columns\TextColumn::make('end_time')
                    ->label('Término')
                    ->dateTime('H:i')
                    ->timezone('America/Sao_Paulo'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

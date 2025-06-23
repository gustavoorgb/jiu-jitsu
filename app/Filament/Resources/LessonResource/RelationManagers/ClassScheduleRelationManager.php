<?php

namespace App\Filament\Resources\LessonResource\RelationManagers;

use App\Enums\DayOfWeekEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;

class ClassScheduleRelationManager extends RelationManager
{
    protected static string $relationship = 'schedules';

    protected static ?string $title = 'Horários';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
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
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Adicionar Horário'),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

<?php

namespace App\Filament\Resources\LessonResource\RelationManagers;

use App\Enums\BeltsEnum;
use App\Models\ClassUser;
use App\Models\User;
use Closure;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClassUserRelationManager extends RelationManager
{
    protected static string $relationship = 'classUsers';

    protected static ?string $title = 'Alunos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Aluno')
                    ->options(User::getUsersStudents()->pluck('name', 'id')->toArray())
                    ->required()
                    ->rules([
                        fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) {
                            $lesson = $this->getOwnerRecord();
                            $lessonId = $lesson->id;

                            $alreadyExists = ClassUser::where('lesson_id', $lessonId)
                                ->where('user_id', $value)
                                ->exists();

                            if ($alreadyExists) {
                                $fail('Este aluno já está vinculado a esta aula.');
                            }
                        },
                    ]),
                Checkbox::make('is_instructor')
                    ->label('Instrutor')
                    ->inline(false)
                    ->extraFieldWrapperAttributes(['class' => 'mt-[0.7rem]'])
                    ->rules([
                        fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                            $userId = $get('user_id');
                            $user = User::find($userId)?->toArray() ?? [];

                            $beltsForInstructor = [
                                BeltsEnum::ROXA->value,
                                BeltsEnum::MARROM->value,
                                BeltsEnum::PRETA->value,
                            ];

                            if (! in_array($user['belt'] ?? null, $beltsForInstructor) && $value) {
                                $fail("Aluno(a) {$user['name']} não tem graduação suficiente para ser instrutor!");
                            }
                        },
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->recordAction(null)
            ->columns([
                TextColumn::make('user.name')->label('Aluno'),

                TextColumn::make('lesson.academy.name')->label('Academia'),

                TextColumn::make('is_instructor')
                    ->label('Função')
                    ->formatStateUsing(fn ($state) => $state ? 'Instrutor' : 'Aluno'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Adicionar Aluno'),
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

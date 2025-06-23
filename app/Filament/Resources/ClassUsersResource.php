<?php

namespace App\Filament\Resources;

use App\Enums\BeltsEnum;
use App\Filament\Resources\ClassAttendanceResource\Pages\ListClassAttendances;
use App\Filament\Resources\ClassUserResource\Pages\CreateClassUser;
use App\Filament\Resources\ClassUserResource\Pages\EditClassUser;
use App\Filament\Resources\ClassUserResource\Pages\ListClassUsers;
use App\Filament\Resources\ClassUsersResource\RelationManagers\ClassAttendaceRelationManager;
use App\Models\ClassUser;
use App\Models\User;
use Closure;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClassUsersResource extends Resource
{
    protected static ?string $model = ClassUser::class;

    protected static ?string $navigationLabel = null;

    protected static bool $shouldRegisterNavigation = false;

    public static function getNavigationItems(): array
    {
        return [];
    }

    public static function getSlug(): string
    {
        return 'aula-aluno';
    }

    public static function getLabel(): string
    {
        return 'Aluno';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('user_id')
                            ->label('Aluno')
                            ->options(fn (User $user) => $user->getUsersStudents()->pluck('name', 'id'))
                            ->required(),
                        Checkbox::make('is_instructor')
                            ->label('Instrutor')
                            ->rules([
                                fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                    $userId = $get('user_id');
                                    $user = User::find($userId)->toArray();
                                    $beltsForInstructor = [
                                        BeltsEnum::ROXA->value,
                                        BeltsEnum::MARROM->value,
                                        BeltsEnum::PRETA->value,
                                    ];
                                    if (! in_array($user['belt'], $beltsForInstructor) and $value) {
                                        $fail("Aluno(a) $user[name] não tem graduação suficiente para ser instrutor!");
                                    }
                                },
                            ]),
                        Hidden::make('lesson_id')
                            ->default(fn ($livewire) => $livewire->parent?->id)
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->recordUrl(null)
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
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Action::make('frequencia')
                        ->label('Frequência')
                        ->icon('heroicon-o-clock')
                        ->url(fn (ClassUser $record) => ListClassAttendances::getUrl(['parent' => $record->id]))
                        ->color('primary'),
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

    public static function getRelations(): array
    {
        return [
            ClassAttendaceRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClassUsers::route('aula-aluno'),
            'create' => CreateClassUser::route('adicionar'),
            'edit' => EditClassUser::route('{record}/editar'),
        ];
    }
}

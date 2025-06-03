<?php

namespace App\Filament\Resources;

use App\Enums\BeltsEnum;
use App\Filament\Resources\ClassUserResource\Pages;
use App\Filament\Resources\ClassUserResource\Pages\ListClassUsers;
use App\Filament\Traits\HasParentResource;
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
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class ClassUsersResource extends Resource
{
    use HasParentResource;

    protected static ?string $model = ClassUser::class;

    protected static ?string $navigationLabel = null;

    protected static bool $shouldRegisterNavigation = false;

    public static string $parentResource = LessonResource::class;

    // public static string $relationshipKey = 'class_users';
    // public static function getRecordTitle(?Model $record): string|null|Htmlable
    // {
    //     return $record?->street ?? 'Endereço';
    // }

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
                Tables\Actions\EditAction::make()->url(fn (ListClassUsers $livewire, Model $record): string => static::$parentResource::getUrl('aula-aluno.edit', [
                    'parent' => $livewire->parent,
                    'record' => $record,
                ])),
                DeleteAction::make()->label('Deletar')
                    ->modalHeading('Confirmar exclusão')
                    ->modalDescription('Tem certeza que deseja deletar esta academia? Esta ação não pode ser desfeita.')
                    ->modalSubmitActionLabel('Deletar')
                    ->modalCancelActionLabel('Cancelar'),

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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClassUsers::route('/'),
            'create' => Pages\CreateClassUser::route('/create'),
            'edit' => Pages\EditClassUser::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Enums\RolesEnum;
use App\Models\User;
use App\Models\UserRole;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class UserRoleResource extends Resource
{
    protected static ?string $model = UserRole::class;

    protected static ?string $navigationLabel = null;

    protected static bool $shouldRegisterNavigation = false;

    public static string $parentResource = AcademiesResource::class;

    public static function getRecordTitle(?Model $record): string|null|Htmlable
    {
        return $record->user->name;
    }

    public static function getSlug(): string
    {
        return 'usuario-funcao';
    }

    public static function getLabel(): string
    {
        return 'Vínculo';
    }

    public static function getNavigationItems(): array
    {
        return [];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Usúario')
                    ->required()
                    ->visible(fn (string $context) => $context !== 'edit')
                    ->options(function ($livewire, $context) {
                        $academyId = $livewire->parent->id;

                        if ($context === 'edit') {
                            return User::whereHas('userRoles', function ($query) use ($academyId) {
                                $query->where('academy_id', $academyId);
                            })
                                ->pluck('name', 'id')
                                ->toArray();
                        }

                        return User::whereDoesntHave('userRoles')
                            ->pluck('name', 'id')
                            ->toArray();
                    }),

                Select::make('role_id')
                    ->label('Papel na Academia')
                    ->required()
                    ->options(
                        collect(RolesEnum::cases())
                            ->mapWithKeys(fn ($role) => [$role->value => $role->label()])
                            ->toArray())
                    ->enum(RolesEnum::class),

                Hidden::make('academy_id')
                    ->default(fn ($livewire) => $livewire->parent?->id)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(null)
            ->columns([
                TextColumn::make('user.name')->label('Usúario'),
                TextColumn::make('academy.name')->label('Academia'),
                TextColumn::make('role.role_label')->label('Papel'),
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

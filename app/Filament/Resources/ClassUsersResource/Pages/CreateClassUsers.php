<?php

namespace App\Filament\Resources\ClassUserResource\Pages;

use App\Filament\Resources\ClassUsersResource;
use App\Filament\Traits\HasParentResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateClassUser extends CreateRecord
{
    use HasParentResource;

    protected static string $resource = ClassUsersResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? static::getParentResource()::getUrl('aula-aluno.index', [
            'parent' => $this->parent,
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data[$this->getParentRelationshipKey()] = $this->parent->id;

        return $data;
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('create')
                ->label('Adicionar')
                ->submit('create'),
            Action::make('clear')
                ->label('Limpar')
                ->action(fn () => $this->form->fill([]))
                ->color('secondary'),
        ];
    }
}

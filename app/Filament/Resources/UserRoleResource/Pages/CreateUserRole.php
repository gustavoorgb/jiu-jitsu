<?php

namespace App\Filament\Resources\UserRoleResource\Pages;

use App\Filament\Resources\UserRoleResource;
use App\Filament\Traits\HasParentResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateUserRole extends CreateRecord
{
    use HasParentResource;

    protected static string $resource = UserRoleResource::class;

    protected function getRedirectUrl(): string {
         return $this->previousUrl ?? static::getParentResource()::getUrl('usuario-funcao.index', [
            'parent' => $this->parent,
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array {
        $data[$this->getParentRelationshipKey()] = $this->parent->id;
        return $data;
    }

    protected function getFormActions(): array {
        return [
            Action::make('create')
                ->label('Adicionar')
                ->submit('create'),
            Action::make('clear')
                ->label('Limpar')
                ->action(fn() => $this->form->fill([]))
                ->color('secondary'),
        ];
    }
}

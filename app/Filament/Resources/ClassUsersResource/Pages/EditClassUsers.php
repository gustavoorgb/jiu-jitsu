<?php

namespace App\Filament\Resources\ClassUserResource\Pages;

use App\Filament\Resources\ClassUsersResource;
use App\Filament\Traits\HasParentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClassUser extends EditRecord
{
    use HasParentResource;

    protected static string $resource = ClassUsersResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? static::getParentResource()::getUrl('aula-aluno.index', [
            'parent' => $this->parent,
        ]);
    }

    protected function configureDeleteAction(Actions\DeleteAction $action): void
    {
        $resource = static::getResource();

        $action->authorize($resource::canDelete($this->getRecord()))
            ->successRedirectUrl(static::getParentResource()::getUrl('aula-aluno.index', [
                'parent' => $this->parent,
            ]));
    }
}

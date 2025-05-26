<?php

namespace App\Filament\Resources\UserRoleResource\Pages;

use App\Filament\Resources\UserRoleResource;
use App\Filament\Traits\HasParentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserRole extends EditRecord
{

    use HasParentResource;

    protected static string $resource = UserRoleResource::class;

    protected function getRedirectUrl(): string {
        return $this->previousUrl ?? static::getParentResource()::getUrl('usuario-funcao.index', [
            'parent' => $this->parent,
        ]);
    }

    protected function configureDeleteAction(Actions\DeleteAction $action): void {

        $resource = static::getResource();

        $action->authorize($resource::canDelete($this->getRecord()))
            ->successRedirectUrl(static::getParentResource()::getUrl('usuario-funcao.index', [
                'parent' => $this->parent,
            ]));
    }
}

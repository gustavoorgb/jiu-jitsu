<?php

namespace App\Filament\Resources\AcademyAddressResource\Pages;

use App\Filament\Resources\AcademyAddressResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Traits\HasParentResource;

class EditAcademyAddress extends EditRecord {

    use HasParentResource;

    protected static string $resource = AcademyAddressResource::class;

    protected function getRedirectUrl(): string {
        return $this->previousUrl ?? static::getParentResource()::getUrl('academia-endereco.index', [
            'parent' => $this->parent,
        ]);
    }

    protected function configureDeleteAction(Actions\DeleteAction $action): void
    {
        $resource = static::getResource();

        $action->authorize($resource::canDelete($this->getRecord()))
            ->successRedirectUrl(static::getParentResource()::getUrl('academia-endereco.index', [
                'parent' => $this->parent,
            ]));
    }
}

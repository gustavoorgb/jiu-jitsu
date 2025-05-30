<?php

namespace App\Filament\Resources\ClassSchedulesResource\Pages;

use App\Filament\Resources\ClassSchedulesResource;
use App\Filament\Traits\HasParentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditClassSchedules extends EditRecord
{
    use HasParentResource;

    protected static string $resource = ClassSchedulesResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? static::getParentResource()::getUrl('aula-horario.index', [
            'parent' => $this->parent,
        ]);
    }

    protected function configureDeleteAction(DeleteAction $action): void
    {
        $resource = static::getResource();

        $action->authorize($resource::canDelete($this->getRecord()))
            ->successRedirectUrl(static::getParentResource()::getUrl('aula-horario.index', [
                'parent' => $this->parent,
            ]));
    }
}

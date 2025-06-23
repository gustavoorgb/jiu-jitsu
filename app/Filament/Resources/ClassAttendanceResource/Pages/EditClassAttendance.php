<?php

namespace App\Filament\Resources\ClassAttendanceResource\Pages;

use App\Filament\Resources\ClassAttendanceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditClassAttendance extends EditRecord
{
    protected static string $resource = ClassAttendanceResource::class;

    // protected function getRedirectUrl(): string
    // {
    //     return $this->previousUrl ?? static::getParentResource()::getUrl('aula-aluno.index', [
    //         'parent' => $this->parent,
    //     ]);
    // }

    // protected function configureDeleteAction(DeleteAction $action): void
    // {
    //     $resource = static::getResource();

    //     $action->authorize($resource::canDelete($this->getRecord()))
    //         ->successRedirectUrl(static::getParentResource()::getUrl('aula-aluno.index', [
    //             'parent' => $this->parent,
    //         ]));
    // }
}

<?php

namespace App\Filament\Resources\ClassAttendanceResource\Pages;

use App\Filament\Resources\ClassAttendanceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClassAttendances extends ListRecords
{
    protected static string $resource = ClassAttendanceResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         CreateAction::make()
    //             ->label('Adicionar')
    //             ->url(fn (): string => static::getParentResource()::getUrl('aula-aluno.create',
    //                 ['parent' => $this->parent])
    //             ),
    //     ];
    // }
}

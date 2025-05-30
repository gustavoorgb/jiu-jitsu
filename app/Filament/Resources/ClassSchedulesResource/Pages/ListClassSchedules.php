<?php

namespace App\Filament\Resources\ClassSchedulesResource\Pages;

use App\Filament\Resources\ClassSchedulesResource;
use App\Filament\Traits\HasParentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClassSchedules extends ListRecords
{
    use HasParentResource;

    protected static string $resource = ClassSchedulesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Adicionar')
                ->url(fn (): string => static::getParentResource()::getUrl('aula-horario.create',
                    ['parent' => $this->parent])
                ),
        ];
    }
}

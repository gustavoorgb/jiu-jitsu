<?php

namespace App\Filament\Resources\ClassSchedulesResource\Pages;

use App\Filament\Resources\ClassSchedulesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClassSchedules extends ListRecords
{
    protected static string $resource = ClassSchedulesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Adicionar'),
        ];
    }
}

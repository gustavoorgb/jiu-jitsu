<?php

namespace App\Filament\Resources\ClassSchedulesResource\Pages;

use App\Filament\Resources\ClassSchedulesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClassSchedules extends ListRecords
{
    protected static string $resource = ClassSchedulesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

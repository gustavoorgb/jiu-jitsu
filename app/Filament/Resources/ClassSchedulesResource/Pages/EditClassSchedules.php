<?php

namespace App\Filament\Resources\ClassSchedulesResource\Pages;

use App\Filament\Resources\ClassSchedulesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClassSchedules extends EditRecord
{
    protected static string $resource = ClassSchedulesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

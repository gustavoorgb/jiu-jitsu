<?php

namespace App\Filament\Resources\ClassSchedulesResource\Pages;

use App\Filament\Resources\ClassSchedulesResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateClassSchedules extends CreateRecord
{
    protected static string $resource = ClassSchedulesResource::class;

    protected function getFormActions(): array
    {
        return [
            Action::make('create')
                ->label('Adicionar')
                ->submit('create'),
            Action::make('clear')
                ->label('Limpar')
                ->action(fn () => $this->form->fill([]))
                ->color('secondary'),
        ];
    }
}

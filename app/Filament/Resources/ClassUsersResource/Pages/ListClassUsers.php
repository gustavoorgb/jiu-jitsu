<?php

namespace App\Filament\Resources\ClassUserResource\Pages;

use App\Filament\Resources\ClassUsersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClassUsers extends ListRecords
{
    protected static string $resource = ClassUsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Adicionar'),
        ];
    }
}

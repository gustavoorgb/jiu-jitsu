<?php

namespace App\Filament\Resources\AcademiesResource\Pages;

use App\Filament\Resources\AcademiesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAcademies extends ListRecords {
    protected static string $resource = AcademiesResource::class;

    protected function getHeaderActions(): array {
        return [
            Actions\CreateAction::make()
                ->label('Adicionar'),
        ];
    }
}

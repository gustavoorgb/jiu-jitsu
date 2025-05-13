<?php

namespace App\Filament\Resources\AcademyAddressResource\Pages;

use App\Filament\Resources\AcademyAddressResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAcademyAddress extends ListRecords {
    protected static string $resource = AcademyAddressResource::class;

    protected function getHeaderActions(): array {
        return [
            Actions\CreateAction::make()->label('Adicionar'),
        ];
    }
}

<?php

namespace App\Filament\Resources\AcademyAddressResource\Pages;

use App\Filament\Resources\AcademyAddressResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAcademyAddress extends EditRecord {
    protected static string $resource = AcademyAddressResource::class;

    protected function getHeaderActions(): array {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}

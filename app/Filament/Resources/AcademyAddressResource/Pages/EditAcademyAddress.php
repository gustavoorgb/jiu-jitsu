<?php

namespace App\Filament\Resources\AcademyAddressResource\Pages;

use App\Filament\Resources\AcademyAddressResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAcademyAddress extends EditRecord {
    protected static string $resource = AcademyAddressResource::class;

    protected function getRedirectUrl(): string {
        return AcademyAddressResource::getUrl('index');
    }
}

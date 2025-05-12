<?php

namespace App\Filament\Resources\AcademiesResource\Pages;

use App\Filament\Resources\AcademiesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAcademies extends CreateRecord {
    protected static string $resource = AcademiesResource::class;

    protected function getRedirectUrl(): string {
        return AcademiesResource::getUrl('index');
    }
}

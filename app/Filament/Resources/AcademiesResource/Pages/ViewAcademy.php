<?php

namespace App\Filament\Resources\AcademiesResource\Pages;

use App\Filament\Resources\AcademiesResource;
use Filament\Resources\Pages\ViewRecord;

class ViewAcademy extends ViewRecord
{
    protected static string $resource = AcademiesResource::class;

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }
}

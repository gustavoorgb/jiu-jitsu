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

    public function getBreadcrumbs(): array
    {
        if ($this->record->parent_academy_id) {
            return [
                AcademiesResource::getUrl() => 'Academias',
                AcademiesResource::getUrl('view', ['record' => $this->record->id]) => 'Filial',
                '' => 'Visualizar',
            ];
        } else {
            return [
                AcademiesResource::getUrl() => 'Academias',
                '' => 'Visualizar',
            ];
        }

    }
}

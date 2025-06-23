<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\AcademiesResource;
use App\Filament\Resources\LessonResource;
use Filament\Resources\Pages\EditRecord;

class EditLesson extends EditRecord
{
    protected static string $resource = LessonResource::class;

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }

    public function getBreadcrumbs(): array
    {
        $academy = $this->record->academy;

        return [
            AcademiesResource::getUrl() => 'Academias',
            AcademiesResource::getUrl('edit', ['record' => $academy->id]).'?activeRelationManager=1' => 'Aula',
            'Editar',
        ];
    }
}

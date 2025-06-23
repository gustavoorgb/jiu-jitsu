<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\AcademiesResource;
use App\Filament\Resources\LessonResource;
use Filament\Resources\Pages\ListRecords;

class ListLesson extends ListRecords
{
    protected static string $resource = LessonResource::class;

    public function getBreadcrumbs(): array
    {

        return [AcademiesResource::geturl() => 'Academias', $this->getUrl() => 'Aulas', 'Listar'];
    }
}

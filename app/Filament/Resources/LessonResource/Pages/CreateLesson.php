<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\AcademiesResource;
use App\Filament\Resources\LessonResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateLesson extends CreateRecord
{
    protected static string $resource = LessonResource::class;

    protected function getFormActions(): array
    {
        return [
            Action::make('create')
                ->label('Adicionar')
                ->submit('create'),
            Action::make('clear')
                ->label('Limpar')
                ->action(fn () => $this->form->fill([]))
                ->color('secondary'),
        ];
    }

    public function getBreadcrumbs(): array
    {
        return [AcademiesResource::geturl() => 'Academias', 'Aula', 'Criar'];
    }
}

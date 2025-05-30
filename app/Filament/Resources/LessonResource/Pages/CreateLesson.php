<?php

namespace App\Filament\Resources\JiuJitsuClassResource\Pages;

use App\Filament\Resources\LessonResource;
use App\Filament\Traits\HasParentResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateLesson extends CreateRecord
{
    use HasParentResource;

    protected static string $resource = LessonResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? static::getParentResource()::getUrl('aula.index', [
            'parent' => $this->parent,
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data[$this->getParentRelationshipKey()] = $this->parent->id;

        return $data;
    }

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
}

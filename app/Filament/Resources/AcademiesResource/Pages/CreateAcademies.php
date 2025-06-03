<?php

namespace App\Filament\Resources\AcademiesResource\Pages;

use App\Filament\Resources\AcademiesResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateAcademies extends CreateRecord
{
    protected static string $resource = AcademiesResource::class;

    protected function getRedirectUrl(): string
    {
        return AcademiesResource::getUrl('index');
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

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['parent_academy_id'] = $data['parent_academy_id'] ?? null;

        return $data;
    }
}

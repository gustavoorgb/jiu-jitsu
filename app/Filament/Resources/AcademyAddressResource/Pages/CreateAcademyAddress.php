<?php

namespace App\Filament\Resources\AcademyAddressResource\Pages;

use App\Filament\Resources\AcademyAddressResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateAcademyAddress extends CreateRecord {
    protected static string $resource = AcademyAddressResource::class;

    public string $academy;

    protected function getRedirectUrl(): string {
        return AcademyAddressResource::getUrl("index");
    }

    public function getBreadcrumb(): string {
        return 'Adicionar';
    }

    protected function mutateFormDataBeforeCreate(array $data): array {
        $data['academy_id'] = $this->academy;
        return $data;
    }

    protected function getFormActions(): array {
        return [
            Action::make('create')
                ->label('Adicionar')
                ->submit('create'),
            Action::make('clear')
                ->label('Limpar')
                ->action(fn() => $this->form->fill([]))
                ->color('secondary'),
        ];
    }
}

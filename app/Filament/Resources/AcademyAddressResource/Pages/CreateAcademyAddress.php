<?php

namespace App\Filament\Resources\AcademyAddressResource\Pages;

use App\Filament\Resources\AcademyAddressResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Traits\HasParentResource;

class CreateAcademyAddress extends CreateRecord {

    use HasParentResource;

    protected static string $resource = AcademyAddressResource::class;

    protected function getRedirectUrl(): string {
         return $this->previousUrl ?? static::getParentResource()::getUrl('academia-endereco.index', [
            'parent' => $this->parent,
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array {
        $data[$this->getParentRelationshipKey()] = $this->parent->id;
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

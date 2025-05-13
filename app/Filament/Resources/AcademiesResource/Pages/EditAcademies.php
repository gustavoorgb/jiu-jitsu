<?php

namespace App\Filament\Resources\AcademiesResource\Pages;

use App\Filament\Resources\AcademiesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAcademies extends EditRecord {
    protected static string $resource = AcademiesResource::class;
    protected function getRedirectUrl(): string {
        return AcademiesResource::getUrl('index');
    }

    public function getBreadcrumb(): string {
        return 'Editar';
    }

    protected function getFormActions(): array {
        return [
            Actions\EditAction::make('edit')
                ->label('Editar')
                ->submit('edit'),
            Actions\EditAction::make('clear')
                ->label('Limpar')
                ->action(fn() => $this->form->fill([]))
                ->modalHeading('Limpar dados da academia')
                ->modalSubmitActionLabel('Limpar')
                ->modalSubmitAction(fn($action) => $action->color('primary'))
                ->modalCancelActionLabel('Cancelar')
                ->modalCancelAction(fn($action) => $action->color('secondary'))
                ->color('secondary'),
        ];
    }
}

<?php

namespace App\Filament\Resources\ClassUserResource\Pages;

use App\Filament\Resources\ClassUsersResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateClassUser extends CreateRecord
{
    protected static string $resource = ClassUsersResource::class;

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

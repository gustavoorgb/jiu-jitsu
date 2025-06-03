<?php

namespace App\Filament\Resources\ClassUserResource\Pages;

use App\Filament\Resources\ClassUsersResource;
use App\Filament\Traits\HasParentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClassUsers extends ListRecords
{
    use HasParentResource;

    protected static string $resource = ClassUsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Adicionar')
                ->url(fn (): string => static::getParentResource()::getUrl('aula-aluno.create',
                    ['parent' => $this->parent])
                ),
        ];
    }
}

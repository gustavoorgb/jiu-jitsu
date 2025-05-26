<?php

namespace App\Filament\Resources\UserRoleResource\Pages;

use App\Filament\Resources\UserRoleResource;
use App\Filament\Traits\HasParentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserRoles extends ListRecords
{
    use HasParentResource;

    protected static string $resource = UserRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Adicionar')
                ->url(fn (): string => static::getParentResource()::getUrl('usuario-funcao.create',
                ['parent' => $this->parent])
                ),
        ];
    }
}

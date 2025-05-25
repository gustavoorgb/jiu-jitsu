<?php

namespace App\Filament\Resources\AcademyAddressResource\Pages;

use App\Filament\Resources\AcademyAddressResource;
use App\Filament\Traits\HasParentResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListAcademyAddress extends ListRecords {
    use HasParentResource;

    protected static string $resource = AcademyAddressResource::class;

    protected function getHeaderActions(): array
    {
       return [
            CreateAction::make()
                ->label('Adicionar')
                ->url(fn (): string => static::getParentResource()::getUrl('academia-endereco.create',
                ['parent' => $this->parent])
                ),
            ];
    }
}

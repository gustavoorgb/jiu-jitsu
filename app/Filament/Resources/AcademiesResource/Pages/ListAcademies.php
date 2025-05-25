<?php

namespace App\Filament\Resources\AcademiesResource\Pages;

use App\Filament\Resources\AcademiesResource;
use App\Models\Academy;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListAcademies extends ListRecords {
    protected static string $resource = AcademiesResource::class;

    protected function getHeaderActions(): array {
        return [
            Actions\CreateAction::make()
                ->label('Adicionar')
                ->url(fn () => static::getResource()::getUrl('create', [
                    'parent_academy_id' => request()->query('parent_academy_id'),
                ])),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        $parentId = request()->query('parent_academy_id');

        if ($parentId) {
            $parent = Academy::find($parentId);
            return ($parent?->name ?? 'Academia Desconhecida');
        }

        return 'Academias Matriz';
    }

   public function getBreadcrumb(): string{
    $parentId = request()->query('parent_academy_id');

    if ($parentId) {
        $parent = Academy::find($parentId);
        return 'Filiais de ' . ($parent?->name ?? 'Matriz desconhecida');
    }

    return 'Academias Matriz';
    }

}

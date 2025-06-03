<?php

namespace App\Filament\Resources\JiuJitsuClassResource\Pages;

use App\Filament\Resources\LessonResource;
use App\Filament\Traits\HasParentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLesson extends ListRecords
{
    use HasParentResource;

    protected static string $resource = LessonResource::class;

    protected function getHeaderActions(): array
    {

        return [
            CreateAction::make()
                ->label('Adicionar')
                ->url(fn (): string => static::getParentResource()::getUrl('aula.create',
                    ['parent' => $this->parent])
                ),

        ];
    }
}

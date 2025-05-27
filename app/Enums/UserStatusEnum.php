<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum UserStatusEnum: int implements HasLabel
{
    case ATIVADO = 1;
    case DESATIVADO = 0;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ATIVADO => 'Ativo',
            self::DESATIVADO => 'Desativado',
        };
    }
}

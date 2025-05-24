<?php

namespace App\Enums;

enum UserStatusEnum: int {
    case ATIVADO = 1;
    case DESATIVADO = 0;

     public function label(): string {
        return match ($this) {
            self::ATIVADO => 'Ativo',
            self::DESATIVADO => 'Desativado',
        };
    }
}

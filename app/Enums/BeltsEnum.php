<?php

namespace App\Enums;

enum BeltsEnum: int
{
    case BRANCA = 1;
    case AZUL = 2;
    case ROXA = 3;
    case MARROM = 4;
    case PRETA = 5;

    public function label(): string
    {
        return match ($this) {
            self::BRANCA => 'Faixa branca',
            self::AZUL => 'Faixa azul',
            self::ROXA => 'Faixa roxa',
            self::MARROM => 'Faixa marrom',
            self::PRETA => 'Faixa preta',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::BRANCA => 'text-gray-400',
            self::AZUL => 'text-blue-500',
            self::ROXA => 'text-purple-500',
            self::MARROM => 'text-amber-700',
            self::PRETA => 'text-black',
        };
    }
}

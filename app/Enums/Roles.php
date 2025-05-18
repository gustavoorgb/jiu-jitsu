<?php

namespace App\Enums;

enum Roles: int {
    case ADMIN = 1;
    case INSTRUCTOR = 2;
    case STUDENT = 3;

    public function label(): string {
        return match ($this) {
            self::ADMIN => 'Administrador',
            self::INSTRUCTOR => 'Instrutor',
            self::STUDENT => 'Estudante',
        };
    }
}

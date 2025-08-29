<?php

namespace App\Entity;

enum EnumType: string
{
    case USER_PASS = 'user_pass';
    case CARD = 'card';

    public function getLabel(): string
    {
        return match ($this) {
            self::USER_PASS => 'Username/Password',
            self::CARD => 'Karta',
        };
    }

}

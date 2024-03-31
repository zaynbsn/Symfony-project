<?php

namespace App\Entity;

enum LocationEnum: string
{
    case Annecy = "Annecy";
    case Lyon = "Lyon";
    case Paris = "Paris";
    case Marseille = "Marseille";
    case Lille = "Lille";


    public static function values(): array
    {
        return [
            self::Annecy,
            self::Lyon,
            self::Paris,
            self::Marseille,
            self::Lille,
        ];
    }


}

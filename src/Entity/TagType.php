<?php

namespace App\Entity;

enum TagType: string
{
    case GameType = "gameType";

    case GameName = "gameName";

    case Region = "region";

    case Tournament = "tournament";

    case Team = "team";

    public static function values(): array
    {
        return [
            self::GameType,
            self::GameName,
            self::Region,
            self::Tournament,
            self::Team,
        ];
    }
    public static function getName(self $type): string
    {
        switch ($type) {
            case self::GameType:
                return 'Game Type';
            case self::GameName:
                return 'Game Name';
            case self::Region:
                return 'Region';
            case self::Tournament:
                return 'Tournament';
            case self::Team:
                return 'Team';
            default:
                return '';
        }
    }

}


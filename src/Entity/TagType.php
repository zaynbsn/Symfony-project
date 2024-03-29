<?php

namespace App\Entity;

enum TagType: string
{
    case GameType = "gameType";

    case GameName = "gameName";

    case Region = "region";

    case Tournament = "tournament";

    case Team = "team";

}


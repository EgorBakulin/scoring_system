<?php

declare(strict_types=1);

namespace App\Config;

enum Education: string
{
    case Secondary = 'secondary';
    case Special = 'special';
    case Higher = 'higher';
}


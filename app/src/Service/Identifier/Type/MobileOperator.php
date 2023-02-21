<?php

declare(strict_types=1);

namespace App\Service\Identifier\Type;

enum MobileOperator: string
{
    case Megafon = 'megafon';
    case Beeline = 'beeline';
    case Mts = 'mts';
    case Other = 'other';
}

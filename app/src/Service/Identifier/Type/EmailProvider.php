<?php

declare(strict_types=1);

namespace App\Service\Identifier\Type;

enum EmailProvider
{
    case gmail;
    case yandex;
    case mailRu;
    case other;
}

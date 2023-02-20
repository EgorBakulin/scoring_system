<?php

declare(strict_types=1);

namespace App\Service\Helper;

class Regex {
    const RUSSIAN_PHONE_NUMBER = '/^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$/';
}

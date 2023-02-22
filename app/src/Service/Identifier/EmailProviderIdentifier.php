<?php

declare(strict_types=1);

namespace App\Service\Identifier;

use App\Service\Identifier\Constant\EmailProvidersDomains;
use App\Service\Identifier\Type\EmailProvider;

class EmailProviderIdentifier
{
    public function identifyEmailProvider(string $email): EmailProvider
    {
        $domain = substr($email, strpos($email, '@') + 1);

        if (in_array($domain, EmailProvidersDomains::GOOGLE_DOMAINS)) {
            return EmailProvider::gmail;
        }

        if (in_array($domain, EmailProvidersDomains::YANDEX_DOMAINS)) {
            return EmailProvider::yandex;
        }

        if (in_array($domain, EmailProvidersDomains::MAIL_RU_DOMAINS)) {
            return EmailProvider::mailRu;
        }

        return EmailProvider::other;
    }
}

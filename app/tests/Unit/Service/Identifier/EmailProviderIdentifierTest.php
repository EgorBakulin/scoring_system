<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Identifier;

use App\Service\Identifier\EmailProviderIdentifier;
use App\Service\Identifier\Type\EmailProvider;
use PHPUnit\Framework\TestCase;

class EmailProviderIdentifierTest extends TestCase
{
    /** @dataProvider getIdentifyEmailProviderdata */
    public function testIdentifyEmailProvider(string $email, EmailProvider $type): void
    {
        $testingClass = new EmailProviderIdentifier();

        $provider = $testingClass->identifyEmailProvider($email);

        self::assertSame($type, $provider);
    }

    public function getIdentifyEmailProviderdata(): array
    {
        return [
            'yandex email' => [
                'email' => 'example@ya.ru',
                'type' => EmailProvider::yandex,
            ],
            'google email' => [
                'email' => 'example@gmail.com',
                'type' => EmailProvider::gmail,
            ],
            'mail.ru email' => [
                'email' => 'example@mail.ru',
                'type' => EmailProvider::mailRu,
            ],
            'other email' => [
                'email' => 'example@example.com',
                'type' => EmailProvider::other,
            ],
        ];
    }
}
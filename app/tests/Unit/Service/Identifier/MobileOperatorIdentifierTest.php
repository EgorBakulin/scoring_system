<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Identifier;

use App\Service\Identifier\MobileOperatorIdentifier;
use App\Service\Identifier\Type\MobileOperator;
use PHPUnit\Framework\TestCase;

class MobileOperatorIdentifierTest extends TestCase
{
    /** @dataProvider getIdentifyNumberData */
    public function testIdentifyNumber(string $number, MobileOperator $operator): void
    {
        $testingClass = new MobileOperatorIdentifier();

        $identifiedOperator = $testingClass->identifyNumber($number);

        self::assertSame($operator, $identifiedOperator);
    }

    public function getIdentifyNumberData(): array
    {
        return [
            'mts case' => [
                'number' => '+7-913-000-00-00',
                'operator' => MobileOperator::Mts,
            ],
            'megafon case' => [
                'number' => '8 (933) 000 00-00',
                'operator' => MobileOperator::Megafon,
            ],
            'beeline case' => [
                'number' => '89660000000',
                'operator' => MobileOperator::Beeline,
            ],
            'other operator case' => [
                'number' => '88000000000',
                'operator' => MobileOperator::Other,
            ],

        ];
    }
}

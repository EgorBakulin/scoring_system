<?php

declare(strict_types=1);

namespace App\Service\Identifier;

use App\Service\Identifier\Constant\OperatorsCodes;
use App\Service\Identifier\Type\MobileOperator;

class MobileOperatorIdentifier
{
    public function identifyNumber(string $phoneNumber): MobileOperator
    {
        $phoneNumberCode = $this->getNumberCode($this->normalizeNumber($phoneNumber));

        if (in_array($phoneNumberCode, OperatorsCodes::MEGAFON_CODES)) {
            return MobileOperator::Megafon;
        }

        if (in_array($phoneNumberCode, OperatorsCodes::BEELINE_CODES)) {
            return MobileOperator::Beeline;
        }

        if (in_array($phoneNumberCode, OperatorsCodes::MTS_CODES)) {
            return MobileOperator::Mts;
        }

        return MobileOperator::Other;
    }

    private function getNumberCode(string $normalizedPhoneNumber): int
    {
        return (int)mb_substr($normalizedPhoneNumber, 1, 3);
    }

    private function normalizeNumber(string $phoneNumber): string
    {
        return preg_replace('/^8/', '7', preg_replace('/[^0-9]/', '', $phoneNumber));
    }
}
    

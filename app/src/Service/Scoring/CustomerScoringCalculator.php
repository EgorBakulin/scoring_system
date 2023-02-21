<?php

declare(strict_types=1);

namespace App\Service\Scoring;

use App\Config\Education;
use App\Service\Identifier\EmailProviderIdenifier;
use App\Service\Identifier\MobileOperatorIdentifier;
use App\Service\Identifier\Type\EmailProvider;
use App\Service\Identifier\Type\MobileOperator;
use App\Service\Scoring\Constant\AgreedToThePersonalDataProcessingScore;
use App\Service\Scoring\Constant\EducationScore;
use App\Service\Scoring\Constant\EmailProviderScore;
use App\Service\Scoring\Constant\MobileOperatorScore;

class CustomerScoringCalculator
{
    public function __construct(
        private MobileOperatorIdentifier $mobileOperatorIdentifier,
        private EmailProviderIdenifier $emailProviderIdentifier
    ) {
    }
    
    public function calculate(
        string $phoneNumber,
        string $email,
        Education $education,
        bool $agreedToThePersonalDataProcessing
    ): int {
        return
            $this->calculatePhoneScoring($phoneNumber) +
            $this->calculateEmailScoring($email) +
            $this->calculateEducationScoring($education) +
            $this->calculateAgreedToThePersonalDataProcessing($agreedToThePersonalDataProcessing);
    }

    private function calculatePhoneScoring(string $phoneNumber): int {
        return match($this->mobileOperatorIdentifier->identifyNumber($phoneNumber)) {
            MobileOperator::Beeline => MobileOperatorScore::BEELINE_SCORE,
            MobileOperator::Megafon => MobileOperatorScore::MEGAFON_SCORE,
            MobileOperator::Mts => MobileOperatorScore::MTS_SCORE,
            MobileOperator::Other => MobileOperatorScore::OTHER_SCORE,
        };
    }

    private function calculateEmailScoring(string $email): int {
        return match($this->emailProviderIdentifier->identifyEmailProvider($email)) {
            EmailProvider::gmail => EmailProviderScore::GMAIL_SCORE,
            EmailProvider::yandex => EmailProviderScore::YANDEX_SCORE,
            EmailProvider::mailRu => EmailProviderScore::MAIL_RU_SCORE,
            EmailProvider::other => EmailProviderScore::OTHER_PROVIDER_SCORE
        };
    }

    private function calculateAgreedToThePersonalDataProcessing(
        bool $agreedToThePersonalDataProcessing
    ): int {
        if ($agreedToThePersonalDataProcessing) {
            return AgreedToThePersonalDataProcessingScore::AGREED_SCORE;
        }

        return AgreedToThePersonalDataProcessingScore::DISAGREED_SCORE;
    }

    private function calculateEducationScoring(Education $education): int
    {
        return match($education) {
            Education::Secondary => EducationScore::SECONDARY_SCORE,
            Education::Special => EducationScore::SPECIAL_SCORE,
            Education::Higher => EducationScore::HIGHER_SCORE,
        };
    }
}

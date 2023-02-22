<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Scoring;

use App\Config\Education;
use App\Service\Identifier\EmailProviderIdentifier;
use App\Service\Identifier\MobileOperatorIdentifier;
use App\Service\Identifier\Type\EmailProvider;
use App\Service\Identifier\Type\MobileOperator;
use App\Service\Scoring\CustomerScoringCalculator;
use Mockery;
use PHPUnit\Framework\TestCase;

class CustomerScoringCalculatorTest extends TestCase
{
    /** @dataProvider getCalculateData */
    public function testCalculate(
        CustomerScoringCalculator $testingClass,
        string $phoneNumber,
        string $email,
        Education $education,
        bool $agreedToThePersonalDataProcessing,
        int $expectingResult
    ): void {
        $scoring = $testingClass->calculate(
            $phoneNumber,
            $email,
            $education,
            $agreedToThePersonalDataProcessing
        );

        self::assertSame($expectingResult, $scoring);
    }

    public function getCalculateData(): array
    {
        return [
            'default case' => [
                'testingClass' => $this->createDefaultTestingClass(MobileOperator::Mts, EmailProvider::mailRu),
                'phoneNumber' => 'phoneNumber',
                'email' => 'email',
                'education' => Education::Special,
                'agreedToThePersonalDataProcessing' => true,
                'expectingResult' => 23,
            ],
        ];
    }

    /** @dataProvider getCalculatePhoneScoringData */
    public function testCalculatePhoneScoring(
        CustomerScoringCalculator $testingClass,
        string $phoneNumber,
        int $expectingResult
    ): void {
        $scoring = $testingClass->calculatePhoneScoring($phoneNumber);

        self::assertSame($expectingResult, $scoring);
    }

    public function getCalculatePhoneScoringData(): array
    {
        return [
            'default case' => [
                'testingClass' => $this->createDefaultTestingClass(MobileOperator::Mts, EmailProvider::mailRu),
                'phoneNumber' => 'phoneNumber',
                'expectingResult' => 3,
            ],
        ];
    }

    /** @dataProvider getCalculateEmailScoringData */
    public function testCalculateEmailScoring(
        CustomerScoringCalculator $testingClass,
        string $email,
        int $expectingResult
    ): void {
        $scoring = $testingClass->calculateEmailScoring($email);

        self::assertSame($expectingResult, $scoring);
    }

    public function getCalculateEmailScoringData(): array
    {
        return [
            'default case' => [
                'testingClass' => $this->createDefaultTestingClass(MobileOperator::Mts, EmailProvider::mailRu),
                'email' => 'email',
                'expectingResult' => 6,
            ],
        ];
    }

    /** @dataProvider  getCalculateEducationScoringData */
    public function testCalculateEducationScoring(
        CustomerScoringCalculator $testingClass,
        Education $education,
        int $expectingResult
    ): void {
        $scoring = $testingClass->calculateEducationScoring($education);

        self::assertSame($expectingResult, $scoring);
    }

    public function getCalculateEducationScoringData(): array
    {
        return [
            'default case' => [
                'testingClass' => $this->createDefaultTestingClass(MobileOperator::Mts, EmailProvider::mailRu),
                'education' => Education::Special,
                'expectingResult' => 10,
            ],
        ];
    }

    /** @dataProvider getAgreedToThePersonalDataProcessingScoringData */
    public function testCalculateAgreedToThePersonalDataProcessingScoring(
        CustomerScoringCalculator $testingClass,
        bool $agreedToThePersonalDataProcessing,
        int $expectingResult
    ): void {
        $scoring = $testingClass
            ->calculateAgreedToThePersonalDataProcessingScoring($agreedToThePersonalDataProcessing);

        self::assertSame($expectingResult, $scoring);
    }

    public function getAgreedToThePersonalDataProcessingScoringData(): array
    {
        return [
            'default case' => [
                'testingClass' => $this->createDefaultTestingClass(MobileOperator::Mts, EmailProvider::mailRu),
                'agreedToThePersonalDataProcessing' => true,
                'expectingResult' => 4,
            ],
        ];
    }

    private function createDefaultTestingClass(
        MobileOperator $operator,
        EmailProvider $provider
    ): CustomerScoringCalculator {
        return new CustomerScoringCalculator(
            $this->createMobileOperatorIdentifierMock($operator),
            $this->createEmailProviderIdentifier($provider)
        );
    }

    private function createMobileOperatorIdentifierMock(MobileOperator $operator): MobileOperatorIdentifier
    {
        $identifier = Mockery::mock(MobileOperatorIdentifier::class);

        $identifier
            ->shouldReceive('identifyNumber')
            ->once()
            ->andReturn($operator);

        return $identifier;
    }

    private function createEmailProviderIdentifier(EmailProvider $provider): EmailProviderIdentifier
    {
        $identifier = Mockery::mock(EmailProviderIdentifier::class);

        $identifier
            ->shouldReceive('identifyEmailProvider')
            ->once()
            ->andReturn($provider);

        return $identifier;
    }
}

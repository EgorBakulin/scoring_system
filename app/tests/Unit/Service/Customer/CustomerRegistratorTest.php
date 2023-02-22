<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Customer;

use App\Config\Education;
use App\Dto\CustomerRegistrationFormInput;
use App\Repository\CustomerRepository;
use App\Service\Customer\CustomerRegistrator;
use App\Service\Scoring\CustomerScoringCalculator;
use Mockery;
use PHPUnit\Framework\TestCase;

class CustomerRegistratorTest extends TestCase
{
    /** @dataProvider getRegisterData */
    public function testRegister(CustomerRegistrator $testingClass, CustomerRegistrationFormInput $input): void
    {
        $testingClass->register($input);

        self::assertTrue(true);
    }

    public function getRegisterData(): array
    {
        return [
            'Default case' => [
                'testingClass' => $this->createDefaultTestingClass(),
                'input' => $this->createDefaultInput(),
            ],
        ];
    }

    private function createDefaultTestingClass(): CustomerRegistrator
    {
        return new CustomerRegistrator(
            $this->createDefaultCustomerRepositoryMock(),
            $this->createDefaultCustomerScoringCalculatorMock(),
        );
    }

    private function createDefaultInput(): CustomerRegistrationFormInput
    {
        $input = new CustomerRegistrationFormInput();

        $input->firstName = 'firstName';
        $input->secondName = 'secondName';
        $input->phoneNumber = 'phoneNumber';
        $input->email = 'email';
        $input->education = Education::Special;
        $input->agreedToThePersonalDataProcessing = true;

        return $input;
    }

    public function createDefaultCustomerRepositoryMock(): CustomerRepository
    {
        $repository = Mockery::mock(CustomerRepository::class);

        $repository
            ->shouldReceive('save')
            ->once();

        return $repository;
    }

    public function createDefaultCustomerScoringCalculatorMock(): CustomerScoringCalculator
    {
        $calculator = Mockery::mock(CustomerScoringCalculator::class);

        $calculator
            ->shouldReceive('calculate')
            ->once()
            ->andReturn(42);

        return $calculator;
    }
}
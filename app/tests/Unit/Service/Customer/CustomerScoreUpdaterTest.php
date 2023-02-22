<?php

declare (strict_types=1);

namespace App\Tests\Unit\Service\Customer;

use App\Entity\Customer;
use App\Service\Customer\CustomerScoreUpdater;
use App\Service\Scoring\CustomerScoringCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

class CustomerScoreUpdaterTest extends TestCase
{
    /** @dataProvider getUpdateCustomerScoreData */
    public function testUpdateCustomerScore(CustomerScoreUpdater $testingClass, Customer $input): void
    {
        $customer = $testingClass->updateCustomerScore($input, true);

        self::assertSame(42, $customer->getScoring());
    }

    public function getUpdateCustomerScoreData(): array
    {
        return [
            'Default Case' => [
                'testingClass' => $this->createDefaultTestingClass(1),
                'input' => new Customer(
                    'firstName',
                    'secondName',
                    'phoneNumber',
                    'email',
                    'special',
                    true,
                    1
                ),
            ],
        ];
    }

    /**
     * @dataProvider getUpdateCustomersScoreData
     * @param Customer[] $input
     */
    public function testUpdateCustomersScore(CustomerScoreUpdater $testingClass, array $input): void
    {
        $customers = $testingClass->updateCustomersScore($input);

        foreach ($customers as $customer) {
            self::assertSame(42, $customer->getScoring());
        }
    }

    public function getUpdateCustomersScoreData(): array
    {
        return [
            'Default Case' => [
                'testingClass' => $this->createDefaultTestingClass(2),
                'input' => [
                    new Customer(
                        'firstName',
                        'secondName',
                        'phoneNumber',
                        'email',
                        'special',
                        true,
                        1
                    ),
                    new Customer(
                        'firstName',
                        'secondName',
                        'phoneNumber',
                        'email',
                        'special',
                        true,
                        1
                    ),
                ],
            ],
        ];
    }

    private function createDefaultTestingClass(int $customerCount): CustomerScoreUpdater
    {
        return new CustomerScoreUpdater(
            $this->createEntityManagerMock($customerCount),
            $this->createCustomerScoringCalculatorMock($customerCount)
        );
    }

    private function createEntityManagerMock(int $persistTimes): EntityManagerInterface
    {
        $entityManager = Mockery::mock(EntityManagerInterface::class);

        $entityManager
            ->shouldReceive('persist')
            ->times($persistTimes);

        $entityManager
            ->shouldReceive('flush')
            ->once();

        return $entityManager;
    }

    private function createCustomerScoringCalculatorMock($calculateTimes): CustomerScoringCalculator
    {
        $calculator = Mockery::mock(CustomerScoringCalculator::class);

        $calculator
            ->shouldReceive('calculate')
            ->times($calculateTimes)
            ->andReturn(42);

        return $calculator;
    }
}

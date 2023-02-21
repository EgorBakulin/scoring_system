<?php

namespace App\Service\Customer;

use App\Config\Education;
use App\Entity\Customer;
use App\Service\Scoring\CustomerScoringCalculator;
use Doctrine\ORM\EntityManagerInterface;

class CustomerScoreUpdater
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private CustomerScoringCalculator $scoringCalculator
    ) {
    }

    public function updateCustomerScore(Customer $customer, bool $flush = false): Customer
    {
        $customer->setScoring(
            $this->scoringCalculator->calculate(
                $customer->getPhoneNumber(),
                $customer->getEmail(),
                Education::from($customer->getEducation()),
                $customer->isAgreedToThePersonalDataProcessing()
            )
        );

        $this->entityManager->persist($customer);

        if ($flush) {
            $this->entityManager->flush();
        }

        return $customer;
    }

    /**
     * @param Customer[] $customers
     * @param bool $flush
     * @return Customer[]
     */
    public function updateCustomersScore(iterable $customers, bool $flush = false): iterable
    {
        foreach ($customers as $customer) {
            yield $this->updateCustomerScore($customer, false);
        }

        if ($flush) {
            $this->entityManager->flush();
        }
    }
}
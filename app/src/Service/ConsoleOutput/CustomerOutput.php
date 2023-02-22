<?php

declare(strict_types=1);

namespace App\Service\ConsoleOutput;

use App\Config\Education;
use App\Entity\Customer;
use App\Service\Scoring\CustomerScoringCalculator;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Style\OutputStyle;

class CustomerOutput
{
    public function __construct(
        private CustomerScoringCalculator $scoringCalculator,
    ) {
    }

    /** @param Customer[] $customers */
    public function printCustomersInfo(iterable $customers, OutputStyle $io): void
    {
        foreach ($customers as $customer) {
            $this->printCustomerInfo($customer, $io);
        }
    }

    public function printCustomerInfo(Customer $customer, OutputStyle $io): void
    {
        $io->title(
            sprintf(
                '%s %s. id: %d',
                $customer->getFirstName(),
                $customer->getSecondName(),
                $customer->getId()
            )
        );

        $this->createCustomerDataTable($customer, $io)->render();
    }

    private function createCustomerDataTable(Customer $customer, OutputStyle $io): Table
    {
        return $io
            ->createTable()
            ->setHeaders(['property', 'value', 'scoring'])
            ->addRow(
                [
                    'phone number',
                    $customer->getPhoneNumber(),
                    $this->scoringCalculator->calculatePhoneScoring($customer->getPhoneNumber()),
                ]
            )
            ->addRow(
                [
                    'email',
                    $customer->getEmail(),
                    $this->scoringCalculator->calculateEmailScoring(
                        $customer->getEmail()
                    ),
                ]
            )
            ->addRow(
                [
                    'education',
                    $customer->getEducation(),
                    $this->scoringCalculator->calculateEducationScoring(
                        Education::from($customer->getEducation())
                    ),
                ]
            )
            ->addRow(
                [
                    'agreed to the personal data processing',
                    $customer->isAgreedToThePersonalDataProcessing() ? '+' : '-',
                    $this->scoringCalculator->calculateAgreedToThePersonalDataProcessingScoring(
                        $customer->isAgreedToThePersonalDataProcessing()
                    ),
                ]
            )
            ->addRow(
                [
                    'total',
                    '',
                    $this->scoringCalculator->calculate(
                        $customer->getPhoneNumber(),
                        $customer->getEmail(),
                        Education::from($customer->getEducation()),
                        $customer->isAgreedToThePersonalDataProcessing()
                    ),
                ]
            );
    }
}

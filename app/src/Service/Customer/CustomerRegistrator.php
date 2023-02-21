<?php

declare(strict_types=1);

namespace App\Service\Customer;

use App\Dto\CustomerRegistrationFormInput;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Service\Scoring\CustomerScoringCalculator;

class CustomerRegistrator
{
    public function __construct(
        private CustomerRepository $repository,
        private CustomerScoringCalculator $scoringCalculator
    ) {
    }

    public function register(CustomerRegistrationFormInput $input): void
    {
        $customer = new Customer(
            $input->firstName,
            $input->secondName,
            $input->phoneNumber,
            $input->email,
            $input->education->name,
            $input->agreedToThePersonalDataProcessing,
            $this->scoringCalculator->calculate(
                $input->phoneNumber,
                $input->email,
                $input->education,
                $input->agreedToThePersonalDataProcessing
            )
        );

        $this->repository->save($customer, true);
    }
}

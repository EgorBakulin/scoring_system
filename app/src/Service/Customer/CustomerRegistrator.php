<?php

declare(strict_types=1);

namespace App\Service\Customer;

use App\Dto\CustomerRegistrationFormInput;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;

class CustomerRegistrator {
    public function __construct(
        private CustomerRepository $repository
    ){
    }

    public function register(CustomerRegistrationFormInput $input): void {
        $customer = new Customer(
            $input->firstName,
            $input->secondName,
            $input->phoneNumber,
            $input->email,
            $input->education->name,
            $input->agreedToThePersonalDataProcessing,
        );

        $this->repository->save($customer, true);
    }
}

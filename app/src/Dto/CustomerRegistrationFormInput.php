<?php

declare(strict_types=1);

namespace App\Dto;

use App\Config\Education;

class CustomerRegistrationFormInput
{
    public string $firstName;

    public string $secondName;

    public string $phoneNumber;

    public string $email;

    public Education $education;

    public bool $agreedToThePersonalDataProcessing;
}
    

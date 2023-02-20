<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $firstName;

    #[ORM\Column(length: 255)]
    private string $secondName;

    #[ORM\Column(length: 255)]
    private string $phoneNumber;

    #[ORM\Column(length: 255)]
    private string $email;

    #[ORM\Column(length: 255)]
    private string $education;

    #[ORM\Column]
    private bool $agreedToThePersonalDataProcessing;

    public function __construct(
        string $firstName,
        string $secondName,
        string $phoneNumber,
        string $email,
        string $education,
        bool $agreedToThePersonalDataProcessing
    ) {
        $this
            ->setFirstName($firstName)
            ->setSecondName($secondName)
            ->setPhoneNumber($phoneNumber)
            ->setEmail($email)
            ->setEducation($education)
            ->setAgreeToThePersonalDataProcessing($agreedToThePersonalDataProcessing);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getSecondName(): string
    {
        return $this->secondName;
    }

    public function setSecondName(string $secondName): self
    {
        $this->secondName = $secondName;

        return $this;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEducation(): string
    {
        return $this->education;
    }

    public function setEducation(string $education): self
    {
        $this->education = $education;

        return $this;
    }

    public function isAgreedToThePersonalDataProcessing(): bool
    {
        return $this->agreedToThePersonalDataProcessing;
    }

    public function setAgreeToThePersonalDataProcessing(bool $agreedToThePersonalDataProcessing): self
    {
        $this->agreedToThePersonalDataProcessing = $agreedToThePersonalDataProcessing;

        return $this;
    }
}

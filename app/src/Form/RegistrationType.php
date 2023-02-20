<?php

declare(strict_types=1);

namespace App\Form;

use App\Config\Education;
use App\Dto\CustomerRegistrationFormInput;
use App\Service\Helper\Regex;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName',
                  TextType::class,
                  ['constraints' => [new Assert\NotBlank()]]
            )
            ->add('secondName',
                  TextType::class,
                  ['constraints' => [new Assert\NotBlank()]]
            )
            ->add('phoneNumber',
                  TelType::class,
                  [
                      'constraints' => [
                          new Assert\NotBlank(),
                          new Assert\Regex(Regex::RUSSIAN_PHONE_NUMBER),
                      ],
                  ]
            )
            ->add('email',
                  EmailType::class,
                  [
                      'constraints' => [
                          new Assert\NotBlank(),
                          new Assert\Email(),
                      ],
                  ]
            )
            ->add('education',
                  EnumType::class,
                  ['class' => Education::class]
            )
            ->add(
                'agreedToThePersonalDataProcessing',
                CheckboxType::class,
                ['required' => false]
            )
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => CustomerRegistrationFormInput::class,
            ]
        );
    }
}

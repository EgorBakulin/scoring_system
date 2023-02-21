<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Config\Education;
use App\Entity\Customer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

/** TODO: change it after finish scoring system */
class CustomerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Customer::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('firstName');
        yield TextField::new('secondName');
        yield TextField::new('phoneNumber');
        yield EmailField::new('email');
        yield ChoiceField::new('education')->setChoices(
            Education::cases()
        );
        yield BooleanField::new('agreedToThePersonalDataProcessing')->renderAsSwitch(false);
        yield IntegerField::new('scoring')->hideOnForm();
    }
}

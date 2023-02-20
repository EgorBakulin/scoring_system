<?php

namespace App\Controller\Admin;

use App\Entity\Customer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

/** TODO: change it after finish scoring system */
class CustomerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Customer::class;
    }
}

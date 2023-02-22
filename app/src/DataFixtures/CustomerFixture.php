<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Config\Education;
use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CustomerFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 100; $i++) {
            $customer = new Customer(
                'firstname',
                'secondName',
                '88005553535',
                'mail@example.com',
                Education::Special->value,
                true,
                0
            );

            $manager->persist($customer);
        }

        $manager->flush();
    }
}

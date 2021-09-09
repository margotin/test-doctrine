<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AddressFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $address = (new Address())
                ->setStreet("54 rue toto")
                ->setPostcode("31000")
                ->setCity("Toulouse");
            $manager->persist($address);
            $this->setReference("address-$i", $address);
        }
        $manager->flush();
    }
}

<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {

            /** @var Address $address */
            $address = $this->getReference("address-$i");

            $user = (new User())
                ->setName("user-$i")
                ->setAddress($address);
            $manager->persist($user);

            $this->setReference("user-$i", $user);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AddressFixtures::class
        ];
    }
}

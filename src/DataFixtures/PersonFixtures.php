<?php

namespace App\DataFixtures;

use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;

class PersonFixtures extends Fixture
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i <= 10; $i++) {
            $manager->persist(
                (new Person())
                    ->setName("Person-$i")
                    ->setAge(random_int(7, 77))
            );
        }

        $manager->flush();
    }
}

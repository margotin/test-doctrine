<?php

namespace App\DataFixtures;

use App\Entity\Person;
use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;

class StudentFixtures extends Fixture
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i <= 10; $i++) {
            $manager->persist(
                (new Student())
                    ->setName("Student-$i")
                    ->setAge(random_int(7, 77))
                    ->setLevel("master")
            );
        }

        $manager->flush();
    }
}

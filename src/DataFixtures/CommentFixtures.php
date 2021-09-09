<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; $i++) {
            $comment = (new Comment())->setContent("comment-$i");
            $manager->persist($comment);
            $this->setReference("comment-$i", $comment);
        }

        $manager->flush();
    }
}

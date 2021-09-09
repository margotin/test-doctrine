<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $counter = 0;

        for ($i = 0; $i < 10; $i++) {

            /** @var User $user */
            $user = $this->getReference("user-$i");

            $article = (new Article())
                ->setName("article-$i")
                ->setSlug("article-$i")
                ->setContent("content-$i")
                ->setUser($user);

            for ($j = $counter; $j < $counter + 10; $j++) {
                /** @var Comment $comment */
                $comment = $this->getReference("comment-$j");
                $article->addComment($comment);
            }
            $counter += 10;
            $manager->persist($article);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            CommentFixtures::class
        ];
    }

}

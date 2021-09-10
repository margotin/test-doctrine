# Doctrine Criteria

**Goal :**  
We have a ``$isDeleted`` property in the ``Comment`` class indicating whether a comment is deleted or not.  
We want to show the view only comments that are not deleted.  
We could loop over each comment and retrieve the ones that are not deleted but this could affect performance.

We will use the ``Criteria`` principle.
> If you have a big collection and need to return only a small number of results, you should use Criteria immediately.

> The Criteria object is similar to the QueryBuilder but with a slightly different.

````php
class Comment
{
    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isDeleted = false;
}
````

````php
class ArticleRepository extends ServiceEntityRepository
{
    public static function createNonDeletedCriteria(): Criteria
    {
        return Criteria::create()
            ->andWhere(Criteria::expr()->eq('isDeleted', false));
    }
}
````

````php
class Article
{
    /**
     * @return Collection|Comment[]
     */
    public function getNonDeletedComments(): Collection
    {
        $criteria = ArticleRepository::createNonDeletedCriteria();

        return $this->comments->matching($criteria);
    }
}
````

### Using the Criteria in a QueryBuilder

````php
class ArticleRepository extends ServiceEntityRepository
{
    public function findAllNonDeletedComments()
    {
        $this->createQueryBuilder('a')
            ->addCriteria(self::createNonDeletedCriteria())
            ->getQuery()
            ->getResult()
        ;
    }
}
````


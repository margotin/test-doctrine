# Doctrine Relations  

We have five tables:
- User
- Address
- Article
- Comment
- Category

*"Management rules"* :  
- Each User has exactly one Address. (Each Address has exactly one User)
- Each User can have many Article. (Each Article has one User)
- Each Article can have many Comment. (Each Comment has one Article)
- Each Article can have many Category. (Each Category can have many Article)

### Relations
1. **OneToOne**  
*Each User has exactly one Address. (Each Address has exactly one User)* 

> ***User class is the owner of the relation***

**Unidirectional**  
````
class User
{
    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private Address $address;
}
````
**Bidirectional**
````
class User
{
    /**
     * @ORM\OneToOne(targetEntity=Address::class, inversedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private Address $address;
}
````
````
class Address
{
    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="address", cascade={"persist", "remove"})
     */
    private User $user;
}
````

2. ManyToOne  
*Each Article can have many Comment. (Each Comment has one Article)* 

> ***Comment class is the owner of the relation***

**Unidirectional**
````
class Comment
{
    /**
     * @ORM\ManyToOne(targetEntity=Article::class)
     */
    private Article $article;
}
````
**Bidirectional**
````
class Comment
{
    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="comments")
     */
    private Article $article;
}
````
````
class Article
{
   /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="articles")
     */
    private Collection $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }
}
````

4. ManyToMany  
*Each Article can have many Comment. (Each Comment can have many Article)* 

> ***Article class is the owner of the relation***

**Unidirectional**
````
class Article
{
    /**
     * @ORM\ManyToMany(targetEntity=Category::class)
     */
    private Collection $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }
}
````

**Bidirectional**
````
class Article
{
    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="articles")
     */
    private Collection $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }
}
````
````
class Category
{
    /**
     * @ORM\ManyToMany(targetEntity=Article::class, mappedBy="categories")
     */
    private Collection $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }
}
````

### About ``@ORM\JoinColumn(nullable=false)``
Means that the property of the relation cannot be null
> Default is ``@ORM\JoinColumn(nullable=true)``

### About ``Owning Vs Inverse Relations``

- For a ManyToOne and OneToMany relation, the owning side is always the **ManyToOne** side.
- Doctrine only looks at the owning side of the relationship to figure out what to persist to the database.
- The owning side is the only side where the data matters when saving.

> The inverse side of a relationship is optional !
 
### About ``Lazy-Loading``
When an article is retrieved, only this data is retrieved. The associated comments are not retrieved automatically.  
The request to retrieve comments is only made when they are wanted.  
> Example in Twig ``{{ article.comments }}``

### About ``@ORM\OrderBy``

 ````
class Comment
{
    /**
    * @ORM\ManyToOne(targetEntity=Article::class, mappedBy="user")
    * @ORM\OrderBy({"createdAt" = "DESC"})
    */
    private Collection $articles;    
}
````
When ``$comment->getArticles()`` is called, the result will be ordered by ``createdAt``

### About ``Fetch EXTRA_LAZY`` 

````
class Article
{
    /**
     * @ORM\OneToMany(targetEntity=Comment::class, inversedBy="articles", fetch="EXTRA_LAZY")
     */
    private Collection $comments;
}
 
````
If you set ``fetch="EXTRA_LAZY"``, and you simply count the result of ``$article->getComments()``, then instead of querying for all the comments, Doctrine does a quick COUNT query.
> If you count the results and loop over them in the same page, you will have an additional query.    
> Before the use of ``EXTRA_LAZY``, this count query didn't exist.
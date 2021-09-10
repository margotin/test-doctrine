
# Doctrine Inheritance

We have two classes :  
- Person
````php
class Person
{
    private int $id;
    private string $name;
    private int $age;
}
````

- Student 
````php
class Student
{
    private int $id;
    private string $level;
}
````

The Person class will be the parent class
````php
/**
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="type", type="string")
 * @DiscriminatorMap({"person" = "Person", "student" = "Student"})
 */
class Person
{
    private int $id;
    private string $name;
    private int $age;
}
````
````php
class Student extends Person
{
    private int $id;
    private string $level;
}
````

### Result with `@ORM\InheritanceType("SINGLE_TABLE")`

A single table containing the following fields:

````
id | name | age | type    | level
1  | toto | 12  | person  | null
2  | tata | 25  | student | master
````

- the `type` field contains either "person" or "student"
- the `level` field contains either a string value or Null

### Result with `@ORM\InheritanceType("JOINED")`

Two tables with the following fields:

- person table

````
id | name | age | type  
1  | toto | 12  | person  
2  | tata | 25  | student
````
- student table

````
id | level  
2  | master
````



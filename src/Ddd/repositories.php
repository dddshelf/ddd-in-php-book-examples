<?php

class UserId
{
    private static $counter = 0;

    private $id;

    public function __construct($id = null)
    {
        $this->id = ($id) ?: self::$counter++;
    }

    public function id()
    {
        return $this->id;
    }
}

class User
{
    private $id;
    private $age;

    public function __construct(UserId $id, $age)
    {
        $this->id = $id;
        $this->age = $age;
    }

    public function id()
    {
        return $this->id;
    }

    public function age()
    {
        return $this->age;
    }

    public function hasAgeBetween($minAge, $maxAge)
    {
        return
            $this->age >= $minAge &&
            $this->age <= $maxAge;
    }
}

interface UserDAO
{
    public function get($username);

    public function create(User $user);

    public function update(User $user);

    public function delete($username);
}

interface BloatUserDAO
{
    public function get($username);

    public function create(User $user);

    public function update(User $user);

    public function delete($username);

    // start-of-new-code-to-take-a-look
    public function getUserByLastName($lastName);

    public function getUserByEmail($email);

    public function updateEmailAddress($username, $email);

    public function updateLastName($username, $lastName);
    // end-of-new-code-to-take-a-look
}

interface UserSpecification
{
    /**
     * @return boolean
     */
    public function specifies(User $user);
}

interface UserRepository
{
    public function query($specification);

    public function store(User $user);
}

interface SqlSpecification
{
    public function toSqlClauses();
}

class UserByAgeSpecification implements UserSpecification, SqlSpecification
{
    private $minAge;
    private $maxAge;

    public function __construct($minAge, $maxAge)
    {
        $this->minAge = $minAge;
        $this->maxAge = $maxAge;
    }

    public function specifies(User $user)
    {
        return $user->hasAgeBetween($this->minAge, $this->maxAge);
    }

    public function toSqlClauses()
    {
        return sprintf('age BETWEEN %d AND %d', $this->minAge, $this->maxAge);
    }
}

class InMemoryUserRepository implements UserRepository
{
    private $users = [];

    /**
     * @param Specification $specification
     */
    public function query($specification)
    {
        $results = [];
        foreach ($this->users as $user) {
            if ($specification->specifies($user)) {
                $results[] = $user;
            }
        }

        return $results;
    }

    public function store(User $user)
    {
        $this->users[$user->id()->id()] = $user;
    }
}

class SqlUserRepository implements UserRepository
{
    private $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function store(User $user)
    {
        $sql = 'INSERT INTO users (id, age) VALUES (%d, %d)';

        $this->conn->exec(sprintf($sql, $user->id()->id(), $user->age()));
    }

    /**
     * @param SqlSpecification $specification
     */
    public function query($specification)
    {
        $clauses = $specification->toSqlClauses();
        $st = $this->conn->prepare('SELECT * FROM users WHERE ' . $clauses);
        $st->execute();

        return $this->buildFrom($st->fetchAll());
    }

    private function buildFrom($rows)
    {
        $users = [];
        foreach ($rows as $row) {
            $users[] = new User(new UserId($row['id']), (int) $row['age']);
        }

        return $users;
    }
}

/*
$pdo = new PDO('sqlite::memory:');
$pdo->exec('CREATE TABLE users (
     id INTEGER PRIMARY KEY,
     age INTEGER
)');
$repo = new SqlUserRepository($pdo);
*/

$repo = new InMemoryUserRepository();

$repo->store(new User(new UserId(), 18));
$repo->store(new User(new UserId(), 15));
$repo->store(new User(new UserId(), 24));
$repo->store(new User(new UserId(), 32));

$results = $repo->query(new UserByAgeSpecification(10, 20));

print_r($results);

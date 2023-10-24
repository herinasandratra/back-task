<?php 

namespace SuperBlog\Persistence;
use SuperBlog\Model\User;
use SuperBlog\Model\UserRepository;

class InMemoryUserRepository implements UserRepository
{
    private $connection;
    public function __construct()
    {
        $db = Database::getInstance();
        $this->connection = $db->getConnection();
    }
    public function create(User $user): User
    {
        $query = $this->connection->prepare("INSERT INTO user (name, email, password) VALUES (:name, :email, :password)");
        $query->bindValue(':name', $user->getName());
        $query->bindValue(':email', $user->getEmail());
        $query->bindValue(':password', $user->getPassword());
        
        if ($query->execute()) {
            return $this->read($this->connection->lastInsertId());
        } else {
            throw new \RuntimeException('User creation failed.');
        }
    }
    
    public function read(int $id)
    {
        $query = $this->connection->prepare("SELECT * FROM user WHERE id = :user_id");
        $query->bindParam(':user_id', $id, \PDO::PARAM_INT);

        if ($query->execute()) {
            $userData = $query->fetch(\PDO::FETCH_ASSOC);
            if ($userData) {
                return User::makeFromArray($userData);
            } else {
                return null; // Return null if user not found
            }
        } else {
            throw new \RuntimeException('Error executing the query.');
        }
    }    public function delete(int $id): bool
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM user WHERE id = :user_id");
            $stmt->bindParam(':user_id', $id, \PDO::PARAM_INT);
            $stmt->execute();
        
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            return 0;
        }
    }
}
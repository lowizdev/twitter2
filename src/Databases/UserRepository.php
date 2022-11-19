<?php
namespace Twitter2\Databases;

class UserRepository
{

    /**
     * PDO object
     * @var \PDO
     */
    private $pdo;

    /**
     * Initialize the object with a specified PDO object
     * @param \PDO $pdo
     */
    public function __construct($pdo) {
        $this->pdo = $pdo->connect();
    }

    public function insertUser($user){

        $sql = 'INSERT INTO users (userName, email, hashedPassword) VALUES(:userName, :email, :hashedPassword)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':userName', $user->userName);
        $stmt->bindValue(':email', $user->email);
        $stmt->bindValue(':hashedPassword', $user->hashedPassword);

        $stmt->execute();

        return $this->pdo->lastInsertId();

    }

    public function findUserById($userId){

        $stmt = $this->pdo->query('SELECT userId, userName, email, hashedPassword FROM users WHERE userId = :userId');

        $stmt->execute([':userId' => $userId]);
        $user = $stmt->fetchObject();

        //TODO: VERIFY SUCCESS

        return $user;

    }

}

?>
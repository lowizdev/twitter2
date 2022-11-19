<?php
namespace Twitter2\Databases;

class StatusRepository
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

    public function insertStatus($status){

        $sql = 'INSERT INTO statuses (userId, statusText) VALUES (:userId, :statusText)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':userId', $status->userId);
        $stmt->bindValue(':statusText', $status->statusText);

        $stmt->execute();

        return $this->pdo->lastInsertId();

    }

    public function findStatusById($statusId){

        $stmt = $this->pdo->query('SELECT * FROM statuses WHERE statusId = :statusId');

        $stmt->execute([':statusId' => $statusId]);
        $status = $stmt->fetchObject();

        //TODO: VERIFY SUCCESS

        return $status;

    }

    public function findAllStatusByUserId($userId){

        $stmt = $this->pdo->query('SELECT * FROM statuses WHERE userId = :userId');

        $stmt->execute([':userId' => $userId]);
        //$status = $stmt->fetchObject();

        //TODO: VERIFY SUCCESS

        //return $status;

    }

}

?>
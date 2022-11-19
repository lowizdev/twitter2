<?php
namespace Twitter2\Databases;

/**
 * SQLite connnection
 */
class SQLiteConnection {
    
    /**
     * PDO instance
     * @var type 
     */
    private $pdo;

    /**
     * return in instance of the PDO object that connects to the SQLite database
     * @return \PDO
     */
    public function connect() { //Singleton
        if ($this->pdo == null) {
            $this->pdo = new \PDO("sqlite:./../database.db"); //TODO: GET VALUE FROM EXTERNAL CONFIG
        }
        return $this->pdo;
    }
}
?>
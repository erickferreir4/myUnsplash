<?php declare(strict_types=1);

namespace app\model;

use PDO;

/**
 *  Authenticate Model
 */
class AuthModel
{
    private static $conn;

    public function __construct()
    {
    }

    /**
     *  Set Connection
     *  @param {PDO} $conn - connection PDO 
     */
    public function setConnection(PDO $conn) : void
    {
        self::$conn = $conn;
        $this->createTableUsers();
    }

    /**
     *  Create Table Users
     */
    private function createTableUsers() : void
    {
        $sql = 'CREATE TABLE IF NOT EXISTS users
                (
                    id INTEGER PRIMARY KEY,
                    email VARCHAR(100) NOT NULL
                )';
        
        self::$conn->exec($sql);
    }

}

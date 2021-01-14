<?php declare(strict_types=1);

namespace app\model;

use app\helpers\Transaction;
use PDO;

/**
 *  Authenticate Model
 */
class AuthModel
{
    private static $conn;

    public function __construct()
    {
        $this->setConnection();
    }

    /**
     *  Set Connection
     *  @param {PDO} $conn - connection PDO 
     */
    private function setConnection() : void
    {
        if( empty(self::$conn) ) {
            self::$conn = Transaction::get();
            $this->createTableUsers();
        }
    }

    /**
     *  Create Table Users
     */
    private function createTableUsers() : void
    {
        $sql = 'CREATE TABLE IF NOT EXISTS users
                (
                    id INTEGER PRIMARY KEY,
                    email VARCHAR(100) NOT NULL UNIQUE
                )';
        
        Transaction::log($sql);
        self::$conn->exec($sql);
    }

    /**
     *  Find in bd
     *  @param {string} $email - check this
     *  @return array - An array of query
     */
    public function find($email) : array
    {
        $sql = "SELECT * FROM users
                WHERE
                    email = :email";

        Transaction::log($sql);

        $stmt = self::$conn->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     *  Preventy
     *  @param {string} $email - check this
     *  @return array - An array of query
     */
    private function preventEntry(string $email) : array
    {
        $sql = 'SELECT * FROM users
                WHERE
                    email = :email';

        Transaction::log($sql);

        $stmt = self::$conn->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     *  Save in bd
     *  @param {string} $email - save info
     *  @return bool - true or false
     */
    public function save(string $email) : bool
    {
        //if( count($this->preventEntry($email)) ) {
        //    return true;
        //}

        $sql = 'INSERT INTO users
                    (email)
                VALUES
                    (:email)';

        Transaction::log($sql);

        $stmt = self::$conn->prepare($sql);
        $stmt->bindValue(':email', $email);

        return $stmt->execute() ? true : false;
    }

    /**
     *  All
     *  @return array - array of object
     */
    public function all() : array
    {
        $sql = 'SELECT * FROM users';

        Transaction::log($sql);

        $result = self::$conn->query($sql);

        return $result->fetchAll(PDO::FETCH_CLASS, 'stdClass');
    }

    /**
     *  Delete
     *  @param {string} $email - id delete
     *  @return bool - true or false
     */
    public function delete(string $email) : bool
    {
        $sql = 'DELETE FROM users
                WHERE
                    email = :email';

        Transaction::log($sql);

        $stmt = self::$conn->prepare($sql);
        $stmt->bindValue(':email', $email);

        return $stmt->execute() ? true : false;
    }

}

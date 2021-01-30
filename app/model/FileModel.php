<?php declare(strict_types=1);

namespace app\model;

use app\helpers\Transaction;
use app\lib\LoggerHTML;
use PDO;
use stdClass;

/**
 *  File Model
 */
class FileModel
{
    private static $conn;

    public function __construct()
    {
        $this->setConnection();
    }

    /**
     *  Set Connection
     */
    private function setConnection()
    {
        if( empty(self::$conn) ) {
            Transaction::open('db');
            Transaction::setLogger(new LoggerHTML('log.html'));
            self::$conn = Transaction::get();
            $this->createTableFiles();
        }
    }

    /**
     *  Close Connection
     */
    public function close()
    {
        Transaction::close();
    }

    /**
     *  Rollback db
     *  @param {string} $message - message to register log
     */
    public function rollback($message)
    {
        Transaction::log($message);
        Transaction::rollback();
    }

    /**
     *  Create Table
     */
    private function createTableFiles()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS files
                (
                    id INTEGER PRIMARY KEY,
                    id_user VARCHAR(250) NOT NULL,
                    photo_url VARCHAR(750),
                    label VARCHAR(250) NOT NULL
                )';

        Transaction::log($sql);

        self::$conn->exec($sql);
    }

    /**
     *  Find user
     *  @param {string} $email - email user to find
     */
    public function find(string $email)
    {
        $sql = 'SELECT * FROM files
                WHERE
                    id_user = :id_user';

        Transaction::log($sql);

        $stmt = self::$conn->prepare($sql);
        $stmt->bindValue(':id_user', $email);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'stdClass');
    }

    /**
     *  Save files
     *  @param {object} $data - object file info
     */
    public function save(stdClass $data)
    {
        $sql = 'INSERT INTO files
                    (id_user, photo_url, label)
                VALUES
                    (:id_user, :photo_url, :label)';

        Transaction::log($sql);

        $stmt = self::$conn->prepare($sql);

        $stmt->bindValue(':id_user', $data->email);
        $stmt->bindValue(':photo_url', $data->file_url);
        $stmt->bindValue(':label', $data->label);

        return $stmt->execute() ? true : false;
    }

    /**
     *  Get all files
     */
    public function All()
    {
        $sql = 'SELECT * FROM files';

        Transaction::log($sql);

        $result = self::$conn->query($sql);

        return $result->fetchAll(PDO::FETCH_CLASS, 'stdClass');
    }

    /**
     *  Delete files
     *  @param {object} $data - file to delete
     */
    public function delete($data)
    {
        $sql = 'DELETE FROM files
                WHERE
                    id = :id
                        AND
                    id_user = :email
                        AND
                    photo_url = :photo_url;';
                        

        Transaction::log($sql);
        $stmt = self::$conn->prepare($sql);

        $stmt->bindValue(':id', $data->id);
        $stmt->bindValue(':email', $data->email);
        $stmt->bindValue(':photo_url', $data->file);

        return $stmt->execute() ? true : false;
    }


}

<?php declare(strict_types=1);

namespace app\model;

use app\helpers\Transaction;
use app\lib\LoggerHTML;
use PDO;
use stdClass;

class FileModel
{
    private static $conn;

    public function __construct()
    {
        $this->setConnection();
    }

    private function setConnection()
    {
        if( empty(self::$conn) ) {
            Transaction::open('db');
            Transaction::setLogger(new LoggerHTML('log.html'));
            self::$conn = Transaction::get();
            $this->createTableFiles();
        }
    }

    public function close()
    {
        Transaction::close();
    }

    public function rollback($message)
    {
        Transaction::log($message);
        Transaction::rollback();
    }


    private function createTableFiles()
    {
        $sql = 'create table if not exists files
                (
                    id integer primary key,
                    id_user varchar(250) not null,
                    file varchar(250),
                    photo_url varchar(250),
                    label varchar(250) not null
                )';

        Transaction::log($sql);

        self::$conn->exec($sql);
    }

    public function find(string $email)
    {
        $sql = 'select * from files
                where
                    id_user = :id_user';

        Transaction::log($sql);

        $stmt = self::$conn->prepare($sql);
        $stmt->bindValue(':id_user', $email);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'stdClass');
    }

    public function save(stdClass $data)
    {
        $sql = 'insert into files
                    (id_user, file, photo_url, label)
                values
                    (:id_user, :file, :photo_url, :label)';

        Transaction::log($sql);

        $stmt = self::$conn->prepare($sql);

        $stmt->bindValue(':id_user', $data->email);
        $stmt->bindValue(':file', $data->file);
        $stmt->bindValue(':photo_url', $data->file_url);
        $stmt->bindValue(':label', $data->label);

        return $stmt->execute() ? true : false;
    }

    public function All()
    {
        $sql = 'select * from files';

        Transaction::log($sql);

        $result = self::$conn->query($sql);

        return $result->fetchAll(PDO::FETCH_CLASS, 'stdClass');
    }

    
    public function delete($email, $file)
    {
    }


}

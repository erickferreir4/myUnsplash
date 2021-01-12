<?php declare(strict_types=1);

namespace app\helpers;

use app\helpers\ConnectionFactory;
use PDO;

/**
 *  Transaction
 */
class Transaction
{
    private static $conn;
    //private static $logger;

    private function __construct()
    {
    }

    /**
     *  Open connection database
     *  @param {string} $database - ini file in config
     */
    public static function open(string $database) : void
    {
        if( empty(self::$conn) ) {
            self::$conn = ConnectionFactory::open($database);
            self::$conn->beginTransaction();
            //self::$logger = null;
        }
    }

    /**
     *  Get PDO connection
     *  @return - PDO connection
     */
    public static function get() : PDO
    {
        return self::$conn;
    }

    /**
     *  Rollback database
     */
    public static function rollback() : void
    {
        if( self::$conn ) {
            self::$conn->rollback();
            self::$conn = null;
        }
    }

    /**
     *  Finish(close0 connection
     */
    public static function close() : void
    {
        if( self::$conn ) {
            self::$conn->commit();
            self::$conn = null;
        }
    }
}

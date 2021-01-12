<?php declare(strict_types=1);

namespace app\controller;

use app\helpers\Transaction;
use app\model\AuthModel;
use Exception;

/**
 *  Authenticate user
 */
class AuthController
{
    public function __construct()
    {
        var_dump($_POST);

        try {
            Transaction::open('db');

            $model = new AuthModel;
            $model->setConnection(Transaction::get());

            Transaction::close();
        }
        catch( Exception $e ) {
            echo $e->getMessage();
            Transaction::rollback();
        }


    }
}

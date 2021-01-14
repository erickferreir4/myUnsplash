<?php declare(strict_types=1);

namespace app\controller;

use app\helpers\Transaction;
use app\lib\LoggerTXT;
use app\lib\LoggerHTML;
use app\model\AuthModel;
use Exception;

/**
 *  Authenticate user
 */
class AuthController
{
    private static $model;

    public function __construct()
    {
        $email = isset($_POST['email']) ? $_POST['email'] : '';

        if($this->authUser($email)) {
            session_start();
            $_SESSION['login'] = $email;
            header('location:index');
        }
        else {
            unset($_SESSION['login']);
            header('location:login');
        }
    }

    /**
     *  Authenticate user
     *  @param {string} $email - email user
     */
    private function authUser(string $email) {

        try {
            Transaction::open('db'); 
            Transaction::setLogger(new LoggerHTML('log.html'));

            self::$model = new AuthModel;

            if( $this->userNotExists($email) ) {
                $this->saveUser($email);
            }

            //var_dump($this->getAllUsers());
            Transaction::close();

            return true;

        } catch( Exception $e ) {
            Transaction::rollback();
            Transaction::log($e->getMessage());
            echo $e->getMessage();
        }
    }

    /**
     *  Check user exists
     *  @param {string} $email - email user
     */
    private function userNotExists(string $email) : bool
    {
        return empty(self::$model->find($email));
    }

    /**
     *  Get all users
     *  @param {string} $email - email user
     */
    private function getAllUsers()
    {
        return self::$model->all(); 
    }

    /**
     *  Save user
     *  @param {string} $email - email user
     */
    private function saveUser(string $email) : bool
    {
        return self::$model->save($email);
    }

    /**
     *  Delete user
     *  @param {string} $email - email user
     */
    private function deleteUser(string $email) : bool
    {
        return self::$model->delete($email);
    }
}

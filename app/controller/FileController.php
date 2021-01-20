<?php declare(strict_types=1);

namespace app\controller;

use app\model\FileModel;
use Exception;
use stdClass;

class FileController
{
    private static $model;

    public function __construct()
    {
        session_start();

        if( $_FILES['userfile']['error'] !== 0 ) {
            header('location:index');
            die();
        }

        $data = new stdClass;
        $data->email = $_SESSION['login'];
        $data->file = filter_var($_FILES['userfile']['name'], FILTER_SANITIZE_SPECIAL_CHARS);
        $data->file_url = $_POST['photo-url']; 
        $data->label = filter_var($_POST['label'], FILTER_SANITIZE_SPECIAL_CHARS);

        $this->saveFiles($data);
    }

    private function saveFiles($data)
    {
        self::$model = new FileModel;
        $uploaddir = __DIR__ . '/../uploads/';
        $uploadfile = $uploaddir . basename($data->file);

        if( move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile) ) {
            try {
                //self::$model->save($data);
                self::$model->close();
                header('location:index');
            } catch( Exception $e ) {
                self::$model->rollback($e->getMessage());
                echo $e->getMessage();
            }
        }else {
            header('location:index');
        }
    }

}

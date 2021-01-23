<?php declare(strict_types=1);

namespace app\controller;

use app\model\FileModel;
use Exception;
use stdClass;

/**
 *  File Controller
 */
class FileController
{
    private static $model;

    public function __construct()
    {
        $action = explode('/', $_SERVER['REQUEST_URI'])[2];

        if( method_exists($this, $action) ) {
            $this->$action();
        }
        else {
            header('location:/index');
        }
    }

    /**
     *  Delete
     */
    private function delete()
    {
        session_start();
        $data = new stdClass;
        $data->email = $_SESSION['login'];
        $data->file = filter_var($_POST['photo_url'], FILTER_SANITIZE_SPECIAL_CHARS);
        
        $this->deleteFiles($data);
    }

    /**
     *  Delete Files
     *  @param {object] $data - email & file attributes
     */
    private function deleteFiles($data)
    {
        if( !empty($data->file) && !empty($data->email)) {
            $model = new FileModel;
            try {
                $model->delete($data);
                $model->close();
                header('location:/index');
            } catch( Exception $e ) {
                $model->rollback($e->getMessage());
                header('location:/index');
            }
        }
        else {
            header('location:/index');
        }
    }

    /**
     *  Add files
     */
    private function add()
    {
        session_start();
        $data = new stdClass;
        $data->email = $_SESSION['login'];
        $data->file_url = filter_var($_POST['photo-url'], FILTER_SANITIZE_SPECIAL_CHARS);
        $data->label = filter_var($_POST['label'], FILTER_SANITIZE_SPECIAL_CHARS);

        $this->saveFiles($data);
    }

    /**
     *  Save Files
     *  @param {object} $data - email, url and label attributes to save
     */
    private function saveFiles($data)
    {
        if( !empty($data->file_url) ) {
            self::$model = new FileModel;
            try {
                self::$model->save($data);
                self::$model->close();
                header('location:/index');
            } catch( Exception $e ) {
                self::$model->rollback($e->getMessage());
                header('location:/index');
            }
        }else {
            header('location:/index');
        }
    }
}

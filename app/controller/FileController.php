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
            header('location:/');
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
        $data->id = filter_var($_POST['id'], FILTER_SANITIZE_SPECIAL_CHARS);
        
        //echo json_encode($data);
        //var_dump($data);
        $this->deleteFiles($data);
    }

    /**
     *  Delete Files
     *  @param {object] $data - email & file attributes
     */
    private function deleteFiles($data)
    {
        if( !empty($data->file) && !empty($data->email) && !empty($data->id)) {
            $model = new FileModel;
            try {
                $model->delete($data);
                $model->close();
                header('location:/');
            } catch( Exception $e ) {
                $model->rollback($e->getMessage());
                header('location:/');
            }
        }
        else {
            header('location:/');
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

        if( filter_var($data->file_url, FILTER_VALIDATE_URL) ) {
            $this->saveFiles($data);
        }
        else {
            header('location:/');
        }
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
                header('location:/');
            } catch( Exception $e ) {
                self::$model->rollback($e->getMessage());
                header('location:/');
            }
        }else {
            header('location:/');
        }
    }
}

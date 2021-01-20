<?php declare(strict_types=1);

namespace app\controller;

use app\traits\TemplateTrait;
use app\lib\Assets;
use app\model\FileModel;
use Exception;

/**
 *  Index Controller
 */
class IndexController
{
    use TemplateTrait;

    public function __construct()
    {
        session_start();
        if(!isset($_SESSION['login'])) {
           header('location:login'); 
        }

        $this->addAssets();
        $this->setTitle('Home');
        $this->layout('Index');

        echo '<pre>';
        var_dump($_SESSION);
        var_dump($this->getFiles($_SESSION['login']));
    }

    public function addAssets()
    {
        $this->setAssets( new Assets );

        $this->addCss('index');
        $this->addCss('header');
        $this->addJs('index');
    }

    public function getFiles($email)
    {
        $model = new FileModel;

        try {
            $result = $model->find($email);
            $model->close();
            return $result;
        } catch( Exception $e ) {
            $model->rollback($e->getMessage());
            echo $e->getMessage();
        }
    }
}

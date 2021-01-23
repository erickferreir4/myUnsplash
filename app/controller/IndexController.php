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
        //session_destroy();
    }

    public function addAssets()
    {
        $this->setAssets( new Assets );

        $this->addCss('index');
        $this->addCss('header');
        $this->addJs('index');
    }

    public function toHtml($result)
    {
        $html = '';
        foreach( $result as $value ) {
            $figure = file_get_contents(__DIR__ . '/../html/templates/figure.html');
            $figure = str_replace('[[SRC]]', $value->photo_url, $figure);
            $figure = str_replace('[[LABEL]]', $value->label, $figure);
            $html .= $figure;
        }

        return $html;
    }

    public function getFiles($email)
    {
        $model = new FileModel;

        try {
            $result = $model->find($email);
            //$result = $model->all();
            $model->close();
            return $result;
        } catch( Exception $e ) {
            $model->rollback($e->getMessage());
            echo $e->getMessage();
        }
    }
}

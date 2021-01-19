<?php declare(strict_types=1);

namespace app\controller;

use app\traits\TemplateTrait;
use app\lib\Assets;

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

        var_dump($_SESSION);
    }

    public function addAssets()
    {
        $this->setAssets( new Assets );

        $this->addCss('index');
        $this->addCss('header');
        $this->addJs('index');
    }
}

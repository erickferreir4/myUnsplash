<?php declare(strict_types=1);

namespace app\controller;

use app\traits\TemplateTrait;
use app\lib\Assets;

class NotFoundController
{
    use TemplateTrait;

    public function __construct()
    {
        $this->addAssets();
        $this->setTitle('404');
        $this->layout('NotFound');
    }
    /**
     *  Add Assets to view
     */
    public function addAssets()
    {
        $this->setAssets( new Assets );

        $this->addCss('notfound');
    }
}

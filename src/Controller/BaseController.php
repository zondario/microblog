<?php


namespace App\Controller;


abstract class BaseController
{
    /**
     * Not nice but obviously cannot make it work with just the view engine as the app god class holds the logic about
     * rendering
     * @var \Slim\Slim
     */
    protected $app;

    public function setApp($app)
    {
        $this->app = $app;
    }

}
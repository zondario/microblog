<?php


namespace App\Controller;


use Slim\Http\Request;
use Slim\Http\Response;

abstract class BaseController
{
    /**
     * Not nice but obviously cannot make it work with just the view engine as the app god class holds the logic about
     * rendering
     * @var \Slim\Slim
     */
    protected $app;
    /**
     * @var \Slim\Http\Request
     */
    protected $request;
    /**
     * @var \Slim\Http\Response
     */
    protected $response;

    public function setApp($app)
    {
        $this->app = $app;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function setResponse(Response $request)
    {
        $this->response = $request;
    }
}
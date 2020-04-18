<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 18-Apr-20
 * Time: 3:19 PM
 */

namespace App\Tests\Services\Validators\Request;


use Slim\Environment;
use Slim\Http\Request;

class RequestMocker
{
    public static function mockPost($array)
    {
        return new Request(Environment::mock([
            'REQUEST_METHOD' => 'POST',
            'slim.input' => http_build_query($array),
            'SERVER_NAME' => 'localhost',
            'CONTENT_TYPE' => 'application/x-www-form-urlencoded'
        ]));
    }
}
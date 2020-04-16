<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 16-Apr-20
 * Time: 10:10 PM
 */

namespace App\Services\Validators\Request;


use Slim\Http\Request;

class Login
{
    public static function isValid(Request $request)
    {
        if (!$request->post('username') || !$request->post('password'))
        {
            return false;
        }
        return true;
    }
}
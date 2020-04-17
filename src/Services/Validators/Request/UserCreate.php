<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 17-Apr-20
 * Time: 3:00 PM
 */

namespace App\Services\Validators\Request;


use Slim\Http\Request;

class UserCreate
{
    public static function isValid(Request $request)
    {
        if (!$request->post('username') ||
            !$request->post('password') ||
            !$request->post('first_name')
        ) {
            return false;
        }
        return true;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 17-Apr-20
 * Time: 9:39 PM
 */

namespace App\Services\Validators\Request;


use Slim\Http\Request;

class PostCreate
{
    public static function isValid(Request $request)
    {
        if (!$request->post('title') ||
            !$request->post('content')
        ) {
            return false;
        }

        return true;
    }
}
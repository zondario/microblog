<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 16-Apr-20
 * Time: 10:31 PM
 */

namespace App\Services\Security;

interface AuthenticationManagerInterface
{
    public function login($username, $password);

    public function isLoggedIn();
}
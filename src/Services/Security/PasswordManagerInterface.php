<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 16-Apr-20
 * Time: 10:25 PM
 */

namespace App\Services\Security;


interface PasswordManagerInterface
{
    public function isValid($password, $hash);

    public function hash($password);
}
<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 16-Apr-20
 * Time: 10:22 PM
 */

namespace App\Services\Security;


class PasswordManager implements PasswordManagerInterface
{
    public function isValid($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public function hash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}
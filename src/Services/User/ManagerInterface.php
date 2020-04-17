<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 17-Apr-20
 * Time: 2:46 PM
 */

namespace App\Services\User;

interface ManagerInterface
{
    public function createNewUser($firstName, $lastName, $username, $password);
}
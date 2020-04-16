<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 16-Apr-20
 * Time: 11:59 PM
 */

namespace App\Services\Security;

use App\Entity\User;

interface AuthenticationTokenManagerInterface
{
    public function generateNewToken(User $user);
}
<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 18-Apr-20
 * Time: 2:50 PM
 */

namespace App\Tests\Services\Security;

use App\Services\Security\PasswordManager;

class PasswordManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testGeneratesAndValidatesCorrectlyValidInput()
    {
        $passwordManager = new PasswordManager();
        $password = '123!@#';
        $hash = $passwordManager->hash($password);
        $this->assertTrue($passwordManager->isValid($password, $hash));
    }

    public function testGeneratesAndValidatesCorrectlyInvalidInput()
    {
        $passwordManager = new PasswordManager();
        $password = '123!@#';
        $invalidPassword = '123!@3';
        $hash = $passwordManager->hash($password);
        $this->assertFalse($passwordManager->isValid($invalidPassword, $hash));
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 18-Apr-20
 * Time: 3:25 PM
 */

namespace App\Tests\Services\Validators\Request;

use App\Services\Validators\Request\UserCreate;

class UserCreateTest extends \PHPUnit_Framework_TestCase
{
    public function testIsValidValidInput()
    {
        $array = [
            'username' => 'zxc',
            'password' => 'zxc',
            'first_name' => 'zxc',
            'last_name' => 'asd'
        ];
        $isValid = UserCreate::isValid(RequestMocker::mockPost($array));
        $this->assertTrue($isValid);
    }

    public function testIsValidInvalidInputEmptyUsername()
    {
        $array = [
            'username' => '',
            'password' => 'zxc',
            'first_name' => 'zxc',
            'last_name' => 'asd'
        ];
        $isValid = UserCreate::isValid(RequestMocker::mockPost($array));
        $this->assertFalse($isValid);
    }
    public function testIsValidInvalidInputEmptyPassword()
    {
        $array = [
            'username' => 'dsadsa',
            'password' => '',
            'first_name' => 'zxc',
            'last_name' => 'asd'
        ];
        $isValid = UserCreate::isValid(RequestMocker::mockPost($array));
        $this->assertFalse($isValid);
    }

    public function testIsValidInvalidInputNoUsername()
    {
        $array = [
            'password' => 'asd',
            'first_name' => 'zxc',
            'last_name' => 'asd'
        ];
        $isValid = UserCreate::isValid(RequestMocker::mockPost($array));
        $this->assertFalse($isValid);
    }

    public function testIsValidInvalidInputNoFirstName()
    {
        $array = [
            'username' => 'dsadsa',
            'password' => 'asd',
            'last_name' => 'asd'
        ];
        $isValid = UserCreate::isValid(RequestMocker::mockPost($array));
        $this->assertFalse($isValid);
    }

    public function testIsValidInvalidInputNoLastName()
    {
        $array = [
            'username' => 'dsadsa',
            'password' => 'asd',
            'first_name' => 'zxc'
        ];
        $isValid = UserCreate::isValid(RequestMocker::mockPost($array));
        $this->assertFalse($isValid);
    }
}

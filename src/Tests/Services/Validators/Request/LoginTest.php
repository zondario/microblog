<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 18-Apr-20
 * Time: 3:01 PM
 */

namespace App\Tests\Services\Validators\Request;

use App\Services\Validators\Request\Login;
use Slim\Environment;
use Slim\Http\Request;

class LoginTest extends \PHPUnit_Framework_TestCase
{
    public function testValidInput()
    {
        $array = [
            'username' => 'test',
            'password' => 'test'
        ];
        $isValid = Login::isValid(RequestMocker::mockPost($array));
        $this->assertTrue($isValid);
    }

    public function testInvalidInputNoPassword()
    {
        $array = [
            'username' => 'test',
        ];
        $isValid = Login::isValid(RequestMocker::mockPost($array));
        $this->assertFalse($isValid);
    }
    public function testInvalidInputNoUsername()
    {
        $array = [
            'password' => 'test'
        ];
        $isValid = Login::isValid(RequestMocker::mockPost($array));
        $this->assertFalse($isValid);
    }
}

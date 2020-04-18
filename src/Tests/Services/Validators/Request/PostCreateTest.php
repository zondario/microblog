<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 18-Apr-20
 * Time: 3:42 PM
 */

namespace App\Tests\Services\Validators\Request;

use App\Services\Validators\Request\PostCreate;

class PostCreateTest extends \PHPUnit_Framework_TestCase
{
    public function testIsValidValidInput()
    {
        $array = [
            'title' => 'test',
            'content' => 'test'
        ];
        $isValid = PostCreate::isValid(RequestMocker::mockPost($array));
        $this->assertTrue($isValid);
    }

    public function testIsValidInvalidInputEmptyTitle()
    {
        $array = [
            'title' => '',
            'content' => 'test'
        ];
        $isValid = PostCreate::isValid(RequestMocker::mockPost($array));
        $this->assertFalse($isValid);
    }

    public function testIsValidInvalidInputEmptyContent()
    {
        $array = [
            'title' => 'test',
            'content' => ''
        ];
        $isValid = PostCreate::isValid(RequestMocker::mockPost($array));
        $this->assertFalse($isValid);
    }
}

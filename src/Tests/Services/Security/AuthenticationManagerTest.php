<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 18-Apr-20
 * Time: 2:32 PM
 */

namespace App\Tests\Services\Security;

use App\Config\DoctrineEntityManagerFactory;
use App\Exceptions\Security\AlreadyLoggedInException;
use App\Services\Security\AuthenticationManager;
use App\Services\Security\AuthenticationTokenManager;
use App\Services\Security\PasswordManager;
use App\Services\User\Manager;
use SlimSession\Helper;

class AuthenticationManagerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // workaround for not being able to inject interface in authentication manager
        $GLOBALS['_SESSION'] = [];
    }
    public function testLoginValidInput()
    {
        $entityManager = DoctrineEntityManagerFactory::create();
        $passwordManager = new PasswordManager();
        $userManager = new Manager($entityManager, $passwordManager);
        $session = new Helper();
        $atm = new AuthenticationTokenManager($entityManager);
        $authenticationManager = new AuthenticationManager(
            $entityManager,
            $passwordManager,
            $session,
            $atm
            );
        $username = uniqid();
        $password = uniqid();
        $user = $userManager->createNewUser('Test', 'Test',$username , $password);
        $authenticationManager->login($username, $password);
        $this->assertTrue($authenticationManager->isLoggedIn());
        $entityManager->remove($user);
        $entityManager->flush();
    }

    public function testLoginInvalidInput()
    {
        $entityManager = DoctrineEntityManagerFactory::create();
        $passwordManager = new PasswordManager();
        $session = new Helper();
        $atm = new AuthenticationTokenManager($entityManager);
        $authenticationManager = new AuthenticationManager(
            $entityManager,
            $passwordManager,
            $session,
            $atm
        );
        $authenticationManager->login(uniqid(), uniqid());
        $this->assertFalse($authenticationManager->isLoggedIn());
    }

    public function testLoginTwoTimes()
    {
        $entityManager = DoctrineEntityManagerFactory::create();
        $passwordManager = new PasswordManager();
        $userManager = new Manager($entityManager, $passwordManager);
        $session = new Helper();
        $atm = new AuthenticationTokenManager($entityManager);
        $authenticationManager = new AuthenticationManager(
            $entityManager,
            $passwordManager,
            $session,
            $atm
        );
        $username = uniqid();
        $password = uniqid();
        $user = $userManager->createNewUser('Test', 'Test',$username , $password);
        $authenticationManager->login($username, $password);
        $this->assertTrue($authenticationManager->isLoggedIn());
        $thrown = false;
        try {

            $authenticationManager->login($username, $password);
        } catch (AlreadyLoggedInException $exception) {
            $thrown = true;
        }
        $entityManager->remove($user);
        $entityManager->flush();
        if (!$thrown) {
            $this->fail('Exception not thrown');
        }
    }
}

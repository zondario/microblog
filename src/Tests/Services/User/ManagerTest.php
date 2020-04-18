<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 18-Apr-20
 * Time: 4:55 PM
 */

namespace App\Tests\Services\User;

use App\Config\DoctrineEntityManagerFactory;
use App\Exceptions\Security\InvalidArgumentSuppliedException;
use App\Exceptions\Security\UserAlreadyExistsException;
use App\Services\Security\PasswordManager;
use App\Services\User\Manager;

class ManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateNewUserValidInput()
    {
        $entityManager = DoctrineEntityManagerFactory::create();
        $passwordManager = new PasswordManager();
        $userManager = new Manager($entityManager, $passwordManager);
        $user = $userManager->createNewUser('Test', 'Test', uniqid(),'123');
        $this->assertNotNull($user->getId());
        $entityManager->remove($user);
        $entityManager->flush();
    }

    public function testCreateNewUserInvalidInputDuplicateUsername()
    {
        $entityManager = DoctrineEntityManagerFactory::create();
        $passwordManager = new PasswordManager();
        $userManager = new Manager($entityManager, $passwordManager);
        $user = $userManager->createNewUser('Test', 'Test', 'asd','123');
        $this->assertNotNull($user->getId());
        $hasException = false;
        try {
            $userManager->createNewUser('Test', 'Test', 'asd','123');
        } catch (UserAlreadyExistsException $exception) {
            $hasException = true;
        }
        $entityManager->remove($user);
        $entityManager->flush();
        if (!$hasException) {
            $this->fail('Exception was not thrown');
        }
    }

    public function testCreateNewUserInvalidInputEmptyUsername()
    {
        $this->expectException(InvalidArgumentSuppliedException::class);
        $entityManager = DoctrineEntityManagerFactory::create();
        $passwordManager = new PasswordManager();
        $userManager = new Manager($entityManager, $passwordManager);
        $userManager->createNewUser('Test', 'Test', null,'123');
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 18-Apr-20
 * Time: 4:45 PM
 */

namespace App\Tests\Services\Security;

use App\Config\DoctrineEntityManagerFactory;
use App\Entity\User;
use App\Services\Security\AuthenticationTokenManager;

class AuthenticationTokenManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateNewToken()
    {
        $entityManager = DoctrineEntityManagerFactory::create();
        $atm = new AuthenticationTokenManager($entityManager);
        $userRepo = $entityManager->getRepository(User::class);
        $user = $userRepo->findOneByUsername('admin');
        $token = $atm->generateNewToken($user);
        $this->assertNotEmpty($token->getId());
        $entityManager->remove($token);
        $entityManager->flush();
    }
}

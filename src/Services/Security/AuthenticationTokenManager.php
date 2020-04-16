<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 16-Apr-20
 * Time: 11:56 PM
 */

namespace App\Services\Security;


use App\Entity\AuthenticationToken;
use App\Entity\User;
use Doctrine\ORM\EntityManager;

class AuthenticationTokenManager implements AuthenticationTokenManagerInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function generateUid($length)
    {
        return substr(hash('md5', uniqid('', true)), 0, $length);
    }

    public function generateNewToken(User $user)
    {
        $token = $this->generateUid(32);
        $authToken = new AuthenticationToken();
        $now = new \DateTime();
        $expires = new \DateTime('+5 minutes');
        $authToken->setCreatedAt($now);
        $authToken->setExpires($expires);
        $authToken->setUser($user);
        $authToken->setToken($token);
        $this->entityManager->persist($authToken);
        $this->entityManager->flush();
        return $authToken;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 17-Apr-20
 * Time: 2:42 PM
 */

namespace App\Services\User;


use App\Entity\User;
use App\Exceptions\Security\UserAlreadyExists;
use App\Services\Security\PasswordManagerInterface;
use Doctrine\ORM\EntityManager;

class Manager implements ManagerInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var PasswordManagerInterface
     */
    private $passwordManager;

    public function __construct(EntityManager $entityManager, PasswordManagerInterface $passwordManager)
    {
        $this->entityManager = $entityManager;
        $this->passwordManager = $passwordManager;
    }

    public function createNewUser($firstName, $lastName, $username, $password)
    {
        $repo = $this->entityManager->getRepository(User::class);
        $possibleUserWithSameUsername = $repo->findBy(['username' => $username]);
        if ($possibleUserWithSameUsername) {
            throw new UserAlreadyExists();
        }
        $user = new User();
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setUsername($username);
        $user->setCreatedAt(new \DateTime());
        $user->setPassword($this->passwordManager->hash($password));
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }
}
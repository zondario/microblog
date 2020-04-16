<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 16-Apr-20
 * Time: 10:17 PM
 */

namespace App\Services\Security;

use App\Entity\AuthenticationToken;
use App\Entity\User;
use App\Exceptions\Security\AlreadyLoggedInException;
use Doctrine\ORM\EntityManager;

class AuthenticationManager implements AuthenticationManagerInterface
{
    const AUTHENTICATION_TOKEN_KEY = 'auth_token';

    private $entityManager;
    /**
     * @var PasswordManagerInterface
     */
    private $passwordManager;
    /**
     * @var \SlimSession\Helper
     */
    private $session;
    /**
     * @var AuthenticationTokenManagerInterface
     */
    private $authenticationTokenManager;

    public function __construct(
        EntityManager $entityManager,
        PasswordManagerInterface $passwordManager,
        \SlimSession\Helper $session,
        AuthenticationTokenManagerInterface $authenticationTokenManager
    ) {
        $this->entityManager = $entityManager;
        $this->passwordManager = $passwordManager;
        $this->session = $session;
        $this->authenticationTokenManager = $authenticationTokenManager;
    }

    public function login($username, $password)
    {
        $repo = $this->entityManager->getRepository(User::class);
        $possibleUser = $repo->findOneBy(['username' => $username]);
        if (!$possibleUser) {
            return false;
        }
        $dbPassword = $possibleUser->getPassword();
        if ($this->passwordManager->isValid($password, $dbPassword)) {
            $this->doLogin($possibleUser);
        }
        return true;
    }

    protected function doLogin($user)
    {
        if ($this->isLoggedIn()) {
            throw new AlreadyLoggedInException();
        }
        $token = $this->authenticationTokenManager->generateNewToken($user);
        $this->session->set(self::AUTHENTICATION_TOKEN_KEY, $token->getToken());
        $this->session->set('user_id', $user->getId());
    }

    public function isLoggedIn()
    {
        $token = $this->session->get(self::AUTHENTICATION_TOKEN_KEY);
        if (!$token) {
            return false;
        }
        $repo = $this->entityManager->getRepository(AuthenticationToken::class);
        $dbToken = $repo->findOneActiveByToken($token, $this->session->get('user_id'));
        if ($dbToken) {
            return true;
        }
        $this->session->delete(self::AUTHENTICATION_TOKEN_KEY);
        return false;
    }


}
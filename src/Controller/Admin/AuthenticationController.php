<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 16-Apr-20
 * Time: 9:26 PM
 */

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Exceptions\Security\AlreadyLoggedInException;
use App\Services\Security\AuthenticationManagerInterface;
use App\Services\Validators\Request\Login;
use Doctrine\ORM\EntityManager;

class AuthenticationController extends BaseController
{
    private $entityManager;
    /**
     * @var AuthenticationManagerInterface
     */
    private $authenticationManager;

    public function __construct(EntityManager $entityManager, AuthenticationManagerInterface $authenticationManager)
    {
        $this->entityManager = $entityManager;
        $this->authenticationManager = $authenticationManager;
    }
    public function login()
    {
        if ($this->authenticationManager->isLoggedIn()) {
            $this->app->redirectTo('home');
        }
        $this->app->render('admin/login.html.twig', []);
    }
    public function loginPost()
    {
        if (!Login::isValid($this->request)) {
            $this->app->render('admin/login.html.twig', ['requestNotValid' => true]);
        }
        $login = false;
        try
        {
            $login = $this->authenticationManager->login(
                $this->request->post('username'),
                $this->request->post('password')
            );
        } catch (AlreadyLoggedInException $alreadyLoggedInException) {
            $this->app->redirectTo('home');
        }
        if (!$login) {
            $this->app->render('admin/login.html.twig', ['authError' => true]);
        }
    }
}
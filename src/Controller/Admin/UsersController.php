<?php

namespace App\Controller\Admin;

use App\Services\Security\AuthenticationManagerInterface;
use App\Services\User\Manager;
use App\Services\Validators\Request\UserCreate;

class UsersController extends AdminBaseController
{
    /**
     * @var Manager
     */
    private $userManager;

    public function __construct(Manager $userManager, AuthenticationManagerInterface $authenticationManager)
    {
        $this->userManager = $userManager;
        parent::__construct($authenticationManager);
    }

    public function create()
    {
        $this->authenticate();
        $this->app->render('admin/user_create.html.twig');
    }

    public function createPost()
    {
        $this->authenticate();
        if (!UserCreate::isValid($this->request))
        {
            $this->app->render('admin/user_create.html.twig',
                [
                    'error' => true,
                    'message' => 'All fields are required'
                ]
            );
        }
        $user = $this->userManager->createNewUser(
            $this->request->post('first_name'),
            $this->request->post('last_name'),
            $this->request->post('username'),
            $this->request->post('password')
        );
        $this->app->render('admin/user_create.html.twig',
            [
                'error' => false,
                'user' => $user
            ]
        );
    }
}
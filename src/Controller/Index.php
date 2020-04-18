<?php

namespace App\Controller;

use App\Services\Post\ManagerInterface;
use App\Services\Security\AuthenticationManagerInterface;
use Doctrine\ORM\EntityManager;

class Index extends BaseController
{
    /**
     * @var ManagerInterface
     */
    private $postManager;

    public function __construct(ManagerInterface $postManager)
    {
        $this->postManager = $postManager;
    }

    public function execute($page = 1)
    {
        $allPosts = $this->postManager->getPostsPagination($page, 10);
        $this->app->render('index.html.twig', ['posts' => $allPosts]);
    }

}
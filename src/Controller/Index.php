<?php

namespace App\Controller;

use App\Services\Security\AuthenticationManagerInterface;
use Doctrine\ORM\EntityManager;

class Index extends BaseController
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function execute()
    {
        $this->app->render('index.html.twig', []);
    }

}
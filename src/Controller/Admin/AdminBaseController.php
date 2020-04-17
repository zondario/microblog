<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 17-Apr-20
 * Time: 2:51 PM
 */

namespace App\Controller\Admin;


use App\Controller\BaseController;
use App\Services\Security\AuthenticationManagerInterface;

abstract class AdminBaseController extends BaseController
{
    /**
     * @var AuthenticationManagerInterface
     */
    protected $authenticationManager;

    public function __construct(AuthenticationManagerInterface $authenticationManager)
    {
        $this->authenticationManager = $authenticationManager;
    }
    protected function authenticate()
    {
        if (!$this->authenticationManager->isAuthenticated()) {
            $this->app->halt(403);
        }
    }
}
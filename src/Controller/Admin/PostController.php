<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 17-Apr-20
 * Time: 9:23 PM
 */

namespace App\Controller\Admin;


use App\Services\Post\Manager;
use App\Services\Post\ManagerInterface;
use App\Services\Security\AuthenticationManagerInterface;
use App\Services\Validators\Request\PostCreate;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PostController extends AdminBaseController
{
    /**
     * @var ManagerInterface
     */
    private $postManager;

    public function __construct(ManagerInterface $postManager, AuthenticationManagerInterface $authenticationManager)
    {
        $this->postManager = $postManager;
        parent::__construct($authenticationManager);
    }

    public function create()
    {
        $this->authenticate();
        $this->app->render('admin/posts/create.html.twig');
    }
    public function createPost()
    {
        $this->authenticate();
        if (!PostCreate::isValid($this->request)) {
            $this->app->render('admin/posts/create.html.twig',
                ['error' => true, 'errorMessage' => 'Title and content fields are required!']
            );
        }
        $this->postManager->createNewPost(
            $this->request->post('title'),
            $this->request->post('content'),
            $this->authenticationManager->getUser()
        );
        $this->app->redirectTo('posts_admin_list');
    }
    public function listAll($page = 1)
    {
        $this->authenticate();
        $allPosts = $this->postManager->getPostsPagination($page, 10);
        $this->app->render('admin/posts/list.html.twig', ['posts' => $allPosts]);
    }
    public function delete($id)
    {
        $this->authenticate();
        $this->postManager->deletePost($id);
        $this->app->redirectTo('posts_admin_list');
    }
    public function edit($id)
    {
        $this->authenticate();
        if (PostCreate::isValid($this->request)) {
           $this->postManager->edit(
               $id,
               $this->request->post('title'),
               $this->request->post('content'));
        }
        $this->app->redirectTo('posts_admin_list');
    }
}
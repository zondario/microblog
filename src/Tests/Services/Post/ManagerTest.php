<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 18-Apr-20
 * Time: 4:10 PM
 */

namespace App\Tests\Services\Post;

use App\Config\DoctrineEntityManagerFactory;
use App\Entity\Post;
use App\Exceptions\Security\InvalidArgumentSuppliedException;
use App\Services\Post\Manager;

class ManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateNewPostAndDeleteValidInput()
    {
        $entityManager = DoctrineEntityManagerFactory::create();
        $postManager = new Manager($entityManager);
        $newPost = $postManager->createNewPost('test', 'test',null);
        $repo = $entityManager->getRepository(Post::class);
        $this->assertNotNull($repo->findOneById($newPost->getId()));
        $postManager->deletePost($newPost->getId());
        $this->assertNull($repo->findOneById($newPost->getId()));
    }

    public function testCreateNewPostInvalidInputEmptyTitle()
    {
        $this->expectException(InvalidArgumentSuppliedException::class);
        $entityManager = DoctrineEntityManagerFactory::create();
        $postManager = new Manager($entityManager);
        $postManager->createNewPost('', 'test',null);
    }

    public function testEditPostValidInput()
    {
        $entityManager = DoctrineEntityManagerFactory::create();
        $postManager = new Manager($entityManager);
        $post = $postManager->createNewPost('test', 'zxc',null);
        $postManager->edit($post->getId(),'test123', 'content123');
        $repo = $entityManager->getRepository(Post::class);
        $edited = $repo->findOneById($post->getId());
        $this->assertEquals('test123', $edited->getTitle());
        $this->assertEquals('content123', $edited->getContent());
        $postManager->deletePost($post->getId());
    }

    public function testEditPostInValidInputEmptyTitle()
    {
        $entityManager = DoctrineEntityManagerFactory::create();
        $postManager = new Manager($entityManager);
        $post = $postManager->createNewPost('test', 'zxc',null);
        try {
            $postManager->edit($post->getId(),'', 'content123');
        }catch (InvalidArgumentSuppliedException $exception) {
           $this->assertEquals('Title cannot be empty', $exception->getMessage());
        }
        $postManager->deletePost($post->getId());
    }

    public function testEditPostInValidInputEmptyContent()
    {
        $entityManager = DoctrineEntityManagerFactory::create();
        $postManager = new Manager($entityManager);
        $post = $postManager->createNewPost('test', 'zxc',null);
        try {
            $postManager->edit($post->getId(),'test', '');
        }catch (InvalidArgumentSuppliedException $exception) {
            $this->assertEquals('Content cannot be empty', $exception->getMessage());
        }
        $postManager->deletePost($post->getId());
    }
}

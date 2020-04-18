<?php

namespace App\Services\Post;


use App\Entity\Post;
use App\Entity\User;
use App\Exceptions\Security\InvalidArgumentSuppliedException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator;

class Manager implements ManagerInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;


    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function createNewPost($title, $content, User $author = null)
    {
        $post = new Post();
        $post->setCreatedAt(new \DateTime());
        $post->setTitle($title);
        $post->setAuthor($author);
        $post->setContent($content);
        $this->entityManager->persist($post);
        $this->entityManager->flush();
        return $post;
    }

    public function getPostsPagination($page, $perPage)
    {
        $repo = $this->entityManager->getRepository(Post::class);
        return $paginator = new Paginator($repo->getPostsQuery($page, $perPage), false);
    }

    public function deletePost($id)
    {
        $post = $this->entityManager->getReference(Post::class, $id);
        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }

    public function edit($id, $title, $content)
    {
        $post = $this->entityManager->getReference(Post::class, $id);
        $post->setTitle($title);
        $post->setContent($content);
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }
}
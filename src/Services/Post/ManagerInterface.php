<?php
/**
 * Created by PhpStorm.
 * User: Notebook
 * Date: 17-Apr-20
 * Time: 2:46 PM
 */

namespace App\Services\Post;

use App\Entity\User;

interface ManagerInterface
{
    public function createNewPost($title, $content, User $author = null);

    public function getPostsPagination($page, $perPage);

    public function deletePost($id);

    public function edit($id, $title, $content);
}
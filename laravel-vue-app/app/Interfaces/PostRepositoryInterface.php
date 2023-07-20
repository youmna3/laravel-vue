<?php

namespace App\Interfaces;

interface PostRepositoryInterface
{
    public function getAllPosts();
    public function createPost($attributes);
    // public function addImage($post, $paths);
    public function delete($id);
}
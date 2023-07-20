<?php

namespace App\Repositories;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use \App\Models\Image;
use Illuminate\Support\Facades\Storage;

class PostRepository implements PostRepositoryInterface
{
    public function getAllPosts()
    {
        return Post::with('images')->get();
    }

    public function createPost($attributes)
    {
        return Post::create($attributes);
    }
    /*
    public function addImage($post, $paths)
    {
        foreach ($paths as $path) {
            $post->images()->create(['image_url' => $path]);
        }
    }
    */
    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $images = $post->images;
        $post->delete();
        foreach ($images as $image) {
            // delete images from storage and db
            Storage::delete($image->image_url);
            $image->delete();
        }

    }
}
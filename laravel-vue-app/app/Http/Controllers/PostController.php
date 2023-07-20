<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Interfaces\PostRepositoryInterface;
use App\Http\Requests\StorePostRequest;

class PostController extends Controller
{

    protected $postRepository;
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = $this->postRepository->getAllPosts();
        return response()->json([
            'Posts' => $posts
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    /*
    public function store(StorePostRequest $request)
    {
        try {
            // $validated = $request->validated();
            // $posts = $this->postRepository->createPost($validated);
            $productAttributes = $request->only(['post']);


            if ($request->hasFile('image')) {
                $images = $request->file('image');
                $imagePath = [];
                foreach ($images as $image) {
                    $path = $image->store('images');
                    $imagePath[] = $path;
                }
                $this->postRepository->addImage($productAttributes, $imagePath);
            } else {
                $posts = $this->postRepository->createPost($productAttributes);

            }

            return response()->json([
                'posts' => $posts,
                'message' => 'successfully added post'

            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
*/
    public function store(StorePostRequest $request)
    {
        try {
            // $validated = $request->validated();
            $postAttribute = $request->only(['post']);
            $post = $this->postRepository->createPost($postAttribute);

            if ($request->hasFile('images')) {
                $images = $request->file(['images']);
                foreach ($images as $image) {
                    $path = $image->store('images');
                    $post->images()->create(['image_url' => $path]);
                }
                //     $imagePath = [];
                //     foreach ($images as $image) {
                //         $path = $image->store('images');
                //         $imagePath = $path;

                //     }
                //     $this->postRepository->addImage($postAttribute, $imagePath);
            }

            return response()->json([
                'post' => $post,
                'message' => 'successfully added post'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->postRepository->delete($id);
        return response()->json([
            'message' => "post deleted",
        ], 200);
    }
}
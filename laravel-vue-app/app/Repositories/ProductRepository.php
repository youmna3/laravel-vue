<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\Image;


class ProductRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        $products = Product::with('images')->get();

        return response()->json([
            'products' => $products

        ], 200);
    }
    public function createProduct($attributes)
    {
        return Product::create($attributes);
    }
    public function addImageToProduct($product, $imagePaths)
    {

        // $image = new Image(['image_url' => $imagePath]);
        // return $product->images()->save($image);
        foreach ($imagePaths as $imagePath) {
            $image = new Image(['image_url' => $imagePath]);
            $product->images()->save($image);
        }

    }
    public function updateProduct($id, $attributes)
    {
        $product = Product::findOrFail($id);
        $product->update($attributes);
        return $product;

    }
    public function updateProductImage($id, $imagePath)
    {
        $product = Product::findOrFail($id);
        $images = $product->images;
        if ($images->isNotEmpty()) {
            // Update all existing images
            foreach ($images as $image) {
                $image->image_url = $imagePath;
                $image->save();
            }
        } else {
            // Add a new image
            $product->image()->createMany(['image_url' => $imagePath]);
        }

    }
    public function findProductById($id)
    {
        return Product::findOrFail($id);
    }
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'message' => "product deleted",
        ], 200);

    }

}
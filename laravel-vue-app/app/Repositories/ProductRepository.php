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

        // return response()->json([
        //     'product' => $product,

        // ], 200);
    }
    public function addImageToProduct($product, $imagePath)
    {
        // $product = new Product;
        $image = new Image([
            // 'imageable_id' => $product->id,
            // 'imageable_type' => 'App\Models\Product',
            'image_url' => $imagePath
        ]);
        return $product->images()->save($image);

    }
    public function editProduct($id, $attributes)
    {
        $product = Product::findOrFail($id);
        $product->update($attributes);

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product,
        ], 200);
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
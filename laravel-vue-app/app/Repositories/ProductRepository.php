<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        $products = Product::all();
        return response()->json([
            'products' => $products

        ], 200);
    }
    public function createProduct($attributes)
    {
        $product = Product::create($attributes);

        return response()->json([
            'product' => $product,
        ], 200);
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
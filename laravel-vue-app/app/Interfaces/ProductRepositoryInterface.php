<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getAll();
    public function createProduct($attributes);
    public function addImageToProduct($product, $imagePath);
    public function updateProduct($id, $attributes);
    public function findProductById($id);
    public function updateProductImage($id, $imagePaths);

    public function deleteProduct($id);
}
<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getAll();
    public function createProduct($attributes);
    public function addImageToProduct($product, $imagePath);
    public function updateProduct($attributes, $id);
    public function updateProductImage($imagePath, $id);
    public function findProductById($id);

    public function deleteProduct($id);
}
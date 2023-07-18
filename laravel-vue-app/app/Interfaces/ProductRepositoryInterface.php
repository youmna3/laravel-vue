<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getAll();
    public function createProduct($attributes);
    public function addImageToProduct($product, $imagePath);
    public function editProduct($id, $attributes);
    // public function updateProductImage($id, $imagePath);
    public function findProductById($id);

    public function deleteProduct($id);
    // public function deleteImage($id);
}
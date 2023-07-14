<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getAll();
    public function createProduct($attributes);
    public function editProduct($id, $attributes);
    public function deleteProduct($id);
}
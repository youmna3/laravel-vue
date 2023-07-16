<?php

namespace App\Services;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Arr;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function storeProduct($data)
    {
        $productData = Arr::only($data, ['name', 'description', 'price']);
        $product = $this->productRepository->createProduct($productData);

        // Associate an image with the product, if provided
        if (Arr::has($data, 'image')) {
            $images = Arr::get($data, 'image');
            $imagePath = [];
            foreach ($images as $image) {
                $path = $image->store('images');
                $imagePath[] = $path;
            }
            $image = $this->productRepository->addImageToProduct($product, $imagePath);
        }

        return [
            'product' => $product,

        ];

    }

}
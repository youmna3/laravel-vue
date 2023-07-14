<?php

namespace App\Http\Controllers;


use App\Http\Requests\ProductStoreRequest;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use SebastianBergmann\Environment\Console;
use App\Jobs\UpdateStatus;

class ProductController extends Controller
{

    private ProductRepositoryInterface $productRepository;
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function index()
    {
        UpdateStatus::dispatch()->onQueue('default');

        return $this->productRepository->getAll();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $validated = $request->validated();

        return $this->productRepository->createProduct($validated);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, ProductStoreRequest $request)
    {
        $validated = $request->validated();
        return $this->productRepository->editProduct($id, $validated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->productRepository->deleteProduct($id);
    }
}
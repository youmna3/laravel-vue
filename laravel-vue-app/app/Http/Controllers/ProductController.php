<?php

namespace App\Http\Controllers;


use App\Http\Requests\ProductStoreRequest;
// use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Services\ProductService;
use Illuminate\Http\Request;
use SebastianBergmann\Environment\Console;
use App\Jobs\UpdateStatus;

class ProductController extends Controller
{

    // private ProductRepositoryInterface $productRepository;
    // public function __construct(ProductRepositoryInterface $productRepository)
    // {
    //     $this->productRepository = $productRepository;
    // }
    protected $productService;
    protected $productRepository;

    public function __construct(ProductService $productService, ProductRepositoryInterface $productRepository, )
    {
        $this->productService = $productService;
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
        try {
            $validated = $request->validated();
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image');
            }
            $result = $this->productService->storeProduct($validated);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    // public function update($id, ProductStoreRequest $request)
    // {
    //     $validated = $request->validated();
    //     return $this->productRepository->editProduct($id, $validated);
    // }
    public function update($id, ProductStoreRequest $request)
    {
        $validated = $request->validated();
        $productAttributes = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
        ];

        $this->productRepository->updateProduct($id, $productAttributes);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images');
            $this->productRepository->updateProductImage($id, $path);
        }

        $product = $this->productRepository->findProductById($id);

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $product
        ]);
    }
    public function show($id)
    {
        $product = $this->productRepository->findProductById($id);
        return response()->json([
            // 'message' => 'Product updated successfully',
            'data' => $product
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->productRepository->deleteProduct($id);
    }
}
<?php

namespace App\Http\Controllers;


use App\Http\Requests\ProductStoreRequest;
// use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use SebastianBergmann\Environment\Console;
use App\Jobs\UpdateStatus;

class ProductController extends Controller
{

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

        $products = $this->productRepository->getAll();
        return response()->json([
            'products' => $products

        ], 200);

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

    public function update($id, ProductStoreRequest $request)
    {
        //
        $validated = $request->validated();
        $product = $this->productRepository->editProduct($id, $validated);
        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product,
        ], 200);

    }


    public function show($id)
    {
        $product = $this->productRepository->findProductById($id);

        return response()->json([
            'message' => 'Product info',
            'product' => $product,

        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->productRepository->deleteProduct($id);
        return response()->json([
            'message' => "product deleted",
        ], 200);
    }

}
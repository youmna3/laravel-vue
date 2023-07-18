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


    /*
public function update(ProductStoreRequest $request, $id)
{
    logger('Update method called with ID: ' . $id);

    try {
        $validated = $request->validated();
        $productAttributes = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
        ];

        $this->productRepository->editProduct($id, $productAttributes);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images');
            $this->productRepository->updateProductImage($id, $path);
        }

        return response()->json([

            'message' => 'Product updated successfully',
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
}
*/
    /*
        public function update(ProductStoreRequest $request, $id)
        {
            // dd('Update method called');

            try {
                $product = Product::findOrFail($id);
                // dd($request->all());

                $product->update([
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                    'price' => $request->input('price'),
                ]);
                // Delete old images
                $product->images()->delete();

                // Add new images
                if ($request->hasFile('image')) {
                    foreach ($request->file('image') as $image) {
                        // dd($image);
                        $path = $image->store('images');
                        // dd($path);
                        $product->images()->create(['image_url' => $path]);
                    }
                }


                return response()->json([

                    'message' => 'Product updated successfully',
                ], 200);

            } catch (\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage()
                ], 500);
            }
        }
        
        /**
         * Remove the specified resource from storage.
         */
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
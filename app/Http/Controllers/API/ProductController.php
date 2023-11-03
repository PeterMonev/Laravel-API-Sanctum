<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Controllers\API\BaseController;

class ProductController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['getAllProducts', 'getSingleProduct', 'createProduct', 'deleteProduct']]);
    }

    // Get all products
    public function getAllProducts()
    {
        $products = Product::all();

        if (is_null($products)) {
            return $this->sendError('Not have products yet.', [], 404);
        }

        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully');
    }

    // Get product by Id
    public function getSingleProduct($id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return $this->sendError('Product not found', [], 404);
        }

        return $this->sendResponse(new ProductResource($product), 'Product retrieved seccessfully');
    }

    // Create product
    public function createProduct(Request $request)
    {
        $validationRules = [
            'name' => 'required|string|min:3|max:255',
            'detail' => 'required|string|min:5',
        ];
    
        $request->validate($validationRules);
    
        $input = $request->all();
    
        $product = Product::create($input);
    
        return $this->sendResponse(new ProductResource($product), 'Product created successfully');
    }

    // Delete product
    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return $this->sendError('Product not found', [], 404);
        }

        $product->delete();

        return $this->sendResponse([], 'Product deleted successfully');
    }
}

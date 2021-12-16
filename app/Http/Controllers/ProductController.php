<?php

namespace App\Http\Controllers;

use StdClass;
use Validator;
use App\Models\Product;
use App\Helpers\StatusCode;
use Illuminate\Http\Request;
use App\Models\ProductOption;
use App\Helpers\ProductHelper;
use App\Models\ProductOptionValue;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $httpCode = 200;

        $take = isset($request->take) ? $request->take : 5;
        $skip = isset($request->skip) ? $request->skip : 0;

        // Validate the request
        $validator = Validator::make(
            array(
                'take'  => $take,
                'skip'  => $skip,
            ),
            array(
                'take' => 'numeric',
                'skip' => 'numeric',
            )
        );

        // Run the validation
        if ($validator->fails()) {
            $errorMessage = $validator->messages()->first();

            return response()->json([
                'code'    => StatusCode::VALIDATION_ERROR,
                'message' => $errorMessage,
                'data' => null,
            ], $httpCode);
        }

        $products = Product::whereNotNull('name');

        $_products = clone $products;

        $products->take($take);
        $products->skip($skip);

        $totalData = $_products->count();
        $listOfData = $products->get();

        $returnedData = new StdClass;
        $returnedData->total_records = $totalData;
        $returnedData->returned_records = count($listOfData);
        $returnedData->records = $listOfData;

        return response()->json([
            'code'    => StatusCode::REQUEST_OK,
            'message' => 'success',
            'data'    => $returnedData,
        ], $httpCode);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $httpCode = 200;
        $userId = 0;

        // Validate the request
        $validator = Validator::make(
            array(
                'name' => $request->name,
                'price'  => $request->price,
            ),
            array(
                'name' => 'required',
                'price'  => 'required',
            ),
            array(
            )
        );

        // Run the validation
        if ($validator->fails()) {
            $errorMessage = $validator->messages()->first();

            return response()->json([
                'code'    => StatusCode::VALIDATION_ERROR,
                'message' => $errorMessage,
                'data' => null,
            ], $httpCode);
        }

        $productHelper = ProductHelper::create($request);

        // Insert data
        $newProduct = new Product();
        $newProduct->name = $request->name;
        $newProduct->description = $request->description;
        $newProduct->price = $request->price;
        $newProduct->quantity = $request->quantity;
        $newProduct->status = $request->status;
        $newProduct->price = $request->price;
        $newProduct->discount = $request->discount;
        $newProduct->discount_percentage = $productHelper->getDiscountPercentage();
        $newProduct->save();

        $newProduct->variant_data = $productHelper->saveVariantData($newProduct->product_id);

        return response()->json([
            'code'    => StatusCode::REQUEST_OK,
            'message' => 'success',
            'data'    => $newProduct,
        ], $httpCode);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $httpCode = 200;

        // Validate the request
        $validator = Validator::make(
            array(
                'id'  => $id,
            ),
            array(
                'id' => 'required|numeric',
            )
        );

        // Run the validation
        if ($validator->fails()) {
            $errorMessage = $validator->messages()->first();

            return response()->json([
                'code'    => StatusCode::VALIDATION_ERROR,
                'message' => $errorMessage,
                'data' => null,
            ], $httpCode);
        }

        $product = Product::with('options')->where('product_id', $id)->first();

        if (!$product) {
            $errorMessage = 'data not found';
            return response()->json([
                'code'    => StatusCode::DATA_NOT_FOUND,
                'message' => $errorMessage,
                'data' => null,
            ], $httpCode);
        }

        return response()->json([
            'code'    => StatusCode::REQUEST_OK,
            'message' => 'success',
            'data'    => $product,
        ], $httpCode);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $httpCode = 200;

        // Validate the request
        $validator = Validator::make(
            array(
                'id'  => $id,
            ),
            array(
                'id' => 'required|numeric',
            )
        );

        // Run the validation
        if ($validator->fails()) {
            $errorMessage = $validator->messages()->first();

            return response()->json([
                'code'    => StatusCode::VALIDATION_ERROR,
                'message' => $errorMessage,
                'data' => null,
            ], $httpCode);
        }

        $product = Product::where('product_id', $id)->first();

        if (!$product) {
            $errorMessage = 'data not found';
            return response()->json([
                'code'    => StatusCode::DATA_NOT_FOUND,
                'message' => $errorMessage,
                'data' => null,
            ], $httpCode);
        }

        $productHelper = ProductHelper::create($request);

        // update the data
        $request->whenFilled('name', function ($input) use ($product) {
            $product->name = $input;
        });

        $request->whenFilled('description', function ($input) use ($product) {
            $product->description = $input;
        });

        $request->whenFilled('price', function ($input) use ($product) {
            $product->price = $input;
        });

        $request->whenFilled('discount', function ($input) use ($product) {
            $product->discount = $input;
        });

        $request->whenFilled('quantity', function ($input) use ($product) {
            $product->quantity = $input;
        });

        $request->whenFilled('status', function ($input) use ($product) {
            $product->status = $input;
        });

        $product->discount_percentage = $productHelper->getDiscountPercentage($product->price, $product->discount);
        $product->save();

        return response()->json([
            'code'    => StatusCode::REQUEST_OK,
            'message' => 'success',
            'data'    => $product,
        ], $httpCode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $httpCode = 200;

        // Validate the request
        $validator = Validator::make(
            array(
                'id'  => $id,
            ),
            array(
                'id' => 'numeric',
            )
        );

        // Run the validation
        if ($validator->fails()) {
            $errorMessage = $validator->messages()->first();

            return response()->json([
                'code'    => StatusCode::VALIDATION_ERROR,
                'message' => $errorMessage,
                'data' => null,
            ], $httpCode);
        }

        $product = Product::where('product_id', $id)->first();

        if (!$product) {
            $errorMessage = 'data not found';
            return response()->json([
                'code'    => StatusCode::DATA_NOT_FOUND,
                'message' => $errorMessage,
                'data' => null,
            ], $httpCode);
        }

        return response()->json([
            'code'    => StatusCode::REQUEST_OK,
            'message' => 'success',
            'data'    => $product,
        ], $httpCode);
    }
}

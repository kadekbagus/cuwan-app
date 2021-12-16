<?php

namespace App\Helpers;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;

/**
 * Class for dealing with product data
 *
 * @author Kadek Bagus <kadekdarma90@gmail.com>
 * 
 */
class ProductHelper 
{
    protected $price;
    protected $discount;
    protected $variant;

    /**
     * Constructor
     *
     * @author Kadek Bagus <kadekdarma90@gmail.com>
     * @param Object $request
     */
    public function __construct($request)
    {
        $this->price = isset($request->price) ? $request->price : 0;
        $this->discount = isset($request->discount) ? $request->discount : 0;
        $this->variant = isset($request->variant) ? $request->variant : '';
    }

    /**
     * Static method to instantiate the class.
     *
     * @author Kadek Bagus <kadekdarma90@gmail.com>
     * @param Object $request
     * 
     */
    public static function create($request)
    {
        return new static($request);
    }

    public function getDiscountPercentage($priceValue = null, $discountValue = null) 
    {
        $price = isset($priceValue) ? $priceValue : $this->price;
        $discount = isset($discountValue) ? $discountValue : $this->discount;

        return ( $discount / $price ) * 100;
    }

    public function saveVariantData($productId)
    {
        $data = [];
        $variantData = @json_decode($this->variant, true);
        $variantData = $variantData ?: [];

        if ( !empty($variantData) ) 
        {
            $optionData = [];
            foreach ($variantData as $key => $value) 
            {
                $newProductOption = new ProductOption();
                $newProductOption->product_id = $productId;
                $newProductOption->option_name = $value['name'];
                $newProductOption->save();
                $data['variant_name'] = $newProductOption;

                foreach ($value['variant_options'] as $key => $value) 
                {
                    $price = isset($value['price']) ? $value['price'] : 0;
                    $discount = isset($value['discount']) ? $value['discount'] : 0;
                    $quantity = isset($value['quantity']) ? $value['quantity'] : 0;

                    $newProductOptionValue = new ProductOptionValue();
                    $newProductOptionValue->product_option_id = $newProductOption->product_option_id;
                    $newProductOptionValue->value_name = $value['value'];
                    $newProductOptionValue->price = $price;
                    $newProductOptionValue->discount = $discount;
                    $newProductOptionValue->discount_percentage = $this->getDiscountPercentage($price, $discount);
                    $newProductOptionValue->quantity = $quantity;
                    $newProductOptionValue->save();
                    $optionData[] = $newProductOptionValue;
                }

                $data['variant_value'] = $optionData;
            }
        }

        return $data;
    }
}
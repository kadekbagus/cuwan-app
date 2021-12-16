<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    use HasFactory;

    protected $table = 'product_options';

    protected $primaryKey = 'product_option_id';

    public function optionValues() {
        $this->hasMany(ProductOptionValue::class, 'product_option_id', 'product_option_id');
    }

    public function product() {
        $this->belongsTo(Product::class);
    }
}

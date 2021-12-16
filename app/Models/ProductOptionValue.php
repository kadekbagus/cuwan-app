<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{
    use HasFactory;

    protected $table = 'product_option_values';

    protected $primaryKey = 'product_option_value_id';

    public function productOption() {
        $this->belongsTo(ProductOption::class);
    }
}

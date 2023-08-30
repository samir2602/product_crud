<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product_image()
    {
        return $this->belongsTo(Attachment::class, 'item', 'meta_id')->where(['meta_key' => 'products']);
    }

    public function item_data()
    {
        return $this->belongsTo(Product::class, 'item', 'id');
    }
}

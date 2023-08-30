<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attachment;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function product_image()
    {
        return $this->belongsTo(Attachment::class, 'id', 'meta_id')->where(['meta_key' => 'products']);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    protected $table = "product_translation";
    protected $fillable = ['name','description'];
}

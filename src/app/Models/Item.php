<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'image_url',
        'price',
        'favorite',
        'comment',
        'item_description',
        'category_id',
        'condition_id'
    ];
}

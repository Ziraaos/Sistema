<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'barcode',
        'cost',
        'price',
        'stock',
        'alerts',
        'image',
        'category_id'
    ];

    public function category()
    {
        return $this->belongTo(Category::class);
    }

    public function getImagenAttribute(){
        if (!empty($this->image)) {
            return (file_exists('storage/products/' . $this->image) ? 'products/' . $this->image : 'noimg.jpg');
        }else{
            return 'noimg.jpg';
        }
    }

}

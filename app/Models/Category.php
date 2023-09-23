<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getImagenAttribute(){
        if (!is_null($this->image)) {
            return (file_exists('storage/categories/' . $this->image) ? 'categories/' . $this->image : 'noimg.jpg');
        }else{
            return 'noimg.jpg';
        }
    }
}

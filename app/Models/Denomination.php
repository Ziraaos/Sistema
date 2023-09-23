<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denomination extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'value',
        'image'
    ];


    public function getImagenAttribute(){
        if (!is_null($this->image)) {
            return (file_exists('storage/denominations/' . $this->image) ? 'denominations/' . $this->image : 'noimg.jpg');
        }else{
            return 'noimg.jpg';
        }
    }

}

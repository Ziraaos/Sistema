<?php

namespace App\Models;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'ci',
        'email',
        'phone',
        'disc',
        'address',
        'image',
        'status',
        'location_id',
        'service_id'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function getImagenAttribute(){
        if (!empty($this->image)) {
            return (file_exists('storage/customers/' . $this->image) ? 'customers/' . $this->image : 'noimg.jpg');
        }else{
            return 'noimg.jpg';
        }
    }
}

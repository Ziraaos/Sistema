<?php

namespace App\Models;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'quantity',
        'date_pay',
        'payment_id',
        'image',
        'payment_method_id'
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function getImagenAttribute(){
        if (!is_null($this->image)) {
            return (file_exists('storage/payments/' . $this->image) ? 'payments/' . $this->image : 'noimg.jpg');
        }else{
            return 'noimg.jpg';
        }
    }
}

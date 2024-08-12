<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'customer_shipping_address_id',
        'total',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    public function customer() {
        return $this->belongsTo(Customers::class, 'customer_id');
    }

    public function shippingAddress() {
        return $this->belongsTo(CustomerShippingAddresses::class, 'customer_shipping_address_id');
    }

    public function orderProducts() {
        return $this->hasMany(OrderProducts::class, 'order_id');
    }
}

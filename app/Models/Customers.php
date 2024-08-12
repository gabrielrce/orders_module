<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Customers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
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
}

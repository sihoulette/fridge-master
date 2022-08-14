<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Reserve date range
     */
    public const DAYS_RANGE = 20;

    /**
     * The table associated with the model.
     *
     * @var string $table
     */
    protected $table = 'order';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'access_code',
        'location_id',
        'temperature',
        'volume',
        'status',
        'name',
        'email',
        'beginning_at',
        'ending_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}

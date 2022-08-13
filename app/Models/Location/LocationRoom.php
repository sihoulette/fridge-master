<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LocationRoom extends Model
{
    use HasFactory;

    /**
     * Temperature offset correction
     */
    public const TEMPERATURE_OFFSET = 2;

    /**
     * The table associated with the model.
     *
     * @var string $table
     */
    protected $table = 'location_room';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'location_id',
        'name',
        'temperature',
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

    /**
     * @return HasOne
     * @author sihoullete
     */
    public function location(): HasOne
    {
        return $this->hasOne(Location::class, 'location_id', 'id');
    }

    /**
     * @return HasMany
     * @author sihoullete
     */
    public function blocks(): HasMany
    {
        return $this->hasMany(LocationRoomBlock::class, 'location_room_id', 'id');
    }
}

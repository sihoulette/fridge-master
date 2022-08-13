<?php

namespace App\Models\Location;

use App\Models\Block\Block;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LocationRoomBlock extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string $table
     */
    protected $table = 'location_room_block';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'block_id',
        'location_id',
        'location_room_id',
        'quantity',
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
    public function block(): HasOne
    {
        return $this->HasOne(Block::class, 'block_id', 'id');
    }

    /**
     * @return HasOne
     * @author sihoullete
     */
    public function location(): HasOne
    {
        return $this->hasOne(Location::class, 'location_id', 'id');
    }

    /**
     * @return HasOne
     * @author sihoullete
     */
    public function room(): HasOne
    {
        return $this->hasOne(LocationRoom::class, 'location_room_id', 'id');
    }
}

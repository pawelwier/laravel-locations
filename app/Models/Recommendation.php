<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Location;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'location_id',
        'target_user',
        'message'
    ];

    // protected $with = ['user'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}

<?php

namespace App\Models\Network;

use Illuminate\Database\Eloquent\Model;

class NetworkLog extends Model
{
    protected $fillable = [
        'vatsim_cid', 'user_id', 'level', 'message', 'recorded_at',
    ];
}

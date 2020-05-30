<?php

namespace App\Models\AtcTraining;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User;

class RosterMember extends Model

//WINNIPEG CONTROLLERS
{
    protected $table = 'roster';

    protected $fillable = [
        'cid', 'user_id', 'full_name', 'rating', 'del', 'gnd', 'twr', 'dep', 'app', 'ctr', 'remarks', 'active'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

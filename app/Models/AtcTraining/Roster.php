<?php

namespace App\Models\AtcTraining;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User;

class Roster extends Model
{
    protected $table = 'members';

    protected $fillable = [
        'cid',  'fname', 'lname', 'email', 'rating',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models\Publications;

use Illuminate\Database\Eloquent\Model;

class PolicySection extends Model
{
    protected $table = 'policies_sections';

    protected $fillable = [
        'section_name',
    ];
}

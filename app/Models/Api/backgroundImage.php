<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class backgroundImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'urls'
    ];
}

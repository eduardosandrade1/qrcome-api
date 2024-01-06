<?php

namespace App\Models\Api;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Crypt;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'background_image',
        'is_template',
        'body_items',
        'opacity_bg'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_menus');
    }
}

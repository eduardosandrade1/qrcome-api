<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api\backgroundImage;
use Illuminate\Http\Request;

class BackgroundImageController extends Controller
{
    public function get()
    {
        $images = [];

        $objImgs = backgroundImage::all();

        foreach ( $objImgs as $img ) {
            $images[] = $img->urls;
        }

        return response()->json($images);
    }
}

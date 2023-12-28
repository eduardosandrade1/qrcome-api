<?php

namespace App\Http\Controllers;

use App\Models\Component;
use Illuminate\Http\Request;

class ComponentController extends Controller
{

    public function get() {
        $bodyComponent = [];
        $components = Component::orderBy('id', 'asc')->get();

        foreach ( $components as $component ) {
            $bodyComponent[] = json_decode($component->json_body);
        }

        return response()->json($bodyComponent);
    }
}

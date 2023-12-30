<?php

namespace App\Http\Controllers;

use App\Models\Api\Menu;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    public function getTemplates()
    {

        return response()->json(
            Menu::all()
        );

    }

    public function getByUser(int $userId)
    {
        try {
            $user = User::find($userId);

            return response()->json($user->menus);

        } catch (Exception $e) {
            Log::error(":::Erro menu:    ".json_encode($e));
        }
    }
}

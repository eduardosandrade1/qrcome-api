<?php

namespace App\Http\Controllers;

use App\Models\Api\Menu;
use App\Models\Api\UserMenu;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    public function getTemplates()
    {
        try {
            return response()->json(
                Menu::where('is_template', true)->get()
            );

        } catch (Exception $e) {
            Log::error($e->getMessage(). "Line: ". $e->getLine());
            return response()->json(
                "bad-request"
            );
        }

    }

    public function getByUser()
    {
        try {
            $userId =  auth('sanctum')->user()->id;

            $user = User::find($userId);

            return response()->json($user->menus);

        } catch (Exception $e) {
            Log::error(":::Erro menu:    ".json_encode($e));
        }
    }

    public function delete(int|string $menuId)
    {
        try {
            $menuId = Crypt::decrypt($menuId);

            $userId =  auth('sanctum')->user()->id;

            if ( UserMenu::where('user_id', $userId)->where('menu_id', $menuId)->delete() ) {

                $menu = Menu::where('id', $menuId)->where('is_template', 0)->first();

                if ( ! empty($menu) ) {
                    if ( Menu::where('id', $menuId)->delete() ) {
                        return response()->json([
                            'status' => 'deleted-success',
                        ]);
                    }
                }
            }

            return response()->json([
                'status' => 'bad-relation-menu'
            ]);

        } catch (Exception $e) {
            Log::error("::ComponentController : 91 ~ ".json_encode($e));
            abort(500, 'bad-deleted-menu');
        }
    }
}

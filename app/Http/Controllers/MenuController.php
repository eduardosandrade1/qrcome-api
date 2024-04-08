<?php

namespace App\Http\Controllers;

use App\Models\Api\Menu;
use App\Models\Api\UserMenu;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
            abort(500, 'bad-relation-menu');

        } catch (Exception $e) {
            Log::error("::ComponentController : 91 ~ ".json_encode($e));
            abort(500, 'bad-deleted-menu');
        }
    }

    /**
     * Function update the config datas about menus table
     *
     * @param $menuId  int | string id of Menu TAble
     * @param $request  Request Http Request
     * @return  Response Json Response with the error or success and your http status
     */
    public function saveConfig(int | string $menuId, Request $request)
    {
        try {
            $validated = $request->validated();

            $pathToUserMenu = auth('api')->user()->id."/".$menuId;
            $logoPath = $pathToUserMenu."/logo_path/";
            $splashPath = $pathToUserMenu."/splash_path/";
            // adicionando imagem da logo
            Storage::put($logoPath, $validated->logo);
            // adicionando imagem splash GIF
            Storage::put($splashPath, $validated->splash);


            $updated = Menu::whereId($menuId)->update([
                'name' => $validated->name,
                'color' => $validated->color,
                'logo_path' => $logoPath,
                'splash_path' => $splashPath
            ]);

            if ( $updated ) {
                return response()->json([
                    'message' => 'updated'
                ]);
            }

        } catch (Exception $e) {
            return response()->json([
                'erro' => $e->getCode(),
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);
        }
    }
}

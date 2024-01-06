<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\MenuBodyRequest;
use App\Models\Api\Menu;
use App\Models\Api\UserMenu;
use App\Models\Component;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class ComponentController extends Controller
{

    public function get()
    {
        $bodyComponent = [];
        $components = Component::orderBy('id', 'asc')->get();

        foreach ( $components as $component ) {
            $bodyComponent[] = json_decode($component->json_body);
        }

        return response()->json($bodyComponent);
    }

    public function getView($menuId)
    {
        try {
            $menuId = Crypt::decrypt($menuId);
            $menu = Menu::where('id', $menuId)->get();
            return response()->json($menu);

        } catch (Exception $e) {
            Log::error($e->getMessage(). "Line: ". $e->getLine());
            return response()->json("bad-requisition");
        }
    }

    public function save(MenuBodyRequest $request)
    {
        try {
            // Log::alert('::params:  '. json_encode($request->all()));
            # create menu first
            $menu = new Menu();
            $menu->body_items = json_encode($request->get('items'));
            $menu->background_image = $request->get('background_url');
            $menu->opacity_bg = $request->get('background_opacity');

            if ( $menu->save() ) {

                $menuId = $menu->id;

                $userMenu = new UserMenu();
                $userMenu->user_id = Crypt::decrypt($request->user_id);
                $userMenu->menu_id = $menuId;
                if ( $userMenu->save() ) {
                    return response()->json([
                        'status' => 'insert-success',
                        'datas'  => [
                            'url'    => env('APP_API_URL', 'http://localhost:8100/mount-components/').Crypt::encrypt($menuId),
                            'id'     => Crypt::encrypt($menuId),
                        ]
                    ]);
                }

                return response()->json([
                    'status' => 'bad-relation-menu'
                ]);
            }


            return response()->json([
                'status' => 'bad-menu'
            ]);


        } catch (Exception $e) {
            Log::error("::ComponentController : 59 ~ ".json_encode($e));
            abort(500, 'bad-insert-menu');
        }
    }
}

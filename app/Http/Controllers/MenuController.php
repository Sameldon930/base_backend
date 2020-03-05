<?php
/**
 * 菜单管理
 *
 * @author      zzs
 */

namespace App\Http\Controllers;

use App\Enums\ReturnCode;
use App\Http\Requests\StoreRequest;
use App\Models\Log;
use App\Service\DataService;
use App\Models\Role;
use App\Models\Menu;

class MenuController extends BaseController
{
    /**
     * 菜单列表
     */
    public function index()
    {
        //获取菜单的树状数据（这里使用到了trait） 获取 所有的角色
        return view('menus.list', ['menus' => Menu::toTree(), 'roles' => Role::all()]);
    }

    /**
     * 菜单增加保存
     */
    public function store(StoreRequest $request)
    {
        $model = new Menu();
        $menu = DataService::handleDate($model, $request->all(), 'menus-add_or_update');
        if ($menu['status'] == ReturnCode::SUCCESS) {
            Log::addLogs(trans('zzs.menus.handle_menu') . trans('zzs.common.success'), '/menus/story');
        } else {
            Log::addLogs(trans('zzs.menus.handle_menu') . trans('zzs.common.fail'), '/menus/destroy');
        }
        return $menu;
    }

    /**
     * 菜单编辑页面
     */
    public function edit($id = 0)
    {
        $menu = ($id > 0) ? Menu::findByRoleId($id) : [];
        return view('menus.edit', ['id' => $id, 'menu' => $menu, 'menus' => Menu::toTree(), 'roles' => Role::all()]);
    }

    /**
     * 菜单删除
     */
    public function destroy($id)
    {
        if (is_config_id($id, "admin.menu_table_cannot_manage_ids", false)) {
            return $this->resultJson('zzs.menus.notdel', 0);
        }
        $model = new Menu();
        $menu = DataService::handleDate($model, ['id' => $id], 'menus-delete');
        if ($menu['status'] == 1) {
            Log::addLogs(trans('zzs.menus.del_menu') . trans('zzs.common.success'), '/menus/destroy/' . $id);
        } else {
            Log::addLogs(trans('zzs.menus.del_menu') . trans('zzs.menus.fail'), '/menus/destroy/' . $id);
        }
        return $menu;
    }
}

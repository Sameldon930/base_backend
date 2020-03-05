<?php
/**
 * 权限管理
 * @author      zzs
 */

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Models\Log;
use App\Models\Permission;
use App\Models\Role;
use App\Service\DataService;
use Illuminate\Http\Request;

class PermissionController extends BaseController
{
    /**
     * 权限列表
     */
    public function index()
    {
        return view('permissions.list', ['list' => Permission::get()->toArray()]);
    }

    /**
     * 权限编辑列表
     */
    public function edit($id = 0)
    {
        $info = $id ? Permission::find($id) : [];
        $role = $info ? $info->roleToIds() : [];
        return view('permissions.edit', ['id' => $id, 'info' => $info, 'roles' => Role::all(), 'rolelist' => $role]);
    }

    /**
     * 权限增加保存
     */
    public function store(StoreRequest $request)
    {
        $model = new Permission();
        $permission = DataService::handleDate($model, $request->all(), 'permissions-add_or_update');
        if ($permission['status'] == 1) {
            Log::addLogs(
                trans('zzs.permissions.handle_permission') . trans('zzs.common.success'),
                '/permissions/story'
            );
        } else {
            Log::addLogs(trans('zzs.permissions.handle_permission') . trans('zzs.common.fail'), '/permissions/destroy');
        }
        return $permission;
    }

    /**
     * 权限删除
     */
    public function destroy($id)
    {
        if (is_config_id($id, "admin.permission_table_cannot_manage_ids", false)) {
            return $this->resultJson('zzs.permissions.notdel', 0);
        }
        $model = new Permission();
        $permission = DataService::handleDate($model, ['id' => $id], 'permissions-delete');
        if ($permission['status'] == 1) {
            Log::addLogs(
                trans('zzs.permissions.del_permission') . trans('zzs.common.success'),
                '/permissions/destroy/' . $id
            );
        } else {
            Log::addLogs(
                trans('zzs.permissions.del_permission') . trans('zzs.common.fail'),
                '/permissions/destroy/' . $id
            );
        }
        return $permission;
    }
}

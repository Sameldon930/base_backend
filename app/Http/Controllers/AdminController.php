<?php
/**
 * 管理员管理
 * @author      zzs
 */

namespace App\Http\Controllers;

use App\Enums\ReturnCode;
use App\Http\Requests\StoreRequest;
use App\Models\Common;
use App\Models\Log;
use App\Models\Role;
use App\Models\Admin;
use App\Service\DataService;
use Illuminate\Http\Request;

class AdminController extends BaseController
{
    /**
     * 管理员列表
     */
    public function index()
    {
        return view('admins.list', ['list' => Admin::with('roles')->latest()->get()->toArray()]);
    }

    /**
     *管理员编辑页面
     */
    public function edit($id = 0)
    {
        $info = $id ? Admin::find($id) : [];
        return view('admins.edit', ['id' => $id, 'roles' => Role::all(), 'info' => $info]);
    }

    /**
     * 管理员增加保存
     */
    public function store(StoreRequest $request)
    {
        $model = new Admin();
        $user = DataService::handleDate($model, $request->all(), 'admins-add_or_update');
        if ($user['status'] == ReturnCode::SUCCESS) {
            Log::addLogs(trans('zzs.admins.handle_user') . trans('zzs.common.success'), '/admins/story');
        } else {
            Log::addLogs(trans('zzs.admins.handle_user') . trans('zzs.common.fail'), '/admins/destroy');
        }
        return $user;
    }

    /**
     *管理员删除
     */
    public function destroy($id)
    {
        //判断这个id 是否在配置文件中 属于可删除
        if (is_config_id($id, "admin.user_table_cannot_manage_ids", false)) {
            return ['status' => ReturnCode::FAIL, 'msg' => trans('zzs.admins.notdel')];
        }
        $model = new Admin();
        $user = DataService::handleDate($model, ['id' => $id], 'admins-delete');
        if ($user['status'] == ReturnCode::SUCCESS) {
            Log::addLogs(trans('zzs.admins.del_user') . trans('zzs.common.success'), '/admins/destroy/' . $id);
        } else {
            Log::addLogs(trans('zzs.admins.del_user') . trans('zzs.common.fail'), '/admins/destroy/' . $id);
        }
        return $user;
    }

    /**
     *管理员基本信息编辑页面
     */
    public function userInfo()
    {
        $user = new Common();
        return view('admins.userinfo', ['userinfo' => $user->user()]);
    }

    /**
     *管理员基本信息修改
     */
    public function saveInfo(StoreRequest $request, $type)
    {
        if ($type == 1) {
            $kind = 'update_info';
        } else {
            $kind = 'update_pwd';
        }
        $user = DataService::handleDate(new Admin(), $request->all(), 'admins-' . $kind);
        if ($user['status'] == ReturnCode::SUCCESS) {
            Log::addLogs(trans('zzs.admins.' . $kind) . trans('zzs.common.success'), '/saveinfo/' . $type);
        } else {
            Log::addLogs(trans('zzs.admins.' . $kind) . trans('zzs.common.fail'), '/saveinfo/' . $type);
        }
        return $user;
    }
}

<?php

namespace App\Service;

use App\Enums\ReturnCode;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

/**
 * 增删改逻辑处理
 * Class DataService
 * @package App\Service
 */
class DataService
{

    /**
     * @param Model $model 要操作的数据表的对应模型
     * @param array $inputs 表单提交的数据
     * @param $kind         表操作动作的区分
     * @return array
     * @throws \Exception
     */
    public static function handleDate(Model $model, Array $inputs, $kind)
    {
        //将字符串炸成数组
        $kind = explode('-', $kind);
        //获取数组的第一个key 对应的是那个数据表
        switch ($kind[0]) {
            case 'menus':
                //获取数组的第二个key 对表进行不一样的操作
                switch ($kind[1]) {
                    //增加或更新
                    case 'add_or_update':
                        $model->parent_id = $inputs['category'];
                        $model->title = $inputs['name'];
                        $model->icon = $inputs['icon'];
                        $model->uri = $inputs['uri'];
                        $model->order = $inputs['order'];
                        $model->routes = 'url:' . $inputs['uri'];
                        $roles = $inputs['roles'];
                        if ($inputs['id']) {
//                            if (is_config_id($inputs['id'], "admin.menu_table_cannot_manage_ids", false))return ['status'=>ReturnCode::FAIL,'msg'=>trans('zzs.menus.notedit')];
                            $model->exists = true;
                            $model->id = $inputs['id'];
                        }
                        try {
                            //保存菜单表 失败则返回
                            if (!$model->save()) {
                                return ['status' => ReturnCode::FAIL, 'msg' => trans('zzs.common.fail')];
                            }
                            foreach ($roles as $k => $role) {
                                if (empty($role)) {
                                    unset($roles[$k]);
                                }
                            }
                            //同时分配给角色
                            $model->saveRoles($roles);
                        } catch (\Exception $e) {
                            return ['status' => ReturnCode::FAIL, 'msg' => trans('zzs.common.fail')];
                        }
                        return ['status' => ReturnCode::SUCCESS, 'msg' => trans('zzs.common.success')];
                        break;

                    case 'delete':
                        $model->id = $inputs['id'];
                        $model->exists = true;
                        if ($model->delete()) {
                            return ['status' => 1, 'msg' => trans('fzs.common.success')];
                        } else {
                            return ['status' => 0, 'msg' => trans('fzs.common.fail')];
                        }
                        break;
                    default:
                        return ['status' => 0, 'msg' => trans('fzs.common.wrong')];
                }
                break;
            case 'users':
                switch ($kind[1]) {
                    case 'add_or_update':
                        $model->username = $inputs['user_name'];
                        $model->email = $inputs['email'];
                        $model->mobile = $inputs['tel'];
                        $model->sex = $inputs['sex'];
                        if ($inputs['pwd']) {
                            $model->password = bcrypt($inputs['pwd']);
                        }
                        if ($inputs['id']) {
//                            if(is_config_id($inputs['id'], "admin.user_table_cannot_manage_ids", false))return ['status'=>0,'msg'=>trans('fzs.users.notedit')];
                            $model->exists = true;
                            $model->id = $inputs['id'];
                        }
                        try {
                            if (!$model->save()) {
                                return ['status' => 0, 'msg' => trans('fzs.common.fail')];
                            }
                            $model->saveRoles($inputs['user_role']);
                        } catch (\Exception $e) {
                            return ['status' => 0, 'msg' => trans('fzs.common.fail')];
                        }
                        return ['status' => 1, 'msg' => trans('fzs.common.success')];
                        break;
                    case 'update_pwd':
                        $userinfo = new Admin();
                        $userinfo = $userinfo->user();
                        if (!App::make('hash')->check($inputs['oldpwd'], $userinfo['password'])) {
                            return ['status' => 0, 'msg' => trans('fzs.users.pwd_false')];
                        }
                        $model->password = bcrypt($inputs['pwd']);
                        $model->exists = true;
                        $model->id = $inputs['id'];
                        try {
                            if (!$model->save()) {
                                return ['status' => 0, 'msg' => trans('fzs.common.fail')];
                            }
                        } catch (\Exception $e) {
                            return ['status' => 0, 'msg' => trans('fzs.common.fail')];
                        }
                        return ['status' => 1, 'msg' => trans('fzs.common.success')];
                        break;
                    case 'update_info':
                        $model->email = $inputs['useremail'];
                        $model->mobile = $inputs['usertel'];
                        $model->sex = $inputs['usersex'];
                        $model->exists = true;
                        $model->id = $inputs['id'];
                        try {
                            if (!$model->save()) {
                                return ['status' => 0, 'msg' => trans('fzs.common.fail')];
                            }
                        } catch (\Exception $e) {
                            return ['status' => 0, 'msg' => trans('fzs.common.fail')];
                        }
                        return ['status' => 1, 'msg' => trans('fzs.common.success')];
                        break;
                    case 'delete':
                        $model->id = $inputs['id'];
                        $model->exists = true;
                        if ($model->delete()) {
                            return ['status' => 1, 'msg' => trans('fzs.common.success')];
                        } else {
                            return ['status' => 0, 'msg' => trans('fzs.common.fail')];
                        }
                        break;
                    default:
                        return ['status' => 0, 'msg' => trans('fzs.common.wrong')];
                }
                break;
            case 'roles':
                switch ($kind[1]) {
                    case 'add_or_update':
                        $model->name = $inputs['role_remark'];
                        $model->display_name = $inputs['role_name'];
                        $model->description = $inputs['role_desc'];
                        if ($inputs['id']) {
//                            if(is_config_id($inputs['id'], "admin.role_table_cannot_manage_ids", false))return ['status'=>0,'msg'=>trans('fzs.roles.notedit')];
                            $model->exists = true;
                            $model->id = $inputs['id'];
                        }
                        try {
                            if (!$model->save()) {
                                return ['status' => 0, 'msg' => trans('fzs.common.fail')];
                            }
                            $role = new Role();
                            $role = $role->find($model->id);
                            $role->savePermissions(isset($inputs['permission_list']) ? $inputs['permission_list'] : '');
                            if (!$role->save()) {
                                return ['status' => 0, 'msg' => trans('fzs.common.fail')];
                            }
                        } catch (\Exception $e) {
                            return ['status' => 0, 'msg' => trans('fzs.common.fail')];
                        }
                        return ['status' => 1, 'msg' => trans('fzs.common.success')];
                        break;

                    case 'delete':
                        if ($model->isAbleDel($inputs['id'])) {
                            return ['status' => 0, 'msg' => trans('fzs.roles.have_user')];
                        }
                        $model->id = $inputs['id'];
                        $model->exists = true;
                        if ($model->delete()) {
                            return ['status' => 1, 'msg' => trans('fzs.common.success')];
                        } else {
                            return ['status' => 0, 'msg' => trans('fzs.common.fail')];
                        }
                        break;
                    default:
                        return ['status' => 0, 'msg' => trans('fzs.common.wrong')];
                }
                break;
            case 'permissions':
                switch ($kind[1]) {
                    case 'add_or_update':
                        $model->name = $inputs['permission_remark'];
                        $model->display_name = $inputs['permission_name'];
                        $model->description = $inputs['permission_desc'];
                        $model->controllers = $inputs['permission_control'];
                        if ($inputs['id']) {
//                            if (is_config_id($inputs['id'], "admin.permission_table_cannot_manage_ids", false))return ['status'=>0,'msg'=>trans('fzs.menus.notedit')];
                            $model->exists = true;
                            $model->id = $inputs['id'];
                        }
                        try {
                            if (!$model->save()) {
                                return ['status' => 0, 'msg' => trans('fzs.common.fail')];
                            }
                            $roles = $inputs['permission_roles'];
                            if (!empty($roles)) {
                                foreach ($roles as $k => $role) {
                                    if (empty($role)) {
                                        unset($roles[$k]);
                                    }
                                }
                            }
                            $model->saveRoles($roles);
                        } catch (\Exception $e) {
                            return ['status' => 0, 'msg' => trans('fzs.common.fail')];
                        }
                        return ['status' => 1, 'msg' => trans('fzs.common.success')];
                        break;

                    case 'delete':
                        $model->id = $inputs['id'];
                        $model->exists = true;
                        if ($model->delete()) {
                            return ['status' => 1, 'msg' => trans('fzs.common.success')];
                        } else {
                            return ['status' => 0, 'msg' => trans('fzs.common.fail')];
                        }
                        break;
                    default:
                        return ['status' => 0, 'msg' => trans('fzs.common.wrong')];
                }
                break;
            default:
                return ['status' => 0, 'msg' => trans('fzs.common.wrong')];
        }
    }

}
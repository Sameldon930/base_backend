<?php
/**
 * 管理员管理
 *
 * @author      zzs
 */
namespace App\Http\Controllers;
use App\Http\Requests\StoreRequest;
use App\Models\Admin;
use App\Models\Log;
use App\Models\Role;
use App\Models\User;
use App\Service\DataService;
use Illuminate\Http\Request;
class AdminController extends BaseController
{
    /**
     * 管理员列表
     */
    public function index()
    {
        return view('admins.list', ['list'=>User::with('roles')->get()->toArray()]);
    }
    /**
     *管理员编辑页面
     */
    public function edit($id=0)
    {
        $info = $id?User::find($id):[];
        return view('admins.edit', ['id'=>$id,'roles'=>Role::all(),'info'=>$info]);
    }
    /**
     * 管理员增加保存
     */
    public function store(StoreRequest $request){
        $model = new User();
        $user = DataService::handleDate($model,$request->all(),'users-add_or_update');
        if($user['status']==1)Log::addLogs(trans('zzs.users.handle_user').trans('zzs.common.success'),'/users/story');
        else Log::addLogs(trans('zzs.users.handle_user').trans('zzs.common.fail'),'/admins/destroy');
        return $user;
    }
    /**
     *管理员删除
     */
    public function destroy($id)
    {
        if (is_config_id($id, "admin.user_table_cannot_manage_ids", false))return $this->resultJson('zzs.users.notdel', 0);
        $model = new User();
        $user = DataService::handleDate($model,['id'=>$id],'users-delete');
        if($user['status']==1)Log::addLogs(trans('zzs.users.del_user').trans('zzs.common.success'),'/admins/destroy/'.$id);
        else Log::addLogs(trans('zzs.users.del_user').trans('zzs.menus.fail'),'/admins/destroy/'.$id);
        return $user;
    }
    /**
     *管理员基本信息编辑页面
     */
    public function userInfo(){
        $user = new Admin();
        return view('admins.userinfo',['userinfo'=>$user->user()]);
    }
    /**
     *管理员基本信息修改
     */
    public function saveInfo(StoreRequest $request,$type){
        if($type==1)$kind = 'update_info';
        else $kind = 'update_pwd';
        $user = DataService::handleDate(new User(),$request->all(),'users-'.$kind);
        if($user['status']==1)Log::addLogs(trans('zzs.users.'.$kind).trans('zzs.common.success'),'/saveinfo/'.$type);
        else Log::addLogs(trans('zzs.users.'.$kind).trans('zzs.common.fail'),'/saveinfo/'.$type);
        return $user;
    }
}

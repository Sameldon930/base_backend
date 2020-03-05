<?php
/**
 * 表单验证类
 * @author      zzs
 */
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];
        switch (request()->getPathInfo()) {
            case '/menus':
                $rules['category'] = 'required';
                if($mid = request()->input('id'))$rules['name'] = 'required|alpha|between:2,12|unique:z_menus,title,'.$mid;
                else $rules['name'] = 'required|alpha|between:2,12|unique:z_menus,title';
                $rules['order']  = 'required|numeric';
                $rules['icon']  = 'required';
                $rules['uri']  = 'required|max:12';
                $rules['roles']  = 'required';
                break;
            case '/admins'://管理员管理相关操作
                if($uid = request()->input('id')){//如果是有提交id那就表示 这个是更新操作
                    $rules['user_name'] = 'required|alpha|between:2,12|unique:z_admins,user_name,'.$uid;
                    $rules['pwd']  = 'nullable|alpha_num|between:6,12|confirmed';
                    $rules['email']  = 'required|email|unique:z_admins,email,'.$uid;

                }else{//否则就是新增操作
                    $rules['user_name'] = 'required|alpha|between:2,12|unique:z_admins,user_name';
                    $rules['pwd']  = 'required|alpha_num|between:6,12|confirmed';
                    $rules['email']  = 'required|email|unique:z_admins,email';
                    $rules['pwd_confirmation']  = 'required';
                }
                $rules['tel']  = 'required|numeric';
                $rules['sex']  = 'required|numeric';

                $rules['user_role']  = 'required|numeric';
                break;
            case '/roles'://角色管理相关操作
                //如果有id 那就是 更新角色操作
                if($rid = request()->input('id')){
                    $rules['role_remark'] = 'required|between:2,12|unique:z_roles,name,'.$rid;
                    $rules['role_name']  = 'required|between:2,12|unique:z_roles,display_name,'.$rid;
                }else{//否则就是新增角色
                    $rules['role_remark'] = 'required|between:2,12|unique:z_roles,name';
                    $rules['role_name']  = 'required|between:2,12|unique:z_roles,display_name';
                }
                $rules['role_desc'] = 'required|between:2,30';
                $rules['permission_list'] = 'array';
                break;
            case '/permissions':
                if($rid = request()->input('id')){
                    $rules['permission_name'] = 'required|between:2,12|unique:z_permissions,name,'.$rid;
                    $rules['permission_control'] = 'required|between:2,50|unique:z_permissions,controllers,'.$rid;

                }else{
                    $rules['permission_name']  = 'required|between:2,12|unique:z_permissions,display_name';
                    $rules['permission_control'] = 'required|between:2,50|unique:z_permissions,controllers';

                }
                $rules['permission_desc'] = 'required|between:2,30';
                $rules['permission_remark'] = 'required|alpha|between:2,30';
                $rules['permission_roles'] = 'required|array';
                break;
            case '/saveinfo/1':
                $rules['useremail']  = 'required|email|unique:z_admins,email,'.request()->input('id');
                $rules['usertel']  = 'required|numeric';
                $rules['usersex']  = 'required|numeric';
                break;
            case '/saveinfo/2':
                $rules['oldpwd']  = 'required|alpha_num|between:6,12|different:pwd';
                $rules['pwd']  = 'required|alpha_num|between:6,12|confirmed';
                $rules['pwd_confirmation']  = 'required';
                break;
        }
        return $rules;
    }


    public function response(array $errors)
    {
        if($errors){
            foreach ($errors as $k => $v){
                $msg = $v[0];
                break;
            }
        }
        if ($this->expectsJson()) {
            return response()->json(['status'=>0,'msg'=>$msg]);
        }
        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash))
            ->withErrors($errors, $this->errorBag);
    }

}
<?php
/**
 * 用户登陆过后首页以及一些公共方法
 *
 * @author      zzs
 */

namespace App\Http\Controllers;

use App\Enums\ReturnCode;
use App\Models\Admin;
use App\Models\Common;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends BaseController
{
    /**
     * 后台首页
     */
    public function index()
    {
        $menu = new Common();
        return view(
            'home.index',
            ['menus' => $menu->menus(), 'mid' => $menu->getMenuId(), 'parent_id' => $menu->getParentMenuId()]
        );
    }

    /**
     * 验证码
     */
    public function verify()
    {
        $phrase = new PhraseBuilder;
        $code = $phrase->build(4);
        $builder = new CaptchaBuilder($code, $phrase);
        $builder->setBackgroundColor(255, 255, 255);
        $builder->build(130, 40);
        $phrase = $builder->getPhrase();
        Session::flash('code', $phrase); //存储验证码
        return response($builder->output())->header('Content-type', 'image/jpeg');
    }

    /**
     * 欢迎首页
     */
    public function welcome()
    {
        return view('home.welcome', ['sysinfo' => $this->getSysInfo()]);
    }

    /**
     * 排序
     */
    public function changeSort(Request $request)
    {
        $data = $request->all();
        if (is_numeric($data['id'])) {
            $res = DB::table('z_' . $data['name'])->where('id', $data['id'])->update(['order' => $data['val']]);
            if ($res) {
                return $this->resultJson('zzs.common.success', ReturnCode::SUCCESS);
            } else {
                return $this->resultJson('zzs.common.fail', ReturnCode::FAIL);
            }
        } else {
            return $this->resultJson('zzs.common.wrong', ReturnCode::ERROR);
        }
    }

    /**
     * 获取系统信息
     */
    protected function getSysInfo()
    {
        $sys_info['ip'] = GetHostByName($_SERVER['SERVER_NAME']);
        $sys_info['phpv'] = phpversion();
        $sys_info['web_server'] = $_SERVER['SERVER_SOFTWARE'];
        $sys_info['time'] = date("Y-m-d H:i:s");
        $sys_info['domain'] = $_SERVER['HTTP_HOST'];
        $mysqlinfo = DB::select("SELECT VERSION() as version");
        $sys_info['mysql_version'] = $mysqlinfo[0]->version;
        return $sys_info;
    }
}

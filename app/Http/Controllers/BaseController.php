<?php
/**
 * 基础控制器，目前只加入一个公共方法，可以拓展
 *
 * @author      zzs
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * 返回自定义标准json格式
     *
     * @access protected
     * @param string $lang 语言包
     * @param number $res 结果code
     * @return json
     */
    protected function resultJson($lang, $res)
    {
        //查找字符串的首次出现
        return strstr($lang, 'zzs') ? ['status' => $res, 'msg' => trans($lang)] : ['status' => $res, 'msg' => $lang];
    }
}

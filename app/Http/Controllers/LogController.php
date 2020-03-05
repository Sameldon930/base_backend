<?php
/**
 * 日志管理
 *
 * @author      zzs
 */

namespace App\Http\Controllers;

/**
 * 操作日志管理
 */
use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * 日志列表
     */
    public function index(Request $request)
    {
        return $this->show($request);
    }

    /**
     * 根据条件日志列表查询
     */
    public function show(Request $request)
    {
        $sql = Log::query();
        $where = [];
        if (!empty($request->input('title')) && !empty($request->input('status'))) {
            $where[] = [$request->input('status'),'=',trim($request->input('title'))];
        }
        if (true == $request->input('begin')) {
            $where[] = ['log_time','>=',trim($request->input('begin'))];
        }
        $sql->where($where);
        $sql->get(Log::FIELD_LIST);
        $pager = $sql->orderBy('id', 'desc')->paginate()->appends($request->all());
        return view('logs.list', ['pager' => $pager, 'input' => $request->all()]);
    }
}

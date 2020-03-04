<?php
/**
 * 用户登陆
 *
 * @author      zzs
 */
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Log;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers {authenticated as oriAuthenticated;}
    use AuthenticatesUsers {login as doLogin;}

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {
        if($request->input('verity')==session('code'))return $this->doLogin($request);
        else return redirect('/login')->withErrors([trans('zzs.login.false_verify')]);
    }
    public function username()
    {
        return 'user_name';
    }

    protected function authenticated(Request $request, $user)
    {
        Log::addLogs(trans('zzs.login.login_info'),'/login');
        return $this->oriAuthenticated($request, $user);
    }

}

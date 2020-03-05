<?php

namespace App\Models;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Models\Interfaces\AdminsInterface;
use App\Models\Traits\AdminsTrait;
class Admin extends Model implements AuthenticatableContract, CanResetPasswordContract, AdminsInterface
{
    use Authenticatable, CanResetPassword, AdminsTrait;
    protected $table = 'z_admins';
    protected $fillable = ['user_name', 'email', 'mobile', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $userInfo;
}

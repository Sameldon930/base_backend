<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Interfaces\RoleInterface;
use App\Models\Traits\RoleTrait;
use Illuminate\Support\Facades\DB;

class Role extends Model implements RoleInterface
{
    use RoleTrait;
    protected $table = 'z_roles';
    public function isAbleDel($roleid){
        return DB::table('z_role_admin')->where('role_id',$roleid)->get()->toArray()?true:false;
    }
}

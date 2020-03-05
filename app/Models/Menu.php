<?php

namespace App\Models;
use Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Interfaces\MenuInterface;
use App\Models\Traits\MenuTrait;
class Menu extends Model implements MenuInterface
{
    use MenuTrait;

    protected $table = 'z_menus';

    protected $primaryKey = 'id';

    protected static $branchOrder = [];

}

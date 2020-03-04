<?php

use Illuminate\Database\Seeder;

class AdminUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('z_admins')->delete();
        \DB::table('z_admins')->insert(array (
            0 => 
		        array (
                    'id'		        =>	1,
	                'user_name'	        =>	'admin',
	                'email'		        =>	'admin@admin.com',
		            'mobile'	        =>	'18888888888',
		            'sex'	            =>	1,
		            'password'	        =>	'$2y$10$zmdxMD32uPC6mMDAUF63MObHvhWXB4olVITCRuCu1/RGm2XagRN2e', //123456
		            'remember_token'    =>	'',
		            'created_at'	    =>	date('Y-m-d H:i:s',time()),
		            'updated_at'	    =>	date('Y-m-d H:i:s',time()),
		        ),
	        )
	    );
    }
}

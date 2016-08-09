<?php namespace Sharenjoy\Cmsharenjoy\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class UserTable extends Seeder {

    public function run()
    {

        $types = [
            [
                'email'         => Config::get('cmsharenjoy.administrator.email'),
                'password'      => Hash::make(Config::get('cmsharenjoy.administrator.password')),
                'name'          => Config::get('cmsharenjoy.administrator.name'),
                'phone'         => Config::get('cmsharenjoy.administrator.phone'),
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ]
        ];
        DB::table('users')->insert($types);
        $this->command->info('User Table Seeded');
    }

}

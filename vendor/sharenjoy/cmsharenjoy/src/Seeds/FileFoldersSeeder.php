<?php namespace Sharenjoy\Cmsharenjoy\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FileFoldersSeeder extends Seeder {

    public function run()
    {
        $types = [
            [
                'parent_id'  => 0,
                'slug'       => '新資料夾',
                'name'       => '新資料夾',
                'location'   => 'local',
                'hidden'     => 0,
                'sort'       => strtotime('now'),
                'created_at' => date('Y-m-d H:i:s')
            ]

        ];
        DB::table('file_folders')->insert($types);
        $this->command->info('File Folders Table Seeded With An Example Record');

    }

}
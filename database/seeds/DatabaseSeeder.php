<?php

use Illuminate\Database\Seeder;
use Sharenjoy\Cmsharenjoy\Seeds\UserTable;
use Sharenjoy\Cmsharenjoy\Seeds\SettingsSeeder;
use Sharenjoy\Cmsharenjoy\Seeds\FileFoldersSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call(UserTable::class);
        $this->call(SettingsSeeder::class);
        $this->call(FileFoldersSeeder::class);
        
        $this->command->info('All Tables Seeded');
    }
}

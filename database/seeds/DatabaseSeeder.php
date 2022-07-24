<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguageSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(PermissionSeed::class);
        $this->call(RoleSeed::class);
        $this->call(UserSeeder::class);
    }
}

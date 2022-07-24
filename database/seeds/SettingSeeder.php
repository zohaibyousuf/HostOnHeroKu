<?php

use Illuminate\Database\Seeder;
use App\Settings;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::create(['site_title'=> 'Malik Mobile Shop','site_logo'=>'logo.png','username'=>'admin','currency'=>'Rs']);
    }
}

<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleObj = \DB::table('roles')->where('name','admin')->first();
        User::create(['name'=> 'Riaz','phone'=>'03478856549','role'=>$roleObj->id,'is_active'=> true,'username'=>'Riaz','password'=>'$2a$12$U5skih7zQjNtlL7Hf7qDhudpEwgUyI60q.kL2tEOJsg6UK7mZQEfi','address'=> 'Yazman','company_name'=>'Malik Mobile Shop','email'=>'riazmalik549@yahoo.com']);
    }
}

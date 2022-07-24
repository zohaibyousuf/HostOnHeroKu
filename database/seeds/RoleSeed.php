<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'admin','is_active'=>1]);
        $role->givePermissionTo(['products-index','products-add','products-delete','products-edit','customers-index','customers-add','customers-edit','customers-delete','purchases-index','purchases-add','purchases-edit','purchases-delete','best-seller','sales-index','sales-add','sales-edit','sales-delete','returns-index','returns-add','returns-edit','returns-delete','users-index','users-add','users-edit','users-delete','profit-loss','product-report','purchase-report','sale-report','product-qty-alert','customer-report','due-report']);
    }
}

<?php
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('cache:clear');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (['products-index','products-add','products-delete','products-edit','customers-index','customers-add','customers-edit','customers-delete','purchases-index','purchases-add','purchases-edit','purchases-delete','best-seller','sales-index','sales-add','sales-edit','sales-delete','returns-index','returns-add','returns-edit','returns-delete','users-index','users-add','users-edit','users-delete','profit-loss','product-report','purchase-report','sale-report','product-qty-alert','customer-report','due-report'] as $value){
            Permission::create(['name' => $value]);
        }
    }
}

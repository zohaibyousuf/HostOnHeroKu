<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function boot()
    {
        $language = DB::table('languages')->latest()->first();
        if(count($language) > 0){
            $alert_product = DB::table('products')->where('is_active', true)->whereColumn('alert_qty', '>', 'qty')->count();
            \App::setLocale($language->code);
            View::share('settings', DB::table('settings')->latest()->first());
            View::share('language', $language);
            View::share('alert_product', $alert_product);
        }
        
        Schema::defaultStringLength(191);
    }
}

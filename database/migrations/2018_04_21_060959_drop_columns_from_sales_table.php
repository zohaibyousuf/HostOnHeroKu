<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnsFromSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('sales', function (Blueprint $table) {
//             $table->dropColumn(['customer', 'address', 'phone']);
//        });

        if (Schema::hasColumn('sales', 'customer'))
        {
            Schema::table('sales', function (Blueprint $table)
            {
                $table->dropColumn('customer');
            });
        }
        if (Schema::hasColumn('sales', 'address'))
        {
            Schema::table('sales', function (Blueprint $table)
            {
                $table->dropColumn('address');
            });
        }
        if (Schema::hasColumn('sales', 'phone'))
        {
            Schema::table('sales', function (Blueprint $table)
            {
                $table->dropColumn('phone');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            //
        });
    }
}

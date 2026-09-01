<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('original_price')->nullable()->after('qty');
            $table->string('selling_price')->nullable()->after('original_price');
            $table->string('gst_charge')->nullable()->after('selling_price');
            $table->string('binding')->nullable()->after('gst_charge');
            $table->string('condition')->nullable()->after('binding');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('original_price');
            $table->dropColumn('selling_price');
            $table->dropColumn('gst_charge');
            $table->dropColumn('binding');
            $table->dropColumn('condition');
        });
    }
};

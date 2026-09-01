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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('length')->nullable()->after('transactionId');
            $table->string('breadth')->nullable()->after('length');
            $table->string('height')->nullable()->after('breadth');
            $table->string('weight')->nullable()->after('height');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('length');
            $table->dropColumn('breadth');
            $table->dropColumn('height');
            $table->dropColumn('weight');
        });
    }
};

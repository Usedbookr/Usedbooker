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
            $table->string('merchantId')->nullable()->after('payment_status');
            $table->string('providerReferenceId')->nullable()->after('merchantId');
            $table->string('checksum')->nullable()->after('providerReferenceId');
            $table->string('transactionId')->nullable()->after('checksum');
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
            $table->dropColumn('merchantId');
            $table->dropColumn('providerReferenceId');
            $table->dropColumn('checksum');
            $table->dropColumn('transactionId');
        });
    }
};

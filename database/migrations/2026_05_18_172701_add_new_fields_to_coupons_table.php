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
        Schema::table('coupons', function (Blueprint $table) {
            $table->string('coupon_limit_user')->nullable()->after('amounttype');
            $table->integer('category_id')->default(0)->after('status')->nullable();
            $table->integer('exclusion_category_id')->default(0)->after('category_id')->nullable();
            $table->integer('subcategory_id')->default(0)->after('status')->nullable();
            $table->integer('childcategory_id')->default(1)->after('limit_user')->nullable();
            $table->json('product_ids')->nullable()->after('coupon_limit_user');
            $table->json('exclusion_product_ids')->nullable()->after('product_ids');
            $table->json('author_ids')->nullable()->after('product_ids');
            $table->json('book_condition_ids')->nullable()->after('author_ids');
            $table->text('description')->nullable()->after('book_condition_ids');
            $table->boolean('all_time')->default(false)->after('description');
            $table->dateTime('start_date')->nullable()->after('all_time');
            $table->dateTime('end_date')->nullable()->after('start_date');
            $table->text('coupon_name')->nullable()->after('name');
            $table->boolean('is_free_shipping')->default(false)->after('coupon_name');
            $table->boolean('is_accept_other_coupons')->default(false)->after('is_free_shipping');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn([
                'coupon_limit_user',
                'category_id',
                'exclusion_category_id',
                'subcategory_id',
                'childcategory_id',
                'product_ids',
                'exclusion_product_ids',
                'author_ids',
                'book_condition_ids',
                'description',
                'all_time',
                'start_date',
                'end_date',
                'coupon_name',
                'is_free_shipping',
                'is_accept_other_coupons'   
            ]);
        });
    }
};

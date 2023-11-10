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
        Schema::table('detail_sales', function (Blueprint $table) {
            $table->string('sales_id', 20)->change();
            $table->foreign("product_id")->on("products")->references("id")->onDelete('cascade');
            $table->foreign("sales_id")->on("sales")->references("id")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_sales', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['sales_id']);
        });
    }
};

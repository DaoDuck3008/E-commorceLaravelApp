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
        Schema::table('promotions', function (Blueprint $table) {
            //
            $table->string('ImgURL');
            $table->decimal('DiscountPercent',5,2)->nullable()->change();
            $table->date('StartDate')->nullable()->change();
            $table->date('EndDate')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotion', function (Blueprint $table) {
            //
            $table->dropColumn('ImgURL');
            $table->decimal('DiscountPercent',5,2)->nullable(false)->change();
            $table->date('StartDate')->nullable(false)->change();
            $table->date('EndDate')->nullable(false)->change();
        });
    }
};

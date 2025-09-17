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
        Schema::table('orderitems', function (Blueprint $table) {
            //
            $table->unsignedInteger('VersionID')->nullable();
            $table->unsignedInteger('ColorID')->nullable();

            $table->foreign('VersionID')->references('VersionID')->on('productversions');
            $table->foreign('ColorID')->references('ColorID')->on('productcolors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orderitems', function (Blueprint $table) {
            //
            $table->dropColumn('VersionID');
            $table->dropColumn('ColorID');
        });
    }
};

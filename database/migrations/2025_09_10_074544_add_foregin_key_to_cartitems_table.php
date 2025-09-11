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
        Schema::table('cartitems', function (Blueprint $table) {
            //
            $table->unsignedInteger('VersionID')->nullable()->after('ProductID')->default(null);
            $table->unsignedInteger('ColorID')->nullable()->after('ProductID')->default(null);
            

            $table->foreign('VersionID')
                ->references('VersionID')
                ->on('productversions')
                ->onDelete('set null');
            
            $table->foreign('ColorID')
                ->references('ColorID')
                ->on('productcolors')
                ->onDelete('set null');
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cartitems', function (Blueprint $table) {
            $table->dropColumn('VerionID');
            $table->dropColumn('ColorID');
        });

       
    }
};

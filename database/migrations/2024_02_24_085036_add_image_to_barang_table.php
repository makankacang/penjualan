<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->string('image')->nullable(); // Assuming the image path will be stored as a string
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            //
        });
    }
};

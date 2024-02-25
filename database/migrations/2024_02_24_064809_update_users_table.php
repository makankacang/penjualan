<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('jenis_kelamin', ['P', 'L'])->nullable()->change();
            $table->bigInteger('telp')->nullable()->change();
            $table->text('alamat')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // This migration cannot be reversed as it only modifies column types and constraints.
    }
}

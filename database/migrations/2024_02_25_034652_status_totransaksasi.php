<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatustransaksasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->enum('status', ['pending', 'ordered', 'completed'])->default('pending')->after('pelanggan_id');
            // Here 'pending', 'ordered', 'completed' are the possible values for the 'status' column
            // 'pending' is the default status for new transactions
            // You can add more status values as needed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_transaksis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('chart_of_account_id')->unsigned();
            $table->foreign('chart_of_account_id')->references('id')->on('m_chart_of_accounts')->onDelete('cascade');
            $table->date('tanggal');
            $table->text('deskripsi');
            $table->integer('debit')->default(0);
            $table->integer('credit')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_transaksis');
    }
}

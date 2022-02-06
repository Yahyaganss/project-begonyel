<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailpemesanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailpemesanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('pemesanan_id');
            $table->integer('jumlah_beli');
            $table->double('harga');
            $table->enum('status_detail',['cart','checkout']);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('pemesanan_id')->references('id')->on('pemesanans')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detailpemesanans');
    }
}

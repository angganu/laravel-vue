<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_lokasi')->index('FK_inventory_lokasi_id');
            $table->unsignedInteger('id_satuan')->index('FK_barang_satuan_id');
            $table->string('kode_barang', 25);
            $table->string('nama_barang', 50)->nullable();
            $table->unsignedInteger('stock');
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
        Schema::dropIfExists('barang');
    }
}

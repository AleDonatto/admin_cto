<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CompraCliente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('compracliente', function (Blueprint $table) {
            $table->id('idCompra');
            $table->string('NombreCliente');
            $table->string('Telefono');
            $table->longText('productos');
            $table->enum('estatus', [1,2,3,4]); // enviado, confirmado, entregado, cancelado
            //$table->unsignedBigInteger('categoria_id');
            //$table->foreign('categoria_id')->references('idCategoria')->on('categorias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('compraCliente');
    }
}

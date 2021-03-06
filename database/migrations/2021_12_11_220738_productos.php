<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Productos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('productos', function (Blueprint $table) {
            $table->id('idProducto');
            $table->string('nameProducto');
            $table->string('codigo');
            $table->string('descripcion');
            $table->double('precio');
            $table->boolean('mostrar');
            $table->string('image');
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('idCategoria')->on('categorias');
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
        Schema::drop('productos');
    }
}

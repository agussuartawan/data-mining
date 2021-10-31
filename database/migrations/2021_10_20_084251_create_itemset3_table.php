<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemset3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itemset3', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id_a')->nullable();
            $table->integer('product_id_b')->nullable();
            $table->integer('product_id_c')->nullable();
            $table->text('product_name')->nullable();
            $table->integer('jumlah');
            $table->double('support');
            $table->enum('status', ['L', 'T']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itemset3');
    }
}

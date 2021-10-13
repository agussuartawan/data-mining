<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemset2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itemset2', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id_a')->nullable();
            $table->integer('product_id_b')->nullable();
            $table->string('product_name')->nullable();
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
        Schema::dropIfExists('itemset2');
    }
}

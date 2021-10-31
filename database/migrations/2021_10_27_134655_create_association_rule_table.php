<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationRuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('association_rule', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id_a')->nullable();
            $table->integer('product_id_b')->nullable();
            $table->integer('product_id_c')->nullable();
            $table->text('rule_name')->nullable();
            $table->integer('jumlah_a_b');
            $table->integer('jumlah_a');
            $table->double('support');
            $table->double('confidence');
            $table->double('support_x_confidence');
            $table->enum('status', ['L', 'T']);
            $table->enum('type', ['Kombinasi 2 item', 'Kombinasi 3 item']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('association_rule');
    }
}

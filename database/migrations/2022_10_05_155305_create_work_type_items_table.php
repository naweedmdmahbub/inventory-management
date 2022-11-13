<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkTypeItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_type_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_type_id');
            $table->unsignedBigInteger('element_type_id');
            $table->text('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->integer('nos')->nullable();
            $table->float('length')->nullable();
            $table->float('breadth')->nullable();
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->float('quantity')->nullable();
            $table->float('total')->nullable();

            $table->float('dia')->nullable();
            $table->float('rod_length')->nullable();
            $table->float('lap')->nullable();
            $table->float('matam')->nullable();
            $table->float('cutting_length')->nullable();
            $table->integer('item')->nullable();
            $table->integer('layer')->nullable();
            $table->float('total_length')->nullable();
            $table->float('unit_weight')->nullable();
            $table->float('total_weight')->nullable();
            
            $table->float('pile')->nullable();
            $table->float('pile_dia')->nullable();
            $table->float('bar_dia')->nullable();
            $table->integer('rebar_num')->nullable();
            $table->float('laping')->nullable();
            $table->float('actual_length')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('work_type_items');
    }
}

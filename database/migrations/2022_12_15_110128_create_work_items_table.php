<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('work_id');
            $table->unsignedBigInteger('element_type_id');
            $table->text('description')->nullable();
            $table->text('workzone')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->integer('nos')->nullable();
            $table->float('length')->nullable();
            $table->float('breadth')->nullable();
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->double('quantity')->nullable();
            $table->double('total')->nullable();

            $table->float('dia')->nullable();
            $table->float('rod_length')->nullable();
            $table->float('lap')->nullable();
            $table->float('matam')->nullable();
            $table->float('cutting_length')->nullable();
            $table->integer('item')->nullable();
            $table->integer('layer')->nullable();
            $table->double('total_length')->nullable();
            $table->float('unit_weight')->nullable();
            $table->double('total_weight')->nullable();
            
            $table->float('pile')->nullable();
            $table->float('pile_dia')->nullable();
            $table->float('bar_dia')->nullable();
            $table->integer('rebar_num')->nullable();
            $table->float('laping')->nullable();
            $table->float('actual_length')->nullable();
            $table->text('remarks')->nullable();
            $table->foreign('work_id')->references('id')->on('works')->onDelete('cascade');
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
        Schema::dropIfExists('work_items');
    }
}

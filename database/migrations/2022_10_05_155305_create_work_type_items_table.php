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
            $table->unsignedBigInteger('unit_id');
            $table->text('description')->nullable();
            $table->float('nos')->nullable();
            $table->float('length')->nullable();
            $table->float('breadth')->nullable();
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->float('quantity')->nullable();
            $table->float('total')->nullable();
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 15,2)->default(0,00);
            $table->enum('status', ['success', 'failure']);
            $table->boolean('notified')->default(false);
            $table->unsignedBigInteger('paying_purse_id');
            $table->foreign('paying_purse_id')->references('id')->on('purses');
            $table->unsignedBigInteger('receiver_purse_id');
            $table->foreign('receiver_purse_id')->references('id')->on('purses');
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
        Schema::dropIfExists('transfers');
    }
}

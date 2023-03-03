<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expired_subscription_docs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('subscription_id')->unsigned()->index();
            $table->foreign('subscription_id')->references('id')->on('subscription')->onDelete('cascade');
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
        Schema::dropIfExists('expired_subscription_docs');
    }
};

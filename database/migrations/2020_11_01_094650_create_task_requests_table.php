<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->index();
            $table->unsignedBigInteger('offer_id')->index();
            $table->string('title')->index();
            $table->string('store')->index();
            $table->string('destination_url');
            $table->string('coupon_code')->nullable();
            $table->timestamp('expires_at')->index()->nullable();
            $table->text('description')->nullable();
            $table->integer('coin_reward');
            $table->json('custom_attributes')->nullable();
            $table->json('images');
            $table->json('tags')->nullable();
            $table->json('prices')->nullable();
            $table->boolean('is_sent')->default(false);
            $table->text('response')->nullable();
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
        Schema::dropIfExists('task_requests');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBulkTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulk_tasks', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->string('csv_file')->nullable()->default(null);
            $table->string('images_zip_file')->nullable()->default(null);
            $table->boolean('is_activated')->default(false)->index();
            $table->string('status')->default('pending')->index();
            $table->string('result')->nullable()->default(null);
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
        Schema::dropIfExists('bulk_tasks');
    }
}

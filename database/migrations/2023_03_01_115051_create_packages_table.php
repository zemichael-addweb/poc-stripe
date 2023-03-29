<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('package_name');
            $table->string('details')->nullable();
            $table->double('price', 8, 2)->nullable()->default(0.00);
            $table->enum('type', ['subscription', 'wallet'])->default('subscription');
            $table->smallInteger('number_of_students')->default(0);
            $table->smallInteger('validity_duration')->nullable()->default(0);
            $table->boolean('is_active');
            $table->boolean('published_stripe')->default(0);
            $table->string('stripe_price_id', 250)->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

			// Add foreign key constraints
			$table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('restrict');
			$table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('restrict');
			$table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
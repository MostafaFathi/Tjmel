<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('section_id')->unsigned()->index();
            $table->bigInteger('clinic_id')->unsigned()->index();
            $table->text('name_ar');
            $table->longText('description_ar')->nullable();
            $table->longText('instructions_ar')->nullable();
            $table->float('price_before')->default(1);
            $table->float('price_after')->default(2);
            $table->integer('status')->default(0);
            $table->timestamps();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}

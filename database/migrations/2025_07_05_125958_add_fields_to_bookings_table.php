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
        Schema::table('bookings', function (Blueprint $table) {
             $table->string('heir_name')->nullable();
    $table->string('heir_id')->nullable();
    $table->text('property_description')->nullable();

    $table->string('authorized_name')->nullable();
    $table->text('proxy_purpose')->nullable();

    $table->text('declaration_content')->nullable();

    $table->string('child_name')->nullable();
    $table->string('travel_destination')->nullable();

    $table->string('ownership_document_path')->nullable();
    $table->string('document_to_legalize_path')->nullable();
    $table->string('child_document_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
};

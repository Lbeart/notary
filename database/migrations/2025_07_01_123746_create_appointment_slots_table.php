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
    public function up(): void
{
    Schema::create('appointment_slots', function (Blueprint $table) {
        $table->id();
        $table->foreignId('notary_id')->constrained()->onDelete('cascade');
        $table->date('date');
        $table->time('start_time');
        $table->time('end_time');
        $table->boolean('is_booked')->default(false);
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
        Schema::dropIfExists('appointment_slots');
    }
};

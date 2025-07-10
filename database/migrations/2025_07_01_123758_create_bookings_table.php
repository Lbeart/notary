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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('notary_id')->constrained()->onDelete('cascade');
        $table->foreignId('appointment_slot_id')->constrained()->onDelete('cascade');
        $table->foreignId('service_type_id')->constrained()->onDelete('cascade');
        $table->text('description')->nullable();
        $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
        
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
        Schema::dropIfExists('bookings');
    }
};

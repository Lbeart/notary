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
        $table->dropForeign(['appointment_slot_id']);
        $table->dropColumn('appointment_slot_id');
    });
}

public function down()
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->foreignId('appointment_slot_id')->constrained()->onDelete('cascade');
    });
}
};

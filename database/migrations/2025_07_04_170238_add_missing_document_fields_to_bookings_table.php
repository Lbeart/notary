<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'document_path')) {
                $table->string('document_path')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'translated_path')) {
                $table->string('translated_path')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'signed_path')) {
                $table->string('signed_path')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'signature_path')) {
                $table->string('signature_path')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'is_translated')) {
                $table->boolean('is_translated')->default(false);
            }
            if (!Schema::hasColumn('bookings', 'is_signed')) {
                $table->boolean('is_signed')->default(false);
            }
            if (!Schema::hasColumn('bookings', 'is_sealed')) {
                $table->boolean('is_sealed')->default(false);
            }
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'document_path',
                'translated_path',
                'signed_path',
                'signature_path',
                'is_translated',
                'is_signed',
                'is_sealed',
            ]);
        });
    }
};
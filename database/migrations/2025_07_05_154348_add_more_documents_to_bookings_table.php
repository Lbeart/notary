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
    $table->string('identity_document_path')->nullable();
    $table->string('additional_document_path')->nullable();
    $table->string('client_photo_path')->nullable();
    $table->string('testament_file_path')->nullable();
    $table->string('property_contract_path')->nullable();
    $table->string('mortgage_document_path')->nullable();
    $table->string('exchange_document_path')->nullable();
    $table->string('rental_agreement_path')->nullable();
    $table->string('coownership_document_path')->nullable();
    $table->string('pledge_document_path')->nullable();
    $table->string('rights_document_path')->nullable();
    $table->string('company_documents_path')->nullable();
    $table->string('signature_doc_path')->nullable();
    $table->string('employment_contract_path')->nullable();
    $table->string('id_card_path')->nullable();
    $table->string('signed_document_path')->nullable();
    $table->string('contract_to_verify_path')->nullable();
    $table->string('original_copy_path')->nullable();
    $table->string('testament_to_store_path')->nullable();
    $table->string('document_to_translate_path')->nullable();
    $table->string('sales_contract_path')->nullable();
    $table->string('donation_contract_path')->nullable();
    $table->string('lease_contract_path')->nullable();
    $table->string('child_passport_path')->nullable();
    $table->string('legalization_document_path')->nullable();
    $table->string('notarization_file_path')->nullable();
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
    $table->dropColumn([
        'identity_document_path',
        'additional_document_path',
        'client_photo_path',
        'testament_file_path',
        'property_contract_path',
        'mortgage_document_path',
        'exchange_document_path',
        'rental_agreement_path',
        'coownership_document_path',
        'pledge_document_path',
        'rights_document_path',
        'company_documents_path',
        'signature_doc_path',
        'employment_contract_path',
        'id_card_path',
        'signed_document_path',
        'contract_to_verify_path',
        'original_copy_path',
        'testament_to_store_path',
        'document_to_translate_path',
        'sales_contract_path',
        'donation_contract_path',
        'lease_contract_path',
        'child_passport_path',
        'legalization_document_path',
        'notarization_file_path',
    ]);
});

    }
};

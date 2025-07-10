<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
protected $fillable = [
    'user_id',
    'notary_id',
    'service_type_id',
    'description',
    'selected_time',

    // Tekste shtesë
    'heir_name',
    'heir_id',
    'property_description',
    'authorized_name',
    'proxy_purpose',
    'declaration_content',
    'child_name',
    'travel_destination',

    // Dokumente
    'document_path',
    'ownership_document_path',
    'document_to_legalize_path',
    'child_document_path',

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

    // Flags
    'is_translated',
    'translated_path',
    'is_signed',
    'signed_path',
    'signature_path',
    'is_sealed',
];

    // RELACIONET

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notary()
    {
        return $this->belongsTo(Notary::class);
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }
}

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
    'appointment_slot_id',
    'service_type_id',
    'description',
];
  public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacioni me Notary
    public function notary()
    {
        return $this->belongsTo(Notary::class);
    }

    // Relacioni me AppointmentSlot
    public function appointmentSlot()
    {
        return $this->belongsTo(AppointmentSlot::class);
    }

    // Relacioni me ServiceType
    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }
}

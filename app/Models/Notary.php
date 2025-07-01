<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notary extends Model
{
    use HasFactory;
     protected $fillable = [
        'user_id',
        'city_id',
        'address',
        'phone',
    ];
    public function ratings()
{
    return $this->hasMany(Rating::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}
public function city()
{
    return $this->belongsTo(City::class);
}
public function appointmentSlots()
{
    return $this->hasMany(AppointmentSlot::class);
}
public function bookings()
{
    return $this->hasMany(\App\Models\Booking::class);
}


}

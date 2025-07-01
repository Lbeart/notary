<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentSlot extends Model
{
    use HasFactory;
    protected $fillable = [
        'notary_id',
        'date',
        'start_time',
        'end_time',
    ];
      // Definimet e marrëdhënieve nëse ke
    public function notary()
    {
        return $this->belongsTo(Notary::class);
    }
}

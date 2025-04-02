<?php

namespace App\Http\Models;

use Core\Model;

class DoctorAppointment extends Model
{
    protected static string $table = 'doctor_appointments';
    protected array $fillable = ['id', 'doctor_schedule_id', 'time', 'is_booked', 'patient_id', 'note', 'diagnosis'];
    protected array $guarded = [];
}

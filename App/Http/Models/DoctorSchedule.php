<?php

namespace App\Http\Models;

use Core\Model;

class DoctorSchedule extends Model
{
    protected static string $table = 'doctor_schedules';
    protected array $fillable = ['id', 'user_id', 'date', 'time_from', 'time_to'];
    protected array $guarded = [];
}

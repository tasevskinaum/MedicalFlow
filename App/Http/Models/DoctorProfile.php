<?php

namespace App\Http\Models;

use Core\Model;

class DoctorProfile extends Model
{
    protected static string $table = 'doctor_profile';
    protected array $fillable = ['id', 'user_id', 'short_bio', 'phone_number', 'is_completed'];
    protected array $guarded = [];
}

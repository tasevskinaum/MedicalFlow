<?php

namespace App\Http\Models;

use Core\Model;

class Patient extends Model
{
    protected static string $table = 'patients';
    protected array $fillable = ['id', 'first_name', 'last_name', 'personal_no', 'phone_number'];
    protected array $guarded = [];
}

<?php

namespace App\Http\Models;

use Core\Model;

class Role extends Model
{
    protected static string $table = 'roles';
    protected array $fillable = ['id', 'name'];
    protected array $guarded = [];
}

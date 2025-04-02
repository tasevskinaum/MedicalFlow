<?php

namespace App\Http\Models;

use Core\Model;

class User extends Model
{
    protected static string $table = 'users';
    protected array $fillable = ['id', 'name', 'role_id', 'email', 'username', 'password'];
    protected array $guarded = [];

    public function isRole(string $role): bool
    {
        $roleModel = Role::queryBuilder()->where('name', '=', $role)->first();

        return $roleModel ? $this->role_id == $roleModel->id : false;
    }
}

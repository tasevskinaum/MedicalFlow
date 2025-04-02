<?php

namespace App\Http\Controllers\API;

use App\Http\Models\Role;
use App\Http\Models\User;
use Exception;

class DoctorController
{
    public function index()
    {
        try {
            $doctorRole = Role::queryBuilder()->where('name', '=', 'doctor')->first();

            echo json_encode(
                [
                    'data' => User::queryBuilder()
                        ->where('role_id', '=', $doctorRole->id)
                        ->except(['email', 'password', 'role_id'])
                        ->get(),
                    'status' => 200
                ]
            );
        } catch (Exception $e) {
            echo json_encode(
                [
                    'status' => $e->getCode(),
                    'message' => $e->getMessage()
                ]
            );
        }
    }
}

<?php

use App\Http\Controllers\API\DoctorAppointmentController;
use App\Http\Controllers\API\DoctorController;
use Core\Router as Route;

// DOCTOR APPOINTMENTS

Route::get('/api/doctor/{doctor}/appointments', DoctorAppointmentController::class, 'getAppointmentsByDoctor');

Route::post('/api/doctor/{doctor}/appointments/{appointment}', DoctorAppointmentController::class, 'storeAppointment');

// DOCTOR

Route::get('/api/doctors', DoctorController::class, 'index');

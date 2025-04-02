<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorAppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorProfileController;
use App\Http\Controllers\DoctorWorkingScheduleController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\PatientDiagnosisController;
use App\Middleware\AdminMiddleware;
use App\Middleware\AuthMiddleware;
use App\Middleware\DoctorMiddleware;
use App\Middleware\SuperAdminMiddleware;
use \Core\Router as Route;

Route::get('/', HomePageController::class, 'index');

require_once BASE_PATH . 'routes/auth.php';

// DASHBOARD
Route::get('/dashboard', AdminDashboardController::class, 'index', [
    AuthMiddleware::class
]);

// ADMIN CRUD
Route::get('/admins', AdminController::class, 'index', [
    AuthMiddleware::class,
    SuperAdminMiddleware::class
]);
Route::get('/admins/create', AdminController::class, 'create', [
    AuthMiddleware::class,
    SuperAdminMiddleware::class
]);
Route::post('/admins/store', AdminController::class, 'store', [
    AuthMiddleware::class,
    SuperAdminMiddleware::class
]);
Route::get('/admins/edit/{user}', AdminController::class, 'edit', [
    AuthMiddleware::class,
    SuperAdminMiddleware::class
]);
Route::post('/admins/update/{user}', AdminController::class, 'update', [
    AuthMiddleware::class,
    SuperAdminMiddleware::class
]);
Route::delete('/admins/destroy/{user}', AdminController::class, 'destroy', [
    AuthMiddleware::class,
    SuperAdminMiddleware::class
]);

// DOCTOR CRUD
Route::get('/doctors', DoctorController::class, 'index', [
    AuthMiddleware::class,
    AdminMiddleware::class
]);
Route::get('/doctors/create', DoctorController::class, 'create', [
    AuthMiddleware::class,
    AdminMiddleware::class
]);
Route::post('/doctors/store', DoctorController::class, 'store', [
    AuthMiddleware::class,
    AdminMiddleware::class
]);
Route::get('/doctors/edit/{user}', DoctorController::class, 'edit', [
    AuthMiddleware::class,
    AdminMiddleware::class
]);
Route::post('/doctors/update/{user}', DoctorController::class, 'update', [
    AuthMiddleware::class,
    AdminMiddleware::class
]);
Route::delete('/doctors/destroy/{user}', DoctorController::class, 'destroy', [
    AuthMiddleware::class,
    AdminMiddleware::class
]);

// DOCTOR WORK SCHEDULE
Route::get('/doctors/{user}/schedule', DoctorWorkingScheduleController::class, 'index', [
    AuthMiddleware::class,
    DoctorMiddleware::class
]);

Route::get('/doctors/{user}/schedule/create', DoctorWorkingScheduleController::class, 'create', [
    AuthMiddleware::class,
    DoctorMiddleware::class
]);

Route::post('/doctors/{user}/schedule/store', DoctorWorkingScheduleController::class, 'store', [
    AuthMiddleware::class,
    DoctorMiddleware::class
]);

Route::delete('/doctors/{user}/schedule/{schedule}/destroy', DoctorWorkingScheduleController::class, 'destroy', [
    AuthMiddleware::class,
    DoctorMiddleware::class
]);

// REQUEST APPOINTMENTS

Route::get('/request-an-appointment', AppointmentController::class, 'index');

// APPOINTMENTS

Route::get('/appointments', DoctorAppointmentController::class, 'index', [
    AuthMiddleware::class,
    DoctorMiddleware::class
]);

Route::get('/appointments/{doctorAppointment}/write-diagnosis', PatientDiagnosisController::class, 'index', [
    AuthMiddleware::class,
    DoctorMiddleware::class
]);

Route::post('/appointments/{doctorAppointment}/write-diagnosis', PatientDiagnosisController::class, 'store', [
    AuthMiddleware::class,
    DoctorMiddleware::class
]);

Route::delete('/appointments/{doctorAppointment}/decline', DoctorAppointmentController::class, 'decline', [
    AuthMiddleware::class,
    DoctorMiddleware::class
]);

<?php

namespace App\Http\Controllers;

use App\Http\Models\DoctorAppointment;
use App\Http\Models\DoctorSchedule;
use App\Http\Models\Patient;
use App\Http\Models\User;


class PatientController extends Controller
{
    public function index()
    {
        return view('doctor.patient.index', [
            'patients' => Patient::all()
        ]);
    }

    public function show(Patient $patient)
    {
        $previousAppointments = DoctorAppointment::queryBuilder()
            ->where('patient_id', '=', $patient->id)
            ->get();

        foreach ($previousAppointments as &$appointment) {
            $schedule = DoctorSchedule::queryBuilder()
                ->where('id', '=', $appointment->doctor_schedule_id)
                ->first();

            $appointment = array_merge(
                (array)$appointment,
                [
                    'date' => $schedule->date,
                    'doctor_name' => User::queryBuilder()->where('id', '=', $schedule->user_id)->first()->name
                ]
            );
        }

        usort($previousAppointments, function ($a, $b) {
            $dateCompare = strtotime($b['date']) <=> strtotime($a['date']);
            return $dateCompare;
        });

        return view('doctor.patient.show', [
            'patient' => $patient,
            'patientHistory' => $previousAppointments
        ]);
    }
}

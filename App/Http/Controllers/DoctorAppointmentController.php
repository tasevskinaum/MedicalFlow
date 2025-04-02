<?php

namespace App\Http\Controllers;

use App\Http\Models\DoctorAppointment;
use App\Http\Models\DoctorSchedule;
use App\Http\Models\Patient;
use Carbon\Carbon;
use Core\Request;
use Core\Session;

class DoctorAppointmentController extends Controller
{
    public function index()
    {
        $activeSchedules = DoctorSchedule::queryBuilder()
            ->where('user_id', '=', auth()->user()->id)
            ->where('date', '>=', Carbon::today())
            ->get();

        $appointments = [];
        foreach ($activeSchedules as $activeSchedule) {
            $appointments[$activeSchedule->date] = array_map(function ($appointment) {
                $patient = Patient::queryBuilder()->where('id', '=', $appointment->patient_id)->first();

                return array_merge((array) $appointment, [
                    'patient_firstname' => $patient->first_name,
                    'patient_lastname' => $patient->last_name,
                    'patient_phone' => $patient->phone_number,
                    'patient_personalno' => $patient->personal_no
                ]);
            }, DoctorAppointment::queryBuilder()
                ->where('doctor_schedule_id', '=', $activeSchedule->id)
                ->where('is_booked', '=', true)
                ->where('diagnosis', 'IS', null)

                ->get());
        }

        return view('doctor.upcoming-appointments.index', [
            'appointments' => $appointments
        ]);
    }

    public function store(Request $request, DoctorSchedule $doctorSchedule)
    {
        $time_from = Carbon::parse($request->time_from);
        $time_to = Carbon::parse($request->time_to);

        $doctorAppointment = new DoctorAppointment();
        $doctorAppointment->doctor_schedule_id = $doctorSchedule->id;

        while ($time_from < $time_to) {
            $doctorAppointment->time = $time_from;
            $doctorAppointment->save();

            $time_from->addHour();
        }
    }

    public function decline(DoctorAppointment $doctorAppointment)
    {
        $doctorAppointment->update(
            [
                'is_booked' => false,
                'patient_id' => null,
                'note' => null
            ]
        );

        Session::flash('success', 'Succesfully declined.');

        return redirect('/appointments');
    }
}

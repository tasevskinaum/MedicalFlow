<?php

namespace App\Http\Controllers;

use App\Http\Models\DoctorAppointment;
use App\Http\Models\DoctorSchedule;
use App\Http\Models\Patient;
use Core\Request;
use Core\Session;
use Core\Validator;

class PatientDiagnosisController extends Controller
{
    public function index(DoctorAppointment $doctorAppointment)
    {
        $appointment = DoctorSchedule::find($doctorAppointment->doctor_schedule_id);

        if ($appointment->user_id != auth()->user()->id) {
            Session::flash('success', "You dont't have acsess to open appointment");
            return redirect('/appointments');
        }

        return view('doctor.write-diagnosis.index', [
            'appointment' => $doctorAppointment,
            'patient' => Patient::find($doctorAppointment->patient_id),
            'previous_diagnosis' => DoctorAppointment::queryBuilder()
                ->where('patient_id', '=', $doctorAppointment->patient_id)
                ->where('diagnosis', "IS NOT", null)
                ->get()
        ]);
    }

    public function store(DoctorAppointment $doctorAppointment, Request $request)
    {
        $data = [
            'diagnosis' => $request->diagnosis,
        ];

        $rules = [
            'diagnosis' => 'required',
        ];

        $validator = new Validator($data, $rules);

        if (!$validator->validate()) {
            return redirect("/appointments/" . $doctorAppointment->id . "/write-diagnosis");
        }

        $doctorAppointment->update([
            'diagnosis' => $request->diagnosis
        ]);

        return redirect('/appointments');
    }
}

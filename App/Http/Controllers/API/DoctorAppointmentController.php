<?php

namespace App\Http\Controllers\API;

use App\Http\Models\DoctorAppointment;
use App\Http\Models\DoctorSchedule;
use App\Http\Models\Patient;
use App\Http\Models\User;
use Carbon\Carbon;
use Core\Request;
use Core\Validator;
use Exception;

class DoctorAppointmentController
{
    public function storeAppointment(User $doctor, DoctorAppointment $appointment, Request $request)
    {
        $schedule = DoctorSchedule::find($appointment->doctor_schedule_id);

        if (!$schedule || $schedule->user_id != $doctor->id) {
            echo json_encode(
                [
                    'message' => 'The term you selected does not belong to the selected doctor.',
                    'status' => 400
                ],
                JSON_PRETTY_PRINT
            );

            return;
        }

        if ($appointment->is_booked) {
            echo json_encode(
                [
                    'message' => 'An error occurred. The term is reserved.',
                    'status' => 400
                ],
                JSON_PRETTY_PRINT
            );

            return;
        }

        $data = $_POST;

        $rules = [
            'first-name' => 'required|max:255',
            'last-name' => 'required|max:255',
            'personal-no' => 'required|regex:/^\d{13}$/',
            'phone-number' => 'required|regex:/^07[0-9]{1}[0-9]{6}$/',
            'note' => 'max:500',
            'doctor' => 'required|exists:users,id',
            'appointment-date' => 'required|date',
            'time-slot' => 'required|exists:doctor_appointments,id',
        ];

        $validator = new Validator($data, $rules);

        if (!$validator->validate()) {
            echo json_encode(
                [
                    "error" => $validator->errors(),
                    "status" => 422
                ],
                JSON_PRETTY_PRINT
            );
            return;
        }

        $patient = Patient::queryBuilder()
            ->where('personal_no', '=', $data['personal-no'])
            ->first();

        if (!$patient) {
            $patient = new Patient();
            $patient->first_name = $data['first-name'];
            $patient->last_name = $data['last-name'];
            $patient->personal_no = $data['personal-no'];
            $patient->phone_number = $data['phone-number'];

            $patient = $patient->save();
        }

        $appointment->update([
            'is_booked' => true,
            'patient_id' => $patient->id,
            'note' => $data['note'] ?? ''
        ]);

        echo json_encode(
            [
                'message' => 'Appointment successfully scheduled',
                'status' => 200
            ],
            JSON_PRETTY_PRINT
        );
    }

    public function getAppointmentsByDoctor(User $doctor)
    {
        try {
            $activeSchedules =
                DoctorSchedule::queryBuilder()
                ->where('user_id', '=', $doctor->id)
                ->where('date', '>', Carbon::now())
                ->get();

            $activeAppointments = [];

            foreach ($activeSchedules as $schedule) {
                $appointments =
                    DoctorAppointment::queryBuilder()
                    ->where('doctor_schedule_id', '=', $schedule->id)
                    ->where('is_booked', '=', false)
                    ->get();

                if (!empty($appointments)) {
                    $activeAppointments[$schedule->date] = $appointments;
                }
            }

            echo json_encode(
                [
                    'data' => $activeAppointments,
                    'status' => 200
                ],
                JSON_PRETTY_PRINT

            );
        } catch (Exception $e) {
            echo json_encode(
                [
                    'status' => $e->getCode(),
                    'message' => $e->getMessage()
                ],
                JSON_PRETTY_PRINT
            );
        }
    }
}

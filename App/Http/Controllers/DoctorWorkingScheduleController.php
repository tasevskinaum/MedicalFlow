<?php

namespace App\Http\Controllers;

use App\Http\Models\DoctorAppointment;
use App\Http\Models\DoctorSchedule;
use App\Http\Models\User;
use Core\Request;
use Core\Session;
use Core\Validator;
use Carbon\Carbon;

class DoctorWorkingScheduleController extends Controller
{
    public function index()
    {
        return view('doctor.work-schedule.index', [
            'schedules' => DoctorSchedule::queryBuilder()
                ->where('user_id', '=', auth()->user()->id)
                ->where('date', '>=', Carbon::today()->toDateString())
                ->get()
        ]);
    }

    public function create()
    {
        return view('doctor.work-schedule.create');
    }

    public function store(Request $request)
    {
        $data = [
            'date' => $request->date,
            'time_from' => $request->time_from,
            'time_to' => $request->time_to
        ];

        $rules = [
            'date' => 'required|date|after:' . Carbon::today()->toDateString() . '|before_or_equal:' . Carbon::today()->addWeeks(2)->toDateString(),
            'time_from' => 'required|time_range|time',
            'time_to' => 'required|time_range|after_time:time_from|time'
        ];

        $validator = new Validator($data, $rules);

        if (!$validator->validate()) {
            return redirect("/doctors/" . auth()->user()->id . "/schedule/create");
        }

        $schedule = new DoctorSchedule();
        $schedule->user_id = auth()->user()->id;
        $schedule->date = $data['date'];
        $schedule->time_from = $data['time_from'];
        $schedule->time_to = $data['time_to'];

        $schedule = $schedule->save();

        (new DoctorAppointmentController)->store($request, $schedule);

        Session::flash('success', 'Doctor schedule added successfully!');

        return redirect("/doctors/" . auth()->user()->id . "/schedule");
    }

    public function destroy(User $user, DoctorSchedule $schedule)
    {
        if ($schedule->user_id != auth()->user()->id) {
            Session::flash('success', "You can't modify schedule for other doctors, you can modify only your schedule.");
            return redirect("/doctors/" . auth()->user()->id . "/schedule");
        }

        if (Carbon::createFromDate($schedule->date)->lessThanOrEqualTo(Carbon::today())) {
            Session::flash('success', "You cannot modify schedules in the past.");
            return redirect("/doctors/" . auth()->user()->id . "/schedule");
        }

        $doctorAppointments = DoctorAppointment::queryBuilder()
            ->where('doctor_schedule_id', '=', $schedule->id)->get();

        foreach ($doctorAppointments as $doctorAppointment) {
            $doctorAppointment->delete();
        }

        $schedule->delete();

        Session::flash('success', 'Schedule deleted successfully!');

        return redirect("/doctors/" . auth()->user()->id . "/schedule");
    }
}

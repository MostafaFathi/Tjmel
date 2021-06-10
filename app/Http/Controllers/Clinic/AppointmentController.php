<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Service\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = auth()->user()->clinic->services;
        $offers = auth()->user()->clinic->offers;
        Carbon::setLocale('ar');
        $date = Carbon::now();
        $days = $date->daysInMonth;
        $currentMonthName = $date->translatedFormat('F Y');
        $currentMonth = $date->format('Y-m');
        $nextMonth = $date->addMonth()->format('Y-m');
        $prevMonth = $date->subMonths(2)->format('Y-m');
        $times = $this->generateTimeIntervals('7:00 am', '1:30 am');

        return view('clinic.appointments.index', compact('services', 'offers', 'days', 'times', 'currentMonthName', 'currentMonth', 'nextMonth', 'prevMonth'));
    }

    public function getDate($month, $id = null)
    {
        Carbon::setLocale('ar');
        $date = Carbon::parse($month);
        $days = $date->daysInMonth;
        $currentMonthName = $date->translatedFormat('F Y');
        $currentMonth = $date->format('Y-m');
        $nextMonth = $date->addMonth()->format('Y-m');
        $prevMonth = $date->subMonths(2)->format('Y-m');
        $selectedTimes = [];
        $appointments = [];
        if ($id) {
            $serviceIdAndType = explode('-', $id);
            $appointments = Appointment::where('clinic_id', auth()->user()->clinic->id)
                ->where('service_id', $serviceIdAndType[0])
                ->where('service_type', $serviceIdAndType[1])
                ->where('date', 'like', '%' . $month . '%')
                ->get();
            $monthList = '<ul class="month-days">';
            for ($i = 1; $i <= $days; $i++) {
                $flag = false;
                foreach ($appointments as $appointment) {

                    if (explode(' ', $appointment->date)[0] == $month . '-' . str_pad($i, 2, '0', STR_PAD_LEFT)) {
                        $flag = true;
                        array_push($selectedTimes, $appointment->times);
                        $monthList .= '<li class="day-btn checked" date="' . $currentMonth . '-' . $i . '"><input type="hidden" class="day-date" name="dates[]" value="' . $currentMonth . '-' . $i . '">' . $i . '<span>' . Carbon::parse($currentMonth . '-' . $i)->translatedFormat('l') . '</span></li>';
                    }
                }
                if (!$flag) {
                    $monthList .= '<li class="day-btn" date="' . $currentMonth . '-' . $i . '"><input type="hidden" class="day-date" name="dates[]" value="">' . $i . '<span>' . Carbon::parse($currentMonth . '-' . $i)->translatedFormat('l') . '</span></li>';

                }

            }
            $monthList .= '<li class="all-days-btn">حدد كل الشهر <span>جميع الايام</span></li>';
            $monthList .= '</ul>';
        }
        if (!$id || count($appointments) == 0) {
            $monthList = '<ul class="month-days">';
            for ($i = 1; $i <= $days; $i++) {
                $monthList .= '<li class="day-btn" date="' . $currentMonth . '-' . $i . '"><input type="hidden" class="day-date" name="dates[]" value="">' . $i . '<span>' . Carbon::parse($currentMonth . '-' . $i)->translatedFormat('l') . '</span></li>';
            }
            $monthList .= '<li class="all-days-btn">حدد كل الشهر <span>جميع الايام</span></li>';
            $monthList .= '</ul>';
        }

        $times = $this->generateTimeIntervals('7:00 am', '1:30 am');
        $selectedTimes = array_unique(Arr::collapse($selectedTimes), SORT_REGULAR);
        return response()->json(['days' => $days, 'monthList' => $monthList, 'times' => $times, 'selectedTimes' => $selectedTimes, 'currentMonthName' => $currentMonthName, 'currentMonth' => $currentMonth, 'nextMonth' => $nextMonth, 'prevMonth' => $prevMonth]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required',
        ], [
            'service_id.required' => 'حقل اسم الخدمة مطلوب',
        ]);
        $serviceIdAndType = explode('-', $request->service_id);
        $service = $serviceIdAndType[1] == 'service' ? auth()->user()->clinic->services->where('id', $request->service_id)->first() : auth()->user()->clinic->offers->where('id', $request->service_id)->first();
        if (!$service)
            return back()->withErrors('إما انك لم تقم باختيار خدمة او ان هذه الخدمة ليست لعيادتكم.');

        $timesArray = [];
        $key = 0;
        foreach ($request->times as $time) {
            if ($time) {
                array_push($timesArray, ['time' => $time, 'status' => $request->status[$key]]);
            }
            $key++;
        }
        $aa = Appointment::where('clinic_id', auth()->user()->clinic->id)
            ->where('service_id', $serviceIdAndType[0])
            ->where('service_type', $serviceIdAndType[1])
            ->where('date', 'like', '%' . $request->current_month . '%')
            ->pluck('id');
        Appointment::destroy($aa);
        foreach ($request->dates as $date) {
            if ($date) {

                $appointment = new Appointment();
                $appointment->clinic_id = auth()->user()->clinic->id;
                $appointment->service_id = $serviceIdAndType[0];
                $appointment->service_type = $serviceIdAndType[1];
                $appointment->date = $date;
                $appointment->times = $timesArray;
                $appointment->save();
            }

        }

        return back()->with('success', 'تمت عملية الحفظ بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function generateTimeIntervals($from, $to)
    {
        $intervals = [];
        $time_from = Carbon::createFromTimeString($from);
        $to = Carbon::createFromTimeString($to)->format('h:i a');
        while (true) {

            $time_from_string = $time_from->format('h:i a');
            array_push($intervals, $time_from_string);
            $time_from = $time_from->addMinutes(30);


            if ($time_from_string == $to) break;
        }
        return $intervals;
    }
}

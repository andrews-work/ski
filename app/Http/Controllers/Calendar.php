<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Meeting;
use Illuminate\Support\Facades\Log;

class Calendar extends Controller
{
    public function monthly(Request $request)
    {
        $userId = Auth::id();

        // Get the year and month from the request (or default to the current month if not provided)
        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month', Carbon::now()->month);

        // Calculate the start and end of the selected month
        $currentMonthStart = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $currentMonthEnd = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        // Fetch meetings for the selected month
        $meetings = Meeting::where('user_id', $userId)
                            ->whereBetween('date', [$currentMonthStart, $currentMonthEnd])
                            ->orderBy('date', 'asc')
                            ->orderBy('time', 'asc')
                            ->get()
                            ->map(function ($meeting) {
                                $meeting->datetime = $meeting->date . 'T' . $meeting->time;
                                return $meeting;
                            });

        // Log the meetings data for debugging
        Log::info('Meetings for the selected month: ', ['meetings' => $meetings]);

        // Return meetings data as a JSON response
        return response()->json([
            'meetings' => $meetings,
        ]);
    }

    public function weekly(Request $request)
    {
        $userId = Auth::id();

        // Get the start date from the request, default to current week
        $startDate = $request->input('start_date', Carbon::now()->startOfWeek());

        // Generate the weeks dynamically, focusing only on future weeks (not past ones)
        $weeks = [];
        for ($i = 0; $i <= 10; $i++) { // Create 5 future weeks: 0, 1, 2, 3, 4
            $weekStart = Carbon::parse($startDate)->addWeeks($i);
            $weekEnd = $weekStart->copy()->endOfWeek();

            // Generate the days of the current week
            $weekDays = [];
            for ($j = 0; $j < 7; $j++) {
                $currentDay = $weekStart->copy()->addDays($j);
                $weekDays[] = [
                    'dayOfWeek' => $currentDay->format('D'),
                    'date' => $currentDay->day,
                    'fullDate' => $currentDay->toDateString(),
                ];
            }

            // Store the week data
            $weeks[] = [
                'startDate' => $weekStart->toDateString(),
                'endDate' => $weekEnd->toDateString(),
                'weekDays' => $weekDays,
            ];
        }

        // The middle week in the array (index 2) is the week you want to focus on
        $middleWeek = $weeks[2];

        // Fetch meetings for the entire range of weeks
        $meetings = Meeting::where('user_id', $userId)
                            ->whereBetween('date', [$weeks[0]['startDate'], $weeks[count($weeks) - 1]['endDate']])
                            ->orderBy('date', 'asc')
                            ->orderBy('time', 'asc')
                            ->get()
                            ->map(function ($meeting) {
                                $meeting->datetime = $meeting->date . 'T' . $meeting->time;
                                return $meeting;
                            });

        // Return all weeks data with the middle week and meetings
        return response()->json([
            'weeks' => $weeks,
            'middleWeek' => $middleWeek, // Pass the middle week separately
            'meetings' => $meetings,
        ]);
    }

    public function daily(Request $request)
    {
        $userId = Auth::id();
        // Get the date from the request (defaults to today's date)
        $date = $request->input('date', Carbon::now()->toDateString());

        // Fetch meetings for the specific date
        $meetings = Meeting::where('user_id', $userId)
                    ->whereDate('date', $date)
                    ->orderBy('time', 'asc')
                    ->get()
                    ->map(function ($meeting) {
                        // Format time to 'g:i a' (e.g., '9:15 am')
                        $meeting->formatted_time = Carbon::parse($meeting->time)->format('g:i a');
                        $meeting->datetime = $meeting->date . 'T' . $meeting->time;
                        return $meeting;
                    });


        return response()->json([
            'meetings' => $meetings,
        ]);
    }

}

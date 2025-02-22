<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Meetings extends Controller
{
    public function index()
    {
        Log::info('show meetings');

        $userId = Auth::id();
        $meetings = Meeting::where('user_id', $userId)
                        ->orderBy('date', 'asc')
                        ->orderBy('time', 'asc')
                        ->get()
                        ->map(function ($meeting) {
                            $meeting->datetime = $meeting->date . 'T' . $meeting->time;
                            return $meeting;
                        });

        return Inertia::render('Auth/Meetings', [
            'meetings' => $meetings,
        ]);
    }

    public function create(Request $request)
    {
        Log::info('meeting controller - create');

        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'time' => ['required', 'regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/'],
            'location' => 'required|string',
        ]);

        Log::info('validated');

        Meeting::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
        ]);

        Log::info('saved to db');

        return redirect()->route('meetings.index');

        Log::info('redirected');
    }

    public function update(Request $request, $meetingId)
    {
        Log::info('meeting controller - update');

        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'time' => ['required', 'regex:/^([01]?[0-9]|2[0-3]):([0-5][0-9])$/'],
            'location' => 'required|string',
        ]);

        Log::info('validated');

        $meeting = Meeting::find($meetingId);

        if (!$meeting) {
            return redirect()->route('meetings.index')->with('error', 'Meeting not found.');
        }

        if ($meeting->user_id !== Auth::id()) {
            return redirect()->route('meetings.index')->with('error', 'You are not authorized to update this meeting.');
        }

        $meeting->update([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
        ]);

        Log::info('meeting updated');

        return redirect()->route('meetings.index')->with('success', 'Meeting updated successfully.');
    }

    public function delete($meetingId)
    {
        Log::info('Deleting meeting', ['meetingId' => $meetingId]);

        $meeting = Meeting::find($meetingId);

        if (!$meeting) {
            return redirect()->route('meetings.index')->with('error', 'Meeting not found.');
        }

        if ($meeting->user_id !== Auth::id()) {
            return redirect()->route('meetings.index')->with('error', 'You are not authorized to delete this meeting.');
        }

        $meeting->delete();

        return redirect()->route('meetings.index')->with('success', 'Meeting deleted successfully.');
    }
}

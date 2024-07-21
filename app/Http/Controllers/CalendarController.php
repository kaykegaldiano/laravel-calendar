<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(): View
    {
        $calendars = Calendar::all();

        return view('dashboard', compact('calendars'));
    }

    public function calendar(): View
    {
        $publishedCalendars = Calendar::whereNotNull('published_at')->get();
        $notPublishedCalendars = Calendar::whereNull('published_at')->get();

        $events = [];

        foreach ($publishedCalendars as $calendar)
        {
            $events[] = [
                'id' => $calendar->id,
                'title' => $calendar->title,
                'start' => $calendar->published_at,
                'extendedProps' => [
                    'route' => route('calendars.update', $calendar->id)
                ]
            ];
        }

        return view('calendars.index', compact('events', 'notPublishedCalendars', 'publishedCalendars'));
    }

    public function getEvents(): JsonResponse
    {
        $events = [];
        $publishedCalendars = Calendar::whereNotNull('published_at')->get();
        foreach ($publishedCalendars as $calendar)
        {
            $events[] = [
                'id' => $calendar->id,
                'title' => $calendar->title,
                'start' => $calendar->published_at,
                'extendedProps' => [
                    'route' => route('calendars.update', $calendar->id)
                ]
            ];
        }

        return response()->json($events);
    }

    public function create(): View
    {
        return view('calendars.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:300',
            'status' => 'required|integer',
            'published_at' => 'required|date',
        ]);

        Calendar::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'published_at' => $request->published_at,
        ]);

        return to_route('calendars.index')->with('success', __('Calendar created successfully.'));
    }

    public function show(Calendar $calendar)
    {
        //
    }

    public function edit(Calendar $calendar): View
    {
        return view('calendars.edit', compact('calendar'));
    }

    public function update(Request $request, Calendar $calendar)
    {
        $calendar->published_at = $request->published_at;
        $calendar->save();
    }

    public function destroy(Calendar $calendar): RedirectResponse
    {
        $calendar->delete();

        return to_route('calendars.index')->with('success', __('Calendar deleted successfully.'));
    }
}

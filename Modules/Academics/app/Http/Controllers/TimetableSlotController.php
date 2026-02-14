<?php

namespace Modules\Academics\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Modules\Academics\Models\TimetableSlot;

class TimetableSlotController extends Controller
{
    public function index()
    {
        $timetableSlots = Schema::connection('mysql_academics')->hasTable('timetable_slots')
            ? TimetableSlot::with(['schoolClass', 'section', 'subject'])->orderBy('day_of_week')->orderBy('period')->get()
            : collect();

        return view('academics::timetable-slots.index', compact('timetableSlots'));
    }

    public function create()
    {
        $schoolClasses = \Modules\Academics\Models\SchoolClass::with('sections')->orderBy('level')->orderBy('name')->get();
        $subjects = \Modules\Academics\Models\Subject::orderBy('name')->get();
        return view('academics::timetable-slots.create', compact('schoolClasses', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => ['required', 'exists:mysql_academics.classes,id'],
            'section_id' => ['required', 'exists:mysql_academics.sections,id'],
            'subject_id' => ['required', 'exists:mysql_academics.subjects,id'],
            'day_of_week' => ['required', 'integer', 'min:1', 'max:7'],
            'period' => ['required', 'integer', 'min:1'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'room' => ['nullable', 'string', 'max:100'],
        ]);
        TimetableSlot::create($validated);
        return redirect()->route('academics.timetable-slots.index')->with('success', 'Timetable slot created.');
    }

    public function show(TimetableSlot $timetableSlot)
    {
        $timetableSlot->setConnection('mysql_academics');
        $timetableSlot->load(['schoolClass', 'section', 'subject']);
        return view('academics::timetable-slots.show', compact('timetableSlot'));
    }

    public function edit(TimetableSlot $timetableSlot)
    {
        $timetableSlot->setConnection('mysql_academics');
        $schoolClasses = \Modules\Academics\Models\SchoolClass::with('sections')->orderBy('level')->orderBy('name')->get();
        $subjects = \Modules\Academics\Models\Subject::orderBy('name')->get();
        return view('academics::timetable-slots.edit', compact('timetableSlot', 'schoolClasses', 'subjects'));
    }

    public function update(Request $request, TimetableSlot $timetableSlot)
    {
        $timetableSlot->setConnection('mysql_academics');
        $validated = $request->validate([
            'class_id' => ['required', 'exists:mysql_academics.classes,id'],
            'section_id' => ['required', 'exists:mysql_academics.sections,id'],
            'subject_id' => ['required', 'exists:mysql_academics.subjects,id'],
            'day_of_week' => ['required', 'integer', 'min:1', 'max:7'],
            'period' => ['required', 'integer', 'min:1'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'room' => ['nullable', 'string', 'max:100'],
        ]);
        $timetableSlot->update($validated);
        return redirect()->route('academics.timetable-slots.index')->with('success', 'Timetable slot updated.');
    }

    public function destroy(TimetableSlot $timetableSlot)
    {
        $timetableSlot->setConnection('mysql_academics');
        $timetableSlot->delete();
        return redirect()->route('academics.timetable-slots.index')->with('success', 'Timetable slot deleted.');
    }
}

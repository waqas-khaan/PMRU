<?php

namespace Modules\Academics\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Modules\Academics\Models\AcademicYear;

class AcademicYearController extends Controller
{
    public function index()
    {
        $academicYears = Schema::connection('mysql_academics')->hasTable('academic_years')
            ? AcademicYear::orderBy('start_date', 'desc')->get()
            : collect();

        return view('academics::academic-years.index', compact('academicYears'));
    }

    public function create()
    {
        return view('academics::academic-years.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'is_current' => ['nullable', 'boolean'],
        ]);
        $validated['is_current'] = $request->boolean('is_current');
        AcademicYear::create($validated);
        return redirect()->route('academics.academic-years.index')->with('success', 'Academic year created.');
    }

    public function show(AcademicYear $academicYear)
    {
        $academicYear->setConnection('mysql_academics');
        return view('academics::academic-years.show', compact('academicYear'));
    }

    public function edit(AcademicYear $academicYear)
    {
        $academicYear->setConnection('mysql_academics');
        return view('academics::academic-years.edit', compact('academicYear'));
    }

    public function update(Request $request, AcademicYear $academicYear)
    {
        $academicYear->setConnection('mysql_academics');
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'is_current' => ['nullable', 'boolean'],
        ]);
        $validated['is_current'] = $request->boolean('is_current');
        $academicYear->update($validated);
        return redirect()->route('academics.academic-years.index')->with('success', 'Academic year updated.');
    }

    public function destroy(AcademicYear $academicYear)
    {
        $academicYear->setConnection('mysql_academics');
        $academicYear->delete();
        return redirect()->route('academics.academic-years.index')->with('success', 'Academic year deleted.');
    }
}

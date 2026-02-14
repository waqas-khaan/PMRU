<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Modules\Finance\Models\AcademicYear;

class AcademicYearController extends Controller
{
    public function index()
    {
        $academicYears = Schema::connection('mysql_finance')->hasTable('academic_years')
            ? AcademicYear::orderBy('start_date', 'desc')->get()
            : collect();

        return view('finance::academic-years.index', compact('academicYears'));
    }

    public function create()
    {
        return view('finance::academic-years.create');
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

        return redirect()->route('finance.academic-years.index')->with('success', 'Academic year created.');
    }

    public function show(AcademicYear $academicYear)
    {
        $academicYear->setConnection('mysql_finance');
        return view('finance::academic-years.show', compact('academicYear'));
    }

    public function edit(AcademicYear $academicYear)
    {
        $academicYear->setConnection('mysql_finance');
        return view('finance::academic-years.edit', compact('academicYear'));
    }

    public function update(Request $request, AcademicYear $academicYear)
    {
        $academicYear->setConnection('mysql_finance');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'is_current' => ['nullable', 'boolean'],
        ]);

        $validated['is_current'] = $request->boolean('is_current');

        $academicYear->update($validated);

        return redirect()->route('finance.academic-years.index')->with('success', 'Academic year updated.');
    }

    public function destroy(AcademicYear $academicYear)
    {
        $academicYear->setConnection('mysql_finance');
        $academicYear->delete();
        return redirect()->route('finance.academic-years.index')->with('success', 'Academic year deleted.');
    }
}

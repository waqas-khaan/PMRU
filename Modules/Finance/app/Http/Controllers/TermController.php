<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Modules\Finance\Models\Term;

class TermController extends Controller
{
    public function index()
    {
        $terms = Schema::connection('mysql_finance')->hasTable('terms')
            ? Term::with('academicYear')->orderBy('start_date', 'desc')->get()
            : collect();

        return view('finance::terms.index', compact('terms'));
    }

    public function create()
    {
        $academicYears = \Modules\Finance\Models\AcademicYear::orderBy('start_date', 'desc')->get();
        return view('finance::terms.create', compact('academicYears'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_year_id' => ['required', 'exists:mysql_finance.academic_years,id'],
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        Term::create($validated);

        return redirect()->route('finance.terms.index')->with('success', 'Term created.');
    }

    public function show(Term $term)
    {
        $term->setConnection('mysql_finance');
        $term->load('academicYear');
        return view('finance::terms.show', compact('term'));
    }

    public function edit(Term $term)
    {
        $term->setConnection('mysql_finance');
        $academicYears = \Modules\Finance\Models\AcademicYear::orderBy('start_date', 'desc')->get();
        return view('finance::terms.edit', compact('term', 'academicYears'));
    }

    public function update(Request $request, Term $term)
    {
        $term->setConnection('mysql_finance');

        $validated = $request->validate([
            'academic_year_id' => ['required', 'exists:mysql_finance.academic_years,id'],
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $term->update($validated);

        return redirect()->route('finance.terms.index')->with('success', 'Term updated.');
    }

    public function destroy(Term $term)
    {
        $term->setConnection('mysql_finance');
        $term->delete();
        return redirect()->route('finance.terms.index')->with('success', 'Term deleted.');
    }
}

<?php

namespace Modules\Academics\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Modules\Academics\Models\Term;

class TermController extends Controller
{
    public function index()
    {
        $terms = Schema::connection('mysql_academics')->hasTable('terms')
            ? Term::with('academicYear')->orderBy('start_date', 'desc')->get()
            : collect();

        return view('academics::terms.index', compact('terms'));
    }

    public function create()
    {
        $academicYears = \Modules\Academics\Models\AcademicYear::orderBy('start_date', 'desc')->get();
        return view('academics::terms.create', compact('academicYears'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_year_id' => ['required', 'exists:mysql_academics.academic_years,id'],
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);
        Term::create($validated);
        return redirect()->route('academics.terms.index')->with('success', 'Term created.');
    }

    public function show(Term $term)
    {
        $term->setConnection('mysql_academics');
        $term->load('academicYear');
        return view('academics::terms.show', compact('term'));
    }

    public function edit(Term $term)
    {
        $term->setConnection('mysql_academics');
        $academicYears = \Modules\Academics\Models\AcademicYear::orderBy('start_date', 'desc')->get();
        return view('academics::terms.edit', compact('term', 'academicYears'));
    }

    public function update(Request $request, Term $term)
    {
        $term->setConnection('mysql_academics');
        $validated = $request->validate([
            'academic_year_id' => ['required', 'exists:mysql_academics.academic_years,id'],
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);
        $term->update($validated);
        return redirect()->route('academics.terms.index')->with('success', 'Term updated.');
    }

    public function destroy(Term $term)
    {
        $term->setConnection('mysql_academics');
        $term->delete();
        return redirect()->route('academics.terms.index')->with('success', 'Term deleted.');
    }
}

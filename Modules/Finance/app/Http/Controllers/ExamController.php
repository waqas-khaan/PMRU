<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Modules\Finance\Models\Exam;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Schema::connection('mysql_finance')->hasTable('exams')
            ? Exam::with('term')->orderBy('exam_date', 'desc')->get()
            : collect();

        return view('finance::exams.index', compact('exams'));
    }

    public function create()
    {
        $terms = \Modules\Finance\Models\Term::with('academicYear')->orderBy('start_date', 'desc')->get();
        return view('finance::exams.create', compact('terms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'term_id' => ['required', 'exists:mysql_finance.terms,id'],
            'name' => ['required', 'string', 'max:255'],
            'exam_date' => ['nullable', 'date'],
            'class_name' => ['nullable', 'string', 'max:255'],
            'subject_name' => ['nullable', 'string', 'max:255'],
            'total_marks' => ['nullable', 'numeric', 'min:0'],
        ]);

        Exam::create($validated);

        return redirect()->route('finance.exams.index')->with('success', 'Exam created.');
    }

    public function show(Exam $exam)
    {
        $exam->setConnection('mysql_finance');
        $exam->load('term');
        return view('finance::exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        $exam->setConnection('mysql_finance');
        $terms = \Modules\Finance\Models\Term::with('academicYear')->orderBy('start_date', 'desc')->get();
        return view('finance::exams.edit', compact('exam', 'terms'));
    }

    public function update(Request $request, Exam $exam)
    {
        $exam->setConnection('mysql_finance');

        $validated = $request->validate([
            'term_id' => ['required', 'exists:mysql_finance.terms,id'],
            'name' => ['required', 'string', 'max:255'],
            'exam_date' => ['nullable', 'date'],
            'class_name' => ['nullable', 'string', 'max:255'],
            'subject_name' => ['nullable', 'string', 'max:255'],
            'total_marks' => ['nullable', 'numeric', 'min:0'],
        ]);

        $exam->update($validated);

        return redirect()->route('finance.exams.index')->with('success', 'Exam updated.');
    }

    public function destroy(Exam $exam)
    {
        $exam->setConnection('mysql_finance');
        $exam->delete();
        return redirect()->route('finance.exams.index')->with('success', 'Exam deleted.');
    }
}

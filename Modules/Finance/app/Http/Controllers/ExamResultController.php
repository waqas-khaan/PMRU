<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Modules\Finance\Models\ExamResult;

class ExamResultController extends Controller
{
    public function index()
    {
        $examResults = Schema::connection('mysql_finance')->hasTable('exam_results')
            ? ExamResult::with('exam.term')->orderBy('id', 'desc')->get()
            : collect();

        return view('finance::exam-results.index', compact('examResults'));
    }

    public function create()
    {
        $exams = \Modules\Finance\Models\Exam::with('term')->orderBy('exam_date', 'desc')->get();
        return view('finance::exam-results.create', compact('exams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => ['required', 'exists:mysql_finance.exams,id'],
            'student_id' => ['required', 'integer', 'min:1'],
            'marks' => ['required', 'numeric', 'min:0'],
            'grade' => ['nullable', 'string', 'max:20'],
            'remarks' => ['nullable', 'string'],
        ]);

        ExamResult::create($validated);

        return redirect()->route('finance.exam-results.index')->with('success', 'Exam result recorded.');
    }

    public function show(ExamResult $examResult)
    {
        $examResult->setConnection('mysql_finance');
        $examResult->load('exam.term');
        return view('finance::exam-results.show', compact('examResult'));
    }

    public function edit(ExamResult $examResult)
    {
        $examResult->setConnection('mysql_finance');
        $exams = \Modules\Finance\Models\Exam::with('term')->orderBy('exam_date', 'desc')->get();
        return view('finance::exam-results.edit', compact('examResult', 'exams'));
    }

    public function update(Request $request, ExamResult $examResult)
    {
        $examResult->setConnection('mysql_finance');

        $validated = $request->validate([
            'exam_id' => ['required', 'exists:mysql_finance.exams,id'],
            'student_id' => ['required', 'integer', 'min:1'],
            'marks' => ['required', 'numeric', 'min:0'],
            'grade' => ['nullable', 'string', 'max:20'],
            'remarks' => ['nullable', 'string'],
        ]);

        $examResult->update($validated);

        return redirect()->route('finance.exam-results.index')->with('success', 'Exam result updated.');
    }

    public function destroy(ExamResult $examResult)
    {
        $examResult->setConnection('mysql_finance');
        $examResult->delete();
        return redirect()->route('finance.exam-results.index')->with('success', 'Exam result deleted.');
    }
}

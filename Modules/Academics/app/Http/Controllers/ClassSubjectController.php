<?php

namespace Modules\Academics\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Modules\Academics\Models\ClassSubject;

class ClassSubjectController extends Controller
{
    public function index()
    {
        $classSubjects = Schema::connection('mysql_academics')->hasTable('class_subjects')
            ? ClassSubject::with(['schoolClass', 'subject'])->orderBy('class_id')->orderBy('subject_id')->get()
            : collect();

        return view('academics::class-subjects.index', compact('classSubjects'));
    }

    public function create()
    {
        $schoolClasses = \Modules\Academics\Models\SchoolClass::orderBy('level')->orderBy('name')->get();
        $subjects = \Modules\Academics\Models\Subject::orderBy('name')->get();
        return view('academics::class-subjects.create', compact('schoolClasses', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => ['required', 'exists:mysql_academics.classes,id'],
            'subject_id' => ['required', 'exists:mysql_academics.subjects,id'],
        ]);
        ClassSubject::firstOrCreate(
            ['class_id' => $validated['class_id'], 'subject_id' => $validated['subject_id']],
            $validated
        );
        return redirect()->route('academics.class-subjects.index')->with('success', 'Class-subject link created.');
    }

    public function show(ClassSubject $classSubject)
    {
        $classSubject->setConnection('mysql_academics');
        $classSubject->load(['schoolClass', 'subject']);
        return view('academics::class-subjects.show', compact('classSubject'));
    }

    public function edit(ClassSubject $classSubject)
    {
        $classSubject->setConnection('mysql_academics');
        $schoolClasses = \Modules\Academics\Models\SchoolClass::orderBy('level')->orderBy('name')->get();
        $subjects = \Modules\Academics\Models\Subject::orderBy('name')->get();
        return view('academics::class-subjects.edit', compact('classSubject', 'schoolClasses', 'subjects'));
    }

    public function update(Request $request, ClassSubject $classSubject)
    {
        $classSubject->setConnection('mysql_academics');
        $validated = $request->validate([
            'class_id' => ['required', 'exists:mysql_academics.classes,id'],
            'subject_id' => ['required', 'exists:mysql_academics.subjects,id'],
        ]);
        $classSubject->update($validated);
        return redirect()->route('academics.class-subjects.index')->with('success', 'Class-subject link updated.');
    }

    public function destroy(ClassSubject $classSubject)
    {
        $classSubject->setConnection('mysql_academics');
        $classSubject->delete();
        return redirect()->route('academics.class-subjects.index')->with('success', 'Class-subject link deleted.');
    }
}

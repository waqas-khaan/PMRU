<?php

namespace Modules\Academics\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Modules\Academics\Models\Subject;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Schema::connection('mysql_academics')->hasTable('subjects')
            ? Subject::orderBy('name')->get()
            : collect();

        return view('academics::subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('academics::subjects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50'],
        ]);
        Subject::create($validated);
        return redirect()->route('academics.subjects.index')->with('success', 'Subject created.');
    }

    public function show(Subject $subject)
    {
        $subject->setConnection('mysql_academics');
        return view('academics::subjects.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        $subject->setConnection('mysql_academics');
        return view('academics::subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $subject->setConnection('mysql_academics');
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50'],
        ]);
        $subject->update($validated);
        return redirect()->route('academics.subjects.index')->with('success', 'Subject updated.');
    }

    public function destroy(Subject $subject)
    {
        $subject->setConnection('mysql_academics');
        $subject->delete();
        return redirect()->route('academics.subjects.index')->with('success', 'Subject deleted.');
    }
}

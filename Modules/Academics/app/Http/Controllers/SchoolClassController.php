<?php

namespace Modules\Academics\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Modules\Academics\Models\SchoolClass;

class SchoolClassController extends Controller
{
    public function index()
    {
        $schoolClasses = Schema::connection('mysql_academics')->hasTable('classes')
            ? SchoolClass::orderBy('level')->orderBy('name')->get()
            : collect();

        return view('academics::school-classes.index', compact('schoolClasses'));
    }

    public function create()
    {
        return view('academics::school-classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'level' => ['nullable', 'integer', 'min:0'],
        ]);
        SchoolClass::create($validated);
        return redirect()->route('academics.school-classes.index')->with('success', 'Class created.');
    }

    public function show(SchoolClass $schoolClass)
    {
        $schoolClass->setConnection('mysql_academics');
        $schoolClass->load(['sections', 'subjects']);
        return view('academics::school-classes.show', compact('schoolClass'));
    }

    public function edit(SchoolClass $schoolClass)
    {
        $schoolClass->setConnection('mysql_academics');
        return view('academics::school-classes.edit', compact('schoolClass'));
    }

    public function update(Request $request, SchoolClass $schoolClass)
    {
        $schoolClass->setConnection('mysql_academics');
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'level' => ['nullable', 'integer', 'min:0'],
        ]);
        $schoolClass->update($validated);
        return redirect()->route('academics.school-classes.index')->with('success', 'Class updated.');
    }

    public function destroy(SchoolClass $schoolClass)
    {
        $schoolClass->setConnection('mysql_academics');
        $schoolClass->delete();
        return redirect()->route('academics.school-classes.index')->with('success', 'Class deleted.');
    }
}

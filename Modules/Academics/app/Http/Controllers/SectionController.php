<?php

namespace Modules\Academics\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Modules\Academics\Models\Section;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Schema::connection('mysql_academics')->hasTable('sections')
            ? Section::with('schoolClass')->orderBy('class_id')->orderBy('name')->get()
            : collect();

        return view('academics::sections.index', compact('sections'));
    }

    public function create()
    {
        $schoolClasses = \Modules\Academics\Models\SchoolClass::orderBy('level')->orderBy('name')->get();
        return view('academics::sections.create', compact('schoolClasses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => ['required', 'exists:mysql_academics.classes,id'],
            'name' => ['required', 'string', 'max:255'],
            'capacity' => ['nullable', 'integer', 'min:0'],
        ]);
        Section::create($validated);
        return redirect()->route('academics.sections.index')->with('success', 'Section created.');
    }

    public function show(Section $section)
    {
        $section->setConnection('mysql_academics');
        $section->load('schoolClass');
        return view('academics::sections.show', compact('section'));
    }

    public function edit(Section $section)
    {
        $section->setConnection('mysql_academics');
        $schoolClasses = \Modules\Academics\Models\SchoolClass::orderBy('level')->orderBy('name')->get();
        return view('academics::sections.edit', compact('section', 'schoolClasses'));
    }

    public function update(Request $request, Section $section)
    {
        $section->setConnection('mysql_academics');
        $validated = $request->validate([
            'class_id' => ['required', 'exists:mysql_academics.classes,id'],
            'name' => ['required', 'string', 'max:255'],
            'capacity' => ['nullable', 'integer', 'min:0'],
        ]);
        $section->update($validated);
        return redirect()->route('academics.sections.index')->with('success', 'Section updated.');
    }

    public function destroy(Section $section)
    {
        $section->setConnection('mysql_academics');
        $section->delete();
        return redirect()->route('academics.sections.index')->with('success', 'Section deleted.');
    }
}

<?php

namespace Modules\Students\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Modules\Students\Models\Guardian;
use Modules\Students\Models\Student;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Schema::connection('mysql_students')->hasTable('students') ? Student::orderBy('id')->get() : collect();
        return view('students::index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $guardians = Schema::connection('mysql_students')->hasTable('guardians') ? Guardian::orderBy('id')->get() : collect();
        $schoolClasses = $this->getAcademicsClasses();
        $sections = $this->getAcademicsSections();
        return view('students::create', compact('guardians', 'schoolClasses', 'sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female,other'],
            'address' => ['nullable', 'string'],
            'guardian_id' => ['nullable', Rule::exists(Guardian::class, 'id')],
            'class' => ['nullable', 'string', 'max:50'],
            'section' => ['nullable', 'string', 'max:50'],
            'class_section' => ['nullable', 'string', 'max:255'],
            'enrollment_date' => ['nullable', 'date'],
        ]);

        $columns = Schema::connection('mysql_students')->getColumnListing('students');
        $data = array_intersect_key($validated, array_flip($columns));

        if ($request->filled('class_section') && str_contains($request->class_section, '|')) {
            [$data['class'], $data['section']] = array_pad(explode('|', $request->class_section, 2), 2, null);
        }

        // If table has name (required), use full_name from form
        if (in_array('name', $columns, true) && empty($data['name']) && ! empty($validated['full_name'])) {
            $data['name'] = trim($validated['full_name']);
        }

        // If table has first_name/last_name (required), derive from full_name so insert doesn't fail
        $needsSplit = (in_array('first_name', $columns, true) && ! isset($data['first_name']))
            || (in_array('last_name', $columns, true) && ! isset($data['last_name']));
        if ($needsSplit) {
            $parts = preg_split('/\s+/', trim($validated['full_name'] ?? ''), 2);
            if (in_array('first_name', $columns, true)) {
                $data['first_name'] = $parts[0] ?? '';
            }
            if (in_array('last_name', $columns, true)) {
                $data['last_name'] = $parts[1] ?? '';
            }
        }

        Student::create($data);

        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $student = Student::on('mysql_students')->findOrFail($id);
        return view('students::show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $student = Student::on('mysql_students')->findOrFail($id);
        $guardians = Schema::connection('mysql_students')->hasTable('guardians') ? Guardian::orderBy('id')->get() : collect();
        $schoolClasses = $this->getAcademicsClasses();
        $sections = $this->getAcademicsSections();
        return view('students::edit', compact('student', 'guardians', 'schoolClasses', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $student = Student::on('mysql_students')->findOrFail($id);

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female,other'],
            'address' => ['nullable', 'string'],
            'guardian_id' => ['nullable', Rule::exists(Guardian::class, 'id')],
            'class' => ['nullable', 'string', 'max:50'],
            'section' => ['nullable', 'string', 'max:50'],
            'class_section' => ['nullable', 'string', 'max:255'],
            'enrollment_date' => ['nullable', 'date'],
        ]);

        $columns = Schema::connection('mysql_students')->getColumnListing('students');
        $data = array_intersect_key($validated, array_flip($columns));

        if ($request->filled('class_section') && str_contains($request->class_section, '|')) {
            [$data['class'], $data['section']] = array_pad(explode('|', $request->class_section, 2), 2, null);
        }

        // If table has name (required), use full_name from form
        if (in_array('name', $columns, true) && empty($data['name']) && ! empty($validated['full_name'])) {
            $data['name'] = trim($validated['full_name']);
        }

        $needsSplit = (in_array('first_name', $columns, true) && ! isset($data['first_name']))
            || (in_array('last_name', $columns, true) && ! isset($data['last_name']));
        if ($needsSplit) {
            $parts = preg_split('/\s+/', trim($validated['full_name'] ?? ''), 2);
            if (in_array('first_name', $columns, true)) {
                $data['first_name'] = $parts[0] ?? '';
            }
            if (in_array('last_name', $columns, true)) {
                $data['last_name'] = $parts[1] ?? '';
            }
        }

        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $student = Student::on('mysql_students')->findOrFail($id);
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    /**
     * Get classes from Academics DB (mysql_academics). Returns empty collection if unavailable.
     */
    protected function getAcademicsClasses(): \Illuminate\Support\Collection
    {
        try {
            if (! Schema::connection('mysql_academics')->hasTable('classes')) {
                return collect();
            }
            return \Modules\Academics\Models\SchoolClass::orderBy('level')->orderBy('name')->get();
        } catch (\Throwable $e) {
            return collect();
        }
    }

    /**
     * Get sections (with class) from Academics DB. Returns empty collection if unavailable.
     */
    protected function getAcademicsSections(): \Illuminate\Support\Collection
    {
        try {
            if (! Schema::connection('mysql_academics')->hasTable('sections')) {
                return collect();
            }
            return \Modules\Academics\Models\Section::with('schoolClass')->orderBy('class_id')->orderBy('name')->get();
        } catch (\Throwable $e) {
            return collect();
        }
    }
}

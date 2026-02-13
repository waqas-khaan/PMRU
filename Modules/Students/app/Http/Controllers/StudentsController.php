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
        return view('students::create', compact('guardians'));
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
            'enrollment_date' => ['nullable', 'date'],
        ]);

        $columns = Schema::connection('mysql_students')->getColumnListing('students');
        $data = array_intersect_key($validated, array_flip($columns));

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
        return view('students::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('students::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}

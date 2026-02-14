<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Modules\Finance\Models\FeeStructure;

class FeeStructureController extends Controller
{
    public function index()
    {
        $feeStructures = Schema::connection('mysql_finance')->hasTable('fee_structures')
            ? FeeStructure::with(['term', 'feeType'])->orderBy('id', 'desc')->get()
            : collect();

        return view('finance::fee-structures.index', compact('feeStructures'));
    }

    public function create()
    {
        $terms = \Modules\Finance\Models\Term::with('academicYear')->orderBy('start_date', 'desc')->get();
        $feeTypes = \Modules\Finance\Models\FeeType::orderBy('name')->get();
        return view('finance::fee-structures.create', compact('terms', 'feeTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'term_id' => ['required', 'exists:mysql_finance.terms,id'],
            'fee_type_id' => ['required', 'exists:mysql_finance.fee_types,id'],
            'class_name' => ['nullable', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'due_date' => ['nullable', 'date'],
        ]);

        FeeStructure::create($validated);

        return redirect()->route('finance.fee-structures.index')->with('success', 'Fee structure created.');
    }

    public function show(FeeStructure $feeStructure)
    {
        $feeStructure->setConnection('mysql_finance');
        $feeStructure->load(['term', 'feeType']);
        return view('finance::fee-structures.show', compact('feeStructure'));
    }

    public function edit(FeeStructure $feeStructure)
    {
        $feeStructure->setConnection('mysql_finance');
        $terms = \Modules\Finance\Models\Term::with('academicYear')->orderBy('start_date', 'desc')->get();
        $feeTypes = \Modules\Finance\Models\FeeType::orderBy('name')->get();
        return view('finance::fee-structures.edit', compact('feeStructure', 'terms', 'feeTypes'));
    }

    public function update(Request $request, FeeStructure $feeStructure)
    {
        $feeStructure->setConnection('mysql_finance');

        $validated = $request->validate([
            'term_id' => ['required', 'exists:mysql_finance.terms,id'],
            'fee_type_id' => ['required', 'exists:mysql_finance.fee_types,id'],
            'class_name' => ['nullable', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'due_date' => ['nullable', 'date'],
        ]);

        $feeStructure->update($validated);

        return redirect()->route('finance.fee-structures.index')->with('success', 'Fee structure updated.');
    }

    public function destroy(FeeStructure $feeStructure)
    {
        $feeStructure->setConnection('mysql_finance');
        $feeStructure->delete();
        return redirect()->route('finance.fee-structures.index')->with('success', 'Fee structure deleted.');
    }
}

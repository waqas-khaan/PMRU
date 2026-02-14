<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Modules\Finance\Models\FeeType;

class FeeTypeController extends Controller
{
    public function index()
    {
        $feeTypes = Schema::connection('mysql_finance')->hasTable('fee_types')
            ? FeeType::orderBy('name')->get()
            : collect();

        return view('finance::fee-types.index', compact('feeTypes'));
    }

    public function create()
    {
        return view('finance::fee-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
        ]);

        FeeType::create($validated);

        return redirect()->route('finance.fee-types.index')->with('success', 'Fee type created.');
    }

    public function show(FeeType $feeType)
    {
        $feeType->setConnection('mysql_finance');
        return view('finance::fee-types.show', compact('feeType'));
    }

    public function edit(FeeType $feeType)
    {
        $feeType->setConnection('mysql_finance');
        return view('finance::fee-types.edit', compact('feeType'));
    }

    public function update(Request $request, FeeType $feeType)
    {
        $feeType->setConnection('mysql_finance');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
        ]);

        $feeType->update($validated);

        return redirect()->route('finance.fee-types.index')->with('success', 'Fee type updated.');
    }

    public function destroy(FeeType $feeType)
    {
        $feeType->setConnection('mysql_finance');
        $feeType->delete();
        return redirect()->route('finance.fee-types.index')->with('success', 'Fee type deleted.');
    }
}

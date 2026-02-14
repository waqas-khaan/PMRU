<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Modules\Finance\Models\FeePayment;

class FeePaymentController extends Controller
{
    public function index()
    {
        $feePayments = Schema::connection('mysql_finance')->hasTable('fee_payments')
            ? FeePayment::with('feeStructure.feeType', 'feeStructure.term')->orderBy('paid_at', 'desc')->get()
            : collect();

        return view('finance::fee-payments.index', compact('feePayments'));
    }

    public function create()
    {
        $feeStructures = \Modules\Finance\Models\FeeStructure::with(['term', 'feeType'])->orderBy('id', 'desc')->get();
        return view('finance::fee-payments.create', compact('feeStructures'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'integer', 'min:1'],
            'fee_structure_id' => ['required', 'exists:mysql_finance.fee_structures,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'paid_at' => ['required', 'date'],
            'payment_method' => ['nullable', 'string', 'max:100'],
            'reference' => ['nullable', 'string', 'max:255'],
            'remarks' => ['nullable', 'string'],
        ]);

        FeePayment::create($validated);

        return redirect()->route('finance.fee-payments.index')->with('success', 'Fee payment recorded.');
    }

    public function show(FeePayment $feePayment)
    {
        $feePayment->setConnection('mysql_finance');
        $feePayment->load('feeStructure.feeType', 'feeStructure.term');
        return view('finance::fee-payments.show', compact('feePayment'));
    }

    public function edit(FeePayment $feePayment)
    {
        $feePayment->setConnection('mysql_finance');
        $feeStructures = \Modules\Finance\Models\FeeStructure::with(['term', 'feeType'])->orderBy('id', 'desc')->get();
        return view('finance::fee-payments.edit', compact('feePayment', 'feeStructures'));
    }

    public function update(Request $request, FeePayment $feePayment)
    {
        $feePayment->setConnection('mysql_finance');

        $validated = $request->validate([
            'student_id' => ['required', 'integer', 'min:1'],
            'fee_structure_id' => ['required', 'exists:mysql_finance.fee_structures,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'paid_at' => ['required', 'date'],
            'payment_method' => ['nullable', 'string', 'max:100'],
            'reference' => ['nullable', 'string', 'max:255'],
            'remarks' => ['nullable', 'string'],
        ]);

        $feePayment->update($validated);

        return redirect()->route('finance.fee-payments.index')->with('success', 'Fee payment updated.');
    }

    public function destroy(FeePayment $feePayment)
    {
        $feePayment->setConnection('mysql_finance');
        $feePayment->delete();
        return redirect()->route('finance.fee-payments.index')->with('success', 'Fee payment deleted.');
    }
}

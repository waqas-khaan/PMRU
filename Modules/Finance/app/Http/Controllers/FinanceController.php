<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

class FinanceController extends Controller
{
    public function index()
    {
        $hasFinanceDb = false;
        try {
            $hasFinanceDb = Schema::connection('mysql_finance')->hasTable('fee_types');
        } catch (\Throwable $e) {
            // Connection or table missing
        }

        return view('finance::index', compact('hasFinanceDb'));
    }
}

<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

class FinanceController extends Controller
{
    public function index()
    {
        $hasFinanceDb = Schema::connection('mysql_finance')->hasTable('academic_years');

        return view('finance::index', compact('hasFinanceDb'));
    }
}

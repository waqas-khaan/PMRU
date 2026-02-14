<?php

namespace Modules\Academics\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

class AcademicsController extends Controller
{
    public function index()
    {
        $hasAcademicsDb = Schema::connection('mysql_academics')->hasTable('academic_years');

        return view('academics::index', compact('hasAcademicsDb'));
    }
}

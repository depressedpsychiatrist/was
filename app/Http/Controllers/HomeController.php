<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\EmploymentStatus;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function initialize()
    {
        $departments = Department::all();
        $employmentStatuses = EmploymentStatus::all();

        return response()->json([
            'departments' => $departments,
            'employmentStatuses' => $employmentStatuses,
        ]);
    }
}

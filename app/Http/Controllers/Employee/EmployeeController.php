<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeReqeust;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    private $mEmployee;
    public function __construct(Employee $employee)
    {
        $this->mEmployee = $employee;
    }
    public function index(Request $request)
    {
        if ($request->has('id_number') && $request->get('id_number')) {

            $employees = Employee::where('id_number', $request->input('id_number'))->paginate(1);
            return response()->json($employees);
        }

        if ($request->has('email') && $request->get('email')) {
            $employees = Employee::where('email', 'LIKE', '%' . $request->input('email') . '%')->paginate(1);
            return response()->json($employees);
        }


        if (($request->has('name') && $request->get('name')) || ($request->has('department_id') && $request->get('department_id')) || ($request->has('employment_status_id') && $request->get('employment_status_id'))) {
            $employees = $this->mEmployee;

            if ($request->has('name') && $request->get('name')) {
                $employees = Employee::where('name', 'LIKE', '%' . $request->input('name') . '%');
            }
            if ($request->has('department_id') && $request->get('department_id')) {
                $employees = $employees->where('department_id', $request->input('department_id'));
            }
            if ($request->has('employment_status_id') && $request->get('employment_status_id')) {
                $employees = $employees->where('employment_status_id', $request->input('employment_status_id'));
            }
            return response()->json($employees->paginate(10), 200);
        }

        $employees = Employee::paginate(10);
        return response()->json($employees);
    }

    public function create(EmployeeReqeust $request)
    {
        $employee_data = $request->validated();
        $documentation_path = request()->file('documentation')->store('public/documentation');
        $employee_data['documentation'] = basename($documentation_path);
        $employee = Employee::create($employee_data);
        return response()->json($employee, 200);
    }
}

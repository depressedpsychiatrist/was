<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeReqeust extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'id_number' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees',
            'department_id' => 'required|exists:departments,id',
            'employment_status_id' => 'required|exists:employment_statuses,id',
        ];
    }
}

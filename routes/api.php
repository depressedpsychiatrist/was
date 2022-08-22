<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('initialize', 'HomeController@initialize')->name('initialize');
Route::post('auth/login', 'AuthController@login')->name('auth.login');
Route::post('auth/register', 'AuthController@register')->name('auth.register');
Route::get('auth/logout', 'AuthController@logout')->name('auth.logout');

Route::get('employees', 'Employee\EmployeeController@index')->name('employees.index');
Route::post('employee', 'Employee\EmployeeController@create')->name('employee.create');

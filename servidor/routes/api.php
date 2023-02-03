<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\AsignaturaController;

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


Route::controller(AuthController::class)
    ->prefix('auth')
    ->group(function () {
    Route::post('login', 'login');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::controller(UserController::class)
    ->prefix('user')
    ->group(function () {
    Route::get('', 'index');
    Route::post('register', 'register');
    Route::post('update/{id}', 'update');
});

Route::controller(EstudianteController::class)
    ->prefix('estudiante')
    ->group(function () {
    Route::get('', 'index');
    Route::post('register', 'register');
    Route::post('update/{id}', 'update');
    Route::post('course/assign', 'assignCourse');
});

Route::controller(ProfesorController::class)
    ->prefix('profesor')
    ->group(function () {
    Route::get('', 'index');
    Route::post('register', 'register');
    Route::post('course/assign', 'assignCourse');
});

Route::controller(AsignaturaController::class)
    ->prefix('asignatura')
    ->group(function () {
    Route::get('', 'index');
    Route::get('areas', 'showAreas');
    Route::post('register', 'register');
    Route::post('update/{id}', 'update');
});
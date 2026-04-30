<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\HospitalisationController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchController;


Route::get('/', function () {return view('welcome');});
Route::resource('medecins', MedecinController::class);
Route::resource('hospitalisations', HospitalisationController::class);
Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
Route::resource('prescriptions', PrescriptionController::class);
Route::patch('/hospitalisations/{id}/sortir', [HospitalisationController::class, 'sortir'])->name('hospitalisations.sortir');
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/search', [SearchController::class, 'query'])->name('search');
<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\ParameterController;

Route::get('/parameters', [ParameterController::class, 'index']);
Route::post('/parameters/{id}/upload-images', [ParameterController::class, 'uploadImages'])->name('parameters.upload-images');
Route::delete('/parameters/image/{id}', [ParameterController::class, 'deleteImage'])->name('parameters.delete-image');
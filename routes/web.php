<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', [TaskController::class,'index'])->name('task');


Route::post('category/store', [CategoryController::class,'store'])->name('category.store');

Route::post('task/store', [TaskController::class,'store'])->name('task.store');

Route::post('task/setstage',[TaskController::class,'setStage'])->name('task.setstage');

Route::get('task/category',[TaskController::class,'index'])->name('task.category');

Route::delete('task/{id}', [TaskController::class,'destroy'])->name('task.destroy')->where('id', '[0-9]+');;


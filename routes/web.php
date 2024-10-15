<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/home', [TodoController::class, "index"])->name('get.data');
Route::post('/home', [TodoController::class, 'insert'])->name('upload.data');
Route::delete('/home/{todo}', [TodoController::class, 'delete'])->name('delete.data');
Route::put('/home/{todo}', [TodoController::class, 'update'])->name('update.data');
Route::patch('/home/{todo}', [TodoController::class, 'checklist'])->name('checklist.data');

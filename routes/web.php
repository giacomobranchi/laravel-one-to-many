<?php

use App\Http\Controllers\Admin\ProjectsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Models\Project;
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

Route::get('/', function () {
    $projects = Project::all();
    return view('welcome', compact('projects'));
});

/* Route::get('/dashboard', function () {s
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); */
Route::middleware('auth', 'verified')->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('projects/restore/{id}', [ProjectsController::class, 'restore'])->name('projects.restore');
    Route::get('projects/forceDelete/{id}', [ProjectsController::class, 'forceDelete'])->name('projects.forceDelete');
    Route::get('projects/recycle', [ProjectsController::class, 'recycle'])->name('projects.recycle');
    Route::get('projects/recycle/{id}', [ProjectsController::class, 'showTrashed'])->name('projects.showTrashed');
    Route::resource('projects', ProjectsController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

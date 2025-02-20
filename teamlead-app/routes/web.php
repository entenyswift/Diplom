<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use Spatie\Permission\Middleware\RoleMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/users/{user}', [ProfileController::class, 'showUser'])->name('users.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/users/{user}/update-role', [AdminController::class, 'updateUserRole'])->name('admin.users.update-role');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
});

Route::middleware(['auth', RoleMiddleware::class . ':teamlead|admin'])->group(function () {
    Route::resource('teams', TeamController::class);
    Route::resource('projects', ProjectController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::resource('tasks', TaskController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/tasks/{task}/update-status', [DashboardController::class, 'updateStatus'])->name('tasks.update-status');
});

Route::middleware(['auth', RoleMiddleware::class . ':teamlead|admin'])->group(function () {
    Route::resource('teams', TeamController::class);
    Route::get('/teams/{team}/edit', [TeamController::class, 'edit'])->name('teams.edit');
    Route::get('/teams/{team}/delete', [TeamController::class, 'destroy'])->name('teams.confirm-delete');
    Route::post('/teams/{team}/add-member', [TeamController::class, 'addMember'])->name('teams.add-member');
    Route::post('/teams/{team}/remove-member', [TeamController::class, 'removeMember'])->name('teams.remove-member');
    Route::patch('/teams/{team}/update', [TeamController::class, 'update'])->name('teams.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::resource('teams', TeamController::class);
    Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
});



require __DIR__.'/auth.php';

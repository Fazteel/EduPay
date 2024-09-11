<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    // Transaction management routes
    Route::get('/dashboard', [TransactionController::class, 'indexHome'])->name('dashboard');
    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');
    Route::post('/transaction/{student}', [TransactionController::class, 'store'])->name('transaction.store');
    Route::get('/report', [TransactionController::class, 'indexReport'])->name('report');
    Route::get('/report/export', [TransactionController::class, 'export'])->name('report.export');
    
    // Student management routes
    Route::get('/students', [StudentController::class, 'index'])->name('students');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::get('import-students', [StudentController::class, 'showImportForm'])->name('student.import-form');
    Route::post('import-students', [StudentController::class, 'import'])->name('student.import');
    
    // Profile management routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.updatePhoto');
    Route::post('/profile/remove-photo', [ProfileController::class, 'removeProfilePhoto'])->name('profile.remove-photo');
});


// Route::prefix('student')->group(function () {
//     Route::get('login', [StudentController::class, 'showLoginForm'])->name('student.login');
//     Route::post('login', [StudentController::class, 'login']);
//     Route::post('logout', [StudentController::class, 'logout'])->name('student.logout');
    
//     Route::middleware('auth:student')->group(function () {
//         Route::get('/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
//     });
// });

require __DIR__.'/auth.php';

require __DIR__.'/student-auth.php';

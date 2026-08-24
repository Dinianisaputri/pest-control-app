<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrapController;
use App\Http\Controllers\EntryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\LandingController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return app(LandingController::class)->index();
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/foto/{path}', function (string $path) {
    $disk = Storage::disk('public');

    abort_unless($disk->exists($path), 404);

    return response()->file($disk->path($path));
})->where('path', '.*')->middleware('auth')->name('photo.file');

Route::middleware('auth')->group(function () {
    Route::get('/traps', [TrapController::class, 'index'])->name('traps.index');
    Route::get('/input', [EntryController::class, 'create'])->name('entries.create');
    Route::post('/input', [EntryController::class, 'store'])->name('entries.store');
    Route::get('/export', [EntryController::class, 'export'])->name('entries.export');
    Route::get('/riwayat', [EntryController::class, 'riwayat'])->name('entries.riwayat');
});

// Route khusus admin — cuma bisa diakses kalau role = admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/traps/create', [TrapController::class, 'create'])->name('traps.create');
    Route::post('/traps', [TrapController::class, 'store'])->name('traps.store');
    Route::get('/traps/{trap}/edit', [TrapController::class, 'edit'])->name('traps.edit');
    Route::put('/traps/{trap}', [TrapController::class, 'update'])->name('traps.update');
    Route::delete('/traps/{trap}', [TrapController::class, 'destroy'])->name('traps.destroy');
});

require __DIR__.'/auth.php';

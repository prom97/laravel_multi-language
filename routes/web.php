<?php

use App\Http\Middleware\Localization;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocalizationController;


Route::get('/localization/{locale}', LocalizationController::class)->name('localization');

/**
 * Las siguientes lineas utilizan el middleware de localization para mostrar la vista acorde al idioma seleccionado en la url (en/es)
 */
Route::middleware(Localization::class)->group(function(){
    
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
    require __DIR__.'/auth.php';
});

// Route::get('/welcome/{locale}', function (string $locale) {
//     if (! in_array($locale, ['en', 'es'])) {
//         abort(400);
//     }
 
//     App::setLocale($locale);
 
//     return view ('welcome');
// });




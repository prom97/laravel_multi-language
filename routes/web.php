<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Localization;

/**
 * La siguiente ruta agrega (redirige) a la vista en ingles, ya que por defecto la pag principal (http://127.0.0.1:8000) tira error 404
 */
Route::get('/',function(){
    return redirect(app()->getLocale()); // toma la variable de idioma configurada en config/app.php
});

/**
 * Las siguientes lineas utilizan el middleware de localization para mostrar la vista acorde al idioma seleccionado en la url (en/es)
 */
Route::prefix('{locale}')->middleware(Localization::class)->group(function(){
    
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




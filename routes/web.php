<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// rotte per l'autenticazione create automaticamente da --auth
Auth::routes();


// Route::get('/home', 'HomeController@index')->name('home');


// controlla che l'accesso avvenga solo attraverso utenti loggati, passa attraverso middleware
Route::middleware('auth')
    ->namespace('Admin')
    ->name('admin.') // inizio nome della rotta
    ->prefix('admin') // oppure prefisso admin, l'uri della nostra rotta
    ->group(function () {
        Route::get('/', 'HomeController@index')->name('home');
    });

// ultima possibilità da inserire alla fine, rotta di fallback, intercetta tutte le rotte non specificate precedentemente
Route::get('{any?}', function(){
    return view('guest.home');
})->where('any', '.*');

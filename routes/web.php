<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('account', 'AccountController@show')->middleware('auth')->name('account');
Route::post('account/{id}', 'AccountController@update')->middleware('auth')->name('account.update');
Route::post('/account', 'AccountController@destroyAvatar')->middleware('auth')->name('account.destroyAvatar');
Route::get('/account/{id}', 'AccountController@destroy')->middleware('auth')->name('account.destroy');


Route::get('/profil/{slug}', 'ProfilController@index')->name('profil');
Route::post('profil/{id}', 'ProfilController@updateAvatar')->middleware('auth')->name('profil.updateAvatar');

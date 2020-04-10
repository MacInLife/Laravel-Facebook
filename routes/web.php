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

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/search', 'SearchController@index')->name('search');
//Route de vision de la page de fil d'actualité
Route::get('/home', 'PostController@index')->name('home');
//Route de la méthode publier un commentaire (création)
Route::post('/home', 'PostController@create')->middleware('auth')->name('create.post');
//Route de la méthode delete un post (suppression)
Route::get('/home/{id}', 'PostController@destroy')->middleware('auth')->name('destroy.post');
Route::get('/home/{id}/like', 'PostController@like')->name('post.like');
Route::get('/home/{id}/unlike', 'PostController@unlike')->name('post.unlike');

Route::get('account', 'AccountController@show')->middleware('auth')->name('account');
Route::post('account/{id}', 'AccountController@update')->middleware('auth')->name('account.update');
Route::post('/account', 'AccountController@destroyAvatar')->middleware('auth')->name('account.destroyAvatar');
Route::get('/account/{id}', 'AccountController@destroy')->middleware('auth')->name('account.destroy');


Route::get('/profil/{slug}', 'ProfilController@index')->name('profil');
Route::post('profil/{slug}', 'ProfilController@updateAvatar')->middleware('auth')->name('profil.updateAvatar');
Route::post('profil', 'ProfilController@updateCover')->middleware('auth')->name('profil.updateCover');
Route::get('/profil/{slug}/amis_add', 'ProfilController@amis_add')->name('profil.amisAdd');
Route::get('/profil/{slug}/amis_invit', 'ProfilController@amis_invit')->name('profil.amisInvit');
Route::get('/profil/{slug}/amis_delete', 'ProfilController@amis_delete')->name('profil.amisDelete');

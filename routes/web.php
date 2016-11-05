<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use app\Helpers\PoringaDownloader;
use Illuminate\Support\Facades\Storage;

Route::get('/', 'GalleryController@show');
Route::get('/{id}', 'GalleryController@show');

Route::get('/poringa','DownloadsController@poringa');
Route::get('/rusas','DownloadsController@rusas');


Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/minor', 'HomeController@minor')->name("minor");
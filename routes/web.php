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

Route::get('/', function () {
    return view('home');
})->name('default');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::prefix('admin')->group(function () {
    
// });
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/beranda', 'PostController@index')->name('beranda');
    Route::get('/get-kota', 'PostController@getKota')->name('ajax.get-kota');
    Route::get('/getCourseUser', 'PostController@getCourseUser')->name('ajax.getCourseUser');
    Route::get('/get-bidang', 'PostController@getBidang')->name('ajax.get-bidang');
    Route::get('/get-categories', 'PostController@getCategories')->name('ajax.get-categories');
    Route::get('/getDetailCourse', 'PostController@getDetailCourse')->name('ajax.getDetailCourse');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/index/{user}', 'ProfileController@index')->name('index');
        Route::get('/edit/{user}', 'ProfileController@edit')->name('edit');
        Route::get('/editPreferences/{user}', 'ProfileController@editPreferences')->name('editPreferences');
        Route::PUT('/update/{user}', 'ProfileController@update')->name('update');
        Route::PUT('/updatePreferences/{user}', 'ProfileController@updatePreferences')->name('updatePreferences');
    });

    Route::prefix('posts')->name('post.')->group(function(){
        Route::get('/create', 'PostController@create')->name('create');
        Route::get('/edit/{post}', 'PostController@edit')->name('edit');
        Route::get('/delete/{post}', 'PostController@delete')->name('delete');
        Route::get('/show/{post}', 'PostController@show')->name('show');
        Route::get('/search', 'PostController@search')->name('search');
        Route::post('/store', 'PostController@store')->name('store');
        Route::PUT('/update/{post}', 'PostController@update')->name('update');
    });
    
    Route::prefix('tutor')->name('tutor.')->group(function(){
        Route::post('/store', 'TutoringController@storeTutorSession')->name('store');
        Route::get('/detail/{session}', 'TutoringController@show')->name('detail');
        Route::post('/joinSession', 'TutoringController@joinSession')->name('joinSession');
        Route::get('/manage-tutor', 'TutoringController@manageTutorSession')->name('manage');
    });
});

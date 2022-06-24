<?php

use App\Helpers\Sonamak;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\InquiryController;
use App\Models\Tour;
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

Auth::routes();

Route::get('/',function(){
    return view('welcome');
});
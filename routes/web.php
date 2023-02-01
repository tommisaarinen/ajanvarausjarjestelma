<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Timetable;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;

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
})->name('home');

Route::get('/home', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('home');
})->name('login');

Route::get('/index', function () {
    return view('home');
});

Route::get('/ajanvaraus', function () {
    return view('home');
});

Route::any('/timetables', [Timetable::class, 'getTimetables']);

Route::any('/newreservation', [ReservationController::class, 'newReservation_start']);

Route::any('/makereservation', [ReservationController::class, 'newReservation_make']);

Route::any('/login', [LoginController::class, 'authenticate']);

Route::any('/dashboard', [LoginController::class, 'gotoDashboard']);

Route::post('/cancelreservation', [LoginController::class, 'cancelReservation']);

Route::any('/logout', [LoginController::class, 'logout']);

Route::get('/admin/login', function () {
    return view('adminlogin');
})->name('adminlogin');

Route::any('/admin/auth', [AdminController::class, 'adminLogin']);

Route::group(['middleware' => ['auth:admin']], function () {
    Route::get('admin/adminpanel', [AdminController::class, 'adminpanel'])->name('adminpanel');
    Route::post('/admin/rmrsrv', [AdminController::class, 'deleteReservation']);
    Route::post('/admin/updatereservation', [AdminController::class, 'updateReservation']);
    Route::post('/admin/rmcustomer', [AdminController::class, 'deleteCustomer']);
    Route::any('/admin/createlocation', [AdminController::class, 'locationCreator']);
    Route::get('/admin/editlocation', [AdminController::class, 'locationEditor']);
    Route::post('/admin/lcthandle', [AdminController::class, 'locationFormHandle']);
    Route::get('/admin/createservice', function () {
        return view('createservice');
    });
    Route::post('/admin/srvchandle', [AdminController::class, 'serviceFormHandle']);
    Route::any('/admin/editservice', [AdminController::class, 'serviceEditor']);
    Route::any('/admin/editcustomer', [AdminController::class, 'customerEditor']);
    Route::post('/admin/updatecustomer', [AdminController::class, 'updateCustomer']);
    Route::post('/admin/rmsrvc', [AdminController::class, 'deleteService']);
    Route::any('/admin/rmexpired', [AdminController::class, 'deleteExpired']);
    Route::any('/admin/createreservation', function () {
        return view('createreservation');
    });
    Route::post('/admin/rmlocation', [AdminController::class, 'deleteLocation']);
    Route::any('/admin/createadmin', function () {
        return view('createadmin');
    });
    Route::post('/admin/newadmin', [AdminController::class, 'createAdmin']);
    Route::post('/admin/rmadmin', [AdminController::class, 'deleteAdmin']);
    Route::get('/admin/editadmin', [AdminController::class, 'adminEditor']);
    Route::post('/admin/updateadmin', [AdminController::class, 'changePassword']);
});

Route::get('/admin/adminpanel{any}', function () {
    return view('adminpanel');
  })->where('any', '/*');

Route::any('/admin/logout', [AdminController::class, 'logout']);


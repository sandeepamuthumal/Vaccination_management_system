<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VaccineController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
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
    return view('welcome');
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/admin/login', 'login')->name('admin_login');
    Route::get('/admin/register', 'Register')->name('admin_register');
    Route::get('/admin/dashboard', 'Dashboard')->name('admin_dashboard');
    Route::post('/admin/register', 'RegisterProcess')->name('registration');
    Route::post('/login/process', 'LoginProcess')->name('login');
    Route::get('/admin/logout', 'AdminLogout')->name('admin_logout');
    Route::get('/user/register', 'UserRegister')->name('user_register');
    Route::post('/user/registration', 'UserRegisterProcess')->name('user_registration');
    Route::get('/user/logout', 'UserLogout')->name('user_logout');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('/center/schedule', 'index');
    Route::get('/contact/to', 'contact');
    Route::get('/locate', 'locate');
});


Route::middleware(['isAdminLoggedIn'])->group(function () {

    Route::controller(LoginController::class)->group(function () {
        Route::get('/admin/dashboard', 'Dashboard')->name('admin_dashboard');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')->name('users');
        Route::post('/users/show', 'showusers');
        Route::post('/user/store', 'StoreNewUser');
        Route::get('/user/edit', 'edit');
        Route::post('/user/update', 'Update');
        Route::post('/user/delete/{id}', 'delete')->name('delete_users');
        Route::get('/user/reservations', 'reservations')->name('user_reservations');
        Route::get('/user/feedbacks', 'feedbacks')->name('user_feedbacks');
        Route::get('/reservation/complete/{id}', 'reservationComplete');
    });

    Route::controller(VaccineController::class)->group(function () {
        Route::get('/vaccines', 'index')->name('vaccines');
        Route::post('/vaccines/show', 'showvaccines');
        Route::post('/vaccine/store', 'StoreNewVaccine');
        Route::get('/vaccine/edit', 'VaccineEdit');
        Route::post('/vaccine/update', 'VaccineUpdate');
        Route::post('/vaccine/delete/{id}', 'VaccineDelete')->name('delete_vaccines');

        //centers
        Route::get('/centers', 'centers')->name('centers');
        Route::post('/center/show', 'showCenters');
        Route::post('/center/store', 'StoreNewCenter');
        Route::get('/center/edit', 'CenterEdit');
        Route::post('/center/update', 'CenterUpdate');
        Route::post('/center/delete/{id}', 'CenterDelete')->name('delete_centers');

        //centers has vaccines
        Route::get('/centers/vaccines', 'centerVaccine')->name('center_vaccines');
        Route::post('/centers/vaccines/show', 'showVaccineCenters');
        Route::post('/centers/vaccines/store', 'StoreNewVaccineCenter');
        Route::get('/centers/vaccines/edit', 'CenterVaccineEdit');
        Route::post('/centers/vaccines/update', 'CenterVaccineUpdate');
        Route::post('/centers/vaccines/delete/{id}', 'CenterVaccineDelete')->name('delete_center_vaccine');
    });
});


Route::middleware(['isUserLoggedIn'])->group(function () {

    Route::controller(ReservationController::class)->group(function () {
        Route::get('/user/dashboard', 'index')->name('user_dashboard');
        Route::get('/schedules', 'schedules')->name('schedules');
        Route::get('/reservation/add', 'addReservation');
        Route::post('/reservation/store', 'storeReservation');
        Route::get('/reservations', 'Reservation')->name('reservations');
        Route::post('/reservations/load', 'LoadReservation');
        Route::post('/reservation/delete/{id}', 'DeleteReservation')->name('delete_reservation');
        Route::get('/reservation/edit', 'EditReservation');
        Route::post('/reservation/update', 'UpdateReservation');
        Route::get('/reservation/verify/{id}', 'VerifyReservation');
        Route::get('/feedbacks', 'feedback')->name('feedbacks');
        Route::post('/feedback/submit', 'SubmitFeedback')->name('submit_feedback');
    });
    
});



Route::get('clear_cache', function () {
    \Artisan::call('config:cache');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
});

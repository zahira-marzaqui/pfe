<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\MyDartController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
    Route::get('/', function() {
        return view('index');
    })->name('index');

     //AUTHENTIFICATION
    Route::get('/login', [AuthController::class, 'login'])->name('user.login');
    Route::post('/login', [AuthController::class, 'loginStore'])->name('user.login.store');
    Route::post('/register', [AuthController::class, 'RegisterStore'])->name('user.register.store');
    Route::get('/inscription', [AuthController::class, 'register'])->name('user.register');
    Route::get('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');




     //USER
    Route::middleware(['auth', 'user-access:user'])->group(function () {

        Route::group(['prefix' => 'Interface-Utilisateur'], function() {

            //Offre
            Route::get('Offers/index',[OfferController::class, 'UserOffer'])->name('user.offer.index');
            Route::get('Offers/create',[OfferController::class, 'create'])->name('user.offer.crate');
            Route::post('Offers/store',[OfferController::class, 'store'])->name('user.offer.store');
            Route::get('Offers/show/{id}', [OfferController::class, 'show'])->name('user.offer.detaills');

            //My Dart
            Route::get('MyDart/index', [MyDartController::class, 'index'])->name('user.mydart.index');
            Route::get('MyDart/paiement', [MyDartController::class, 'PaiementIndex'])->name('user.mydart.paiement');
        });
    });


    //ADMIN
    Route::middleware(['auth', 'user-access:admin'])->group(function () {

        Route::group(['prefix' => 'Interface-Admin'], function() {

           Route::get('dashboard', function () {
               return view('Admin.dashboard.cards');

           })->name('admin.dashboard');
            Route::get('Offers/index',[OfferController::class, 'AdminOffer'])->name('admin.offer.index');
            Route::get('Offers/create',[OfferController::class, 'create'])->name('admin.offer.create');
            Route::post('Offers/store',[OfferController::class, 'store'])->name('admin.offer.store');
            // Route::get('edit/{id}',[OfferController::class, 'edit'])->name('admin.offer.edit');
            // Route::put('edit/{id}', [OfferController::class, 'update'])->name('admin.offer.update');
            Route::delete('destroy/{id}', [OfferController::class, 'destroy'])->name('admin.offer.destroy');

         });

    });

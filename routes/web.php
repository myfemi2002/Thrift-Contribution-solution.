<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SmtpController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RolesController;

use App\Http\Controllers\DepositController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GroupNameController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AdminWalletController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\AdminDepositController;
use App\Http\Controllers\SystemSettingController;
use App\Http\Controllers\RoleWithPermissionController;

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


    Route::controller(App\Http\Controllers\IndexController::class)->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/properties/{slug}', 'show')->name('properties.show');
    });





    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->middleware(['auth', 'verified'])->name('dashboard');

    // Route::middleware('auth')->group(function () {
    //     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // });

    require __DIR__.'/auth.php';


    Route::middleware(['auth','roles:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/logout', [AdminController::class, 'adminDestroy'])->name('admin.logout');
        Route::get('/profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
        Route::post('/profile/store', [AdminController::class, 'adminProfileStore'])->name('admin.profile.store');
        Route::get('/change/password', [AdminController::class, 'adminChangePassword'])->name('admin.change.password');
        Route::post('/update/password', [AdminController::class, 'adminUpdatePassword'])->name('update.password');  
    });


    // All Admin Routes Middleware Starts Here
    Route::middleware(['auth', 'roles:admin'])->group(function () {

        Route::prefix('users')->controller(CustomerController::class)->group(function () {
            Route::get('/', 'index')->name('admin.users.index');
            Route::post('/store', 'store')->name('admin.users.store');
            Route::post('/update/{id}', 'update')->name('admin.users.update');
            Route::get('/delete/{id}', 'destroy')->name('admin.users.delete');
            Route::get('/toggle-status/{id}', 'toggleStatus')->name('admin.users.toggle-status');
            Route::get('/view/{id}', 'show')->name('admin.users.view');
            Route::get('/edit/{id}', 'edit')->name('admin.users.edit');
            
        });
        


    // Route::prefix('admin-deposits')->controller(AdminDepositController::class)->group(function () {
    //     Route::get('/', 'index')->name('admin.deposits.index');
    //     Route::get('/show/{id}', 'show')->name('admin.deposits.show');
        
    //     // Confirmation pages (GET routes)
    //     Route::get('/confirm-approve/{id}', 'confirmApprove')->name('admin.deposits.confirm-approve');
    //     Route::get('/confirm-reject/{id}', 'confirmReject')->name('admin.deposits.confirm-reject');
    //     Route::get('/confirm-verify/{id}', 'confirmVerify')->name('admin.deposits.confirm-verify');
        
    //     // Action routes (POST routes)
    //     Route::post('/approve/{id}', 'approve')->name('admin.deposits.approve');
    //     Route::post('/reject/{id}', 'reject')->name('admin.deposits.reject');
    //     Route::post('/verify-blockchain/{id}', 'verifyFromBlockchain')->name('admin.deposits.verify-blockchain');

    //     // Admin Deposit Appeals Routes
    //     Route::get('/appeals', 'appeals')->name('admin.deposits.appeals');
    //     Route::get('/appeals-show/{id}', 'showAppeal')->name('admin.deposits.appeals.show');
    //     Route::post('/appeals-approve/{id}', 'approveAppeal')->name('admin.deposits.appeals.approve');
    //     Route::post('/appeals-reject/{id}', 'rejectAppeal')->name('admin.deposits.appeals.reject');

    //     // Admin Transaction routes
    //     Route::get('/deposits/transaction-logs',  'transactionLogs')->name('admin.deposits.transaction-logs');
    // });

           


        // GroupName Management
        Route::prefix('groupname')->controller(GroupNameController::class)->group(function () {
            Route::get('/view', 'groupnameView')->name('groupname.view')->middleware('auth', 'permission:groupname.view');
            Route::post('/store', 'groupnameStore')->name('groupname.store');        
            Route::post('/update/{id}', 'groupnameUpdate')->name('groupname.update');
            Route::get('/delete/{id}', 'groupnameDelete')->name('groupname.delete');
        }); 

        // Permission Management
        Route::prefix('permission')->controller(PermissionController::class)->group(function () {
            Route::get('/view', 'permissionView')->name('permission.view')->middleware('auth', 'permission:permission.view');
            Route::post('/store', 'permissionStore')->name('permission.store');
            Route::post('/update/{id}', 'permissionUpdate')->name('permission.update');
            Route::get('/delete/{id}', 'permissionDelete')->name('permission.delete');
        }); 

        // Roles Management
        Route::prefix('roles')->controller(RolesController::class)->group(function () {
            Route::get('/view', 'rolesView')->name('roles.view')->middleware('auth', 'permission:roles.view');
            Route::post('/store', 'rolesStore')->name('roles.store');
            Route::post('/update/{id}', 'rolesUpdate')->name('roles.update');
            Route::get('/delete/{id}', 'rolesDelete')->name('roles.delete');
        });

        // Roles with Permission Management
        Route::prefix('roles-permission')->controller(RoleWithPermissionController::class)->group(function () {
            Route::get('/view', 'rolesWithPermissionView')->name('roleswithpermission.view')->middleware('auth', 'permission:roleswithpermission.view');
            Route::post('/store', 'rolesWithPermissionStore')->name('roleswithpermission.store');
            Route::post('/update/{id}', 'rolesWithPermissionUpdate')->name('roleswithpermission.update');
            Route::get('/delete/{id}', 'rolesWithPermissionDelete')->name('roleswithpermission.delete');
        });

        // System Settings Management
        Route::prefix('system-settings')->controller(SystemSettingController::class)->group(function () {
            Route::get('/', 'index')->name('system.settings');
            Route::post('/update', 'update')->name('system.settings.update');
        });

        // (Optional) SMTP Setup Management (Commented Out)
        // Route::prefix('smtp-setup')->controller(SmtpController::class)->group(function () {
        //     Route::get('/smtp-setting', 'smtpSettings')->name('smtp.setting')->middleware('auth', 'permission:smtp.setting');
        //     Route::post('update-smtp', 'smtpUpdate')->name('smtp-settings.update');
        // });

    });




    // ==========================
    // 🧍 All Customer Routes
    // ==========================
    Route::middleware(['auth', 'roles:user'])->group(function () {

        // 👉 User Dashboard & Profile
        Route::controller(UserController::class)->group(function () {
            Route::get('/user/dashboard', 'userDashboard')->name('user.dashboard');
            Route::get('/user-logout', 'userDestroy')->name('user.logout');
            Route::get('/user-profile', 'userProfile')->name('user.profile');
            Route::post('/user-profile/store', 'userProfileStore')->name('user.profile.store');
            Route::get('/user-change/password', 'userChangePassword')->name('user.change.password');
            Route::post('/user-update/password', 'userUpdatePassword')->name('user.update.password');
        });



        // Route::prefix('wallet')->controller(DepositController::class)->group(function () {
        //     Route::get('/deposit', 'showDepositForm')->name('user.wallet.deposit');
        //     Route::post('/verify-deposit', 'verifyDeposit')->name('user.wallet.verify-deposit');
        //     // User Deposit Appeal Routes         
        //     Route::get('/appeal/{id}', 'showAppealForm')->name('user.wallet.deposit.appeal.form');
        //     Route::post('/appeal/{id}', 'submitAppeal')->name('user.wallet.deposit.appeal.submit');
        //     Route::get('/appeal/view/{id}', 'viewAppeal')->name('user.wallet.deposit.appeal.view');

        //     // User routes
        //     Route::get('/deposit/transaction-logs', 'depositTransactionLogs')->name('user.wallet.deposit.transaction-logs');
        // });



    });








    Route::prefix('auths')->controller(AuthController::class)->group(function () {
        Route::get('/register', 'showRegister')->name('auth.register');
        Route::post('/register/store',  'register')->name('auth.register.store');
    });








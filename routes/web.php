<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EnrolledStudentController;
use App\Http\Controllers\InquiryStudentController;
use App\Http\Controllers\FeePaymentController;
use App\Http\Controllers\FeeStructureController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherSalaryPaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
| Developer + Director only
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:developer,director'])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| Authenticated Academy Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | Inquiry Students
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'inquiry-students',
        InquiryStudentController::class
    );


    /*
    |--------------------------------------------------------------------------
    | Enrolled Students
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'enrolled-students',
        EnrolledStudentController::class
    );


    /*
    |--------------------------------------------------------------------------
    | Fee Collection
    |--------------------------------------------------------------------------
    */

    Route::get(
        'enrolled-students/{student}/pay-fee',
        [FeePaymentController::class, 'create']
    )->name('fee-payments.create');


    Route::post(
        'enrolled-students/{student}/pay-fee',
        [FeePaymentController::class, 'store']
    )->name('fee-payments.store');

    Route::resource(
    'fee-structures',
    FeeStructureController::class
);
Route::resource(
    'teachers',
    TeacherController::class
);
 Route::get(
        '/teachers/{teacher}/pay-salary',
        [TeacherSalaryPaymentController::class, 'create']
    )->name('teacher-salary-payments.create');

    Route::post(
        '/teachers/{teacher}/pay-salary',
        [TeacherSalaryPaymentController::class, 'store']
    )->name('teacher-salary-payments.store');

    Route::get('/reports/fees-history', [ReportController::class, 'feesHistory'])
    ->name('reports.fees-history');


    /*
    |--------------------------------------------------------------------------
    | Fee Receipt
    |--------------------------------------------------------------------------
    */

    Route::get(
        'fee-payments/{id}',
        [FeePaymentController::class, 'show']
    )->name('fee-payments.show');

});


/*
|--------------------------------------------------------------------------
| Temporary Role Test
|--------------------------------------------------------------------------
| Remove this after role testing is complete.
|--------------------------------------------------------------------------
*/

Route::get('/role-test', function () {

    return 'Welcome ' .
        auth()->user()->name .
        ' — Your role is: ' .
        auth()->user()->role;

})
->middleware(['auth', 'role:developer,director'])
->name('role.test');

Route::middleware(['auth'])->group(function () {
    Route::get('/reports/fees', [ReportController::class, 'feeReport'])->name('reports.fees');
    Route::get('/reports/fees/pdf', [ReportController::class, 'exportFeePdf'])->name('reports.fees.pdf');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
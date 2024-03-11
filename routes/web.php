<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

use App\Http\Livewire\CategoriesController;
use App\Http\Livewire\ProductsController;
use App\Http\Livewire\CoinsController;
use App\Http\Livewire\PosController;
use App\Http\Livewire\RolesController;
use App\Http\Livewire\PermisosController;
use App\Http\Livewire\AsignarController;
use App\Http\Livewire\CashoutController;
use App\Http\Livewire\ReportsController;
use App\Http\Controllers\ExportController;
use App\Http\Livewire\CustomersController;
use App\Http\Livewire\DashController;
use App\Http\Livewire\DiscountsController;
use App\Http\Livewire\LocationsController;
use App\Http\Livewire\MethodsController;
use App\Http\Livewire\PaymentsController;
use App\Http\Livewire\ProfileController;
use App\Http\Livewire\ReportServiceController;
use App\Http\Livewire\ReportCustomerController;
use App\Http\Livewire\ServicesController;
use App\Http\Livewire\UsersController;

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
    return view('auth.login');
});

Auth::routes();

/* Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); */
Route::get('/home', DashController::class);
/* Route::get('/blank', [HomeController::class, 'test'])->name('test'); */


Route::middleware(['auth'])->group(function () {
    Route::get('categories', CategoriesController::class);
    Route::get('products', ProductsController::class);
    Route::get('coins', CoinsController::class);
    Route::get('pos', PosController::class);
    Route::get('profile', ProfileController::class);
    Route::get('services', ServicesController::class);
    Route::get('discounts', DiscountsController::class);
    Route::get('locations', LocationsController::class);
    Route::get('customers', CustomersController::class);
    Route::get('methods', MethodsController::class);
    Route::get('payments', PaymentsController::class);

    Route::group(['middleware' => ['role:Admin']], function () {
        Route::get('roles', RolesController::class);
        Route::get('permisos', PermisosController::class);
        Route::get('asignar', AsignarController::class);
    });

    Route::get('users', UsersController::class);
    Route::get('cashout', CashoutController::class);
    Route::get('reports', ReportsController::class);
    Route::get('reportService', ReportServiceController::class);
    Route::get('reportCustomer', ReportCustomerController::class);
    /* Route::get('services', ServicesController::class); */

    //reportes PDF
    Route::get('report/pdf/{user}/{type}/{f1}/{f2}', [ExportController::class, 'reportPDF']);
    Route::get('report/pdf/{user}/{type}', [ExportController::class, 'reportPDF']);

    //reportes servicios
    Route::get('reportService/pdf/{location}/{type}', [ExportController::class, 'reportServicePDF']);

    //reportes clientes
    Route::get('reportCustomer/pdf/{namec}/{cid}/{location}', [ExportController::class, 'reportCustomerPDF']);

    //reportes Excel
    Route::get('report/excel/{user}/{type}/{f1}/{f2}', [ExportController::class, 'reporteExcel']);
    Route::get('report/excel/{user}/{type}', [ExportController::class, 'reporteExcel']);
});

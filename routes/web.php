<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\Publico\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PÁGINA PÚBLICA
|--------------------------------------------------------------------------
*/

Route::get(
    '/',
    [
        HomeController::class,
        'index',
    ]
)->name('home');


/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

Route::middleware('guest')
    ->group(function (): void {

        Route::get(
            '/login',
            [
                AuthController::class,
                'showLogin',
            ]
        )->name('login');

        Route::post(
            '/login',
            [
                AuthController::class,
                'login',
            ]
        )->name('login.post');
    });


Route::post(
    '/logout',
    [
        AuthController::class,
        'logout',
    ]
)
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| USUARIOS AUTENTICADOS
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->group(function (): void {

        /*
        |--------------------------------------------------------------
        | INVENTARIO
        | Solicitante: solo consulta
        | Encargado: consulta y posteriormente CRUD
        |--------------------------------------------------------------
        */

        Route::get(
            '/inventario',
            [
                InventoryController::class,
                'index',
            ]
        )->name('inventory.index');


        /*
        |--------------------------------------------------------------
        | CALENDARIO
        |--------------------------------------------------------------
        */

        Route::get(
            '/calendario',
            [
                CalendarController::class,
                'index',
            ]
        )->name('calendar.index');


        /*
        |--------------------------------------------------------------
        | SOLICITAR PRÉSTAMO
        |--------------------------------------------------------------
        */

        Route::get(
            '/prestamos/solicitar',
            [
                LoanController::class,
                'create',
            ]
        )->name('loans.create');

        Route::post(
            '/prestamos',
            [
                LoanController::class,
                'store',
            ]
        )->name('loans.store');

        Route::get(
            '/mis-prestamos',
            [
                LoanController::class,
                'myLoans',
            ]
        )->name('loans.mine');


        /*
        |--------------------------------------------------------------
        | INCIDENCIAS
        |--------------------------------------------------------------
        */

        Route::get(
            '/incidencias',
            [
                IncidentController::class,
                'index',
            ]
        )->name('incidents.index');

        Route::get(
            '/incidencias/nueva',
            [
                IncidentController::class,
                'create',
            ]
        )->name('incidents.create');

        Route::post(
            '/incidencias',
            [
                IncidentController::class,
                'store',
            ]
        )->name('incidents.store');
    });


/*
|--------------------------------------------------------------------------
| SOLO ENCARGADO
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth',
    'role:encargado',
])
    ->group(function (): void {

        /*
        |--------------------------------------------------------------
        | CATEGORÍAS
        |--------------------------------------------------------------
        */

        Route::get(
            '/categorias',
            [
                CategoryController::class,
                'index',
            ]
        )->name('categories.index');

        Route::get(
            '/categorias/nueva',
            [
                CategoryController::class,
                'create',
            ]
        )->name('categories.create');

        Route::post(
            '/categorias',
            [
                CategoryController::class,
                'store',
            ]
        )->name('categories.store');

        Route::get(
            '/categorias/{category}/editar',
            [
                CategoryController::class,
                'edit',
            ]
        )->name('categories.edit');

        Route::put(
            '/categorias/{category}',
            [
                CategoryController::class,
                'update',
            ]
        )->name('categories.update');

        Route::delete(
            '/categorias/{category}',
            [
                CategoryController::class,
                'destroy',
            ]
        )->name('categories.destroy');


        /*
        |--------------------------------------------------------------
        | EQUIPOS
        |--------------------------------------------------------------
        */

        Route::get(
            '/equipos/nuevo',
            [
                EquipmentController::class,
                'create',
            ]
        )->name('equipment.create');

        Route::post(
            '/equipos',
            [
                EquipmentController::class,
                'store',
            ]
        )->name('equipment.store');

        Route::get(
            '/equipos/{equipment}/editar',
            [
                EquipmentController::class,
                'edit',
            ]
        )->name('equipment.edit');

        Route::put(
            '/equipos/{equipment}',
            [
                EquipmentController::class,
                'update',
            ]
        )->name('equipment.update');

        Route::delete(
            '/equipos/{equipment}',
            [
                EquipmentController::class,
                'destroy',
            ]
        )->name('equipment.destroy');


        /*
        |--------------------------------------------------------------
        | IMPORTAR Y EXPORTAR TXT JSON
        |--------------------------------------------------------------
        */

        Route::get(
            '/equipos/importar',
            [
                EquipmentController::class,
                'importForm',
            ]
        )->name('equipment.import');

        Route::post(
            '/equipos/importar',
            [
                EquipmentController::class,
                'importStore',
            ]
        )->name(
            'equipment.import.store'
        );

        Route::get(
            '/equipos/exportar/txt',
            [
                EquipmentController::class,
                'exportTxt',
            ]
        )->name(
            'equipment.export'
        );


        /*
        |--------------------------------------------------------------
        | TABLA DE SOLICITUDES
        |--------------------------------------------------------------
        */

        Route::get(
            '/prestamos',
            [
                LoanController::class,
                'index',
            ]
        )->name('loans.index');

        Route::patch(
            '/prestamos/{loan}/aprobar',
            [
                LoanController::class,
                'approve',
            ]
        )->name('loans.approve');

        Route::patch(
            '/prestamos/{loan}/rechazar',
            [
                LoanController::class,
                'reject',
            ]
        )->name('loans.reject');

        Route::patch(
            '/prestamos/{loan}/entregar',
            [
                LoanController::class,
                'deliver',
            ]
        )->name('loans.deliver');

        Route::patch(
            '/prestamos/{loan}/devolver',
            [
                LoanController::class,
                'returnLoan',
            ]
        )->name('loans.return');


        /*
        |--------------------------------------------------------------
        | ADMINISTRAR INCIDENCIAS
        |--------------------------------------------------------------
        */

        Route::get(
            '/incidencias/{incident}/editar',
            [
                IncidentController::class,
                'edit',
            ]
        )->name('incidents.edit');

        Route::put(
            '/incidencias/{incident}',
            [
                IncidentController::class,
                'update',
            ]
        )->name('incidents.update');

        Route::delete(
            '/incidencias/{incident}',
            [
                IncidentController::class,
                'destroy',
            ]
        )->name('incidents.destroy');
    });
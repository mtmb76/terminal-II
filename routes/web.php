<?php

#use App\Http\Controllers\Controller;
#use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TemaController;
use App\Http\Controllers\ParticipanteController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\EventoparticipanteController;

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

# GRUPO DE USUÁRIOS
###################################################################
# da raiz vai para a tela de login do usuário
Route::get('/',[UserController::class, 'login']);
Route::get('/login', [UserController::class, 'login']);
Route::post('/autenticar',  [UserController::class, 'autenticar'])->middleware('ldap')->name('autenticar');
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware(['ldap','auth'])->name('dashboard');


###################################################################

Route::prefix('admin')->middleware('ldap','auth')->group(
    function (){
        Route::get('/lista',[UserController::class,'lista'])->name('admin.lista');
        Route::get('/consulta/{page?}',[UserController::class, 'consulta'])->name('admin.consulta');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('admin.delete');
        Route::get('/edit/{id}',[UserController::class, 'edit'])->name('admin.edit');
        Route::post('/update',[UserController::class, 'update'])->name('admin.update');
    }
);

# GRUPO DE TEMAS
###################################################################
Route::prefix('tema')->middleware('auth')->group(
    function () {
        Route::get('/lista',[TemaController::class, 'index'])->name('tema.lista');
        Route::get('/consulta/{page?}',[TemaController::class, 'consulta'])->name('tema.consulta');
        Route::get('/view/{id}', [TemaController::class, 'view'])->name('tema.view');
        Route::get('/novo',[TemaController::class, 'open'])->name('tema.novo');
        Route::post('/add', [TemaController::class, 'add'])->name('tema.add');
        Route::get('/edit/{id}',[TemaController::class, 'edit'])->name('tema.edit');
        Route::post('/update',[TemaController::class, 'update'])->name('tema.update');
        Route::get('/delete/{id}', [TemaController::class, 'delete'])->name('tema.delete');
        Route::post('/import', [TemaController::class, 'import'])->name('tema.import');
    }
);
###################################################################


# GRUPO DE PARTICIPANTES
###################################################################
Route::prefix('participante')->middleware('auth')->group(
    function () {
        Route::get('/lista', [ParticipanteController::class, 'index'])->name('participante.lista');
        Route::get('/consulta/{page?}', [ParticipanteController::class, 'consulta'])->name('participante.consulta');
        Route::get('/view/{id}', [ParticipanteController::class, 'view'])->name('participante.view');
        Route::get('/novo', [ParticipanteController::class, 'open'])->name('participante.novo');
        Route::post('/add', [ParticipanteController::class, 'add'])->name('participante.add');
        Route::get('/edit/{id}', [ParticipanteController::class, 'edit'])->name('participante.edit');
        Route::post('/update', [ParticipanteController::class, 'update'])->name('participante.update');
        Route::get('/delete/{id}', [ParticipanteController::class, 'delete'])->name('participante.delete');
    }
);
###################################################################


# GRUPO DE EVENTOS
###################################################################
Route::prefix('evento')->middleware('auth')->group(
    function () {
        Route::get('/lista', [EventoController::class, 'index'])->name('evento.lista');
        Route::get('/consulta/{page?}', [EventoController::class, 'consulta'])->name('evento.consulta');
        Route::get('/view/{id}/{page?}', [EventoController::class, 'view'])->name('evento.view');
        Route::get('/novo', [EventoController::class, 'open'])->name('evento.novo');
        Route::post('/add', [EventoController::class, 'add'])->name('evento.add');
        Route::get('/edit/{id}', [EventoController::class, 'edit'])->name('evento.edit');
        Route::post('/update', [EventoController::class, 'update'])->name('evento.update');
        Route::get('/delete/{id}', [EventoController::class, 'delete'])->name('evento.delete');
        Route::get('/ata/{id}', [EventoController::class, 'ata'])->name('evento.ata');
    }
);
###################################################################


# GRUPO DE EVENTOSPARTICIPANTES
###################################################################
Route::prefix('eventoparticipante')->middleware('auth')->group(
    function () {
        Route::get('/delete/{evento}/{participante}',[EventoparticipanteController::class,'delete'])->name('eventoparticipante.delete');
        Route::post('/add',[EventoparticipanteController::class, 'add'])->name('eventoparticipante.add');
    }
);
###################################################################

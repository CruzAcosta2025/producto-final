<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CentroMedicoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CentroMedico\PersonalMedicoController;
use App\Http\Controllers\CentroMedico\GestionPersonalController;
use App\Http\Controllers\CentroMedico\RolController;
use App\Http\Controllers\CentroMedico\PermisoController;
use App\Http\Controllers\CentroMedico\RolPermisoController;
use App\Http\Controllers\CentroMedico\UsuarioCentroController;
use App\Http\Controllers\CentroMedico\Paciente\PacienteController;
use App\Http\Controllers\CentroMedico\Historial\HistorialClinicoController;
use App\Http\Controllers\CentroMedico\Historial\AnamnesisController;
use App\Http\Controllers\CentroMedico\Historial\ConsultasController;
use App\Http\Controllers\CentroMedico\Historial\ExamenesMedicosController;
use App\Http\Controllers\CentroMedico\Historial\ArchivosAdjuntosController;
use App\Http\Controllers\CentroMedico\Historial\AlergiaController;
use App\Http\Controllers\CentroMedico\Historial\CirugiaController;
use App\Http\Controllers\CentroMedico\Historial\VacunaController;
use App\Http\Controllers\CentroMedico\Historial\DiagnosticoController;
use App\Http\Controllers\CentroMedico\Historial\RecetaController;
use App\Http\Controllers\CentroMedico\Historial\MedicamentoController;
use App\Http\Controllers\CentroMedico\Historial\TratamientoController;
use App\Http\Controllers\CentroMedico\Historial\TriajeController;
use App\Http\Controllers\CentroMedico\Horario\HorarioMedicoController;
use App\Http\Controllers\CentroMedico\Horario\TurnoController;
use App\Http\Controllers\CentroMedico\Caja\CajaController;
use App\Http\Controllers\CentroMedico\Caja\FacturaServicioController;
use App\Http\Controllers\CentroMedico\Caja\ServicioPrecioController;
use App\Http\Controllers\CentroMedico\Configuracion\ConfiguracionCentroController;
use App\Http\Controllers\CentroMedico\Sangre\DonadoresController;
use App\Http\Controllers\CentroMedico\Sangre\SolicitudesController;
use App\Http\Controllers\CentroMedico\Especialidad\EspecialidadController;
use App\Http\Controllers\CentroMedico\Modulocaja\CajaTransaccionesController;
use App\Http\Controllers\CentroMedico\Reportes\ReporteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DniController;
use App\Http\Controllers\AdminGlobalController;
use App\Http\Controllers\HistorialEliminacionesController;




Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Rutas para restablecimiento de contraseña
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    })->name('password.email');
});


// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Panel de Administrador Global
    Route::get('/admin/global/dashboard', [AdminGlobalController::class, 'dashboard'])
        ->name('admin.global.dashboard');

    // Panel de Administrador de Centro Médico
    Route::get('/admin/centro/dashboard', function () {
        $centro = auth()->user()->centroMedico;
        return view('admin.centro.dashboard', compact('centro'));
    })->name('admin.centro.dashboard');

    Route::get('/historial/export-excel', [HistorialEliminacionesController::class, 'exportExcel'])->name('historial.exportExcel');
    Route::get('/historial/export-pdf', [HistorialEliminacionesController::class, 'exportPDF'])->name('historial.exportPDF');

    Route::get('/admin/global/historial-eliminaciones', [HistorialEliminacionesController::class, 'index'])
        ->name('historial.eliminaciones')
        ->middleware('auth');

    // Rutas específicas de habilitar y deshabilitar centros
    Route::post('centros/{id}/disable', [CentroMedicoController::class, 'disable'])->name('centros.disable');
    Route::post('centros/{id}/enable', [CentroMedicoController::class, 'enable'])->name('centros.enable');
    Route::post('/admin/centro/usuarios/{id}/personal/store', [GestionPersonalController::class, 'guardarPersonalMedico'])->name('personal.store');

    // Rutas de recursos
    Route::resource('centros', CentroMedicoController::class)->except(['show']);
    Route::resource('usuarios', UsuarioController::class)->except(['show']);
    Route::resource('roles', RolController::class)->except(['show']);
    Route::resource('permisos', PermisoController::class)->except(['show']);
    Route::resource('personal-medico', PersonalMedicoController::class)->except(['show']);
    Route::resource('usuarios-centro', UsuarioCentroController::class)->except(['show']);
    Route::resource('pacientes', PacienteController::class)->except(['show']);
    Route::resource('historial', HistorialClinicoController::class)->except(['show']);

    // Rutas para la gestión de roles y permisos
    Route::get('roles/{id}/permisos', [RolPermisoController::class, 'edit'])->name('roles-permisos.edit');
    Route::put('roles/{id}/permisos', [RolPermisoController::class, 'update'])->name('roles-permisos.update');

    // Rutas para la gestión de personal médico y no médico
    Route::prefix('/admin/centro')->group(function () {
        Route::get('personal-medico', [PersonalMedicoController::class, 'index'])->name('admin.centro.personal-medico.index');
        Route::get('trabajadores', [PersonalMedicoController::class, 'indexTrabajadores'])->name('trabajadores.index');
        Route::get('trabajadores/{id}/edit', [PersonalMedicoController::class, 'editTrabajador'])->name('trabajadores.edit');
        Route::put('trabajadores/{id}', [PersonalMedicoController::class, 'updateTrabajador'])->name('trabajadores.update');
        Route::delete('trabajadores/{id}', [PersonalMedicoController::class, 'destroyTrabajador'])->name('trabajadores.destroy');
    });

    // Rutas específicas para la gestión de personal del centro médico
    Route::prefix('/admin/centro/usuarios')->group(function () {
        Route::get('/{id}/personal/create', [GestionPersonalController::class, 'mostrarFormularioPersonal'])->name('personal.create');
        Route::post('/{id}/personal/store', [GestionPersonalController::class, 'guardarPersonalMedico'])->name('personal.store');
        Route::get('/{id}/trabajadores/create', [GestionPersonalController::class, 'mostrarFormularioTrabajadores'])->name('trabajadores.create');
        Route::post('/{id}/trabajadores/store', [GestionPersonalController::class, 'guardarPersonalNoMedico'])->name('trabajadores.store');
    });

    // Rutas para Historial Clínico
    Route::get('historial/{id}/show', [HistorialClinicoController::class, 'show'])->name('historial.show');
    Route::post('historial/create/{idPaciente}', [HistorialClinicoController::class, 'store'])->name('historial.store.paciente');
    Route::delete('historial/{id}/', [HistorialClinicoController::class, 'destroy'])->name('historial.destroy');


    // Rutas para Anamnesis
    Route::prefix('historial/{idHistorial}/anamnesis')->group(function () {
        Route::get('/create', [AnamnesisController::class, 'create'])->name('anamnesis.create');
        Route::post('/', [AnamnesisController::class, 'store'])->name('anamnesis.store');
        Route::get('/{idAnamnesis}/edit', [AnamnesisController::class, 'edit'])->name('anamnesis.edit');
        Route::put('/{idAnamnesis}', [AnamnesisController::class, 'update'])->name('anamnesis.update');
        Route::delete('/{idAnamnesis}', [AnamnesisController::class, 'destroy'])->name('anamnesis.destroy');
    });

    // Rutas para Consultas
    Route::prefix('historial/{idHistorial}/consultas')->group(function () {
        Route::get('/create', [ConsultasController::class, 'create'])->name('consultas.create');
        Route::post('/', [ConsultasController::class, 'store'])->name('consultas.store');
        Route::get('/{idConsulta}/edit', [ConsultasController::class, 'edit'])->name('consultas.edit');
        Route::put('/{idConsulta}', [ConsultasController::class, 'update'])->name('consultas.update');
        Route::delete('/{idConsulta}', [ConsultasController::class, 'destroy'])->name('consultas.destroy');
    });

    // Rutas para Exámenes Médicos
    Route::get('examenes/buscar', [ExamenesMedicosController::class, 'buscar'])->name('examenes.buscar');
    Route::prefix('historial/{idHistorial}/examenes')->group(function () {
        Route::get('/', [ExamenesMedicosController::class, 'index'])->name('examenes.index');
        Route::get('/create', [ExamenesMedicosController::class, 'create'])->name('examenes.create');
        Route::post('/', [ExamenesMedicosController::class, 'store'])->name('examenes.store');
        Route::get('/{idExamen}/edit', [ExamenesMedicosController::class, 'edit'])->name('examenes.edit');
        Route::put('/{idExamen}', [ExamenesMedicosController::class, 'update'])->name('examenes.update');
        Route::delete('/{idExamen}', [ExamenesMedicosController::class, 'destroy'])->name('examenes.destroy');
    });

    // Rutas para Archivos Adjuntos
    Route::get('archivos', [ArchivosAdjuntosController::class, 'index'])->name('archivos.index');
    Route::prefix('historial/{idHistorial}/archivos')->group(function () {
        Route::get('/create', [ArchivosAdjuntosController::class, 'create'])->name('archivos.create');
        Route::post('/', [ArchivosAdjuntosController::class, 'store'])->name('archivos.store');
        Route::delete('/{idArchivo}', [ArchivosAdjuntosController::class, 'destroy'])->name('archivos.destroy');
    });

    // Rutas para Alergias
    Route::prefix('alergias')->group(function () {
        Route::get('/', [AlergiaController::class, 'index'])->name('alergias.index');
        Route::get('/{idPaciente}/create', [AlergiaController::class, 'create'])->name('alergias.create');
        Route::post('/{idPaciente}', [AlergiaController::class, 'store'])->name('alergias.store');
        Route::get('/{idPaciente}/{idAlergia}/edit', [AlergiaController::class, 'edit'])->name('alergias.edit');
        Route::put('/{idPaciente}/{idAlergia}', [AlergiaController::class, 'update'])->name('alergias.update');
        Route::delete('/{idPaciente}/{idAlergia}', [AlergiaController::class, 'destroy'])->name('alergias.destroy');
    });

    // Rutas para Cirugías
    Route::prefix('cirugias')->group(function () {
        Route::get('/', [CirugiaController::class, 'index'])->name('cirugias.index');
        Route::get('/{idHistorial}/create', [CirugiaController::class, 'create'])->name('cirugias.create');
        Route::post('/{idHistorial}', [CirugiaController::class, 'store'])->name('cirugias.store');
        Route::get('/{idHistorial}/{idCirugia}/edit', [CirugiaController::class, 'edit'])->name('cirugias.edit');
        Route::put('/{idHistorial}/{idCirugia}', [CirugiaController::class, 'update'])->name('cirugias.update');
        Route::delete('/{idHistorial}/{idCirugia}', [CirugiaController::class, 'destroy'])->name('cirugias.destroy');
    });

    // Rutas para Vacunas
    Route::prefix('vacunas')->group(function () {
        Route::get('/', [VacunaController::class, 'index'])->name('vacunas.index');
        Route::get('/{idHistorial}/create', [VacunaController::class, 'create'])->name('vacunas.create');
        Route::post('/{idHistorial}', [VacunaController::class, 'store'])->name('vacunas.store');
        Route::get('/{idHistorial}/{idVacuna}/edit', [VacunaController::class, 'edit'])->name('vacunas.edit');
        Route::put('/{idHistorial}/{idVacuna}', [VacunaController::class, 'update'])->name('vacunas.update');
        Route::delete('/{idHistorial}/{idVacuna}', [VacunaController::class, 'destroy'])->name('vacunas.destroy');
    });

    // Rutas para Diagnósticos
    Route::prefix('diagnosticos')->group(function () {
        Route::get('/', [DiagnosticoController::class, 'index'])->name('diagnosticos.index');
        Route::get('/{idHistorial}/create', [DiagnosticoController::class, 'create'])->name('diagnosticos.create');
        Route::post('/{idHistorial}', [DiagnosticoController::class, 'store'])->name('diagnosticos.store');
        Route::get('/{idHistorial}/{idDiagnostico}/edit', [DiagnosticoController::class, 'edit'])->name('diagnosticos.edit');
        Route::put('/{idHistorial}/{idDiagnostico}', [DiagnosticoController::class, 'update'])->name('diagnosticos.update');
        Route::delete('/{idHistorial}/{idDiagnostico}', [DiagnosticoController::class, 'destroy'])->name('diagnosticos.destroy');
    });

    // Rutas para Recetas y Medicamentos
    Route::prefix('recetas')->group(function () {
        Route::get('/', [RecetaController::class, 'index'])->name('recetas.index');
        Route::get('/{idHistorial}/create', [RecetaController::class, 'create'])->name('recetas.create');
        Route::post('/{idHistorial}', [RecetaController::class, 'store'])->name('recetas.store');
        Route::get('/{idHistorial}/{idReceta}/edit', [RecetaController::class, 'edit'])->name('recetas.edit');
        Route::put('/{idHistorial}/{idReceta}', [RecetaController::class, 'update'])->name('recetas.update');
        Route::delete('/{idHistorial}/{idReceta}', [RecetaController::class, 'destroy'])->name('recetas.destroy');
    });

    Route::prefix('recetas/{idReceta}/medicamentos')->group(function () {
        Route::get('/', [MedicamentoController::class, 'index'])->name('medicamentos.index');
        Route::get('/create', [MedicamentoController::class, 'create'])->name('medicamentos.create');
        Route::post('/', [MedicamentoController::class, 'store'])->name('medicamentos.store');
        Route::get('/{idMedicamento}/edit', [MedicamentoController::class, 'edit'])->name('medicamentos.edit');
        Route::put('/{idMedicamento}', [MedicamentoController::class, 'update'])->name('medicamentos.update');
        Route::delete('/{idMedicamento}', [MedicamentoController::class, 'destroy'])->name('medicamentos.destroy');
    });

    // Rutas para Tratamientos
    Route::prefix('tratamientos')->group(function () {
        Route::get('/', [TratamientoController::class, 'index'])->name('tratamientos.index');
        Route::get('/{idHistorial}/create', [TratamientoController::class, 'create'])->name('tratamientos.create');
        Route::post('/{idHistorial}', [TratamientoController::class, 'store'])->name('tratamientos.store');
        Route::get('/{idHistorial}/{idTratamiento}/edit', [TratamientoController::class, 'edit'])->name('tratamientos.edit');
        Route::put('/{idHistorial}/{idTratamiento}', [TratamientoController::class, 'update'])->name('tratamientos.update');
        Route::delete('/{idHistorial}/{idTratamiento}', [TratamientoController::class, 'destroy'])->name('tratamientos.destroy');
    });

    // Rutas para Triaje
    Route::prefix('triajes')->group(function () {
        Route::get('/', [TriajeController::class, 'index'])->name('triajes.index');
        Route::get('/create/{idHistorial}', [TriajeController::class, 'create'])->name('triajes.create');
        Route::post('/store/{idHistorial}', [TriajeController::class, 'store'])->name('triajes.store');
        Route::get('/edit/{idHistorial}/{idTriaje}', [TriajeController::class, 'edit'])->name('triajes.edit');
        Route::put('/update/{idHistorial}/{idTriaje}', [TriajeController::class, 'update'])->name('triajes.update');
        Route::delete('/delete/{idHistorial}/{idTriaje}', [TriajeController::class, 'destroy'])->name('triajes.destroy');
    });

    // Rutas para Horarios Médicos
    Route::prefix('horarios')->group(function () {
        Route::get('/', [HorarioMedicoController::class, 'index'])->name('horarios.index');
        Route::get('/create', [HorarioMedicoController::class, 'create'])->name('horarios.create');
        Route::post('/store', [HorarioMedicoController::class, 'store'])->name('horarios.store');
        Route::get('/{id}/edit', [HorarioMedicoController::class, 'edit'])->name('horarios.edit');
        Route::put('/{id}', [HorarioMedicoController::class, 'update'])->name('horarios.update');
        Route::delete('/{id}', [HorarioMedicoController::class, 'destroy'])->name('horarios.destroy');
    });

    // Rutas para Turnos
    Route::get('turnos/disponibles', [TurnoController::class, 'index'])->name('turnos.disponibles');

    // Rutas para Caja
    Route::prefix('caja')->group(function () {
        Route::get('/', [CajaController::class, 'index'])->name('caja.index');
        Route::get('/buscar-paciente', [CajaController::class, 'buscarPaciente'])->name('caja.buscarPaciente');
        Route::get('/crear-factura', [CajaController::class, 'crearFactura'])->name('caja.crearFactura');
        Route::post('/store-factura', [CajaController::class, 'storeFactura'])->name('caja.storeFactura');
        Route::get('/editar-factura/{id}', [CajaController::class, 'editarFactura'])->name('caja.editarFactura');
        Route::get('/factura/{id}', [CajaController::class, 'verFactura'])->name('caja.verFactura');
        Route::get('/factura/{id}/descargar', [CajaController::class, 'descargarFactura'])->name('caja.descargarFactura');
        Route::post('/factura-general', [CajaController::class, 'generarFacturaGeneral'])->name('caja.generarFacturaGeneral');
        Route::post('/factura-general/descargar', [CajaController::class, 'descargarFacturaGeneral'])->name('caja.descargarFacturaGeneral');
        Route::put('/actualizar-factura/{id}', [CajaController::class, 'actualizarFactura'])->name('caja.actualizarFactura');
        Route::delete('/eliminar-factura/{id}', [CajaController::class, 'eliminarFactura'])->name('caja.eliminarFactura');
    });

    // Rutas para Servicios
    Route::prefix('servicios')->group(function () {
        Route::get('/', [ServicioPrecioController::class, 'index'])->name('servicios.index');
        Route::get('/create', [ServicioPrecioController::class, 'create'])->name('servicios.create');
        Route::post('/store', [ServicioPrecioController::class, 'store'])->name('servicios.store');
        Route::get('/{id}/edit', [ServicioPrecioController::class, 'edit'])->name('servicios.edit');
        Route::put('/{id}', [ServicioPrecioController::class, 'update'])->name('servicios.update');
        Route::delete('/{id}', [ServicioPrecioController::class, 'destroy'])->name('servicios.destroy');
    });

    // Rutas para Factura Servicios
    Route::prefix('factura-servicio')->group(function () {
        Route::put('/{id}', [FacturaServicioController::class, 'update'])->name('factura-servicio.update');
        Route::delete('/{id}', [FacturaServicioController::class, 'destroy'])->name('factura-servicio.destroy');
    });

    // Rutas para Configuración del Centro
    Route::prefix('configurar')->group(function () {
        Route::get('/', [ConfiguracionCentroController::class, 'index'])->name('configurar.centro');
        Route::put('/', [ConfiguracionCentroController::class, 'update'])->name('configurar.centro.update');
    });

    // Rutas para Donadores de Sangre
    Route::prefix('sangre/donadores')->name('sangre.donadores.')->group(function () {
        Route::get('/', [DonadoresController::class, 'index'])->name('index');
        Route::get('/create', [DonadoresController::class, 'create'])->name('create');
        Route::post('/', [DonadoresController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [DonadoresController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DonadoresController::class, 'update'])->name('update');
        Route::delete('/{id}', [DonadoresController::class, 'destroy'])->name('destroy');
    });

    // Rutas para Solicitudes de Sangre
    Route::prefix('sangre/solicitudes')->name('sangre.solicitudes.')->group(function () {
        Route::get('/', [SolicitudesController::class, 'index'])->name('index');
        Route::get('/create', [SolicitudesController::class, 'create'])->name('create');
        Route::post('/', [SolicitudesController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SolicitudesController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SolicitudesController::class, 'update'])->name('update');
        Route::delete('/{id}', [SolicitudesController::class, 'destroy'])->name('destroy');
    });

    // Ruta para obtener personal médico por especialidad
    Route::get('personal-medico/por-especialidad/{id_especialidad}', [PersonalMedicoController::class, 'obtenerPorEspecialidad'])->name('personal.por-especialidad');
});

// Ruta para la especialidad (fuera del grupo de autenticación)
Route::resource('especialidad', EspecialidadController::class)->except(['show']);

// Buscar DNI (Usado en la vista para autocompletar datos del paciente)
Route::get('/buscar-dni/{dni}', [DniController::class, 'buscarDni'])->name('pacientes.buscar.dni');


// Buscar DNI para pacientes
Route::post('/pacientes/buscar-dni', [PacienteController::class, 'buscarPorDni'])->name('pacientes.buscar.dni');

// Buscar DNI para donadores
Route::get('/donadores/buscar-dni/{dni}', [DonadoresController::class, 'buscarDni'])->name('donadores.buscar.dni');
Route::post('/donadores/buscar-dni', [DonadoresController::class, 'buscarDni'])->name('donadores.buscar.dni.post');

// Página principal con autenticación
Route::middleware('auth')->get('/home', [HomeController::class, 'index'])->name('home');

// Obtener tipos de permisos
Route::get('permisos/tipos', [PermisoController::class, 'getTiposPermisos'])->name('permisos.tipos');

// Grupo de rutas para reportes con autenticación
Route::middleware(['auth'])->prefix('centro/reportes')->group(function () {
    Route::get('/', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/create/{tipo}', [ReporteController::class, 'create'])->name('reportes.create');
    Route::post('/store/{tipo}', [ReporteController::class, 'store'])->name('reportes.store');
    Route::get('/show/{id}', [ReporteController::class, 'show'])->name('reportes.show');
    Route::post('/export/pdf/{id}', [ReporteController::class, 'exportarPDF'])->name('reportes.exportar.pdf');
});

Route::get('/donadores/registrar-paciente/{id}', [DonadoresController::class, 'registrarPacienteComoDonador'])->name('sangre.donadores.registrarPaciente');
Route::get('/sangre/buscar-paciente', [\App\Http\Controllers\CentroMedico\Sangre\SolicitudesController::class, 'buscarPaciente'])->name('sangre.buscar-paciente');

Route::middleware(['auth'])->prefix('centro/modulocaja')->group(function () {
    Route::get('/', [CajaTransaccionesController::class, 'index'])->name('modulocaja.index');
    Route::get('/create', [CajaTransaccionesController::class, 'create'])->name('modulocaja.create');
    Route::post('/store', [CajaTransaccionesController::class, 'store'])->name('modulocaja.store');
    Route::get('/edit/{id}', [CajaTransaccionesController::class, 'edit'])->name('modulocaja.edit');
    Route::put('/update/{id}', [CajaTransaccionesController::class, 'update'])->name('modulocaja.update');
    Route::delete('/destroy/{id}', [CajaTransaccionesController::class, 'destroy'])->name('modulocaja.destroy');
    Route::post('/sincronizar', [CajaTransaccionesController::class, 'sincronizarTransaccionesDesdeFacturas'])->name('modulocaja.sincronizar');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Tienda\DetalleTienda;
use App\Http\Livewire\Kardex\Formulario;
use App\Http\Livewire\Tienda\Editar;
use App\Http\Livewire\RoleModule\Formulario as FormularioRoleModule;
use App\Http\Controllers\ImprimirPDF;
use App\Http\Controllers\RequerimientoPersonal;
use App\Http\Controllers\OrdenCompra;
use App\Http\Controllers\RequerimientoComprasController;
use App\Http\Livewire\OrdenCompra\Formularios as OrdenCompraFormulario;

use App\Http\Controllers\IngresosArticulos;
use App\Http\Controllers\SalidaArticulos;
use App\Http\Controllers\VerificarLogin;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SolicitudCotizacionController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\RoleModuleController;
use App\Http\Livewire\SucursalEmpresa\Principal as SucursalEmpresa;
use App\Http\Livewire\Permission\Formulario as FomrularioPermission;
use App\Models\Util;

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

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', [VerificarLogin::class, 'showLoginForm']);
});



Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

    Route::get('/dashboard', function () {
        $data = Util::verificarEstadoUsuario('dashboard');
        return view($data);
    })->name('dashboard');
    
    Route::get('/ver-empresas', function () {
        $data = Util::getTiendaIdLocalStorage();

        if ($data != -10) {
            return redirect()->route('ver-surcursales-empresa', $data);
        } else {
            return redirect()->route('dashboard', $data);
        }
    })->name('ver-empresa');

    Route::get('/setting', function () {
        $data = Util::verificarEstadoUsuario('admin.principal.setting');
        return view($data);
    })->name('setting');

    Route::get('/permiso-usuario', function () {
        $data = Util::verificarEstadoUsuario('admin.permiso-usuario.principal');
        return view($data);
    })->name('permiso-usuario');

    /* TIENDA */

    Route::get('/tiendas', function () {
        $data = Util::verificarEstadoUsuario('admin.tienda.principal');
        return view($data);
    })->name('tiendas');

    Route::get('/tienda.editar', function () {
        $data = Util::verificarEstadoUsuario('admin.tienda.editar');
        return view($data);
    })->name('tienda.editar');


    Route::get('/tienda-editar', Editar::class)->name('tienda-editar');

    /* TIPO UNIDAD */
    Route::get('/tipo-unidad', function () {
        $data = Util::verificarEstadoUsuario('admin.tipo-unidad.principal');
        return view($data);
    })->name('tipo-unidad');

    /* TIPO UNIDAD */

    /* TIPO PERSONAL */
    Route::get('/tipo-personal', function () {
        $data = Util::verificarEstadoUsuario('admin.tipo-personal.principal');
        return view($data);
    })->name('tipo-personal');

    /* TIPO PERSONAL */

    /* TIPO PERSONAL */
    Route::get('/personal-pdf', function () {
        $data = Util::verificarEstadoUsuario('admin.personal-pdf.principal');
        return view($data);
    })->name('personal-pdf');

    /* TIPO PERSONAL */

    Route::get('/personal', function () {
        $data = Util::verificarEstadoUsuario('admin.personal.principal');
        return view($data);
    })->name('personal');

    Route::get('/proveedor', function () {

        $data = Util::verificarEstadoUsuario('admin.proveedor.principal');
        return view($data);
    })->name('proveedor');

    Route::get('/requerimiento-personal', function () {
        $data = Util::verificarEstadoUsuario('admin.requerimiento-personal.principal');
        return view($data);
    })->name('requerimiento-personal');

    Route::get('/requerimiento-compras', function () {
        $data = Util::verificarEstadoUsuario('admin.requerimiento-compras.principal');
        return view($data);
    })->name('requerimiento-compras');

    //Ordeb de compra
    Route::get('/orden-compra', function () {
        $data = Util::verificarEstadoUsuario('admin.orden-compra.principal');
        return view($data);
    })->name('orden-compra');
    //Ordeb de compra
    Route::get('/solicitud-cotizacion', function () {
        $data = Util::verificarEstadoUsuario('admin.solicitud-cotizacion.principal');
        return view($data);
    })->name('solicitud-cotizacion');


    Route::get('conductor/ordenCompra/formulario/{data}', OrdenCompraFormulario::class)->name('ordenCompra.formulario');

    //Ordeb de compra
    Route::get('/ingreso', function () {
        $data = Util::verificarEstadoUsuario('admin.ingreso.principal');
        return view($data);
    })->name('ingreso');

    Route::get('/cuenta-inactiva', function () {

        $data = Util::verificarEstadoUsuario('admin.configuracion.cuenta-inactiva');
        return view($data);
    })->name('cuenta-inactiva');

    Route::get('/facturacion', function () {
        $data = Util::verificarEstadoUsuario('admin.facturacion.principal');
        return view($data);
    })->name('facturacion');

    Route::get('/lista-productos', function () {

        $data = Util::verificarEstadoUsuario('admin.lista-productos.principal');
        return view($data);
    })->name('lista-productos');

    Route::get('/transporte', function () {

        $data = Util::verificarEstadoUsuario('admin.transporte.principal');
        return view($data);
    })->name('transporte');

    Route::get('/salida', function () {

        $data = Util::verificarEstadoUsuario('admin.salida.principal');
        return view($data);
    })->name('salida');

    Route::get('/devolucion', function () {

        $data = Util::verificarEstadoUsuario('admin.devolucion.principal');
        return view($data);
    })->name('devolucion');

    Route::get('/usuario', function () {
        $data = Util::verificarEstadoUsuario('admin.usuario.principal');
        return view($data);
    })->name('usuario');

    Route::get('/prueba', function () {
        $data = Util::verificarEstadoUsuario('admin.salida.prueba');
        return view($data);
    })->name('prueba');

    Route::get('/kardex', function () {

        $data = Util::verificarEstadoUsuario('admin.kardex.principal');
        return view($data);
    })->name('kardex');

    Route::get('/verDetalleKardex/{articulo_id}', Formulario::class)->name('verDetalleKardex');
    /* ARTICULOS */
    Route::get('/articulo', function () {

        $data = Util::verificarEstadoUsuario('admin.articulo.principal');
        return view($data);
    })->name('articulo');
    Route::get('/articulo-list-excel', [ExcelController::class, 'exportExcel'])->name('articulos.excel');

    Route::get('/requerimiento-personal-list-excel/{medelo_id}', [ExcelController::class, 'requerimientoPersonalExcel']);




    /* ARTICULOS */


    Route::get('/inventario-inicial', function () {

        $data = Util::verificarEstadoUsuario('admin.inventario-inicial.principal');
        return view($data);
    })->name('inventario-inicial');

    Route::get('/informacion', function () {

        $data = Util::verificarEstadoUsuario('admin.tienda.informacion');
        return view($data);
    })->name('informacion');

    Route::get('/role', function () {

        $data = Util::verificarEstadoUsuario('admin.role.principal');
        return view($data);
    })->name('role');

    /* PERMISSSION */
    Route::get('/permission', function () {

        $data = Util::verificarEstadoUsuario('admin.permission.principal');
        return view($data);
    })->name('permission');

    Route::get('/module', function () {

        $data = Util::verificarEstadoUsuario('admin.permission.principal');
        return view($data);
    })->name('module');

    Route::get('/permission-asign/{medelo_id}', [PermissionController::class, 'asign'])->name('permission-asign');
    Route::post('/permission-asign-actualizar/{medelo_id}', [PermissionController::class, 'permissionAsign'])->name('permission-asign-actualizar');

    Route::get('/role-module-asign/{medelo_id}', [RoleModuleController::class, 'asign'])->name('role-module-asign');
    Route::post('/role-module-asign-actualizar/{medelo_id}', [RoleModuleController::class, 'rolemoduleasign'])->name('role-module-asign-actualizar');





    /* PERMISSSION */




    Route::get('/role-module', function () {

        $data = Util::verificarEstadoUsuario('admin.role-module.principal');
        return view($data);
    })->name('role-module');


    Route::get('/empresa', function () {

        $data = Util::verificarEstadoUsuario('admin.empresa.principal');
        return view($data);
    })->name('empresa');


    Route::get('/imprimir-kardex/{criterioBusqueda}/{rango_inicio}/{rango_fin}/{mes}/{anio}/{articulo}', [ImprimirPDF::class, 'imprimirPdfs']);
    Route::get('/imprimir-kardex-excel/{criterioBusqueda}/{rango_inicio}/{rango_fin}/{mes}/{anio}/{articulo}', [ImprimirPDF::class, 'imprimirPdfs']);

    Route::get('/imprimir-requerimiento-personal/{medelo_id}', [RequerimientoPersonal::class, 'imprimirRequemiento']);
    Route::get('/imprimir-requerimiento-comprasssss/{medelo_id}', [RequerimientoPersonal::class, 'imprimirRequerimientoCompras']);
    Route::get('/imprimir-orden-compra/{medelo_id}', [OrdenCompra::class, 'imprimirOrdenCompra']);
    Route::get('/imprimir-requerimiento-compras/{medelo_id}', [RequerimientoComprasController::class, 'imprimirRequerimientoCompra']);
    Route::get('/imprimir-solicitud-cotizacion/{medelo_id}', [SolicitudCotizacionController::class, 'imprimirSolicitudCotizacion']);
    Route::get('/imprimir-ingreso/{medelo_id}', [IngresosArticulos::class, 'imprimirIngreso']);
    Route::get('/imprimir-ingreso-general/{medelo_id}', [IngresosArticulos::class, 'imprimirIngresoGeneral']);
    Route::get('/imprimir-salida/{modeloId}', [SalidaArticulos::class, 'imprimirSalidaId']);
    /*   Route::get('/imprimir-salida/{rango_inicio}/{rango_fin}', [SalidaArticulos::class, 'imprimirSalida']); */
    Route::get('/imprimir-salida-general/{fecha_salida}', [SalidaArticulos::class, 'imprimirSalidaGeneral']);




    Route::get('/ventasDetalles/{tienda_id}', DetalleTienda::class)->name('ventasDetalles');
    Route::get('/ver-surcursales-empresa/{empresa_id}', SucursalEmpresa::class)->name('ver-surcursales-empresa');


    Route::get('/ver-detalle-sucursal-empresa/{tienda_id}', DetalleTienda::class)->name('ver-detalle-sucursal-empresa');
});

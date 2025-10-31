<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\AppController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PDFController;

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

Route::get('/',[AuthController::class,'Index'])->middleware('guest');
Route::get('/app/login', [AuthController::class,'Index'])->middleware('guest');
Route::get('/app/loginSSO', [AuthController::class,'indexSSO'])->middleware('guest');

Route::get('/app', [AppController::class,'index'])->middleware('cek_login');
Route::get('/app/index', [AppController::class,'index'])->middleware('cek_login');

Route::post('/app/login/action', [AuthController::class,'action']);
// Route::get('/app/home', [HomePageController::class,'home'])->middleware('cek_login');

Route::get('/phpinfo', [HomePageController::class,'info'])->middleware('cek_login');
Route::get('/cek_koneksi', [HomePageController::class,'cek_koneksi']);

Route::get('/app/login/action', [AuthController::class,'Index'])->middleware('cek_login');
Route::get('/app/login/actionSSO', [AuthController::class,'Index'])->middleware('cek_login');

Route::post('/app/logout', [AuthController::class,'logout']);
Route::get('/AuthController/changesatker/{id}/{reqPegawaiId}', [AuthController::class,'change_satker']);

Route::get('/app/asesor/{pegawai_id}/{ujian_id}/{tgl}', [AsesorController::class,'index']);

Route::get('/onecb', [HomePageController::class,'onecb']);

Route::get('/generate-pdf', [PDFController::class, 'generatePDF']);
// Clear all cache:
Route::get('/cache-clear', function() {
    Artisan::call('optimize:clear');
    return 'all cache has been cleared';
})->middleware('cek_login');




// Route::get('/{controller_name}/{function_name}',
// 	function ($controller_name, $function_name,Request $request) 
// 	{

// 		$app = app();
// 		$controller = $app->make('\App\Http\Controllers\\'.$controller_name.'Controller');
// 		return $controller->$function_name($request);
//     }
// );


//buat route dinamis ke folder controller
$DS = DIRECTORY_SEPARATOR;

\App\Http\Controllers\Util\RouteUtil::getRouteFromController($DS.'Http'.$DS.'Controllers'.$DS);


Auth::routes();


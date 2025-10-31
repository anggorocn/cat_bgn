<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eselon;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;

//buat panggil fungsi
use App\Helper\StringFunc;
use App\Helper\DateFunc;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SatuanKerjaController;

use Session;

use Carbon\Carbon;

class LevelJabatanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $stringfunc;
    public function __construct()
    {
        $this->middleware('cek_login');

        $this->middleware(function ($request, $next) {
          $this->user= Session::get('user');
          // $this->user= Auth::user()->load('pegawai.satker_model');

          // $this->ID                   = $this->user->pegawai->pegawai_id;   
          // $this->NAMA                 = $this->user->pegawai->nama;   
          // $this->JABATAN              = $this->user->pegawai->jabatan;   
          // $this->HAK_AKSES            = $this->user->pegawai->hak_akses;   
          // $this->LAST_LOGIN           = $this->user->pegawai->last_login;   
          // $this->USERNAME             = $this->user->pegawai->username;  
          // $this->USER_LOGIN_ID        = $this->user->pegawai->user_login_id;  
          // $this->USER_GROUP           = $this->user->pegawai->user_group;  
          // $this->MULTIROLE            = $this->user->pegawai->multirole;  
          // $this->CABANG_ID            = $this->user->pegawai->satuan_kerja_id;  
          // $this->CABANG               = $this->user->pegawai->cabang;  
          // $this->SATUAN_KERJA_ID_ASAL = $this->user->pegawai->satuan_kerja_id_asal;  
          // $this->SATUAN_KERJA_ASAL    = $this->user->pegawai->satuan_kerja_asal;  
          // $this->SATUAN_KERJA_HIRARKI = $this->user->pegawai->satuan_kerja_hirarki;  
          // $this->SATUAN_KERJA_JABATAN = $this->user->pegawai->satuan_kerja_jabatan;  
          // $this->KD_LEVEL             = $this->user->pegawai->kd_level;  
          // $this->JENIS_KELAMIN        = $this->user->pegawai->jenis_kelamin;

          return $next($request);
        });

        $this->stringfunc = new StringFunc();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function route_web() {
    
        //buat route view
        Route::get('/app/level_jabatan/index', [LevelJabatanController::class,'index']);
        Route::get('/app/level_jabatan/add/{id?}/{view?}', [LevelJabatanController::class,'addview']);

        //buat route proses
        Route::get('level_jabatan/json/{id?}', [LevelJabatanController::class,'json']);
        Route::post('level_jabatan/add/{id?}', [LevelJabatanController::class,'add']);
        Route::delete('level_jabatan/delete/{id}',[ LevelJabatanController::class, "delete" ]);
    }

    public function index(request $request) {
     return view("app/level_jabatan");
    }

    public function json(request $request)
    {
        $reqPencarian = isset($_GET['reqPencarian']) ? $_GET['reqPencarian'] : null;
        $statement='';
        if(!empty($reqPencarian)){
          $statement.=" and (UPPER(a.NAMA) like UPPER('%".$reqPencarian."%') OR a.NIP_BARU like '%".$reqPencarian."%')";
        }
        // dd($reqUnitKerja);
        $query= new Eselon();

        $query=$query->selectByParamsMonitoring($statement);
        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          // $btn='';
          $btn = '<a href="'.url('app/level_jabatan/add/'.$row->eselon_id).'" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';
          $btn .= '<a onclick=\'deletedata("'.$row->eselon_id.'")\' data-original-title="Detail" class="btn btn-danger mr-1 btn-sm detailProduct"><span class="fa fa-trash"></span></a>';

          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        ->make(true);
    }
    public function addview(request $request)
    {
      $reqId=$request->route('id');
      if(empty($reqId))
      {
        $query = "";
        // return view('app/pegawai.add', compact('query','jenis','satker','reqUnitKerjaId'));
      }
      else
      {
        $query = new Eselon();
        $statement='and eselon_id='.$reqId;
        $query=$query->selectByParamsMonitoring($statement)->first();
        //buat tes sqli
        // $query=$query->selectByParamsSqlI($reqId)->first();
      }
      
        return view('app/level_jabatan_add', compact('query','reqId'));
    }
    public function add(request $request)
    {

      //buat validasi
      $validated = $request->validate([
            'reqNama' => 'required',
            'reqIntegritas' => 'required',
            'reqKerjasama' => 'required',
            'reqKomunikasi' => 'required',
            'reqOPH' => 'required',
            'reqPelayananPublik' => 'required',
            'reqMengembangkanDiri' => 'required',
            'reqMengelolahPerubahan' => 'required',
            'reqPengambilanKeputusan' => 'required',
            'reqPerekatBangsa' => 'required',
      ]);

      $reqId= $request->reqId;
    //   print_r($reqId); exit;
      $reqNama= $request->reqNama;
      $reqIntegritas= $request->reqIntegritas;
      $reqKerjasama= $request->reqKerjasama;
      $reqKomunikasi= $request->reqKomunikasi;
      $reqOPH= $request->reqOPH;
      $reqPelayananPublik= $request->reqPelayananPublik;
      $reqMengembangkanDiri= $request->reqMengembangkanDiri;
      $reqMengelolahPerubahan= $request->reqMengelolahPerubahan;
      $reqPengambilanKeputusan= $request->reqPengambilanKeputusan;
      $reqPerekatBangsa= $request->reqPerekatBangsa;

      if(empty($reqId))
      {
        $maxId = Eselon::NextId();
        $set = new Eselon();
        // nama kolom yang di insert
        $set->eselon_id = $maxId;
        $reqId=$maxId;
      }else{           
        $set = Eselon::findOrFail($reqId);
        $set->eselon_id = $reqId;
      }

      $set->nama =$reqNama;
      $set->integritas =$reqIntegritas;
      $set->kerjasama =$reqKerjasama;
      $set->komunikasi=$reqKomunikasi;
      $set->orientasi_hasil=$reqOPH;
      $set->pelayanan_publik=$reqPelayananPublik;
      $set->mengembangkan_diri=$reqMengembangkanDiri;
      $set->mengelolah_perubahan=$reqMengelolahPerubahan;
      $set->pengambilan_keputusan=$reqPengambilanKeputusan;
      $set->perekat_bangsa=$reqPerekatBangsa;
      $set->total=$reqIntegritas+$reqKerjasama+$reqKomunikasi+$reqOPH+$reqPelayananPublik+$reqMengembangkanDiri+$reqMengelolahPerubahan+$reqPengambilanKeputusan+$reqPerekatBangsa;
      $set->save(); 

      return StringFunc::json_response(200, $reqId."-Data berhasil disimpan.");
      
    }
    public function delete($request)
    {
      $reqId = $request;
      Eselon::where('eselon_id', $reqId)
      ->delete();
      
      return StringFunc::json_response(200, "Data berhasil dihapus");

    }

}
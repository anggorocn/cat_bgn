<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SettingAwal;
use App\Models\SatuanKerja;
use App\Models\UserLogin;
use App\Models\FormulaEselon;
use App\Models\SettingPelaksanaan;
use App\Models\JadwalAwalTes;
use App\Models\JadwalTes;
use App\Models\JadwalAwalTesPegawai;
use App\Models\JadwalAwalTesSimulasi;
use App\Models\JadwalAwalTesSimulasiPegawai;
use App\Models\Pegawai;
use App\Models\JadwalAcara;
use App\Models\JadwalAsesor;
use App\Models\JadwalPegawai;
use App\Models\Log;
use App\Models\SettingJadwal;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\IOFactory;

//buat panggil fungsi
use App\Helper\StringFunc;
use App\Helper\DateFunc;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SatuanKerjaController;
use Session;


use Carbon\Carbon;

class SettingAwalController extends Controller
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
        Route::get('/app/setting_awal/index', [SettingAwalController::class,'index']);
        Route::get('/app/setting_awal/edit/{view?}/{id?}/{iddll?}', [SettingAwalController::class,'addviewEdit']);
        Route::get('/app/setting_awal/add/{id?}/{view?}', [SettingAwalController::class,'addview']);
        Route::get('/app/setting_awal/hapustanggal/{id?}/{view?}', [SettingAwalController::class,'addviewhapustanggal']);
        Route::get('/app/setting_awal/undangan/{id?}/{view?}', [SettingAwalController::class,'addviewundangan']);
        Route::get('/app/setting_awal/simulasi/{id?}/{view?}', [SettingAwalController::class,'addviewsimulasi']);
        Route::get('/app/setting_awal/lookup/formula/{id?}/{view?}', [SettingAwalController::class,'addviewlookupFormula']);
        Route::get('/app/setting_awal/lookup/pegawai/{id?}/{filter?}', [SettingAwalController::class,'addviewlookupPegawai']);
        Route::get('/app/setting_awal/lookup/pegawaisimulasi/{id?}/{filter?}', [SettingAwalController::class,'addviewlookupPegawaiSimulasi']);
        Route::get('/app/setting_awal/log/{id?}', [SettingAwalController::class,'addviewlog']);
        // Route::get('/app/pegawai/lookup/{link?}/{id?}', [PegawaiController::class,'lookup']);

        //buat route proses
        Route::get('SettingAwal/json/{id?}', [SettingAwalController::class,'json']);
        Route::get('SettingAwal/jsonFormula/{id?}', [SettingAwalController::class,'jsonFormula']);
        Route::get('SettingAwal/jsonpegawai/{id?}/{filter?}', [SettingAwalController::class,'jsonPegawai']);
        Route::get('SettingAwal/jsonsimulasi/{id?}/{filter?}', [SettingAwalController::class,'jsonSimulasi']);
        Route::get('SettingAwal/jsonlog/{id?}/{filter?}', [SettingAwalController::class,'jsonlog']);

        Route::post('SettingAwal/addJadwal', [SettingAwalController::class, 'addJadwal']);
        Route::post('SettingAwal/addUndang', [SettingAwalController::class, 'addUndang']);
        Route::post('SettingAwal/importUndang', [SettingAwalController::class, 'importUndang']);
        Route::post('SettingAwal/addSimulasi', [SettingAwalController::class, 'addSimulasi']);
        Route::post('SettingAwal/addSimulasiSemua/{id?}/{detilid?}', [SettingAwalController::class, 'addSimulasiSemua']);
        // Route::get('Pegawai/json/', [PegawaiController::class,'json']);
        // Route::post('Pegawai/add/{id?}', [PegawaiController::class,'add']);
        Route::delete('SettingAwal/deleteJadwal/{id}',[ SettingAwalController::class, "deleteJadwal" ]);
        Route::delete('SettingAwal/deleteJadwalAwalTes/{id}',[ SettingAwalController::class, "deleteJadwalAwalTes" ]);
        Route::delete('SettingAwal/deleteUndangan/{id}/{pegawaiId}',[ SettingAwalController::class, "deleteUndangan" ]);
        Route::delete('SettingAwal/deleteSimulasi/{id}',[ SettingAwalController::class, "deleteSimulasi" ]);

    }

    public function addJadwal(request $request)
    {
      // buat validasi
      // $validated = $request->validate([
      //       'reqTahun' => 'required',
      //       'reqFormula' => 'required',
      //       'reqKeterangan' => 'required',
      //       'reqTipeFormula' => 'required',
      // ]);

      $reqId= $request->reqId;
      $reqFormula= $request->reqFormula;
      $reqFormulaId= $request->reqFormulaId;
      $reqTanggalMulai= $request->reqTanggalMulai;
      $reqTanggalSelesai= $request->reqTanggalSelesai;
      $reqAcara= $request->reqAcara;
      $reqTempat= $request->reqTempat;
      $reqAlamat= $request->reqAlamat;
      $reqKeterangan= $request->reqKeterangan;
      $reqLimitDRH= $request->reqLimitDRH;

      if(empty($reqId))
      {
        $maxId = JadwalAwalTes::NextId();
        $set = new JadwalAwalTes();
        // nama kolom yang di insert
        $set->jadwal_awal_tes_id = $maxId;
        $set->last_create_user = $this->user->user_app_id;
        $set->last_create_date = Carbon::now();
        $reqId=$maxId;
      }else{           
        $set = JadwalAwalTes::findOrFail($reqId);
        $set->jadwal_awal_tes_id = $reqId;
        $set->last_update_user = $this->user->user_app_id;
        $set->last_update_date = Carbon::now();
      }

      $set->formula_eselon_id =$reqFormulaId;
      $set->tanggal_tes =$reqTanggalMulai;
      $set->tanggal_tes_akhir =$reqTanggalSelesai;
      $set->acara =$reqAcara;
      $set->tempat =$reqTempat;
      $set->alamat =$reqAlamat;
      $set->keterangan =$reqKeterangan;
      $set->limit_drh =$reqLimitDRH;
      $set->save(); 

      $reqfolderjenis= $reqId;
      $filedata= $_FILES["reqPE"];
      // print_r($filedata);exit;
      $folderfilesimpan= "uploads/pe/".$reqfolderjenis;
      if(file_exists($folderfilesimpan)){}
      else
      {
        mkdir($folderfilesimpan);
      }

      $namafile= $filedata["name"];
      $fileType= $filedata["type"];
      $datafileupload= $filedata["tmp_name"];
      $filepath= explode('.',$namafile);
      $longfilepath=count($filepath);
      $filepath=$filepath[$longfilepath-1];

      if($namafile == ""){}
      else
      {
        $penamaanfile= "pe_soal";
        $linkfile= $penamaanfile.".".strtolower($filepath);
        $targetsimpan= $folderfilesimpan."/".$linkfile;

        if (move_uploaded_file($datafileupload, $targetsimpan))
        {

          $set = JadwalAwalTes::findOrFail($reqId);
          $set->jadwal_awal_tes_id = $reqId;
          $set->last_update_user = $this->user->user_app_id;
          $set->last_update_date = Carbon::now();
          $set->link_pe = $linkfile;
          $set->save();
        }
      }

      return StringFunc::json_response(200, $reqId."-Data berhasil disimpan.");

    }

    public function index(request $request) {
     $satuan_kerja = new SatuanKerjaController();
     $jenis='';
     return view("app/setting_awal",compact('jenis'));
    }

    public function addviewlog(request $request) {
      $reqId = $request->route('id');
      // print_r($reqId);exit;
      return view("app/log",compact('reqId'));
    }

    public function json(request $request)
    {
        $reqUnitKerja = $request->input('reqUnitKerja');
        $reqJenis = $request->input('reqJenis');
        // dd($reqUnitKerja);
        $query= new SettingAwal();
        $query=$query->selectByParamsMonitoring();
        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          $btn = '<a href="'.url('app/setting_awal/add/'.$row->jadwal_awal_tes_id).'" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';
          $btn .= '<a onclick=\'deletedata("'.$row->jadwal_awal_tes_id.'")\' data-original-title="Detail" class="btn btn-danger mr-1 btn-sm detailProduct"><span class="fa fa-trash"></span></a>';

          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        
        ->make(true);
    }

    public function jsonlog(request $request)
    {
        $id = $request->route('id');

        $query= new Log();
        $statement=" and log_Uniq='".$id."'";
        $query=$query->selectByParamsMonitoring($statement);
        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          $btn = '';

          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        
        ->make(true);
    }

    public function addview(request $request)
    {
      $reqId=$request->route('id');
      $reqView = $request->route('view');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      // $satker=$satuan_kerja->combo_cabang($request,$reqUnitKerjaId);

      $pg='setting_awal_add';
      if(empty($reqId))
      {
        $query = "";
        // return view('app/pegawai.add', compact('query','jenis','satker','reqUnitKerjaId'));
        return view('app/setting_awal_add', compact('query','reqId','pg'));
      }
      else
      {
        $query = new JadwalAwalTes();
        $statement=" and jadwal_awal_tes_id = ".$reqId;
        $query=$query->selectByParamsMonitoring($statement)->first();
        //buat tes sqli
        // $query=$query->selectByParamsSqlI($reqId)->first();
        return view('app/setting_awal_add', compact('query','reqId','pg'));
      }
    }

    public function addviewEdit(request $request)
    {
      $reqId=$request->route('id');
      $pg = $request->route('view');
      $iddll = $request->route('iddll');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);
      
      // $satker=$satuan_kerja->combo_cabang($request,$reqUnitKerjaId);
      // $pg='setting_awal_hapus_tanggal';

      if(empty($reqId))
      {
        // return view('app/pegawai.add', compact('query','jenis','satker','reqUnitKerjaId'));
        return view('app/setting_awal_edit', compact('query','reqId','iddll','pg'));
      }
      else
      {
        $query = new JadwalTes();
        $statement=' and c.jadwal_awal_tes_id='.$reqId;
        $query=$query->selectByParamsMonitoring($statement);
        //buat tes sqli
        // $query=$query->selectByParamsSqlI($reqId)->first();
        return view('app/setting_awal_edit', compact('query','reqId','iddll','pg'));
      }
    }

    public function addviewhapustanggal(request $request)
    {
      $reqId=$request->route('id');
      $reqView = $request->route('view');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);
      $pg='setting_awal_hapus_tanggal';

      // $satker=$satuan_kerja->combo_cabang($request,$reqUnitKerjaId);

      $query = new JadwalTes();
      $statement=' and a.jadwal_awal_tes_id='.$reqId;
      $query=$query->selectByParamsMonitoring($statement);
      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('app/setting_awal_hapus_tanggal', compact('query','reqId','pg'));
    }

    public function addviewundangan(request $request)
    {
      $reqId=$request->route('id');
      $reqView = $request->route('view');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      // $satker=$satuan_kerja->combo_cabang($request,$reqUnitKerjaId);
      $pg='setting_awal_undangan';
      $query= new JadwalAwalTesPegawai();
      $statement=' AND A.JADWAL_AWAL_TES_ID = '.$reqId;
      $query=$query->selectByParamsMonitoring($statement);
      
      return view('app/setting_awal_undangan', compact('query','reqId','pg'));
    }

    public function addviewsimulasi(request $request)
    {
      $reqId=$request->route('id');
      $reqDetil = $request->route('view');

      $order="";

      $request->merge([
        'reqMode' => 'xxx',
      ]);

      // $satker=$satuan_kerja->combo_cabang($request,$reqUnitKerjaId);
      $pg='setting_awal_simulasi';
      $query = new JadwalAwalTesSimulasiPegawai();
      $statement=' and jadwal_awal_tes_simulasi_id= '.$reqDetil;
      $query=$query->selectByParamsMonitoring($statement);

      $queryInfo = new JadwalAwalTesSimulasi();
      $statement=' and jadwal_awal_tes_simulasi_id= '.$reqDetil;
      $queryInfo=$queryInfo->selectByParamsMonitoring($statement)->first();
      //buat tes sqli
      // $query=$query->selectByParamsSqlI($reqId)->first();
      return view('app/setting_awal_simulasi', compact('query','reqId','pg','reqId','reqDetil','queryInfo'));
    }

    public function deleteJadwal (request $request)
    {
      $reqId = $request->route('id');
      JadwalTes::where('jadwal_tes_id', $reqId)
      ->delete();

      DB::table('jadwal_awal_tes_simulasi')->where('jadwal_awal_tes_simulasi_id', $reqId)->delete();
      
      return StringFunc::json_response(200, "Data berhasil dihapus");

    }

    public function deleteJadwalAwalTes (request $request)
    {
      $reqId = $request->route('id');
      JadwalAwalTes::where('jadwal_awal_tes_id', $reqId)
      ->delete();
      
      return StringFunc::json_response(200, "Data berhasil dihapus");

    }

    public function deleteUndangan (request $request)
    {
      $reqId = $request->route('id');
      $pegawaiId = $request->route('pegawaiId');
      JadwalAwalTesPegawai::where('jadwal_awal_tes_id', $reqId)
      ->where('pegawai_id', $pegawaiId)
      ->delete();
      return StringFunc::json_response(200, "Data berhasil dihapus");

    }

    public function deleteSimulasi (request $request)
    {
      $reqId = $request->route('id');
      JadwalAwalTesSimulasiPegawai::where('jadwal_awal_tes_simulasi_pegawai_id', $reqId)
      ->delete();
      return StringFunc::json_response(200, "Data berhasil dihapus");

    }

    public function lookup(request $request,$link) 
    {
      $satuan_kerja= new SatuanKerjaController();
      $reqUnitKerjaId=$this->CABANG_ID;
      $satker=$satuan_kerja->combo_cabang($request,$reqUnitKerjaId);
      $query= new Pegawai();
      return view('app/pegawai.pegawai_satuan_kerja', compact('query','satker','reqUnitKerjaId'));
    }

    public function addviewlookupFormula(request $request) 
    {
      $query='';
      return view('app/setting_awal_formula_lookup', compact('query'));
    }

     public function jsonFormula(request $request)
    {
        $reqId = $request->route('id');
        // dd($reqUnitKerja);
        $query= new SettingPelaksanaan();

        if(!empty($reqId)){
          $statement=' and a.formula_eselon_id not in ('.$reqId.')';
        }
        else{
          $statement='';
        }

        $query=$query->selectByParamsMonitoringLookop($statement);
        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          $disini="'".$row->formula_nama."'";
          $disini2="'".$row->nama."'";
          $btn = '<a onclick="tampil('.$row->formula_eselon_id.','.$disini.','.$disini2.')" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';

          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        
        ->make(true);
    }

    public function addviewlookupPegawai(request $request) 
    {
      $reqId = $request->route('id');
      $filter = $request->route('filter');
      return view('app/setting_awal_pegawai_lookup', compact('filter','reqId'));
    }

     public function jsonPegawai(request $request)
    {
        $reqId = $request->route('id');
        $reqIdFilter = $request->route('filter');
        // dd($reqUnitKerja);
        // echo $reqId;exit;

        if(!empty($reqIdFilter)){
          $statement=' and a.PEGAWAI_ID not in ('.$reqIdFilter.')';
        }
        else{
          $statement='';
        }

        $query= new JadwalAwalTesPegawai();

        $query=$query->selectByParamsLookup($reqId, $statement);

        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          $disini="'".$row->nama."'";
          $disini2="'".$row->nip_baru."'";
          $btn = '<a onclick="tampil('.$row->idpeg.','.$disini.','.$disini2.')" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';

          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        
        ->make(true);
    }

    public function addUndang(request $request)
    {
      // buat validasi
      // $validated = $request->validate([
      //       'reqTahun' => 'required',
      //       'reqFormula' => 'required',
      //       'reqKeterangan' => 'required',
      //       'reqTipeFormula' => 'required',
      // ]);

      $reqId= $request->reqId;
      $reqPegawaiId= $request->reqPegawaiId;
      $reqPegawaiTesId= $request->reqPegawaiTesId;
      // print_r($reqPegawaiTesId);exit;

      for($i=0;$i<count($reqPegawaiTesId);$i++){
        if(empty($reqPegawaiTesId[$i]))
        {
          $maxId = JadwalAwalTesPegawai::NextId();
          $set = new JadwalAwalTesPegawai();
          // nama kolom yang di insert
          $set->jadwal_awal_tes_pegawai_id = $maxId;
          $set->last_create_user = $this->user->user_app_id;
          $set->last_create_date = Carbon::now();
        }else{           
          $set = JadwalAwalTesPegawai::findOrFail($reqPegawaiTesId[$i]);
          $set->jadwal_awal_tes_pegawai_id = $reqPegawaiTesId[$i];
          $set->last_update_user = $this->user->user_app_id;
          $set->last_update_date = Carbon::now();
        }
        $set->jadwal_awal_tes_id =$reqId;
        $set->pegawai_id =$reqPegawaiId[$i];
        $set->save(); 
      }

      
      return StringFunc::json_response(200, $reqId."-Data berhasil disimpan.");

    }

    public function importUndang(request $request)
    {
      // buat validasi
      // $validated = $request->validate([
      //       'reqTahun' => 'required',
      //       'reqFormula' => 'required',
      //       'reqKeterangan' => 'required',
      //       'reqTipeFormula' => 'required',
      // ]);
      $reqId= $request->reqId;
      $excelFile= $_FILES["excelFile"];
      $fileTmpPath = $_FILES['excelFile']['tmp_name'];
      if(empty($fileTmpPath)){
        return StringFunc::json_response(200, "xxx--Lampirkan FIle.");
        exit;
      }
      
      // Baca file langsung dari lokasi sementara
      $spreadsheet = IOFactory::load($fileTmpPath);
      $worksheet = $spreadsheet->getActiveSheet();
      // print_r($worksheet);exit;

      $query = new Log();
      $query=$query->selectByParamsUniq()->first();
      $log_Uniq=$query->max;

      $maxId = Log::NextId();
      $set = new Log();
      // nama kolom yang di insert
      $set->log_id = $maxId;
      $set->last_create_user = $this->user->user_app_id;
      $set->last_create_date = Carbon::now();
      $set->log_uniq =$log_Uniq;
      $set->input ='';
      $set->id ='';
      $set->keterangan ='';
      $set->save(); 
      $eror=0;
      $i=1;
      foreach ($worksheet->getRowIterator() as $row) {
        if($i>1){
          $cell = $worksheet->getCell('A' . $row->getRowIndex()); // Ambil data dari kolom A
          $reqNip=htmlspecialchars($cell->getValue());

          $query = new Pegawai();
          $statement=" and nip_baru= '".$reqNip."'";
          $query=$query->selectByParamsMonitoring($statement)->first();
          if(empty($query)){
            $maxId = Log::NextId();
            $set = new Log();
            // nama kolom yang di insert
            $set->log_id = $maxId;
            $set->last_create_user = $this->user->user_app_id;
            $set->last_create_date = Carbon::now();
            $set->log_uniq =$log_Uniq;
            $set->input =$reqNip;
            $set->id =$reqId;
            $set->keterangan ='data tidak ada di database';
            $set->save(); 
            $eror=1;
          }
          else{
            $pegawai_id=$query->pegawai_id;
            
            $query = new JadwalAwalTesPegawai();
            $statement=' and a.pegawai_id= '.$pegawai_id." and jadwal_awal_tes_id=".$reqId;
            $query=$query->selectByParamsMonitoring($statement)->first();

            if(empty($query)){
              $maxId = JadwalAwalTesPegawai::NextId();
              $set = new JadwalAwalTesPegawai();
              // nama kolom yang di insert
              $set->jadwal_awal_tes_pegawai_id = $maxId;
              $set->last_create_user = $this->user->user_app_id;
              $set->last_create_date = Carbon::now();
              $set->jadwal_awal_tes_id =$reqId;
              $set->pegawai_id =$pegawai_id;
              $set->save(); 
            }
            else{
              $jadwal_awal_tes_pegawai_id=$query->jadwal_awal_tes_pegawai_id;
              $maxId = Log::NextId();
              $set = new Log();
              // nama kolom yang di insert
              $set->log_id = $maxId;
              $set->last_create_user = $this->user->user_app_id;
              $set->last_create_date = Carbon::now();
              $set->log_uniq =$log_Uniq;
              $set->input =$reqNip;
              $set->id =$reqId;
              $set->keterangan ='data sudah terdaftar';
              $set->save(); 
              $eror=1;
            }
          }          
        }
        $i++;
      }

      if($eror==0){
        return StringFunc::json_response(200, $reqId."-xxx-Data berhasil disimpan.");
      }
      else{
        return StringFunc::json_response(200, $reqId."-".$log_Uniq."-Data berhasil disimpan. Tetapi ada data yang bermasalah.");
      }

    }



    public function importUndangBaru(Request $request)
    {
        $reqId = $request->reqId;

        // Validasi file ada
        if (!$request->hasFile('excelFile')) {
            return StringFunc::json_response(200, "xxx--Lampirkan File.");
        }

        $file = $request->file('excelFile');
        $spreadsheet = IOFactory::load($file->getRealPath());
        $worksheet = $spreadsheet->getActiveSheet();

        // Ambil log uniq
        $query = new Log();
        $query=$query->selectByParamsUniq()->first();
        $log_Uniq=$query->max;

        // Ambil semua NIP dari file Excel
        $allNip = [];
        $i = 1;
        foreach ($worksheet->getRowIterator() as $row) {
            if ($i > 1) { // skip header
                $reqNip = trim((string) $worksheet->getCell('A' . $row->getRowIndex())->getValue());
                if ($reqNip) {
                    $allNip[] = $reqNip;
                }
            }
            $i++;
        }

        if (empty($allNip)) {
            return StringFunc::json_response(200, "xxx--File kosong.");
        }

        // Ambil data pegawai berdasarkan NIP (sekali query)
        $pegawaiList = Pegawai::whereIn('nip_baru', $allNip)
            ->get(['pegawai_id', 'nip_baru'])
            ->keyBy('nip_baru');

        $pegawaiIds = $pegawaiList->pluck('pegawai_id')->toArray();

        // Ambil data jadwal pegawai yang sudah ada (sekali query)
        $existing = JadwalAwalTesPegawai::whereIn('pegawai_id', $pegawaiIds)
            ->where('jadwal_awal_tes_id', $reqId)
            ->pluck('pegawai_id')
            ->toArray();

        // Array untuk batch insert
        $insertJadwal = [];
        $logInsert = [];
        $eror = 0;

        foreach ($allNip as $nip) {
            if (!isset($pegawaiList[$nip])) {
                // Data pegawai tidak ada
                $logInsert[] = [
                    'log_uniq' => $log_Uniq,
                    'input' => $nip,
                    'id' => $reqId,
                    'keterangan' => 'data tidak ada di database',
                    'last_create_user' => $this->user->user_app_id,
                    'last_create_date' => Carbon::now(),
                ];
                $eror = 1;
            } else {
                $pegawaiId = $pegawaiList[$nip]->pegawai_id;
                if (in_array($pegawaiId, $existing)) {
                    // Sudah terdaftar sebelumnya
                    $logInsert[] = [
                        'log_uniq' => $log_Uniq,
                        'input' => $nip,
                        'id' => $reqId,
                        'keterangan' => 'data sudah terdaftar',
                        'last_create_user' => $this->user->user_app_id,
                        'last_create_date' => Carbon::now(),
                    ];
                    $eror = 1;
                } else {
                    // Data baru → simpan ke jadwal
                    $insertJadwal[] = [
                        'jadwal_awal_tes_id' => $reqId,
                        'pegawai_id' => $pegawaiId,
                        'last_create_user' => $this->user->user_app_id,
                        'last_create_date' => Carbon::now(),
                    ];
                }
            }
        }

        // Eksekusi batch insert
        print_r($insertJadwal);exit;
        if (!empty($insertJadwal)) {
            JadwalAwalTesPegawai::insert($insertJadwal);
        }
        print_r($logInsert);exit;
        if (!empty($logInsert)) {
            Log::insert($logInsert);
        }

        // Response akhir
        if ($eror == 0) {
            return StringFunc::json_response(200, $reqId . "-xxx-Data berhasil disimpan.");
        } else {
            return StringFunc::json_response(200, $reqId . "-" . $log_Uniq . "-Data berhasil disimpan. Tetapi ada data yang bermasalah.");
        }
    }

    public function addviewlookupPegawaiSimulasi(request $request) 
    {
      $reqId = $request->route('id');
      $filter = $request->route('filter');
      $query='';
      return view('app/setting_awal_simulasi_lookup', compact('filter','reqId'));
    }

    public function jsonSimulasi(request $request)
    {
        $reqId = $request->route('id');
        $reqIdFilter = $request->route('filter');
        // dd($reqUnitKerja);
        // echo $reqId;exit;

        if(!empty($reqIdFilter)){
          $statement=' and a.PEGAWAI_ID not in ('.$reqIdFilter.')';
        }
        else{
          $statement='';
        }

        
        $query= new JadwalAwalTesPegawai();
        $statement.=' AND A.JADWAL_AWAL_TES_ID = '.$reqId.' and a.pegawai_id not in
        (
          select pegawai_id 
          from jadwal_awal_tes_simulasi_pegawai aa
          where aA.JADWAL_AWAL_TES_ID = '.$reqId.'
        )
        ';
        $query=$query->selectByParamsMonitoring($statement);

        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          $disini="'".$row->pegawai_nama."'";
          $disini2="'".$row->pegawai_nip."'";
          $btn = '<a onclick="tampil('.$row->pegawai_id.','.$disini.','.$disini2.')" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';

          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        
        ->make(true);
    }

    public function addSimulasi(request $request)
    {
      // buat validasi
      // $validated = $request->validate([
      //       'reqTahun' => 'required',
      //       'reqFormula' => 'required',
      //       'reqKeterangan' => 'required',
      //       'reqTipeFormula' => 'required',
      // ]);

      $reqId= $request->reqId;
      $reqPegawaiId= $request->reqPegawaiId;
      $reqPegawaiTesId= $request->reqPegawaiTesId;
      $reqDetil= $request->reqDetil;
      $reqBatas= $request->reqBatas;


      $statement=" and jadwal_tes_id=".$reqDetil;
      $query = new SettingJadwal();
      $query=$query->selectByParamsMonitoring($statement)->first();
      $tipe_formula=$query->tipe_formula;

      if($tipe_formula!=1){
        $this->rapidLangsung($reqDetil);
      }

      $set = JadwalAwalTesSimulasi::findOrFail($reqDetil);
      $set->batas_pegawai =$reqBatas;
      $set->save();       

      // print_r($reqPegawaiTesId);exit;
      if(!empty($reqPegawaiTesId)){

        $query= new JadwalAwalTesSimulasi();
        $statement=" and a.jadwal_awal_tes_simulasi_id =".$reqDetil;
        $query=$query->selectByParamsJadwalAwalTesSimulasi($statement)->first();
        // print_r($query);exit;
        if($reqBatas<count($reqPegawaiTesId)){
          return StringFunc::json_response(200, "xxx-".$reqDetil."-Jumlah Pegawai Melebihi Batas.<br> Refresh website agar melihat data pegawai terdaftar terbaru<br> Kuota terisi ".$reqBatas."/".$query->total_terdaftar);
        }
        
        for($i=0;$i<count($reqPegawaiTesId);$i++){
          if(empty($reqPegawaiTesId[$i]))
          {
            $maxId = JadwalAwalTesSimulasiPegawai::NextId();
            $set = new JadwalAwalTesSimulasiPegawai();
            // nama kolom yang di insert
            $set->jadwal_awal_tes_simulasi_pegawai_id = $maxId;
            $set->last_create_user = $this->user->user_app_id;
            $set->last_create_date = Carbon::now();
          }else{           
            $set = JadwalAwalTesSimulasiPegawai::findOrFail($reqPegawaiTesId[$i]);
            $set->jadwal_awal_tes_simulasi_pegawai_id = $reqPegawaiTesId[$i];
            $set->last_update_user = $this->user->user_app_id;
            $set->last_update_date = Carbon::now();
          }
          $set->jadwal_awal_tes_id =$reqId;
          $set->jadwal_awal_tes_simulasi_id =$reqDetil;
          $set->pegawai_id =$reqPegawaiId[$i];
          $set->save();

          if($tipe_formula!=1){
            $query = new JadwalAsesor();
            $statement=' and a.jadwal_tes_id='. $reqDetil;
            $query=$query->selectByParamsMonitoring($statement)->first();        
            $reqJadwalAsesorId=$query->jadwal_asesor_id;
            $maxId = JadwalPegawai::NextId();
            $query = new JadwalPegawai();
            // nama kolom yang di insert
            $query->jadwal_pegawai_id = $maxId;
            $query->last_create_user = $this->user->user_app_id;
            $query->last_create_date = Carbon::now();    
            $query->kelompok_id= '-1';
            $query->id_jadwal= $reqDetil;
            $query->jadwal_asesor_id= $reqJadwalAsesorId;
            $query->penggalian_id= '0';
            $query->pegawai_id= $reqPegawaiId[$i];
              
            $query->save();
          }
 
        }
      }
      
      return StringFunc::json_response(200, $reqId."-".$reqDetil."-Data berhasil disimpan.");

    }

    public function addSimulasiSemua(request $request)
    {
      // buat validasi
      // $validated = $request->validate([
      //       'reqTahun' => 'required',
      //       'reqFormula' => 'required',
      //       'reqKeterangan' => 'required',
      //       'reqTipeFormula' => 'required',
      // ]);

      $reqId = $request->route('id');
      $reqDetil = $request->route('detilid');       

      $statement=" and jadwal_tes_id=".$reqDetil;
      $query = new SettingJadwal();
      $query=$query->selectByParamsMonitoring($statement)->first();
      $tipe_formula=$query->tipe_formula;

      if($tipe_formula!=1){
        $this->rapidLangsung($reqDetil);
      }

      $query= new JadwalAwalTesPegawai();
      $statement=' AND A.JADWAL_AWAL_TES_ID = '.$reqId;
      $query=$query->selectByParamsMonitoring($statement);

      $set = JadwalAwalTesSimulasi::findOrFail($reqDetil);
      $set->batas_pegawai =count($query);
      $set->save();

      $query= new JadwalAwalTesPegawai();
      $statement=' AND A.JADWAL_AWAL_TES_ID = '.$reqId.' and a.pegawai_id not in
      (
        select pegawai_id 
        from jadwal_awal_tes_simulasi_pegawai aa
        where aA.JADWAL_AWAL_TES_ID = '.$reqId.'
      )';
      $query=$query->selectByParamsMonitoring($statement);

      foreach ($query as $key => $value) {
        $maxId = JadwalAwalTesSimulasiPegawai::NextId();
        $set = new JadwalAwalTesSimulasiPegawai();
        // nama kolom yang di insert
        $set->jadwal_awal_tes_simulasi_pegawai_id = $maxId;
        $set->last_create_user = $this->user->user_app_id;
        $set->last_create_date = Carbon::now();
        $set->jadwal_awal_tes_id =$reqId;
        $set->jadwal_awal_tes_simulasi_id =$reqDetil;
        $set->pegawai_id =$value->pegawai_id;
        $set->save(); 
          // print_r($tipe_formula);exit;

        if($tipe_formula!=1){
          $query = new JadwalAsesor();
          $statement=' and a.jadwal_tes_id='. $reqDetil;
          $query=$query->selectByParamsMonitoring($statement)->first();        
          $reqJadwalAsesorId=$query->jadwal_asesor_id;
          $maxId = JadwalPegawai::NextId();
          $query = new JadwalPegawai();
          // nama kolom yang di insert
          $query->jadwal_pegawai_id = $maxId;
          $query->last_create_user = $this->user->user_app_id;
          $query->last_create_date = Carbon::now();    
          $query->kelompok_id= '-1';
          $query->id_jadwal= $reqDetil;
          $query->jadwal_asesor_id= $reqJadwalAsesorId;
          $query->penggalian_id= '0';
          $query->pegawai_id= $value->pegawai_id;
            
          $query->save();
        }

      }
      
      return StringFunc::json_response(200, "Data berhasil disimpan.");
    }

    function rapidLangsung($reqDetil){
      $query = new JadwalAsesor();
      $statement=' and a.jadwal_tes_id='. $reqDetil;
      $query=$query->selectByParamsMonitoring($statement)->first();        

      if(empty($query)){
        $maxId = JadwalAcara::NextId();
        $query = new JadwalAcara();
        // nama kolom yang di insert
        $query->jadwal_acara_id = $maxId;
        $query->last_create_user = $this->user->user_app_id;
        $query->last_create_date = Carbon::now();
        $reqJadwalAcaraId=$maxId;

        $query->jadwal_tes_id= $reqDetil;
        $query->penggalian_id= '0';        
        $query->keterangan= 'rapid';
        $query->save();

        $maxId = JadwalAsesor::NextId();
        $query = new JadwalAsesor();
        // nama kolom yang di insert
        $query->jadwal_asesor_id = $maxId;
        $query->last_create_user = $this->user->user_app_id;
        $query->last_create_date = Carbon::now();

        $query->jadwal_tes_id= $reqDetil;
        $query->jadwal_acara_id= $reqJadwalAcaraId;
        $query->asesor_id='-1';
        $query->batas_pegawai= 1000000000;
        $query->keterangan= 'rapid';
        $query->save();        
      }
    }

}
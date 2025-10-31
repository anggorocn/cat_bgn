<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipeUjian;
use App\Models\BankSoal;
use App\Models\Penggalian;
use App\Models\KegiatanFile;
use App\Models\BankSoalPilihan;
use App\Models\SoalPe;
use App\Models\SoalIntray;
use App\Models\SoalPapi;
use App\Models\JawabanPapi;

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

class SoalController extends Controller
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
        Route::get('/app/soal/index', [SoalController::class,'index']);
        Route::get('/app/soal/index_sjt', [SoalController::class,'index_sjt']);
        Route::get('/app/soal/detil/{id?}', [SoalController::class,'detil']);
        Route::get('/app/soal/detilsjt/{id?}', [SoalController::class,'detilsjt']);
        Route::get('/app/soal/add/{id?}/{soalid?}', [SoalController::class,'addview']);
        Route::get('/app/soal/addgambar/{id?}/{soalid?}', [SoalController::class,'addviewgambar']);
        Route::get('/app/soal/addsjt/{id?}/{soalid?}', [SoalController::class,'addviewsjt']);
        Route::get('/app/soal/index_essay', [SoalController::class,'index_essay']);
        Route::get('/app/soal/detil_essay/{id?}', [SoalController::class,'detil_essay']);
        Route::get('/app/soal/addessay/{kode?}/{id?}', [SoalController::class,'addviewessay']);
        Route::get('/app/soal/index_pe', [SoalController::class,'index_pe']);
        Route::get('/app/soal/detil_pe/{id?}', [SoalController::class,'detil_pe']);
        Route::get('/app/soal/index_intray', [SoalController::class,'index_intray']);
        Route::get('/app/soal/soal_detil_intray/{id?}', [SoalController::class,'soal_detil_intray']);

        //buat route proses
        Route::get('Soal/json/{id?}', [SoalController::class,'json']);
        Route::get('Soal/jsonsjt/{id?}', [SoalController::class,'jsonsjt']);
        Route::get('Soal/jsonpe/{id?}', [SoalController::class,'jsonpe']);
        Route::get('Soal/jsonintray/{id?}', [SoalController::class,'jsonintray']);
        Route::get('Soal/jsondetil/{id?}', [SoalController::class,'jsondetil']);
        Route::get('Soal/jsondetilsjt/{id?}', [SoalController::class,'jsondetilsjt']);
        Route::get('Soal/jsonessay/', [SoalController::class,'jsonessay']);
        Route::get('Soal/jsondetilessay/{id?}', [SoalController::class,'jsondetilessay']);

        Route::post('Soal/Update/', [SoalController::class,'add']);
        Route::post('Soal/addsjt/', [SoalController::class,'addsjt']);
        Route::post('Soal/addessay/{id?}', [SoalController::class,'addessay']);
        Route::post('Soal/addPe/{id?}', [SoalController::class,'addPe']);

        Route::delete('Soal/deleteessay/{id}',[ SoalController::class, "deleteessay" ]);
        Route::delete('Soal/deletejawaban/{id}',[ SoalController::class, "deletejawaban" ]);
        Route::delete('Soal/deleteSoal/{id}',[ SoalController::class, "deletesoal" ]);
        Route::delete('Soal/deletepe/{id}',[ SoalController::class, "deletepe" ]);
        Route::delete('Soal/deleteItr/{id}',[ SoalController::class, "deleteItr" ]);
    }

    public function index(request $request) {
     $jenis='';
     return view("app/master_soal",compact('jenis'));
    }

    public function index_sjt(request $request) {
     $jenis='';
     return view("app/master_soal_sjt",compact('jenis'));
    }

    public function index_pe(request $request) {
     $jenis='';
     return view("app/master_soal_pe",compact('jenis'));
    }

    public function index_intray(request $request) {
     $jenis='';
     return view("app/master_soal_intray",compact('jenis'));
    }

    public function index_intray_detil(request $request) {
     $jenis='';
     return view("app/master_soal_intray_detil",compact('jenis'));
    }

    public function index_essay(request $request) {
     $jenis='';
     return view("app/master_soal_essay",compact('jenis'));
    }

    public function detil(request $request) {
      $reqId=$request->route('id');

      $query= new TipeUjian();
    //   $statement=' and anak = 0 and a.tipe_ujian_id='.$reqId;
      $statement=' and a.tipe_ujian_id='.$reqId;
      $query=$query->selectByParamsMonitoring($statement )->first();

    //   print_r($query);exit;
      return view("app/soal_detil",compact('reqId','query'));
    }

    public function detilsjt(request $request) {
      $reqId=$request->route('id');

      $query= new TipeUjian();
      $statement=' and anak = 0 and a.tipe_ujian_id='.$reqId;
      $query=$query->selectByParamsMonitoring($statement )->first();

      return view("app/soal_detil_sjt",compact('reqId','query'));
    }

    public function detil_essay(request $request) {
      $reqId=$request->route('id');


      $query= new Penggalian();
      $statement=" and kode='".$reqId."'";        
      $query=$query->selectByParams($statement)->first();

      return view("app/soal_detil_essay",compact('reqId','query'));
    }

    public function detil_pe(request $request) {
      $reqId=$request->route('id');

      $query="";

      if(!empty($reqId)){
        $query= new SoalPe();
        $statement=' and soal_pe_id='.$reqId;        
        $query=$query->selectByParamsMonitoring($statement)->first();
      }

      return view("app/soal_detil_pe",compact('reqId','query'));
    }

    public function soal_detil_intray(request $request) {

      $reqId=$request->route('id');
      $reqKode=$request->route('kode');
      
      $query=$queryDetil='';
      
      if(!empty($reqId)){
          $query= new KegiatanFile();
          $statement=' and kegiatan_file_id='.$reqId;
          $query=$query->selectByParamsMonitoring($statement )->first();

          $queryDetil= new SoalIntray();
          $statement=' and kegiatan_file_id='.$reqId;
          $queryDetil=$queryDetil->selectByParamsMonitoring($statement );
      }

      return view("app/soal_detil_intray",compact('reqId','query','queryDetil'));
    }

    public function json(request $request)
    {
        // dd($reqUnitKerja);
        $query= new TipeUjian();
        
        // $arr=array(8,9,10,11,12,13,14,15,7);

        // $statement=" and anak != 0 and keterangan_ujian != 'SJT' and muncul=1";
        $statement=" and keterangan_ujian != 'SJT' and keterangan_ujian != 'ITR' and muncul=1 and anak=0";
        $query=$query->selectByParamsMonitoring($statement);
        // print_r($arr);exit;
        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          $btn = '<a href="'.url('app/soal/detil/'.$row->tipe_ujian_id).'" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';
          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        ->make(true);
    }

    public function jsonsjt(request $request)
    {
        // dd($reqUnitKerja);
        $query= new TipeUjian();
        
        $arr=array(8,9,10,11,12,13,14,15,7);

        $statement=" and anak = 0 and keterangan_ujian = 'SJT'";
        $query=$query->selectByParamsMonitoring($statement);
        // print_r($arr);exit;
        return Datatables::of($query)
        ->addColumn('aksi', function ($row) use ($arr) {
          // $btn='';
          if (in_array($row->tipe_ujian_id, $arr)) {
            $btn='';
          } else {
            $btn = '<a href="'.url('app/soal/detilsjt/'.$row->tipe_ujian_id).'" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';
          }
          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        ->make(true);
    }

    public function jsonpe(request $request)
    {
        
        // dd($reqUnitKerja);
        $query= new SoalPe();
        $query=$query->selectByParamsMonitoring();
        // print_r($arr);exit;
        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          // $btn='';
          $btn = '<a href="'.url('app/soal/detil_pe/'.$row->soal_pe_id).'" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';
            $btn .= '<a onclick=\'deletedata("'.$row->soal_pe_id.'")\' data-original-title="Detail" class="btn btn-danger mr-1 btn-sm detailProduct"><span class="fa fa-trash"></span></a>';
          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        ->make(true);
    }

    public function jsonintray(request $request)
    {
        $reqId=$request->route('id');

        $query= new KegiatanFile();
        $statement=" and jenis ='ITR'";
        $query=$query->selectByParamsMonitoring($statement);
        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
            $btn = '<a href="'.url('app/soal/soal_detil_intray/'.$row->kegiatan_file_id).'" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';
            $btn .= '<a onclick=\'deletedata("'.$row->kegiatan_file_id.'")\' data-original-title="Detail" class="btn btn-danger mr-1 btn-sm detailProduct"><span class="fa fa-trash"></span></a>';
          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        ->make(true);
    }

    public function jsondetil(request $request)
    {
        $reqId=$request->route('id');
        $query= new TipeUjian();
        $statement=" and keterangan_ujian != 'SJT' and muncul=1 and anak=0";
        $statement=' and tipe_ujian_id ='.$reqId;

        $query=$query->selectByParamsMonitoring($statement)->first();
        $jenis=$query->keterangan_ujian;

        if($jenis=='B1'){

          $query= new SoalPapi();
          $statement=' and tipe_ujian_id ='.$reqId;
          $query=$query->selectByParamsMonitoring($statement);
          return Datatables::of($query)
          ->editColumn('bank_soal_id', function ($row) {
              return $row->soal_papi_id; // bisa HTML, teks, dsb.
          })
          ->addColumn('fieldcustom', function ($row) use ($jenis) {
              if($jenis=='potential'){
                $path_gambar=str_replace('main/uploads/', 'images/soal/', $row->path_gambar);
                $btn = '<img src="'.$path_gambar.'/'.$row->path_soal.'" height="100px">';
              }
              else{
                $btn = $row->pertanyaan;
              }
            return $btn;
          })
          ->addColumn('aksi', function ($row) use ($jenis) {
              if($jenis=='potential'){
                $btn = '<a href="'.url('app/soal/addgambar/'.$row->tipe_ujian_id.'/'.$row->soal_papi_id).'" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';
              }
              else{
                $btn = '<a href="'.url('app/soal/add/'.$row->tipe_ujian_id.'/'.$row->soal_papi_id).'" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';
              }
            return $btn;
          })
          ->rawColumns(['aksi'])
          ->addIndexColumn()
          ->make(true);
        }
        
        else{
          $query= new BankSoal();
          $statement=' and tipe_ujian_id ='.$reqId;
          $query=$query->selectByParamsMonitoring($statement);
          return Datatables::of($query)
          ->addColumn('fieldcustom', function ($row) use ($jenis) {
              if($jenis=='potential'){
                $path_gambar=str_replace('main/uploads/', 'images/soal/', $row->path_gambar);
                $btn = '<img src="'.$path_gambar.'/'.$row->path_soal.'" height="100px">';
              }
              else{
                $btn = $row->pertanyaan;
              }
            return $btn;
          })
          ->addColumn('aksi', function ($row) use ($jenis) {
              if($jenis=='potential'){
                $btn = '<a href="'.url('app/soal/addgambar/'.$row->tipe_ujian_id.'/'.$row->bank_soal_id).'" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';
              }
              else{
                $btn = '<a href="'.url('app/soal/add/'.$row->tipe_ujian_id.'/'.$row->bank_soal_id).'" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';
              }
            return $btn;
          })
          ->rawColumns(['aksi','fieldcustom'])
          ->addIndexColumn()
          ->make(true);
        }
    }

    public function jsondetilsjt(request $request)
    {
        $reqId=$request->route('id');
        $query= new BankSoal();
        $statement=' and tipe_ujian_id ='.$reqId;
        $query=$query->selectByParamsMonitoring($statement);
        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
            $btn = '<a href="'.url('app/soal/addsjt/'.$row->tipe_ujian_id.'/'.$row->bank_soal_id).'" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';
            $btn .= '<a onclick=\'deletedata("'.$row->bank_soal_id.'")\' data-original-title="Detail" class="btn btn-danger mr-1 btn-sm detailProduct"><span class="fa fa-trash"></span></a>';
          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        ->make(true);
    }

    public function jsondetilessay(request $request)
    {
        $reqId=$request->route('id');

        $query= new KegiatanFile();
        $statement=" and jenis ='".strtoupper($reqId)."'";
        $query=$query->selectByParamsMonitoring($statement);
        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
            $btn = '<a href="'.url('app/soal/addessay/'.$row->jenis.'/'.$row->kegiatan_file_id).'" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';
            $btn .= '<a onclick=\'deletedata("'.$row->kegiatan_file_id.'")\' data-original-title="Detail" class="btn btn-danger mr-1 btn-sm detailProduct"><span class="fa fa-trash"></span></a>';


            if(!empty($row->file)){
              $infolinkfile='template_soal/'.$row->file;
              $btn .= '<a href="'.$infolinkfile.'" target="_blank" data-original-title="Detail" class="btn btn-warning mr-1 btn-sm detailProduct">Lihat File</a>';
            }
          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        ->make(true);
    }

    public function jsonessay(request $request)
    {
        // dd($reqUnitKerja);
        $query= new Penggalian();
        $statement="and kode !='PE'";
        $query=$query->selectByParams($statement);
        // print_r($arr);exit;
        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          // $btn='';
          $btn = '<a href="'.url('app/soal/detil_essay/'.$row->kode).'" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';
          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        ->make(true);
    }

    public function addview(request $request)
    {
      $reqId=$request->route('id');
      $reqSoalId=$request->route('soalid');

      if($reqId==7){
        $query= new SoalPapi();
        $statement=' and a.soal_papi_id='.$reqSoalId;
        $query=$query->selectByParamsMonitoring($statement )->first();

        $queryJawaban= new JawabanPapi();
        $statement=' and a.soal_papi_id='.$reqSoalId;
        $queryJawaban=$queryJawaban->selectByParamsMonitoring($statement );
      }
      else{
        $query= new BankSoal();
        $statement=' and a.bank_soal_id='.$reqSoalId;
        $query=$query->selectByParamsMonitoring($statement )->first();

        $queryJawaban= new BankSoalPilihan();
        $statement=' and a.bank_soal_id='.$reqSoalId;
        $queryJawaban=$queryJawaban->selectByParamsMonitoring($statement );
      }

      return view('app/soal_add', compact('query','reqId','reqSoalId','queryJawaban'));
    }

    public function addviewgambar(request $request)
    {
      $reqId=$request->route('id');
      $reqSoalId=$request->route('soalid');

      $query= new BankSoal();
      $statement=' and a.bank_soal_id='.$reqSoalId;
      $query=$query->selectByParamsMonitoring($statement )->first();

      $queryJawaban= new BankSoalPilihan();
      $statement=' and a.bank_soal_id='.$reqSoalId;
      $queryJawaban=$queryJawaban->selectByParamsMonitoring($statement );
   
      return view('app/soal_add_gambar', compact('query','reqId','reqSoalId','queryJawaban'));
    }

    public function addviewsjt(request $request)
    {
      $reqId=$request->route('id');
      $reqSoalId=$request->route('soalid');
      $query='';
      $queryJawaban='';

      if(!empty($reqSoalId)){
        $query= new BankSoal();
        $statement=' and a.bank_soal_id='.$reqSoalId;
        $query=$query->selectByParamsMonitoring($statement )->first();

        $queryJawaban= new BankSoalPilihan();
        $statement=' and a.bank_soal_id='.$reqSoalId;
        $queryJawaban=$queryJawaban->selectByParamsMonitoring($statement );
      }
   
      return view('app/soal_add_sjt', compact('query','reqId','reqSoalId','queryJawaban'));
    }

    public function addviewessay(request $request)
    {
      $reqId=$request->route('id');
      $reqKode=$request->route('kode');
      
      $query='';
      
      if(!empty($reqId)){
          $query= new KegiatanFile();
          $statement=' and kegiatan_file_id='.$reqId;
          $query=$query->selectByParamsMonitoring($statement )->first();
      }

      return view('app/soal_add_essay', compact('query','reqId','reqKode'));
    }

    public function add(request $request)
    {
      $reqBankSoalId=$request->reqBankSoalId;
      $reqPertanyaan=$request->reqPertanyaan;
      $reqJawabanId=$request->reqJawabanId;
      $reqJawaban=$request->reqJawaban;
         
      $set = BankSoal::findOrFail($reqBankSoalId);
      $set->pertanyaan =$reqPertanyaan;
      $set->last_update_user = $this->user->user_app_id;
      $set->last_update_date = Carbon::now();
      $set->save(); 

      for($i=0;$i<count($reqJawabanId);$i++){
        $set = BankSoalPilihan::findOrFail($reqJawabanId[$i]);
        $set->jawaban =$reqJawaban[$i];
        $set->last_update_user = $this->user->user_app_id;
        $set->last_update_date = Carbon::now();
        $set->save();
      }

      return StringFunc::json_response(200, $reqBankSoalId."-Data berhasil disimpan.");
      
    }

    public function addsjt(request $request)
    {
      $reqBankSoalId=$request->reqBankSoalId;
      $reqPertanyaan=$request->reqPertanyaan;
      $reqKategori=$request->reqKategori;
      $reqJawabanId=$request->reqJawabanId;
      $reqJawaban=$request->reqJawaban;
      $reqId=$request->reqId;
      $reqNilai=$request->reqNilai;

      if(empty($reqBankSoalId))
      {
        $maxId = BankSoal::NextId();
        $set = new BankSoal();
        // nama kolom yang di insert
        $set->bank_soal_id = $maxId;
        $reqBankSoalId=$maxId;
        $set->tipe_ujian_id = $reqId;        
        $set->last_create_user = $this->user->user_app_id;
        $set->last_create_date = Carbon::now();
      }else{           
        $set = BankSoal::findOrFail($reqBankSoalId);
        $set->last_update_user = $this->user->user_app_id;
        $set->last_update_date = Carbon::now();
      }
      $set->pertanyaan =$reqPertanyaan;
      $set->kategori =$reqKategori;
      $set->save(); 

      $totalSoal= new TipeUjian();
      $statement=' and a.tipe_ujian_id='.$reqId;
      $totalSoal=$totalSoal->selectByParamsTotalSoal($statement )->first();
         
      $set = TipeUjian::findOrFail($reqId);      
      $set->total_soal = $totalSoal->total_soal;
      $set->save(); 

      if(!empty($reqJawabanId)){
        for($i=0;$i<count($reqJawabanId);$i++){
          if(empty($reqJawabanId[$i]))
          {
            $maxId = BankSoalPilihan::NextId();
            $set = new BankSoalPilihan();
            // nama kolom yang di insert
            $set->bank_soal_pilihan_id = $maxId;
            $set->last_create_user = $this->user->user_app_id;
            $set->last_create_date = Carbon::now();
          }else{           
            $set = BankSoalPilihan::findOrFail($reqJawabanId[$i]);
            $set->last_update_user = $this->user->user_app_id;
            $set->last_update_date = Carbon::now();
          }
          $set->bank_soal_id = $reqBankSoalId;
          $set->jawaban =$reqJawaban[$i];
          $set->grade_prosentase =$reqNilai[$i];
          $set->save();
        }
      }

      return StringFunc::json_response(200, $reqBankSoalId."-Data berhasil disimpan.");
      
    }

    public function addessay(request $request)
    {
      $reqNama=$request->reqNama;
      $reqKode=$request->reqKode;
      $reqId=$request->reqId;
      $reqNamaItr=$request->reqNamaItr;
      $reqIdItr=$request->reqIdItr;

      if(empty($reqId))
      {
        $maxId = KegiatanFile::NextId();
        $set = new KegiatanFile();
        // nama kolom yang di insert
        $set->kegiatan_file_id = $maxId;
        $reqId=$maxId;
      }else{           
        $set = KegiatanFile::findOrFail($reqId);
      }

      $filedata= $_FILES["reqLinkFile"];
    //   print_r($filedata['name']);exit;
      
      if(!empty($filedata['name'])){
          // print_r($filedata);exit;
          $folderfilesimpan= "template_soal";
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
          $linkfile= md5($reqKode.'-'.$reqId).".".strtolower($filepath);
          // print_r($reqId.'-'.$this->user->pegawai_id);exit;
    
          $targetsimpan= $folderfilesimpan."/".$linkfile;
    
          if (move_uploaded_file($datafileupload, $targetsimpan))
          {
            $set->nama =$reqNama;
            $set->jenis =$reqKode;
            $set->file =$linkfile;
            $set->save();
            // return StringFunc::json_response(200, $reqId."-Data berhasil disimpan.");
          }
          else{
            // return StringFunc::json_response(200, "xxx-Data gagal disimpan.");
          }
      }
      else{
        $set->nama =$reqNama;
        $set->jenis =$reqKode;
        $set->save();
      }

      if(!empty($reqNamaItr)){
          $folderfilesimpan= "template_soal/itr";
          if(file_exists($folderfilesimpan)){}
          else
          {
            mkdir($folderfilesimpan);
          }

          $filedataItr= $_FILES["reqFileItr"];

          for($i=0;$i<count($reqNamaItr);$i++){

            if(empty($reqIdItr[$i]))
            {
              // echo 'xxxx';exit;
              $maxId = SoalIntray::NextId();
              $set = new SoalIntray();
              // nama kolom yang di insert
              $set->kegiatan_file_itr_id = $maxId;
              $reqIdItrSave=$maxId;
            }else{           
              $set = SoalIntray::findOrFail($reqIdItr[$i]);
              $reqIdItrSave=$reqIdItr[$i];
            }
            $namafile= $filedataItr["name"][$i];
            $fileType= $filedataItr["type"][$i];
            $datafileupload= $filedataItr["tmp_name"][$i];
            $filepath= explode('.',$namafile);
            $longfilepath=count($filepath);
            $filepath=$filepath[$longfilepath-1];
            $linkfile= md5($reqId.'-'.$reqIdItrSave).".".strtolower($filepath);
            // print_r($reqId.'-'.$this->user->pegawai_id);exit;
      
            $targetsimpan= $folderfilesimpan."/".$linkfile;
            // print_r($filedataItr["name"]);exit;
      
            if (move_uploaded_file($datafileupload, $targetsimpan))
            {
              $set->keterangan =$reqNamaItr[$i];
              $set->kegiatan_file_id =$reqId;
              $set->file =$linkfile;
              $set->save();
            }
            else{

              $set->keterangan =$reqNamaItr[$i];
              $set->kegiatan_file_id =$reqId;
              // $set->file =$linkfile;
              $set->save();
              // return StringFunc::json_response(200, "xxx-Data gagal disimpan.");
            }
          }
              return StringFunc::json_response(200, $reqId."-Data berhasil disimpan.");


      }
      else{
        return StringFunc::json_response(200, $reqId."-Data berhasil disimpan.");
      }
    }

    public function addPe(request $request)
    {
      $reqPertanyaan=$request->reqPertanyaan;
      $reqNo=$request->reqNo;
      $reqId=$request->reqId;

      $query= new SoalPe();
      $statement=' and no='.$reqNo;     

      if(!empty($reqId)){
        $statement.=' and soal_pe_id !='.$reqId;     
      }   

      $query=$query->selectByParamsMonitoring($statement)->first();
      if(!empty($query)){
        return StringFunc::json_response(200, "xxx-Urutan Sudah Ada.");
      }

      if(empty($reqId))
      {
        $maxId = SoalPe::NextId();
        $set = new SoalPe();
        // nama kolom yang di insert
        $set->soal_pe_id = $maxId;
        $reqId=$maxId;
      }else{           
        $set = SoalPe::findOrFail($reqId);
      }

      $set->soal =$reqPertanyaan;
      $set->no =$reqNo;
      $set->save();
      return StringFunc::json_response(200, $reqId."-Data berhasil disimpan.");
    }

    public function deleteessay($request)
    {
      $reqId = $request;
      KegiatanFile::where('kegiatan_file_id', $reqId)
      ->delete();
      
      return StringFunc::json_response(200, "Data berhasil dihapus");

    }

    public function deleteItr($request)
    {
      $reqId = $request;
      SoalIntray::where('kegiatan_file_itr_id', $reqId)
      ->delete();
      
      return StringFunc::json_response(200, "Data berhasil dihapus");

    }

    public function deletepe($request)
    {
      $reqId = $request;
      SoalPe::where('soal_pe_id', $reqId)
      ->delete();
      
      return StringFunc::json_response(200, "Data berhasil dihapus");

    }

    public function deletejawaban($request)
    {
      $reqId = $request;
      BankSoalPilihan::where('bank_soal_pilihan_id', $reqId)
      ->delete();
      
      return StringFunc::json_response(200, "Data berhasil dihapus");

    }

    public function deleteSoal($request)
    {
      $reqId = $request;
      BankSoal::where('bank_soal_id', $reqId)
      ->delete();
      
      return StringFunc::json_response(200, "Data berhasil dihapus");

    }
}
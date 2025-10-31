<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\SatuanKerja;
use App\Models\UserLogin;
use App\Models\FormulaEselon;
use App\Models\JadwalAwalTesSimulasiPegawai;
use App\Models\JadwalAwalTesSimulasi;

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

class PegawaiController extends Controller
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
        Route::get('/app/pegawai/index', [PegawaiController::class,'index']);
        Route::get('/app/pegawai/add/{id?}/{view?}', [PegawaiController::class,'addview']);
        Route::get('/app/pegawai/daftar/{id?}', [PegawaiController::class,'addviewdaftar']);
        Route::get('/app/pegawai/lookup/{link?}/{id?}', [PegawaiController::class,'lookup']);

        //buat route proses
        Route::get('Pegawai/json/{id?}', [PegawaiController::class,'json']);
        Route::get('Pegawai/json/', [PegawaiController::class,'json']);
        Route::get('Pegawai/jsonHome/', [PegawaiController::class,'jsonHome']);
        Route::get('Pegawai/jsonDaftar/{id?}', [PegawaiController::class,'jsonDaftar']);
        Route::post('Pegawai/add/{id?}', [PegawaiController::class,'add']);
        Route::post('Pegawai/addDRH/{id?}', [PegawaiController::class,'addDRH']);
        Route::post('Pegawai/sinkron', [PegawaiController::class,'sinkron']);
        Route::delete('Pegawai/delete/{id}',[ PegawaiController::class, "delete" ]);

        Route::post('Pegawai/addDaftar/{id?}/{jadwalId?}', [PegawaiController::class,'addDaftar']);
    }

    public function index(request $request) {
     $satuan_kerja = new SatuanKerjaController();
     // $cabangid=$this->CABANG_ID;
     // $satker=$satuan_kerja->combo_cabang($request,$cabangid);

     $jenis=$this->combojenis($request);
     // dd($jenis);
     // return view("app/pegawai/index",compact('satker','cabangid','jenis'));
     return view("app/pegawai",compact('jenis'));
    }

    public function json(request $request)
    {
        $reqUnitKerja = $request->input('reqUnitKerja');
        $reqJenis = $request->input('reqJenis');
        $reqPencarian = isset($_GET['reqPencarian']) ? $_GET['reqPencarian'] : null;
        $statement='';
        if(!empty($reqPencarian)){
          $statement.=" and (UPPER(a.NAMA) like UPPER('%".$reqPencarian."%') OR a.NIP_BARU like '%".$reqPencarian."%')";
        }
        // dd($reqUnitKerja);
        $query= new Pegawai();

        $query=$query->selectByParamsMonitoring($statement);
        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          // $btn='';
          $btn = '<a href="'.url('app/pegawai/add/'.$row->pegawai_id).'" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';
          $btn .= '<a onclick=\'deletedata("'.$row->pegawai_id.'")\' data-original-title="Detail" class="btn btn-danger mr-1 btn-sm detailProduct"><span class="fa fa-trash"></span></a>';

          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        ->editColumn('tgl_lahir', function ($user) {
          return DateFunc::dateToPageCheck($user->tgl_lahir);
        })
        ->make(true);
    }

    public function jsonHome(request $request)
    {
        $query= new Pegawai();
        $statement=" and tanggal_tes <= CURRENT_DATE + INTERVAL '3 days' and b.pegawai_id=".$this->user->pegawai_id." and tanggal_tes > CURRENT_DATE ";
        $query=$query->selectByParamsHome($statement);
        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          // $btn='';
          $btn = '<a href="'.url('app/pegawai/daftar/'.$row->jadwal_awal_tes_id).'" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"> Daftar</span></a>';
          return $btn;
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        ->editColumn('start', function ($user) {
          return DateFunc::getDayMonthYear(DateFunc::datetimeToPage($user->tanggal_tes,'date'));
        })
        ->editColumn('end', function ($user) {
          return DateFunc::getDayMonthYear(DateFunc::datetimeToPage($user->tanggal_tes_akhir,'date'));
        })
        ->editColumn('terdaftar', function ($user) {
          if($user->terdaftar==1){
            return 'Terdaftar';
          }
          else{
            return 'Belum Terdaftar';
          }
        })
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

      $eselon = new Pegawai();
      $eselon=$eselon->selectByParamsEselon();
      
      $satker = new Pegawai();
      $satker=$satker->selectByParamsSatker();

      if(empty($reqId))
      {
        $query = "";
        // return view('app/pegawai.add', compact('query','jenis','satker','reqUnitKerjaId'));
      }
      else
      {
        $query = new Pegawai();
        $statement='and pegawai_id='.$reqId;
        $query=$query->selectByParamsMonitoring($statement)->first();
        //buat tes sqli
        // $query=$query->selectByParamsSqlI($reqId)->first();
      }
      
        return view('app/pegawai_add', compact('query','eselon','reqId','satker'));
    }

    public function addviewdaftar(request $request)
    {
      $reqId=$request->route('id');
      $reqPegawaiId=$this->user->pegawai_id;
      return view('app/pegawai_daftar', compact('reqId','reqPegawaiId'));
    }

    public function jsonDaftar(request $request)
    {
      $reqId=$request->route('id');
      $query= new Pegawai();
      $statement=" and a.jadwal_awal_tes_id =".$reqId;
      $query=$query->selectByParamsJadwalAwalTesSimulasi($statement,$this->user->pegawai_id);
      return Datatables::of($query)
      ->addColumn('aksi', function ($row) {
        // $btn='';
        if($row->terdaftar==1){
          $btn = 'Terdaftar';
        } else if($row->total_terdaftar==$row->batas_pegawai){
          $btn = 'Kuota Penuh';
        } else{
          $btn = '<a onclick="daftar('.$row->jadwal_awal_tes_simulasi_id.')" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"> Daftar</span></a>';
        }
        return $btn;
      })
      ->addColumn('kuota', function ($row) {
        // $btn='';
        $btn = $row->total_terdaftar.'/'.$row->batas_pegawai;
        return $btn;
      })
      ->rawColumns(['aksi'])
      ->addIndexColumn()
      ->editColumn('start', function ($user) {
        return DateFunc::getDayMonthYear(DateFunc::datetimeToPage($user->tanggal_tes,'date'));
      })
      ->make(true);
    }

    public function add(request $request)
    {

      //buat validasi
      $validated = $request->validate([
            'reqNip' => 'required',
            'reqNama' => 'required',
            'reqJabatan' => 'required',
            'reqEselon' => 'required',
            'reqSatker' => 'required',
      ]);

      // dd($request->reqMode);

      $reqId= $request->reqId;
    //   print_r($reqId); exit;
      $reqNip= $request->reqNip;
      $reqNama= $request->reqNama;
      $reqJabatan= $request->reqJabatan;
      $reqEselon= $request->reqEselon;
      $reqSatker= $request->reqSatker;
      
      $setCari = Pegawai::where('nip_baru', $reqNip)
      ->where('pegawai_id', '!=', $reqId)
      ->first();
    //   print_r($setCari);
    //   exit;
      if(!empty($setCari)){
          return StringFunc::json_response(200, "xxx-Nip Sudah Ada");
      }

      if(empty($reqId))
      {
        $maxId = Pegawai::NextId();
        $set = new Pegawai();
        // nama kolom yang di insert
        $set->pegawai_id = $maxId;
        $reqId=$maxId;
      }else{           
        $set = Pegawai::findOrFail($reqId);
        $set->pegawai_id = $reqId;
      }

      $set->nip_baru =$reqNip;
      $set->nama =$reqNama;
      $set->last_jabatan =$reqJabatan;
      $set->last_eselon_id=$reqEselon;
      $set->satker_id=$reqSatker;
      $set->save(); 

      return StringFunc::json_response(200, $reqId."-Data berhasil disimpan.");
      
    }

    public function addDRH(request $request)
    {
      $reqId=$request->route('id');

      $upstatus='';
      $filedata= $_FILES["reqLinkFile"];
      // print_r($filedata);exit;
      $folderfilesimpan= "uploads/drh/".$reqId;
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
      $linkfile= md5($reqId.'-'.$this->user->pegawai_id).".".strtolower($filepath);
      // print_r($reqId.'-'.$this->user->pegawai_id);exit;

      $targetsimpan= $folderfilesimpan."/".$linkfile;


      if (move_uploaded_file($datafileupload, $targetsimpan))
      {
        $upstatus.='DRH';
      }

      if(!empty($_FILES["reqLinkFilePE"])){
        $filedata= $_FILES["reqLinkFilePE"];
        // print_r($filedata);exit;
        $folderfilesimpan= "uploads/pe/".$reqId;
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
        $linkfile= md5($reqId.'-'.$this->user->pegawai_id).".".strtolower($filepath);
        // print_r($reqId.'-'.$this->user->pegawai_id);exit;

        $targetsimpan= $folderfilesimpan."/".$linkfile;

        if (move_uploaded_file($datafileupload, $targetsimpan))
        {
          $upstatus.=' PE';
        }

        if(empty($upstatus)){
          return StringFunc::json_response(200, "xxx-Data gagal disimpan.");
        }
        else{
          return StringFunc::json_response(200, $upstatus." berhasil diupload.");
        }
      }

      if(empty($upstatus)){
        return StringFunc::json_response(200, "xxx-Data gagal disimpan.");
      }
      else{
        return StringFunc::json_response(200, $reqId."-".$upstatus." berhasil diupload.");
      }


      
    }

    public function addDaftar(request $request)
    {
      $reqId=$request->route('id');
      $jadwalId=$request->route('jadwalId');

      $query= new JadwalAwalTesSimulasi();
      $statement=" and a.jadwal_awal_tes_simulasi_id =".$jadwalId;
      $query=$query->selectByParamsJadwalAwalTesSimulasi($statement)->first();
      // print_r($query);exit;
      if($query->batas_pegawai <= $query->total_terdaftar){
        return StringFunc::json_response(200, "xxx-Jumlah Pegawai Melebihi Batas.<br> Refresh website agar melihat data pegawai terdaftar terbaru");
        exit;
      }

      DB::table('jadwal_awal_tes_simulasi_pegawai')
      ->where('jadwal_awal_tes_id', $reqId)
      ->where('pegawai_id', $this->user->pegawai_id)
      ->delete();

      $maxId = JadwalAwalTesSimulasiPegawai::NextId();
      $set = new JadwalAwalTesSimulasiPegawai();
      // nama kolom yang di insert
      $set->jadwal_awal_tes_simulasi_pegawai_id = $maxId;
      $set->last_create_user = $this->user->pegawai_id;
      $set->last_create_date = Carbon::now();
      $set->jadwal_awal_tes_id =$reqId;
      $set->jadwal_awal_tes_simulasi_id = $jadwalId;
      $set->pegawai_id =$this->user->pegawai_id;
      $set->save(); 
      return StringFunc::json_response(200,"1-Berhasil Mendaftar");
      
    }

    public function delete($request)
    {
      $reqId = $request;
      Pegawai::where('pegawai_id', $reqId)
      ->delete();

      DB::table('user_app')->where('pegawai_id', $reqId)->delete();
      
      return StringFunc::json_response(200, "Data berhasil dihapus");

    }

    public function combojenis(request $request) {

      $i = 0;

      if(empty($request->reqMode))
      {
        $arr_json[$i]['id']   = "";
        $arr_json[$i]['text'] = "Semua";
        $i++;
      }

      $arr_json[$i]['id']   = "ORGANIK";
      $arr_json[$i]['text'] = "Organik";
      $i++;
      $arr_json[$i]['id']   = "PENSIUN";
      $arr_json[$i]['text'] = "Pensiun";
      $i++;

      return $arr_json;
    }

    public function lookup(request $request,$link) 
    {
      $satuan_kerja= new SatuanKerjaController();
      $reqUnitKerjaId=$this->CABANG_ID;
      $satker=$satuan_kerja->combo_cabang($request,$reqUnitKerjaId);
      $query= new Pegawai();
      return view('app/pegawai.pegawai_satuan_kerja', compact('query','satker','reqUnitKerjaId'));
    }
    
    public function sinkron(){
        // URL API
        $url = "https://apisimpeg.web.bps.go.id/oac?apiKey=dSt1eWFQaXRLT255aGhHU0pIbElPQT09&kategori=view_pegawai_bps";
        // $url = "https://api.example.com/data";
        
        // Inisialisasi cURL
        $ch = curl_init();
        
        // Set opsi cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // agar hasilnya tidak langsung ditampilkan
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Authorization: Bearer TOKEN_API_KAMU' // jika butuh token
        ]);
        
        // Eksekusi dan ambil responsenya
        $response = curl_exec($ch);
        
        // Cek jika ada error
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        } else {
            // Ubah JSON jadi array PHP
            $data = json_decode($response, true);
            // print_r($data); // tampilkan hasilnya
            for($i=0;$i<count($data);$i++){
                
                $query= new Pegawai();
                $statement=" and nip_baru='".$data[$i]['nip']."'";
                $query=$query->selectByParamsMonitoring($statement)->first();
                if(empty($query))
                {
                    $maxId = Pegawai::NextId();
                    $set = new Pegawai();
                    // nama kolom yang di insert
                    $set->pegawai_id = $maxId;
                    $reqId=$maxId;
                }else{           
                    $set = Pegawai::findOrFail($query->pegawai_id);
                    $set->pegawai_id = $query->pegawai_id;
                }
                
                $eselon= new Pegawai();
                $statement=" and nama='".$data[$i]['kelompok_jabatan']."'";
                $eselon=$eselon->selectByParamsEselon($statement)->first();
                if(empty($eselon->eselon_id)){
                    $eselonId='0';
                }
                else{
                    $eselonId=$eselon->eselon_id;
                }
                $tanggalFormatted = date("Y-m-d", strtotime($data[$i]['tgllahir']));
            
                $set->nip_baru =$data[$i]['nip'];
                $set->nama =$data[$i]['namagelar'];
                $set->last_jabatan =$data[$i]['jabatan'];
                $set->last_eselon_id=$eselonId;
                $set->satker_id=$data[$i]['satker_id'];
                $set->tgl_lahir=$tanggalFormatted;
                $set->save(); 
                
            }
        }
        
        // Tutup koneksi cURL
        curl_close($ch);
        return StringFunc::json_response(200,"Berhasil Sinkronisasi");
    }
}
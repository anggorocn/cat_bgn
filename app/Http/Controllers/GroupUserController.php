<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupUser;
use App\Models\SatuanKerja;
use App\Models\UserLogin;
use App\Models\Pegawai;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;

//buat panggil fungsi
use App\Helper\StringFunc;
use App\Helper\DateFunc;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SatuanKerjaController;


// use Carbon\Carbon;

class GroupUserController extends Controller
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
        Route::get('/app/group_user/index', [GroupUserController::class,'index']);
        Route::get('/app/pegawai/lookup/{link?}/{id?}', [GroupUserController::class,'lookup']);

        //buat route proses
        Route::get('GroupUser/json/{id?}', [GroupUserController::class,'json']);

    }

    public function index(request $request) {
     $satuan_kerja = new SatuanKerjaController();
     // $cabangid=$this->CABANG_ID;
     // $satker=$satuan_kerja->combo_cabang($request,$cabangid);

     $jenis=$this->combojenis($request);
     // dd($jenis);
     // return view("app/pegawai/index",compact('satker','cabangid','jenis'));
     return view("app/group_user",compact('jenis'));
    }

    public function json(request $request)
    {
        $reqUnitKerja = $request->input('reqUnitKerja');
        $reqJenis = $request->input('reqJenis');
        // dd($reqUnitKerja);
        $query= new GroupUser();

        $query=$query->selectByParamsMonitoring();
        return Datatables::of($query)
        ->addColumn('aksi', function ($row) {
          $btn = '<a href="'.url('app/pegawai/add/'.$row->user_group_id).'" data-original-title="Detail" class="btn btn-success mr-1 btn-sm detailProduct"><span class="fa fa-edit"></span></a>';
          $btn .= '<a onclick=\'deletedata("'.$row->user_group_id.'")\' data-original-title="Detail" class="btn btn-danger mr-1 btn-sm detailProduct"><span class="fa fa-trash"></span></a>';

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

      $jenis=$this->combojenis($request);
      $satuan_kerja = new SatuanKerjaController();

      // $satker=$satuan_kerja->combo_cabang($request,$reqUnitKerjaId);

      if(empty($reqId))
      {
        $query = "";
        // return view('app/pegawai.add', compact('query','jenis','satker','reqUnitKerjaId'));
        return view('app/pegawai_add', compact('query'));
      }
      else
      {
        $query = new Pegawai();
        $statement='and pegawai_id='.$reqId;
        $query=$query->selectByParamsMonitoring($statement)->first();
        //buat tes sqli
        // $query=$query->selectByParamsSqlI($reqId)->first();
        $satker='';
        $reqUnitKerjaId='';
        return view('app/pegawai_add', compact('query','jenis','satker','reqUnitKerjaId'));
      }
    }

    public function add(request $request)
    {

      //buat validasi
      $validated = $request->validate([
            'reqNip' => 'required',
            'reqNama' => 'required',
            'reqJabatan' => 'required',
            // 'reqUnitKerjaNama' => 'required',
            'reqNamaDirektorat' => 'required',
            'reqJenisPegawai' => 'required',
            'reqEmail' => 'required',
      ]);

      // dd($request->reqMode);

      $infomode= $request->reqMode;
      $infoid= $request->reqId;
      $infonip= $request->reqNip;
      $infounitkerjaid= $request->reqUnitKerjaId;
      $infounitkerjanama= $request->reqUnitKerjaNama;
      $infosatuankerjaid= $request->reqIdDirektorat;
      $infosatuankerjanama= $request->reqNamaDirektorat;
      $infonamapegawai= $this->stringfunc->setQuote($request->reqNama);
      $infoemail= $request->reqEmail;
      $infophone= $request->reqPhone;
      $infojenispegawai= $request->reqJenisPegawai;

      $ubahidpegawai= "";
      if ($infomode=='insert') 
      {
        $pegawai= new Pegawai();
        $cek= $pegawai->getCountByParams(" AND A.PEGAWAI_ID ='".$infonip."'")->first();
        $cek= $cek->rowcount;
        if ($cek != 0) 
        {
          return StringFunc::json_response(400, "xxx-Nip yang anda inputkan sudah digunakan, cek kembali inputan anda.");
          exit();
        }

        $chk= new SatuanKerja();
        $jumlahchk= $chk->getCountByParams(" AND TREE_PARENT = '".$request->reqIdDirektorat."' AND UPPER(NAMA) = '".strtoupper(StringFunc::setQuote($request->reqJabatan))."'");

        $jumlahchk=collect($jumlahchk)->first();

        $jumlahchk= $jumlahchk->rowcount;

        if($jumlahchk > 0)
        {
          return StringFunc::json_response(400, "xxx-Unit Kerja ".$request->reqJabatan." sudah ada.");
          exit();
        }
      }
      else
      {
        $pegawai= new Pegawai();
        $cek= $pegawai->getCountByParams(" AND NOT A.PEGAWAI_ID = '".$infoid."' AND A.PEGAWAI_ID ='".$infonip."'")->first();
        $cek= $cek->rowcount;

        if ($cek != 0) 
        {
          return StringFunc::json_response(400, "xxx-Nip yang anda inputkan sudah digunakan, cek kembali inputan anda.");
          exit();
        }

        if($infonip !== $infoid)
        {
          $ubahidpegawai= "1";
        }
      }

      // DB::enableQueryLog();
      if($infomode=='insert')
      {
        $query= new Pegawai();
        $query->PEGAWAI_ID= $infonip;
        $query->LAST_CREATE_USER = $this->user->pegawai_id;
        $query->LAST_CREATE_DATE = date('Y-m-d');
      }
      else
      {
        $query= Pegawai::findOrFail($infoid);
        $query->PEGAWAI_ID =$request->reqNip;
        $query->LAST_UPDATE_USER = $this->user->pegawai_id;
        $query->LAST_UPDATE_DATE = date('Y-m-d');
      }

      $query->NIP= $infonip;
      $query->NAMA= $infonamapegawai;
      $query->JABATAN= $request->reqJabatan;
      $query->SATUAN_KERJA_ID= $infounitkerjaid;
      $query->SATUAN_KERJA= $this->stringfunc->setQuote($infounitkerjanama);
      $query->DEPARTEMEN_ID= $infosatuankerjaid;
      $query->DEPARTEMEN= $this->stringfunc->setQuote($infosatuankerjanama);
      $query->JENIS_PEGAWAI= $infojenispegawai;
      $query->EMAIL= $infoemail;
      $query->PHONE= $infophone;
        
      $query->save();

      // dd(DB::getQueryLog());

      if(!$query)
      {
         return StringFunc::json_response(400, "Data gagal disimpan");
      }
      else
      {
        if(!empty($ubahidpegawai))
        {
          // untuk update data data paraf
          $set= new Pegawai();
          $execsurat= $set->execubahdata($infoid, $infonip);
        }
        else
        {
          if($infojenispegawai == "ORGANIK")
          {
            SatuanKerja::where('SATUAN_KERJA_ID', $infosatuankerjaid)
            ->update([
              'NIP' => $infonip
              , 'NAMA_PEGAWAI' => $infonamapegawai
              , 'EMAIL' => $infoemail
            ]);

            $jumlahuserlogin= UserLogin::where("PEGAWAI_ID", $infonip)->count();
            // echo $jumlahuserlogin;exit;
            if($jumlahuserlogin == 0)
            {
              $nextid= UserLogin::NextId();
              $set= new UserLogin();
              $set->user_login_id= $nextid;
              $set->user_group_id= "PEGAWAI";
              $set->pegawai_id= $infonip;
              $set->satuan_kerja_id_asal= $infosatuankerjaid;
              $set->nama= $infonamapegawai;
              $set->jabatan= $request->reqJabatan;
              $set->email= $infoemail;
              $set->telepon= $infophone;
              $set->status= "1";
              $set->user_login= $infonip;
              $set->user_pass= md5($infonip);
              $set->save();
            }

          }
        }

        return StringFunc::json_response(200, $infonip."-Data berhasil disimpan.");
      }
      
    }

    public function delete($reqId)
    {

      $query = Pegawai::findOrFail($reqId);
      $query->delete($reqId);

      if(!$query)
      {
        return StringFunc::json_response(400, "Data gagal dihapus");
      }
      else
      {
        $jumlahcheck= SatuanKerja::where('NIP', $reqId)->count();
        if($jumlahcheck > 0)
        {
          SatuanKerja::where('NIP', $reqId)
          ->update([
            'NIP' => ''
          ]);
        }

        $jumlahcheck= SatuanKerja::where('USER_BANTU', $reqId)->count();
        if($jumlahcheck > 0)
        {
          SatuanKerja::where('USER_BANTU', $reqId)
          ->update([
            'USER_BANTU' => ''
          ]);
        }
        return StringFunc::json_response(200, "Data berhasil dihapus");
      }

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
}
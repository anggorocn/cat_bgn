<?php

namespace App\Http\Controllers;

use App\Models\UserApp;
use App\Models\AsesorBaru;
use App\Models\JadwalAwalTesPegawai;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;

//buat panggil fungsi
use App\Helper\StringFunc;
use App\Helper\DateFunc;
use Session;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class AppController extends Controller
{

  public function __construct()
  {
    $this->middleware(function ($request, $next) {
      $this->user= Session::get('user');

      // $this->ID                   = $this->user->pegawai->pegawai_id;   
      // $this->NAMA                 = $this->user->pegawai->nama;   
      // $this->JABATAN              = $this->user->pegawai->jabatan;   
      // $this->HAK_AKSES            = $this->user->pegawai->hak_akses;   
      // $this->LAST_LOGIN           = $this->user->pegawai->last_login;   
      // $this->USERNAME             = $this->user->pegawai->username;  
      // $this->USER_LOGIN_ID        = $this->user->pegawai->user_login_id;  
      // $this->USER_GROUP           = $this->user->USER_GROUP;  
      // $this->MULTIROLE            = $this->user->pegawai->multirole;  
      // $this->CABANG_ID            = $this->user->pegawai->satuan_kerja_id;  
      // $this->CABANG               = $this->user->pegawai->cabang;  
      // $this->SATUAN_KERJA_ID_ASAL= $this->user->SATUAN_KERJA_ID_ASAL;
      // $this->SATUAN_KERJA_ID_ASAL_ASLI= $this->user->SATUAN_KERJA_ID_ASAL_ASLI;
      // $this->SATUAN_KERJA_ASAL    = $this->user->pegawai->satuan_kerja_asal;  
      // $this->SATUAN_KERJA_HIRARKI = $this->user->pegawai->satuan_kerja_hirarki;  
      // $this->SATUAN_KERJA_JABATAN = $this->user->pegawai->satuan_kerja_jabatan;  
      // $this->KD_LEVEL             = $this->user->pegawai->kd_level;  
      // $this->JENIS_KELAMIN        = $this->user->pegawai->jenis_kelamin;
      // $this->KELOMPOK_JABATAN= $this->user->pegawai->satker_model->kelompok_jabatan ?? null;

      return $next($request);
    });  
  }

  public  function index()
  {
    $query1='';
    if($this->user->user_group_id==6){
      $query = new UserApp();
      $statement=" and status_valid is null and a.PEGAWAI_ID = ".$this->user->pegawai_id;
      $query=$query->selectByParamsCekUjian($statement)->first();
      // print_r($query);exit;
      if(!empty($query)){
        $this->user->jadwal_tes_id=$query->jadwal_tes_id;
        $this->user->formula_assesment_id=$query->formula_assesment_id;
        $this->user->formula_eselon_id=$query->formula_eselon_id;
        $this->user->ujian_id=$query->ujian_id;
        $this->user->ujian_pegawai_daftar_id=$query->ujian_pegawai_daftar_id;
        if(empty($query->waktu_mulai)){
            $this->user->waktu_mulai='08:45';
        }
        else{
            $this->user->waktu_mulai=$query->waktu_mulai;
        }
      }
      $query1 = new JadwalAwalTesPegawai();
      $statement="and  A.tanggal_tes - (A.limit_drh || ' days')::INTERVAL <= CURRENT_DATE  and b.pegawai_id=".$this->user->pegawai_id;
      $query1=$query1->selectByParamsJadwalDRH($statement)->first();
      // print_r($query1);exit;
    }
    else if($this->user->user_group_id==2){
      $query = new AsesorBaru();
      $query=$query->selectByParamsJumlahAsesorPegawai('',$this->user->pegawai_id);
      // print_r($query);exit;
    }
    else{
      $query='';
    }
    return view('app/home', compact('query','query1'));
  }
}

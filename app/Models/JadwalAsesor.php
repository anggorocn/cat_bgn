<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use App\Models\UserLogin;
use Illuminate\Support\Facades\DB;
use App\Models\SatuanKerjaFix;
use Illuminate\Support\Str;




class JadwalAsesor extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;

    protected $table = 'jadwal_asesor';

    protected $primaryKey = 'jadwal_asesor_id';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'users_id'
    // ];


    public function scopeNextId($query)
    {
        return $query->max('jadwal_asesor_id') + 1; 
    }

      

    public static function selectByParamsMonitoringLookup($statement="", $order=" ORDER BY A.asesor_id ASC")
    {
        $query="
           select * from asesor a
           WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsMonitoring($statement="", $order=" ORDER BY A.jadwal_asesor_id ASC")
    {
        $query="
           select a.*, b.nama nama_asesor , d.kode, d.nama nama_penggalian, d.penggalian_id,
           (select count(jadwal_pegawai_id ) from jadwal_pegawai x where a. jadwal_asesor_id= x.jadwal_asesor_id) total_terpilih, status_group
           from jadwal_asesor a
           left join asesor b on a.asesor_id=b.asesor_id
           left join jadwal_acara c on a.jadwal_acara_id=c.jadwal_acara_id
           left join penggalian d on c.penggalian_id=d.penggalian_id
           WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsPenggalianPegawai($statement="", $order=" ORDER BY B.KODE ASC")
    {
        $query="
           SELECT
            B.PENGGALIAN_ID, B.NAMA PENGGALIAN_NAMA, B.KODE PENGGALIAN_KODE
        FROM jadwal_pegawai A
        INNER JOIN penggalian B ON A.PENGGALIAN_ID = B.PENGGALIAN_ID
           WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsPenilaianPegawaiAtribut($statement="", $order="")
    {
        $query="
          
        SELECT
            A.JADWAL_PEGAWAI_DETIL_ATRIBUT_ID, A.JADWAL_TES_ID, A.PENGGALIAN_ID, 
            A.JADWAL_PEGAWAI_ID, A.JADWAL_ASESOR_ID, A.ATRIBUT_ID, A.PEGAWAI_ID, 
            A.ASESOR_ID, A.FORM_PERMEN_ID, A.NILAI_STANDAR, A.NILAI, A.GAP, A.CATATAN, 
            A.LAST_CREATE_USER, A.LAST_CREATE_DATE, A.LAST_UPDATE_USER, A.LAST_UPDATE_DATE,
            cast(PENGGALIAN_ID as VARCHAR)||'-'||ATRIBUT_ID PENGGALIAN_ATRIBUT
        FROM jadwal_pegawai_detil_atribut A
           WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsAsesorKompetensi($statement="", $order="")
    {
        $query="
        SELECT 
            F.ATRIBUT_ID, B.ASESOR_ID, C1.PENGGALIAN_ID, B1.NAMA NAMA_ASESOR, F.NAMA ATRIBUT_NAMA
            , A.JADWAL_PEGAWAI_ID, A.JADWAL_ASESOR_ID, F.ASPEK_ID, D.FORM_PERMEN_ID, D.NILAI_STANDAR
        FROM jadwal_pegawai A
        INNER JOIN jadwal_asesor B ON A.JADWAL_ASESOR_ID = B.JADWAL_ASESOR_ID
        INNER JOIN asesor B1 ON B.ASESOR_ID = B1.ASESOR_ID
        INNER JOIN jadwal_tes C ON B.JADWAL_TES_ID = C.JADWAL_TES_ID
        INNER JOIN jadwal_acara C1 ON C1.JADWAL_TES_ID = C.JADWAL_TES_ID AND B.JADWAL_ACARA_ID = C1.JADWAL_ACARA_ID
        INNER JOIN formula_atribut D ON C.FORMULA_ESELON_ID = D.FORMULA_ESELON_ID
        INNER JOIN atribut F ON D.FORM_ATRIBUT_ID = F.ATRIBUT_ID AND D.FORM_PERMEN_ID = F.PERMEN_ID
           WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }
}

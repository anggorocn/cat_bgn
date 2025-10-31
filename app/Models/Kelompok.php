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




class Kelompok extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;

    protected $table = 'kelompok';

    protected $primaryKey = 'kelompok_id';

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
        return $query->max('kelompok_id') + 1; 
    }

    function selectByParams($statement='',  $order="")
    {
        $query="
            SELECT
            * from kelompok A
        WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query;
    }

    public static function selectByParamsMonitoringLookup($jadwaltesid="", $statement='',$order="ORDER BY A.LAST_PANGKAT_ID DESC, COALESCE(A.LAST_ESELON_ID,'99') ASC")
    {
        $query="           
            SELECT 
            A.SATKER_ID KODE_UNKER,
            A.PEGAWAI_ID IDPEG, A.NIP NIP_LAMA, A.NIP_BARU, A.NAMA, A.NIK
            , '' GELAR_DEPAN, '' GELAR_BELAKANG, JENIS_KELAMIN, A.TEMPAT_LAHIR, A.TGL_LAHIR, 
            case A.status_pegawai_id when 1 then 'CPNS' when 2 then 'PNS' when 3 then 'Non ASN' when 4 then 'Pensiun' else '' end STATUS
            , B.KODE NAMA_GOL, A.LAST_TMT_PANGKAT TMT_GOL_AKHIR, C.NAMA NAMA_ESELON, A.LAST_JABATAN NAMA_JAB_STRUKTURAL, '' TELP
            , '' STATUS_KANDIDAT, '' UMUR
            , A.SATKER_ID, D.NAMA SATKER, A.LAST_ESELON_ID ESELON_PENILAIAN
            , SUBSTR(CAST(A.LAST_ESELON_ID AS CHAR),1,1) ESELON_PARENT
            FROM simpeg.pegawai A
            LEFT JOIN simpeg.pangkat B ON A.LAST_PANGKAT_ID = B.PANGKAT_ID
            LEFT JOIN eselon C ON A.LAST_ESELON_ID = C.ESELON_ID
            LEFT JOIN simpeg.satker D ON A.SATKER_ID = D.SATKER_ID
            WHERE 1=1 
                        AND A.PEGAWAI_ID IN (
                        SELECT PEGAWAI_ID
                FROM jadwal_awal_tes_simulasi_pegawai where jadwal_awal_tes_simulasi_id='".$jadwaltesid."' 
                        )
            
            AND A.PEGAWAI_ID NOT IN 
            (
                SELECT PEGAWAI_ID
                FROM kelompok_detil A
                LEFT JOIN kelompok B ON A.kelompok_id = B.kelompok_id
                WHERE 1=1 AND a.JADWAL_TES_ID = '".$jadwaltesid."' 
            )". $statement." ". $order;

          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }



    public static function selectByParamsMonitoringLookupMaster($jadwaltesid="", $statement='',$order="ORDER BY A.nama ASC")
    {
        $query="           
               SELECT 
            a.kelompok_id, nama, COALESCE(total,0) total
            from kelompok a
            left join 
            (
                select kelompok_id,count(*) total
                from kelompok_detil a
                where jadwal_tes_id=".$jadwaltesid."
                GROUP by a.kelompok_id
            )b on a.kelompok_id=b.kelompok_id
            where 1=1  
             ". $statement." ". $order;

          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }
}

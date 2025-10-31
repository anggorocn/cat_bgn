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




class JadwalAwalTesPegawai extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;

    protected $table = 'jadwal_awal_tes_pegawai';

    protected $primaryKey = 'jadwal_awal_tes_pegawai_id';

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
        return $query->max('jadwal_awal_tes_pegawai_id') + 1; 
    }

    public static function selectByParamsMonitoring($statement="", $order=" ORDER BY A1.NIP_BARU ASC")
    {
        $query="
        SELECT A.PEGAWAI_ID, A1.NAMA PEGAWAI_NAMA, A1.NIP_BARU PEGAWAI_NIP, A1.NIK, a.jadwal_awal_tes_pegawai_id
        , B1.KODE PEGAWAI_GOL, C1.NAMA PEGAWAI_ESELON, A1.LAST_JABATAN PEGAWAI_JAB_STRUKTURAL
        , D1.SATKER_ID SATKER_TES_ID, s.nama satker, COALESCE(JD.JUMLAH_DATA,0) JUMLAH_DATA
        FROM jadwal_awal_tes_pegawai A
        INNER JOIN simpeg.pegawai A1 ON A.PEGAWAI_ID = A1.PEGAWAI_ID
        LEFT JOIN simpeg.satker s ON A1.satker_id = s.satker_id
        LEFT JOIN
        (
            SELECT JADWAL_AWAL_TES_ID ROW_CHECK_ID, A.PEGAWAI_ID ROW_CHECK_PEGAWAI_ID, COUNT(1) JUMLAH_DATA
            FROM jadwal_awal_tes_simulasi_pegawai A
            INNER JOIN cat.ujian_pegawai_daftar B ON A.JADWAL_AWAL_TES_SIMULASI_ID = B.JADWAL_TES_ID AND A.PEGAWAI_ID = B.PEGAWAI_ID
            GROUP BY JADWAL_AWAL_TES_ID, A.PEGAWAI_ID
        ) JD ON JADWAL_AWAL_TES_ID = ROW_CHECK_ID AND A.PEGAWAI_ID = ROW_CHECK_PEGAWAI_ID
        LEFT JOIN simpeg.pangkat B1 ON A1.LAST_PANGKAT_ID = B1.PANGKAT_ID
        LEFT JOIN eselon C1 ON A1.LAST_ESELON_ID = C1.ESELON_ID
        LEFT JOIN simpeg.satker D1 ON A1.SATKER_ID = D1.SATKER_ID
        WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsLookup($reqId="", $statement="", $order=" ORDER BY A.LAST_PANGKAT_ID DESC, COALESCE(A.LAST_ESELON_ID,'99') ASC")
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
            --left join jadwal_tes_simulasi_pegawai e on a.pegawai_id = e.pegawai_id and jadwal_tes_id=190
            WHERE 1=1
            
        AND A.LAST_ESELON_ID 
        in
        (
            SELECT
            FE.ESELON_ID
            FROM jadwal_awal_tes JT 
            INNER JOIN 
            (
                select b.FORMULA_ESELON_ID, a.ESELON_ID 
                from formula_eselon a
                inner join (select FORMULA_ESELON_ID, formula_id from formula_eselon) b on a.formula_id = b.formula_id 
                where 1=1
            ) FE ON JT.FORMULA_ESELON_ID = FE.FORMULA_ESELON_ID WHERE 1=1 AND JT.JADWAL_AWAL_TES_ID = ".$reqId."
        )
        AND A.PEGAWAI_ID NOT IN (SELECT A.PEGAWAI_ID FROM jadwal_awal_tes_pegawai A WHERE A.JADWAL_AWAL_TES_ID = ".$reqId.")
        AND A.PEGAWAI_ID NOT IN (SELECT A.PEGAWAI_ID FROM jadwal_awal_tes_simulasi_pegawai A WHERE A.JADWAL_AWAL_TES_ID = ".$reqId.") 
        AND A.PEGAWAI_ID NOT IN (
            SELECT A.PEGAWAI_ID FROM jadwal_awal_tes_simulasi_pegawai A 
            WHERE A.JADWAL_AWAL_TES_ID in ( 
                select JADWAL_AWAL_TES_ID from jadwal_awal_tes_simulasi x 
                where x.tanggal_tes BETWEEN 
                (select tanggal_tes from JADWAL_AWAL_TES where JADWAL_AWAL_TES_ID=".$reqId.") and 
                (select tanggal_tes_akhir from JADWAL_AWAL_TES where JADWAL_AWAL_TES_ID=".$reqId.")
            )
        ) 
        ".$statement.' '.$order;
        //   echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsJadwalDaftar($statement="", $order=" ORDER BY A.TANGGAL_TES DESC ")
    {
        $query="
        SELECT A.* 
        FROM
            jadwal_awal_tes
            A LEFT JOIN jadwal_awal_tes_simulasi_pegawai b ON A.jadwal_awal_tes_id = b.jadwal_awal_tes_id 
        WHERE
            1 = 1 
        ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsJadwalDRH($statement="", $order=" ORDER BY A.TANGGAL_TES DESC ")
    {
        $query="
        SELECT A.* 
        FROM
            jadwal_awal_tes
            A LEFT JOIN jadwal_awal_tes_pegawai b ON A.jadwal_awal_tes_id = b.jadwal_awal_tes_id 
        WHERE
            1 = 1 
        ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }
}

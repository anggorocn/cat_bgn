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

class Penilaian extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;

    protected $table = 'penilaian';

    protected $primaryKey = 'penilaian_id';

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
        return $query->max('penilaian_id') + 1; 
    }


    public static function selectByParamsPenggalianAsesorPegawai($statement="", $statemenIdentias='', $order='ORDER BY C.KODE')
    {
        $query="
           SELECT
            A.JADWAL_ASESOR_ID, A.ASESOR_ID,  z.nama nama_asesor, z.no_sk nip_asesor,  B.PENGGALIAN_ID
            , CASE B.PENGGALIAN_ID WHEN 0 THEN 'Psikotes' ELSE C.NAMA END PENGGALIAN_NAMA
            , CASE B.PENGGALIAN_ID WHEN 0 THEN 'Psikotes' ELSE C.KODE END PENGGALIAN_KODE
            , PENGGALIAN_KODE_ID
            , CASE WHEN PENGGALIAN_KODE_ID IS NOT NULL THEN 1 ELSE 0 END PENGGALIAN_KODE_STATUS
        FROM jadwal_asesor A
        INNER JOIN jadwal_acara B ON A.JADWAL_ACARA_ID = B.JADWAL_ACARA_ID
        LEFT JOIN penggalian C ON C.PENGGALIAN_ID = B.PENGGALIAN_ID
        LEFT JOIN asesor z ON z.asesor_ID = a.Asesor_ID
        LEFT JOIN
        (
            SELECT
                A.JADWAL_TES_ID JT_ID, A.PENGGALIAN_ID PENGGALIAN_KODE_ID
            FROM jadwal_acara A INNER JOIN penggalian C ON C.PENGGALIAN_ID = A.PENGGALIAN_ID
            WHERE 1=1
            AND UPPER(C.KODE) = 'CBI'
            ".$statement."
        ) JT ON B.JADWAL_TES_ID = JT.JT_ID
        WHERE 1=1  
        -- AND CASE WHEN PENGGALIAN_KODE_ID IS NOT NULL THEN 1 ELSE 0 END = 1 
        ".$statemenIdentias." ".$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }
}

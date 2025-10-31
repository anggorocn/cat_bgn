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




class JadwalAwalTesSimulasiPegawai extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;

    protected $table = 'jadwal_awal_tes_simulasi_pegawai';

    protected $primaryKey = 'jadwal_awal_tes_simulasi_pegawai_id';

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
        return $query->max('jadwal_awal_tes_simulasi_pegawai_id') + 1; 
    }


    public static function selectByParamsMonitoring($statement="", $order=" ORDER BY A.jadwal_awal_tes_simulasi_pegawai_id ASC")
    {
        $query="
           select a.*, b.nama pegawai_nama, b.nip_baru pegawai_nip
           FROM jadwal_awal_tes_simulasi_pegawai A 
           left join simpeg.pegawai b on a.pegawai_id = b.pegawai_id WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }
}

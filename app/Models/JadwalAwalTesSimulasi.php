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




class JadwalAwalTesSimulasi extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;

    protected $table = 'jadwal_awal_tes_simulasi';

    protected $primaryKey = 'jadwal_awal_tes_simulasi_id';

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
        return $query->max('jadwal_awal_tes_simulasi_id') + 1; 
    }


    public static function selectByParamsMonitoring($statement="", $order=" ORDER BY A.jadwal_awal_tes_simulasi_id ASC")
    {
        $query="
            select *
            FROM jadwal_awal_tes_simulasi A 
            WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }



    function selectByParamsJadwalAwalTesSimulasi($statement="", $order="ORDER BY TANGGAL_tes DESC")
    { 
      $str = "
      SELECT a.jadwal_awal_tes_simulasi_id, acara , tanggal_tes,count(c.jadwal_awal_tes_simulasi_pegawai_id) total_terdaftar, batas_pegawai
      FROM jadwal_awal_tes_simulasi a 
      LEFT JOIN jadwal_awal_tes_simulasi_pegawai c ON A.jadwal_awal_tes_simulasi_id = c.jadwal_awal_tes_simulasi_id
      WHERE 1 = 1 
      "; 

      $str .= $statement." GROUP BY a.jadwal_awal_tes_simulasi_id,acara, batas_pegawai , tanggal_tes ".$order;
      
      $query = DB::select( $str);
      $query = collect($query);

      // echo($str); exit;

      return $query; 
    }
}

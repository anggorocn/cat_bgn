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




class KelompokDetil extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;

    protected $table = 'kelompok_detil';

    protected $primaryKey = 'kelompok_detil_id';

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
        return $query->max('kelompok_detil_id') + 1; 
    }

    function selectByParams($statement='',  $order="")
    {
        $query="
            SELECT
            a.*, b.nama nama_pegawai, b.nip_baru nip_pegawai from kelompok_detil A
            left join simpeg.pegawai b on a. pegawai_id= b.pegawai_id
        WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query;
    }
}

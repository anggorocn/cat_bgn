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

class SoalPe extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;

    protected $table = 'cat.soal_pe';

    protected $primaryKey = 'soal_pe_id';

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
        return $query->max('soal_pe_id') + 1; 
    }

    public static function selectByParamsMonitoring($statement="", $order=" ORDER BY A.soal_pe_id asc")
    {
        $query="
           select a.*
           FROM cat.Soal_Pe A WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);
        return $query;  
    }

    public static function selectByParamsSoalJawaban($statement="", $pegawai_id='', $ujian_id='', $order=" ORDER BY A.soal_pe_id asc")
    {
        $query="
           select a.*, jp.situasi, jp.kendala, jp.langkah, jp. hasil
           FROM cat.Soal_Pe A 
           left join cat.jawaban_pe jp on a.soal_pe_id=jp.soal_pe_id and pegawai_id=".$pegawai_id." and ujian_id=".$ujian_id."
           WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);
        return $query;  
    }
}

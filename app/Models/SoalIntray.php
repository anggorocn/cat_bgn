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

class SoalIntray extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;

    protected $table = 'kegiatan_file_itr';

    protected $primaryKey = 'kegiatan_file_itr_id';

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
        return $query->max('kegiatan_file_itr_id') + 1; 
    }

    public static function selectByParamsMonitoring($statement="", $order=" ORDER BY A.kegiatan_file_itr_id asc")
    {
        $query="
           select a.*
           FROM kegiatan_file_itr A WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);
        return $query;  
    }

    public static function selectByParamsSoal($statement="",$order=" ORDER BY A.kegiatan_file_itr_id asc")
    {
        $query="
           select a.*
           FROM kegiatan_file_itr A 
           left join essay_soal b on  a.kegiatan_file_id=b.kegiatan_file_id
           where 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);
        return $query;  
    }

    public static function selectByParamsSoalJawaban($statement="",$pegawai_id="",$order=" ORDER BY d.jawaban_itr_id asc")
    {
        $query="
           SELECT A
                .* ,jawaban
            FROM
                kegiatan_file_itr a
                left join essay_soal b on a.kegiatan_file_id=b.kegiatan_file_id
                left join penggalian c on b.penggalian_id=c.penggalian_id
                left join jawaban_itr d on a.kegiatan_file_itr_id=d.kegiatan_file_itr_id and b.ujian_id=d.ujian_id AND pegawai_id = ".$pegawai_id."
           where 1=1 ".$statement." ".$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);
        return $query;  
    }
}

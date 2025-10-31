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

class JawabanItr extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;

    protected $table = 'jawaban_itr';

    protected $primaryKey = 'jawaban_itr_id';

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
           FROM jawaban_itr A WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);
        return $query;  
    }

    public static function selectByParamsPenggalianJawaban($statement="", $order=" ORDER BY A.kegiatan_file_itr_id asc")
    {
        $query="
            select a.*
            FROM jawaban_itr A 
            left join kegiatan_file_itr b on a.kegiatan_file_itr_id=b.kegiatan_file_itr_id
            left join essay_soal c  on b.kegiatan_file_id=c.kegiatan_file_id
            WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);
        return $query;  
    }
}

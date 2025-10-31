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




class EssayJawaban extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;

    protected $table = 'essay_jawaban';

    protected $primaryKey = 'essay_jawaban_id';

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
        return $query->max('essay_jawaban_id') + 1; 
    }



    public static function selectByParamsMonitoring($statement="", $order=" ORDER BY essay_jawaban_id ASC")
    {
        $query="
        select a.*, c.kode penggalian_kode from essay_jawaban a
        left join essay_soal b on a.essay_soal_id= b.essay_soal_id
        left join penggalian c on b.penggalian_id= c.penggalian_id
        WHERE 1=1 ".$statement.' '.$order;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);
        return $query;  
    }
}

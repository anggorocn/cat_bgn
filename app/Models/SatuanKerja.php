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



class SatuanKerja extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'simpeg.satker';

    protected $primaryKey = 'satker_id';

    public function selectByParamsMonitoring($statement='')
    {
      // \DB::enableQueryLog();
      $str = "
      select a.*, count(b.satker_id) total_child
      from simpeg.satker a
      left join simpeg.satker b on a.satker_id=b.satker_id_parent
      WHERE 1 = 1 ".$statement." 
      GROUP BY a.satker_id
      order by a.satker_id::INTEGER asc;";
      // echo $str;exit;

      $query = DB::select( $str);
      $query = collect($query);
      // $query = collect($query)->slice($from, $limit);

      // dd($query);

      return $query; 
    }


    public function selectByParamsMonitoringMax($statement='')
    {
      // \DB::enableQueryLog();
      $str = "
      select max(satker_id)::INTEGER + 1 selanjutnya
      from simpeg.satker 
      WHERE 1 = 1 ".$statement." ";
      // echo $str;exit;

      $query = DB::select( $str);
      $query = collect($query);
      // $query = collect($query)->slice($from, $limit);

      // dd($query);

      return $query; 
    }
   
}

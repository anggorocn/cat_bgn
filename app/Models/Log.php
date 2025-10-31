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



class Log extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'log';

    protected $primaryKey = 'log_id';

    // protected $dates = ['tanggal_lahir'];


    protected $dateFormat = 'd-m-Y';
    // buat ubah primary key ke string
    protected $keyType = 'string';

    // protected $casts = [
    //    'tanggal_lahir' => 'date:d-m-Y',
    // ];

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
        return $query->max('log_id') + 1; 
    }

    function selectByParamsUniq( $order="")
    { 
      $str = "
      select
      coalesce(max(log_uniq),0)+1 max
      FROM log A 
      WHERE 1 = 1 ".$order;
      // echo $str;exit;

      $query = DB::select( $str);
      $query = collect($query);
      // $query = collect($query)->slice($from, $limit);

      // dd($query);

      return $query; 
    }

    function selectByParamsMonitoring($statement='', $order="")
    { 
      $str = "
      select
      *
      FROM log A 
      WHERE id is not null ".$statement." ".$order;
      // echo $str;exit;

      $query = DB::select( $str);
      $query = collect($query);
      // $query = collect($query)->slice($from, $limit);

      // dd($query);

      return $query; 
    }

   
}

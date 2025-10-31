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



class Eselon extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'eselon';

    protected $primaryKey = 'eselon_id';

    public function scopeNextId($query)
    {
        return $query->max('eselon_id') + 1; 
    }

    public function scopeSelectByParamsView($query, $id)
    {
        return $query->where('eselon_id', $id);
    }

    public function selectByParamsMonitoring($statement='')
    {
      // \DB::enableQueryLog();
      $str = "
      select * FROM eselon
      WHERE 1 = 1 ".$statement." order by eselon_id desc";
      // echo $str;exit;

      $query = DB::select( $str);
      $query = collect($query);
      // $query = collect($query)->slice($from, $limit);

      // dd($query);

      return $query; 
    }
  }
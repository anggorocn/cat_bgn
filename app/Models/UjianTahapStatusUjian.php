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




class UjianTahapStatusUjian extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;

    protected $table = 'cat.ujian_tahap_status_ujian';

    protected $primaryKey = 'ujian_tahap_status_ujian_id';

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
        return $query->max('ujian_tahap_status_ujian_id') + 1; 
    }

    function selectByParamsCheck($statement='', $jadwaltesid='',  $order="")
    {
        $query="
            SELECT
            A.UJIAN_PEGAWAI_DAFTAR_ID, A.JADWAL_TES_ID, A.FORMULA_ASSESMENT_ID, A.FORMULA_ESELON_ID
            , A.UJIAN_PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_BANK_SOAL_ID, A.BANK_SOAL_ID
            , A.UJIAN_TAHAP_ID, A.TIPE_UJIAN_ID, A.PEGAWAI_ID, A.BANK_SOAL_PILIHAN_ID
            , A.TANGGAL, A.URUT, b.keterangan_ujian
        FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
        left join cat.tipe_ujian b on a.tipe_ujian_id=b.tipe_ujian_id 
        WHERE 1=1 ".$statement.' '.$order;
        //   echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query;
    }
    
    function checkPreviousTahap($pegawai_id, $jadwal_tes_id, $ujian_tahap_id, $urutan, $list_ujian_tahap) {
        $sedangDikerjakan = UjianTahapPegawai::where('pegawai_id', $pegawai_id)
            ->where('jadwal_tes_id', $jadwal_tes_id)
            ->where('ujian_tahap_id', '!=', $ujian_tahap_id)
            ->orderBy('ujian_tahap_id', 'asc')
            ->pluck('ujian_tahap_id');

        if ($sedangDikerjakan->isEmpty() && $urutan != 1) return false;

        foreach ($list_ujian_tahap as $tahap) {
            if ($tahap == $ujian_tahap_id) return true; 

            $sudahSelesai = UjianTahapStatusUjian::where('pegawai_id', $pegawai_id)
                ->where('jadwal_tes_id', $jadwal_tes_id)
                ->where('ujian_tahap_id', $tahap)
                ->first();

            if (!$sudahSelesai && $tahap != $ujian_tahap_id) {
                return false; // Ada tahap yang belum selesai
            }
        }

        return true; // Semua tahap sebelumnya sudah selesai
    }
}

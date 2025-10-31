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




class PermohonanFile extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;

    protected $table = 'permohonan_file';

    protected $primaryKey = 'permohonan_file_id';

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
        return $query->max('permohonan_file_id') + 1; 
    }

    public static function selectByParamsPenggalian($tahun="",$reqId='', $statement='',$pegawaiId='')
    {
        $query="
        SELECT PENGGALIAN_ID, TAHUN, KODE, a.NAMA, a.KETERANGAN, STATUS_GROUP, STATUS_CBI, STATUS_CAT,
        b.PERMOHONAN_FILE_ID, b.LINK_FILE, b.KETERANGAN keterangan_permohonan, c.LINK_FILE link_jawaban,
        (CASE STATUS_GROUP WHEN '1' THEN 'Ya' ELSE 'Tidak' END) STATUS_GROUP_NAMA,
        (CASE STATUS_CBI WHEN '1' THEN 'Ya' ELSE 'Tidak' END) STATUS_CBI_NAMA,
        (CASE STATUS_CAT WHEN '1' THEN 'Ya' ELSE 'Tidak' END) STATUS_CAT_NAMA
        FROM penggalian A 
        left join PERMOHONAN_FILE b on b.PERMOHONAN_TABLE_ID=".$reqId." and b.PERMOHONAN_TABLE_NAMA='jadwaltes".$reqId."-soal' and b.PEGAWAI_ID=a.kode
        left join PERMOHONAN_FILE c on c.PERMOHONAN_TABLE_ID=".$reqId." and c.PERMOHONAN_TABLE_NAMA='jadwaltes".$reqId."-jawab' and c.PEGAWAI_ID=a.kode||'-".$pegawaiId."'
        WHERE 1=1  AND A.TAHUN = '".$tahun."' AND A.KODE != 'PT' ".$statement." ORDER BY PENGGALIAN_ID ASC";
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsPenggalianNew($tahun="",$reqId='', $statement='',$pegawaiId='')
    {
        $query="
        SELECT a.PENGGALIAN_ID, TAHUN, KODE, a.NAMA, a.KETERANGAN, STATUS_GROUP, STATUS_CBI, STATUS_CAT,
        b.essay_soal_id, b.kegiatan_file_id, c.nama kegiatan_file_nama, c.file kegiatan_file_file
        FROM penggalian A 
        left join essay_soal b on b.penggalian_id=a.penggalian_id and ujian_id=".$reqId."
        left join kegiatan_file c on b.kegiatan_file_id=c.kegiatan_file_id
        inner join (
        SELECT DISTINCT d.penggalian_id
        FROM jadwal_tes A 
        inner join formula_eselon B on a.formula_eselon_id = b.formula_eselon_id
        inner join formula_atribut C on b.formula_eselon_id = c.formula_eselon_id
        left join atribut_penggalian D on c.formula_atribut_id = d.formula_atribut_id
        WHERE A.JADWAL_TES_ID = ".$reqId.") d ON A.PENGGALIAN_ID = d.PENGGALIAN_ID
        WHERE 1=1  AND A.TAHUN = '".$tahun."' AND A.KODE != 'PT' ".$statement." ORDER BY PENGGALIAN_ID ASC";
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsPenggalianUjian($tahun="",$reqId='',$pegawaiId='', $statement='')
    {
        $query="
        SELECT a.PENGGALIAN_ID, TAHUN, KODE, a.NAMA, a.KETERANGAN, STATUS_GROUP, STATUS_CBI, STATUS_CAT,
        b.essay_soal_id, b.kegiatan_file_id, c.nama kegiatan_file_nama, c.file kegiatan_file_file, 
        case when ej.submit=1 then 'tersubmit'
        when  ej.submit is null and essay_jawaban_id is not null then 'tersimpan' 
        else 'kosong' end status
        FROM penggalian A 
        left join essay_soal b on b.penggalian_id=a.penggalian_id and ujian_id=".$reqId."
        left join essay_jawaban ej on b.essay_soal_id=ej.essay_soal_id and pegawai_id=".$pegawaiId."
        left join kegiatan_file c on b.kegiatan_file_id=c.kegiatan_file_id
        inner join (
            SELECT DISTINCT d.penggalian_id
            FROM jadwal_tes A 
            inner join formula_eselon B on a.formula_eselon_id = b.formula_eselon_id
            inner join formula_atribut C on b.formula_eselon_id = c.formula_eselon_id
            left join atribut_penggalian D on c.formula_atribut_id = d.formula_atribut_id
            WHERE A.JADWAL_TES_ID = ".$reqId."
        ) d ON A.PENGGALIAN_ID = d.PENGGALIAN_ID
        WHERE 1=1  AND A.TAHUN = '".$tahun."' AND A.KODE != 'PT' ".$statement." ORDER BY PENGGALIAN_ID ASC";
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParams($statement="")
    {
        $query="
        select *
        FROM permohonan_file A WHERE 1=1  ".$statement;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsMonitoring($statement="",$order='ORDER BY NIP_BARU asc')
    {
        $query="
        SELECT
        A.PEGAWAI_ID, A.NIP_BARU, A.NAMA, A.EMAIL, A.LAST_JABATAN, D1.NAMA SATKER
        , info_bukti_file(JP.JADWAL_AWAL_TES_SIMULASI_ID, A.PEGAWAI_ID) BUKTI_PENDUKUNG
        FROM jadwal_awal_tes_simulasi_pegawai JP
        INNER JOIN simpeg.pegawai A ON A.PEGAWAI_ID = JP.PEGAWAI_ID
        LEFT JOIN simpeg.satker D1 ON A.SATKER_ID = D1.SATKER_ID
        WHERE 1=1
        ".$statement." ".$order;
        
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsFileBaru($statement="",$order='')
    {
        $query="
        select * From kegiatan_file
        WHERE 1=1
        ".$statement." ".$order;
        // echo $query;exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsPenggalianJawaban( $statement='')
    {
        $query="
        select a.* from essay_jawaban a
        left join essay_soal b on a. essay_soal_id=b.essay_soal_id
        left join penggalian c on b. penggalian_id=c.penggalian_id
        WHERE 1=1".$statement;
        //   echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsPenggalianAsesorJawaban( $statement='')
    {
        $query="
        select a.*, c.nama nama_penggalian, c.kode kode_penggalian from essay_jawaban a
        left join essay_soal b on a.essay_soal_id=b.essay_soal_id
        left join penggalian c on b.penggalian_id=c.penggalian_id
        WHERE 1=1".$statement;
          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }
    

    public static function selectByParamsMonitoringHasil($reqId="",$order='ORDER BY NIP_BARU asc')
    {
        $query="
        
        SELECT
        A.PEGAWAI_ID, A.NIP_BARU, A.NAMA, A.EMAIL, A.LAST_JABATAN, D1.NAMA SATKER
        , info_bukti_file(JP.JADWAL_AWAL_TES_SIMULASI_ID, A.PEGAWAI_ID) BUKTI_PENDUKUNG, x.status
        FROM jadwal_awal_tes_simulasi_pegawai JP
        INNER JOIN simpeg.pegawai A ON A.PEGAWAI_ID = JP.PEGAWAI_ID
        LEFT JOIN simpeg.satker D1 ON A.SATKER_ID = D1.SATKER_ID
				left join(
				SELECT string_agg(
					c.nama || ' (' || 
					CASE 
							WHEN submit = 1 THEN 'selesai'
							WHEN submit is null THEN 'Proses'
							ELSE 'Belum'
					END || ')<br>',
					' '
					ORDER BY a.penggalian_id
			) AS status, pegawai_id, ujian_id
			FROM essay_soal a 
			left join essay_jawaban b on a.essay_soal_id=b.essay_soal_id
			left join penggalian c on a.penggalian_id=c.penggalian_id
			WHERE 1=1
         AND a.ujian_id = ".$reqId."
				 GROUP BY pegawai_id ,a.ujian_id
				)x on jp.jadwal_awal_tes_simulasi_id = x.ujian_id and x.PEGAWAI_ID = JP.PEGAWAI_ID
        WHERE 1=1
         AND jp.jadwal_awal_tes_simulasi_id = ".$reqId."
				 
         ".$order;
        
        //   echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }
}

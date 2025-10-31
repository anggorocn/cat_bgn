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

class HasilUjian extends Model
{

    // public static function selectByParamsMonitoringCfitHasilRekapB($jadwaltesid="",$tipeujianid="",$statement="",$statementdetil="", $order="order by NOMOR_URUT_GENERATE asc")
    // {
    //     $query="
    //     SELECT A.*
    //     , CASE
    //     WHEN STATUS_KESIMPULAN = '1' THEN 'Sangat Superior'
    //     WHEN STATUS_KESIMPULAN = '2' THEN 'Superior'
    //     WHEN STATUS_KESIMPULAN = '3' THEN 'Diatas Rata - Rata'
    //     WHEN STATUS_KESIMPULAN = '4' THEN 'Rata - Rata'
    //     WHEN STATUS_KESIMPULAN = '5' THEN 'Dibawah Rata - Rata'
    //     WHEN STATUS_KESIMPULAN = '6' THEN 'Borderline'
    //     WHEN STATUS_KESIMPULAN = '7' THEN 'Intellectual Deficient'
    //     END KESIMPULAN
    //     FROM
    //     (
    //         SELECT
    //             UJIAN_PEGAWAI_DAFTAR_ID, B.UJIAN_ID, B.PEGAWAI_ID, B.FORMULA_ASSESMENT_ID, B.JADWAL_TES_ID
    //             , A.NAMA NAMA_PEGAWAI, A.EMAIL NIP_BARU1, A.NIP_BARU, a.last_jabatan
    //             , CAST(COALESCE(HSL.JUMLAH_SOAL,0) AS NUMERIC) JUMLAH_SOAL
    //             , CAST(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0) AS NUMERIC) JUMLAH_BENAR
    //             , CAST(COALESCE(HSL.JUMLAH_BENAR_0101,0) AS NUMERIC) JUMLAH_BENAR_0101
    //             , CAST(COALESCE(HSL.JUMLAH_BENAR_0102,0) AS NUMERIC) JUMLAH_BENAR_0102
    //             , CAST(COALESCE(HSL.JUMLAH_BENAR_0103,0) AS NUMERIC) JUMLAH_BENAR_0103
    //             , CAST(COALESCE(HSL.JUMLAH_BENAR_0104,0) AS NUMERIC) JUMLAH_BENAR_0104
    //             , HSL.UJIAN_TAHAP_ID, HSL.TIPE_UJIAN_ID
    //             , cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) NILAI_HASIL
    //             , CASE
    //             WHEN CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) >= 130 THEN '1'
    //             WHEN CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) >= 120 AND CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) < 130 THEN '2'
    //             WHEN CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) >= 110 AND CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) < 120 THEN '3'
    //             WHEN CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) >= 90 AND CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) < 110 THEN '4'
    //             WHEN CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) >= 80 AND CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) < 90 THEN '5'
    //             WHEN CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) >= 70 AND CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) < 80 THEN '6'
    //             WHEN CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) <= 69 THEN '7'
    //             END STATUS_KESIMPULAN
    //             , 
    //             JA.NOMOR_URUT NOMOR_URUT_GENERATE
    //             , AA.NAMA NAMA_SATKER
    //         FROM cat.ujian_pegawai_daftar B
    //         INNER JOIN simpeg.pegawai A ON B.PEGAWAI_ID = A.PEGAWAI_ID
    //         LEFT JOIN SIMPEG.SATKER AA ON A.SATKER_ID =AA.SATKER_ID
    //         LEFT JOIN
    //         (
    //             SELECT
    //             A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID, A.ID
    //             , COALESCE(D.JUMLAH_SOAL,0) JUMLAH_SOAL
    //             , COALESCE(A.JUMLAH_BENAR,0) JUMLAH_BENAR_PEGAWAI
    //             , C.UJIAN_TAHAP_ID, C.TIPE_UJIAN_ID
    //             , COALESCE(A1.D_BN,0) JUMLAH_BENAR_0101
    //             , COALESCE(A2.D_BN,0) JUMLAH_BENAR_0102
    //             , COALESCE(A3.D_BN,0) JUMLAH_BENAR_0103
    //             , COALESCE(A4.D_BN,0) JUMLAH_BENAR_0104
    //             FROM
    //             (
    //                 SELECT 
    //                 A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID, A.ID, COUNT(A.PEGAWAI_ID) JUMLAH_BENAR
    //                 FROM
    //                 (
    //                     SELECT A.*
    //                     FROM
    //                     (
    //                         SELECT A.*
    //                         FROM
    //                         (
    //                             SELECT
    //                             A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID, A.TIPE_UJIAN_ID, SUBSTR(TU.ID,1,2) ID, A.BANK_SOAL_ID
    //                             , SUM(GRADE_PROSENTASE) GRADE_PROSENTASE
    //                             , COUNT(1) JUMLAH_CHECK
    //                             FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
    //                             INNER JOIN cat.tipe_ujian TU ON TU.TIPE_UJIAN_ID = A.TIPE_UJIAN_ID
    //                             INNER JOIN 
    //                             (
    //                                 SELECT BANK_SOAL_ID, BANK_SOAL_PILIHAN_ID, JAWABAN, GRADE_PROSENTASE
    //                                 FROM cat.bank_soal_pilihan
    //                             ) C ON A.BANK_SOAL_PILIHAN_ID = C.BANK_SOAL_PILIHAN_ID
    //                             where 1=1 and a.tipe_ujian_id in (12, 13, 14, 15)
    //                             GROUP BY A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID, A.TIPE_UJIAN_ID, SUBSTR(TU.ID,1,2), A.BANK_SOAL_ID
    //                         ) A
    //                         INNER JOIN
    //                         (
    //                             SELECT BANK_SOAL_ID, COUNT(1) JUMLAH_CHECK
    //                             FROM cat.bank_soal_pilihan
    //                             WHERE GRADE_PROSENTASE > 0
    //                             GROUP BY BANK_SOAL_ID
    //                         ) B ON A.BANK_SOAL_ID = B.BANK_SOAL_ID AND A.JUMLAH_CHECK = B.JUMLAH_CHECK
    //                         WHERE GRADE_PROSENTASE = 100
    //                         ORDER BY A.BANK_SOAL_ID
    //                     ) A
    //                 ) A
    //                 WHERE 1=1
    //                 GROUP BY A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID, A.ID
    //             ) A
    //             LEFT JOIN
    //             (
    //                 SELECT
    //                     A.JADWAL_TES_ID D_JTI, A.PEGAWAI_ID D_PID
    //                     , A.FORMULA_ASSESMENT_ID D_FAI, A.PARENT_ID D_ID, COUNT(A.PEGAWAI_ID) D_BN
    //                 FROM
    //                 (
    //                     SELECT
    //                     A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID
    //                     , A.TIPE_UJIAN_ID, TU.ID, SUBSTR(TU.ID,1,2) PARENT_ID, A.BANK_SOAL_ID
    //                     , SUM(GRADE_PROSENTASE) GRADE_PROSENTASE
    //                     , COUNT(1) JUMLAH_CHECK
    //                     FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
    //                     INNER JOIN cat.tipe_ujian TU ON TU.TIPE_UJIAN_ID = A.TIPE_UJIAN_ID
    //                     INNER JOIN 
    //                     (
    //                         SELECT BANK_SOAL_ID, BANK_SOAL_PILIHAN_ID, JAWABAN, GRADE_PROSENTASE
    //                         FROM cat.bank_soal_pilihan
    //                     ) C ON A.BANK_SOAL_PILIHAN_ID = C.BANK_SOAL_PILIHAN_ID
    //                     where 1=1 and a.tipe_ujian_id in (12, 13, 14, 15)
    //                     GROUP BY A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID
    //                     , A.TIPE_UJIAN_ID, TU.ID, SUBSTR(TU.ID,1,2), A.BANK_SOAL_ID
    //                 ) A
    //                 INNER JOIN
    //                 (
    //                     SELECT BANK_SOAL_ID, COUNT(1) JUMLAH_CHECK
    //                     FROM cat.bank_soal_pilihan
    //                     WHERE GRADE_PROSENTASE > 0
    //                     GROUP BY BANK_SOAL_ID
    //                 ) B ON A.BANK_SOAL_ID = B.BANK_SOAL_ID AND A.JUMLAH_CHECK = B.JUMLAH_CHECK
    //                 WHERE GRADE_PROSENTASE = 100
    //                 AND A.ID = '0201'
    //                 GROUP BY A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID, A.PARENT_ID
    //             ) A1 ON A.JADWAL_TES_ID = A1.D_JTI AND A.PEGAWAI_ID = A1.D_PID AND A.FORMULA_ASSESMENT_ID = A1.D_FAI AND A.ID = A1.D_ID
    //             LEFT JOIN
    //             (
    //                 SELECT
    //                     A.JADWAL_TES_ID D_JTI, A.PEGAWAI_ID D_PID
    //                     , A.FORMULA_ASSESMENT_ID D_FAI, A.PARENT_ID D_ID, COUNT(A.PEGAWAI_ID) D_BN
    //                 FROM
    //                 (
    //                     SELECT
    //                     A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID
    //                     , A.TIPE_UJIAN_ID, TU.ID, SUBSTR(TU.ID,1,2) PARENT_ID, A.BANK_SOAL_ID
    //                     , SUM(GRADE_PROSENTASE) GRADE_PROSENTASE
    //                     , COUNT(1) JUMLAH_CHECK
    //                     FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
    //                     INNER JOIN cat.tipe_ujian TU ON TU.TIPE_UJIAN_ID = A.TIPE_UJIAN_ID
    //                     INNER JOIN 
    //                     (
    //                         SELECT BANK_SOAL_ID, BANK_SOAL_PILIHAN_ID, JAWABAN, GRADE_PROSENTASE
    //                         FROM cat.bank_soal_pilihan
    //                     ) C ON A.BANK_SOAL_PILIHAN_ID = C.BANK_SOAL_PILIHAN_ID
    //                     where 1=1 and a.tipe_ujian_id in (12, 13, 14, 15)
    //                     GROUP BY A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID
    //                     , A.TIPE_UJIAN_ID, TU.ID, SUBSTR(TU.ID,1,2), A.BANK_SOAL_ID
    //                 ) A
    //                 INNER JOIN
    //                 (
    //                     SELECT BANK_SOAL_ID, COUNT(1) JUMLAH_CHECK
    //                     FROM cat.bank_soal_pilihan
    //                     WHERE GRADE_PROSENTASE > 0
    //                     GROUP BY BANK_SOAL_ID
    //                 ) B ON A.BANK_SOAL_ID = B.BANK_SOAL_ID AND A.JUMLAH_CHECK = B.JUMLAH_CHECK
    //                 WHERE GRADE_PROSENTASE = 100
    //                 AND A.ID = '0202'
    //                 GROUP BY A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID, A.PARENT_ID
    //             ) A2 ON A.JADWAL_TES_ID = A2.D_JTI AND A.PEGAWAI_ID = A2.D_PID AND A.FORMULA_ASSESMENT_ID = A2.D_FAI AND A.ID = A2.D_ID
    //             LEFT JOIN
    //             (
    //                 SELECT
    //                     A.JADWAL_TES_ID D_JTI, A.PEGAWAI_ID D_PID
    //                     , A.FORMULA_ASSESMENT_ID D_FAI, A.PARENT_ID D_ID, COUNT(A.PEGAWAI_ID) D_BN
    //                 FROM
    //                 (
    //                     SELECT
    //                     A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID
    //                     , A.TIPE_UJIAN_ID, TU.ID, SUBSTR(TU.ID,1,2) PARENT_ID, A.BANK_SOAL_ID
    //                     , SUM(GRADE_PROSENTASE) GRADE_PROSENTASE
    //                     , COUNT(1) JUMLAH_CHECK
    //                     FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
    //                     INNER JOIN cat.tipe_ujian TU ON TU.TIPE_UJIAN_ID = A.TIPE_UJIAN_ID
    //                     INNER JOIN 
    //                     (
    //                         SELECT BANK_SOAL_ID, BANK_SOAL_PILIHAN_ID, JAWABAN, GRADE_PROSENTASE
    //                         FROM cat.bank_soal_pilihan
    //                     ) C ON A.BANK_SOAL_PILIHAN_ID = C.BANK_SOAL_PILIHAN_ID
    //                     where 1=1 and a.tipe_ujian_id in (12, 13, 14, 15)
    //                     GROUP BY A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID
    //                     , A.TIPE_UJIAN_ID, TU.ID, SUBSTR(TU.ID,1,2), A.BANK_SOAL_ID
    //                 ) A
    //                 INNER JOIN
    //                 (
    //                     SELECT BANK_SOAL_ID, COUNT(1) JUMLAH_CHECK
    //                     FROM cat.bank_soal_pilihan
    //                     WHERE GRADE_PROSENTASE > 0
    //                     GROUP BY BANK_SOAL_ID
    //                 ) B ON A.BANK_SOAL_ID = B.BANK_SOAL_ID AND A.JUMLAH_CHECK = B.JUMLAH_CHECK
    //                 WHERE GRADE_PROSENTASE = 100
    //                 AND A.ID = '0203'
    //                 GROUP BY A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID, A.PARENT_ID
    //             ) A3 ON A.JADWAL_TES_ID = A3.D_JTI AND A.PEGAWAI_ID = A3.D_PID AND A.FORMULA_ASSESMENT_ID = A3.D_FAI AND A.ID = A3.D_ID
    //             LEFT JOIN
    //             (
    //                 SELECT
    //                     A.JADWAL_TES_ID D_JTI, A.PEGAWAI_ID D_PID
    //                     , A.FORMULA_ASSESMENT_ID D_FAI, A.PARENT_ID D_ID, COUNT(A.PEGAWAI_ID) D_BN
    //                 FROM
    //                 (
    //                     SELECT
    //                     A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID
    //                     , A.TIPE_UJIAN_ID, TU.ID, SUBSTR(TU.ID,1,2) PARENT_ID, A.BANK_SOAL_ID
    //                     , SUM(GRADE_PROSENTASE) GRADE_PROSENTASE
    //                     , COUNT(1) JUMLAH_CHECK
    //                     FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
    //                     INNER JOIN cat.tipe_ujian TU ON TU.TIPE_UJIAN_ID = A.TIPE_UJIAN_ID
    //                     INNER JOIN 
    //                     (
    //                         SELECT BANK_SOAL_ID, BANK_SOAL_PILIHAN_ID, JAWABAN, GRADE_PROSENTASE
    //                         FROM cat.bank_soal_pilihan
    //                     ) C ON A.BANK_SOAL_PILIHAN_ID = C.BANK_SOAL_PILIHAN_ID
    //                     where 1=1 and a.tipe_ujian_id in (12, 13, 14, 15)
    //                     GROUP BY A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID
    //                     , A.TIPE_UJIAN_ID, TU.ID, SUBSTR(TU.ID,1,2), A.BANK_SOAL_ID
    //                 ) A
    //                 INNER JOIN
    //                 (
    //                     SELECT BANK_SOAL_ID, COUNT(1) JUMLAH_CHECK
    //                     FROM cat.bank_soal_pilihan
    //                     WHERE GRADE_PROSENTASE > 0
    //                     GROUP BY BANK_SOAL_ID
    //                 ) B ON A.BANK_SOAL_ID = B.BANK_SOAL_ID AND A.JUMLAH_CHECK = B.JUMLAH_CHECK
    //                 WHERE GRADE_PROSENTASE = 100
    //                 AND A.ID = '0204'
    //                 GROUP BY A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID, A.PARENT_ID
    //             ) A4 ON A.JADWAL_TES_ID = A4.D_JTI AND A.PEGAWAI_ID = A4.D_PID AND A.FORMULA_ASSESMENT_ID = A4.D_FAI AND A.ID = A4.D_ID
    //             INNER JOIN
    //             (
    //                 SELECT A.FORMULA_ASSESMENT_UJIAN_TAHAP_ID UJIAN_TAHAP_ID, B.ID, A.FORMULA_ASSESMENT_ID, A.TIPE_UJIAN_ID
    //                 FROM formula_assesment_ujian_tahap A
    //                 INNER JOIN cat.tipe_ujian B ON A.TIPE_UJIAN_ID = B.TIPE_UJIAN_ID
    //                 WHERE 1=1
    //                 AND PARENT_ID = '0'
    //             ) C ON A.FORMULA_ASSESMENT_ID = C.FORMULA_ASSESMENT_ID AND A.ID = C.ID
    //             INNER JOIN
    //             (
    //                 SELECT A.FORMULA_ASSESMENT_ID, SUBSTR(TU.ID,1,2) ID, SUM(A.JUMLAH_SOAL_UJIAN_TAHAP) JUMLAH_SOAL
    //                 FROM formula_assesment_ujian_tahap A
    //                 INNER JOIN cat.tipe_ujian TU ON TU.TIPE_UJIAN_ID = A.TIPE_UJIAN_ID
    //                 GROUP BY A.FORMULA_ASSESMENT_ID, SUBSTR(TU.ID,1,2)
    //             ) D ON A.FORMULA_ASSESMENT_ID = D.FORMULA_ASSESMENT_ID AND A.ID = D.ID
    //             WHERE 1=1
    //             AND C.TIPE_UJIAN_ID = ".$tipeujianid."
    //         ) HSL ON HSL.PEGAWAI_ID = B.PEGAWAI_ID AND HSL.JADWAL_TES_ID = B.JADWAL_TES_ID
    //         INNER JOIN
    //         (
    //             SELECT a.NO_URUT NOMOR_URUT, A.PEGAWAI_ID, A.LAST_UPDATE_DATE
    //             FROM jadwal_awal_tes_simulasi_pegawai A
    //             INNER JOIN jadwal_tes B ON JADWAL_AWAL_TES_SIMULASI_ID = JADWAL_TES_ID
    //             WHERE JADWAL_AWAL_TES_SIMULASI_ID = ".$jadwaltesid."
    //         ) JA ON JA.PEGAWAI_ID = A.PEGAWAI_ID
    //         WHERE 1=1
    //     ".$statement." 
    //     ) A
    //     LEFT JOIN 
    //     (
    //         SELECT
    //             X.LOWONGAN_ID, UJIAN_TAHAP_ID, SUM(1) AS JUMLAH_SOAL
    //         FROM cat.ujian_bank_soal X
    //         GROUP BY X.LOWONGAN_ID, UJIAN_TAHAP_ID
    //     ) B ON A.FORMULA_ASSESMENT_ID = B.LOWONGAN_ID AND B.UJIAN_TAHAP_ID = A.UJIAN_TAHAP_ID
    //     WHERE 1=1
    //     ".$statementdetil." ".$order;

    //     DB::statement('SET statement_timeout = 120000');
        
    //     //   echo  $query; exit;
    //     $str = DB::select($query);
    
    //     $query = $str;
    //     $query=collect($query);

    //     return $query; 
    // }
    
    public static function selectByParamsMonitoringCfitHasilRekapB($jadwaltesid="",$tipeujianid="",$statement="",$statementdetil="", $order="order by NOMOR_URUT_GENERATE asc")
    {
        $query = "
            WITH base_data AS (
                SELECT 
                    u.ujian_pegawai_daftar_id, 
                    u.ujian_id, 
                    u.pegawai_id, 
                    u.formula_assesment_id, 
                    u.jadwal_tes_id,
                    p.nama AS nama_pegawai,
                    p.email AS nip_baru1,
                    p.nip_baru,
                    p.last_jabatan,
                    f.formula_assesment_ujian_tahap_id AS ujian_tahap_id,
                    f.tipe_ujian_id,
                    s.nama AS nama_satker
                FROM cat.ujian_pegawai_daftar u
                LEFT JOIN simpeg.pegawai p ON u.pegawai_id = p.pegawai_id
                LEFT JOIN (
                    SELECT formula_assesment_id, formula_assesment_ujian_tahap_id, tipe_ujian_id
                    FROM public.formula_assesment_ujian_tahap
                    WHERE tipe_ujian_id = ".$tipeujianid."
                ) f ON u.formula_assesment_id = f.formula_assesment_id
                LEFT JOIN simpeg.satker s ON p.satker_id = s.satker_id
                WHERE u.jadwal_tes_id = ".$jadwaltesid."
            ),
            -- nomor urut
            nomor_urut AS (
                SELECT A.no_urut AS nomor_urut, A.pegawai_id, A.last_update_date
                FROM jadwal_awal_tes_simulasi_pegawai A
                INNER JOIN jadwal_tes B ON A.jadwal_awal_tes_simulasi_id = B.jadwal_tes_id
                WHERE A.jadwal_awal_tes_simulasi_id = ".$jadwaltesid."
            ),
            -- hitung jumlah soal yang harus dikerjakan
            tipe_dikerjakan AS (
                SELECT DISTINCT pegawai_id, tipe_ujian_id
                FROM cat_pegawai.ujian_pegawai_".$jadwaltesid."
                WHERE bank_soal_pilihan_id IS NOT NULL
                AND tipe_ujian_id IN (12,13,14,15)
            ),
            total_soal AS (
                SELECT d.pegawai_id, SUM(t.total_soal) AS jumlah_soal
                FROM tipe_dikerjakan d
                JOIN cat.tipe_ujian t ON t.tipe_ujian_id = d.tipe_ujian_id
                GROUP BY d.pegawai_id
            ),
            -- agregasi jawaban benar
            jawaban_benar AS (
                SELECT 
                    u.pegawai_id,
                    u.tipe_ujian_id,
                    u.bank_soal_id,
                    SUM(p.grade_prosentase) AS total_persen,
                    COUNT(*) AS jumlah_dipilih,
                    SUM(CASE WHEN p.grade_prosentase > 0 THEN 1 ELSE 0 END) AS jumlah_pilihan_benar
                FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." u
                JOIN cat.bank_soal_pilihan p ON u.bank_soal_pilihan_id = p.bank_soal_pilihan_id
                WHERE u.tipe_ujian_id IN (12,13,14,15)
                GROUP BY u.pegawai_id, u.tipe_ujian_id, u.bank_soal_id
            ),
            -- hitung jumlah kunci benar per soal
            kunci_benar AS (
                SELECT 
                    bank_soal_id,
                    COUNT(*) AS jumlah_kunci
                FROM cat.bank_soal_pilihan
                WHERE grade_prosentase > 0
                GROUP BY bank_soal_id
            ),
            -- join dan hitung benar final
            rekap_benar AS (
                SELECT 
                    j.pegawai_id,
                    SUM(CASE WHEN j.tipe_ujian_id = 12  AND j.total_persen = 100 AND j.jumlah_dipilih = k.jumlah_kunci THEN 1 ELSE 0 END) AS jumlah_benar_0101,
                    SUM(CASE WHEN j.tipe_ujian_id = 13  AND j.total_persen = 100 AND j.jumlah_dipilih = k.jumlah_kunci THEN 1 ELSE 0 END) AS jumlah_benar_0102,
                    SUM(CASE WHEN j.tipe_ujian_id = 14 AND j.total_persen = 100 AND j.jumlah_dipilih = k.jumlah_kunci THEN 1 ELSE 0 END) AS jumlah_benar_0103,
                    SUM(CASE WHEN j.tipe_ujian_id = 15 AND j.total_persen = 100 AND j.jumlah_dipilih = k.jumlah_kunci THEN 1 ELSE 0 END) AS jumlah_benar_0104
                FROM jawaban_benar j
                JOIN kunci_benar k ON j.bank_soal_id = k.bank_soal_id
                GROUP BY j.pegawai_id
            ),
            final_rekap AS (
                SELECT
                    b.*,
                    nu.nomor_urut AS nomor_urut_generate,
                    COALESCE(ts.jumlah_soal, 0) AS jumlah_soal,
                    COALESCE(r.jumlah_benar_0101, 0) 
                    + COALESCE(r.jumlah_benar_0102, 0)
                    + COALESCE(r.jumlah_benar_0103, 0)
                    + COALESCE(r.jumlah_benar_0104, 0) AS jumlah_benar,
                    COALESCE(r.jumlah_benar_0101, 0) AS jumlah_benar_0101,
                    COALESCE(r.jumlah_benar_0102, 0) AS jumlah_benar_0102,
                    COALESCE(r.jumlah_benar_0103, 0) AS jumlah_benar_0103,
                    COALESCE(r.jumlah_benar_0104, 0) AS jumlah_benar_0104
                FROM base_data b
                LEFT JOIN nomor_urut nu ON b.pegawai_id = nu.pegawai_id
                LEFT JOIN total_soal ts ON b.pegawai_id = ts.pegawai_id
                LEFT JOIN rekap_benar r ON b.pegawai_id = r.pegawai_id
            ),
            nilai_iq AS (
                SELECT *, CAST(cat.AMBIL_IQ_NILAI(COALESCE(jumlah_benar,0)) AS NUMERIC) AS nilai_hasil
                FROM final_rekap
            )
            SELECT
                *,
                CASE
                    WHEN nilai_hasil >= 130 THEN '1'
                    WHEN nilai_hasil >= 120 THEN '2'
                    WHEN nilai_hasil >= 110 THEN '3'
                    WHEN nilai_hasil >= 90  THEN '4'
                    WHEN nilai_hasil >= 80  THEN '5'
                    WHEN nilai_hasil >= 70  THEN '6'
                    ELSE '7'
                END AS status_kesimpulan,
                CASE
                    WHEN nilai_hasil >= 130 THEN 'Sangat Superior'
                    WHEN nilai_hasil >= 120 THEN 'Superior'
                    WHEN nilai_hasil >= 110 THEN 'Diatas Rata - Rata'
                    WHEN nilai_hasil >= 90  THEN 'Rata - Rata'
                    WHEN nilai_hasil >= 80  THEN 'Dibawah Rata - Rata'
                    WHEN nilai_hasil >= 70  THEN 'Borderline'
                    ELSE 'Intellectual Deficient'
                END AS kesimpulan
            FROM nilai_iq
            ORDER BY pegawai_id;
        ";

        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsMonitoringCfitHasilRekapA($jadwaltesid="",$tipeujianid="",$statement="",$statementdetil="", $order="order by NOMOR_URUT_GENERATE asc")
    {
        $query="
        SELECT A.*
        , CASE
        WHEN STATUS_KESIMPULAN = '1' THEN 'Sangat Superior'
        WHEN STATUS_KESIMPULAN = '2' THEN 'Superior'
        WHEN STATUS_KESIMPULAN = '3' THEN 'Diatas Rata - Rata'
        WHEN STATUS_KESIMPULAN = '4' THEN 'Rata - Rata'
        WHEN STATUS_KESIMPULAN = '5' THEN 'Dibawah Rata - Rata'
        WHEN STATUS_KESIMPULAN = '6' THEN 'Borderline'
        WHEN STATUS_KESIMPULAN = '7' THEN 'Intellectual Deficient'
        END KESIMPULAN
        FROM
        (
            SELECT
                UJIAN_PEGAWAI_DAFTAR_ID, B.UJIAN_ID, B.PEGAWAI_ID, B.FORMULA_ASSESMENT_ID, B.JADWAL_TES_ID
                , A.NAMA NAMA_PEGAWAI, A.EMAIL NIP_BARU1, A.NIP_BARU, a.last_jabatan
                , CAST(COALESCE(HSL.JUMLAH_SOAL,0) AS NUMERIC) JUMLAH_SOAL
                , CAST(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0) AS NUMERIC) JUMLAH_BENAR
                , CAST(COALESCE(HSL.JUMLAH_BENAR_0101,0) AS NUMERIC) JUMLAH_BENAR_0101
                , CAST(COALESCE(HSL.JUMLAH_BENAR_0102,0) AS NUMERIC) JUMLAH_BENAR_0102
                , CAST(COALESCE(HSL.JUMLAH_BENAR_0103,0) AS NUMERIC) JUMLAH_BENAR_0103
                , CAST(COALESCE(HSL.JUMLAH_BENAR_0104,0) AS NUMERIC) JUMLAH_BENAR_0104
                , HSL.UJIAN_TAHAP_ID, HSL.TIPE_UJIAN_ID
                , cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) NILAI_HASIL
                , CASE
                WHEN CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) >= 130 THEN '1'
                WHEN CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) >= 120 AND CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) < 130 THEN '2'
                WHEN CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) >= 110 AND CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) < 120 THEN '3'
                WHEN CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) >= 90 AND CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) < 110 THEN '4'
                WHEN CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) >= 80 AND CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) < 90 THEN '5'
                WHEN CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) >= 70 AND CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) < 80 THEN '6'
                WHEN CAST(cat.AMBIL_IQ_NILAI(COALESCE(HSL.JUMLAH_BENAR_PEGAWAI,0)) AS NUMERIC) <= 69 THEN '7'
                END STATUS_KESIMPULAN
                , JA.NOMOR_URUT NOMOR_URUT_GENERATE
                , AA.NAMA NAMA_SATKER
            FROM cat.ujian_pegawai_daftar B
            INNER JOIN simpeg.pegawai A ON B.PEGAWAI_ID = A.PEGAWAI_ID
            LEFT JOIN SIMPEG.SATKER AA ON A.SATKER_ID =AA.SATKER_ID
            LEFT JOIN
            (
                SELECT
                A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID, A.ID
                , COALESCE(D.JUMLAH_SOAL,0) JUMLAH_SOAL
                , COALESCE(A.JUMLAH_BENAR,0) JUMLAH_BENAR_PEGAWAI
                , C.UJIAN_TAHAP_ID, C.TIPE_UJIAN_ID
                , COALESCE(A1.D_BN,0) JUMLAH_BENAR_0101
                , COALESCE(A2.D_BN,0) JUMLAH_BENAR_0102
                , COALESCE(A3.D_BN,0) JUMLAH_BENAR_0103
                , COALESCE(A4.D_BN,0) JUMLAH_BENAR_0104
                FROM
                (
                    SELECT 
                    A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID, A.ID, COUNT(A.PEGAWAI_ID) JUMLAH_BENAR
                    FROM
                    (
                        SELECT A.*
                        FROM
                        (
                            SELECT A.*
                            FROM
                            (
                                SELECT
                                A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID, A.TIPE_UJIAN_ID, SUBSTR(TU.ID,1,2) ID, A.BANK_SOAL_ID
                                , SUM(GRADE_PROSENTASE) GRADE_PROSENTASE
                                , COUNT(1) JUMLAH_CHECK
                                FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                                INNER JOIN cat.tipe_ujian TU ON TU.TIPE_UJIAN_ID = A.TIPE_UJIAN_ID
                                INNER JOIN 
                                (
                                    SELECT BANK_SOAL_ID, BANK_SOAL_PILIHAN_ID, JAWABAN, GRADE_PROSENTASE
                                    FROM cat.bank_soal_pilihan
                                ) C ON A.BANK_SOAL_PILIHAN_ID = C.BANK_SOAL_PILIHAN_ID
                                where 1=1 and a.tipe_ujian_id in (8, 9, 10, 11)
                                GROUP BY A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID, A.TIPE_UJIAN_ID, SUBSTR(TU.ID,1,2), A.BANK_SOAL_ID
                            ) A
                            INNER JOIN
                            (
                                SELECT BANK_SOAL_ID, COUNT(1) JUMLAH_CHECK
                                FROM cat.bank_soal_pilihan
                                WHERE GRADE_PROSENTASE > 0
                                GROUP BY BANK_SOAL_ID
                            ) B ON A.BANK_SOAL_ID = B.BANK_SOAL_ID AND A.JUMLAH_CHECK = B.JUMLAH_CHECK
                            WHERE GRADE_PROSENTASE = 100
                            ORDER BY A.BANK_SOAL_ID
                        ) A
                    ) A
                    WHERE 1=1
                    GROUP BY A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID, A.ID
                ) A
                LEFT JOIN
                (
                    SELECT
                        A.JADWAL_TES_ID D_JTI, A.PEGAWAI_ID D_PID
                        , A.FORMULA_ASSESMENT_ID D_FAI, A.PARENT_ID D_ID, COUNT(A.PEGAWAI_ID) D_BN
                    FROM
                    (
                        SELECT
                        A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID
                        , A.TIPE_UJIAN_ID, TU.ID, SUBSTR(TU.ID,1,2) PARENT_ID, A.BANK_SOAL_ID
                        , SUM(GRADE_PROSENTASE) GRADE_PROSENTASE
                        , COUNT(1) JUMLAH_CHECK
                        FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                        INNER JOIN cat.tipe_ujian TU ON TU.TIPE_UJIAN_ID = A.TIPE_UJIAN_ID
                        INNER JOIN 
                        (
                            SELECT BANK_SOAL_ID, BANK_SOAL_PILIHAN_ID, JAWABAN, GRADE_PROSENTASE
                            FROM cat.bank_soal_pilihan
                        ) C ON A.BANK_SOAL_PILIHAN_ID = C.BANK_SOAL_PILIHAN_ID
                        where 1=1 and a.tipe_ujian_id in (8, 9, 10, 11)
                        GROUP BY A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID
                        , A.TIPE_UJIAN_ID, TU.ID, SUBSTR(TU.ID,1,2), A.BANK_SOAL_ID
                    ) A
                    INNER JOIN
                    (
                        SELECT BANK_SOAL_ID, COUNT(1) JUMLAH_CHECK
                        FROM cat.bank_soal_pilihan
                        WHERE GRADE_PROSENTASE > 0
                        GROUP BY BANK_SOAL_ID
                    ) B ON A.BANK_SOAL_ID = B.BANK_SOAL_ID AND A.JUMLAH_CHECK = B.JUMLAH_CHECK
                    WHERE GRADE_PROSENTASE = 100
                    AND A.ID = '0101'
                    GROUP BY A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID, A.PARENT_ID
                ) A1 ON A.JADWAL_TES_ID = A1.D_JTI AND A.PEGAWAI_ID = A1.D_PID AND A.FORMULA_ASSESMENT_ID = A1.D_FAI AND A.ID = A1.D_ID
                LEFT JOIN
                (
                    SELECT
                        A.JADWAL_TES_ID D_JTI, A.PEGAWAI_ID D_PID
                        , A.FORMULA_ASSESMENT_ID D_FAI, A.PARENT_ID D_ID, COUNT(A.PEGAWAI_ID) D_BN
                    FROM
                    (
                        SELECT
                        A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID
                        , A.TIPE_UJIAN_ID, TU.ID, SUBSTR(TU.ID,1,2) PARENT_ID, A.BANK_SOAL_ID
                        , SUM(GRADE_PROSENTASE) GRADE_PROSENTASE
                        , COUNT(1) JUMLAH_CHECK
                        FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                        INNER JOIN cat.tipe_ujian TU ON TU.TIPE_UJIAN_ID = A.TIPE_UJIAN_ID
                        INNER JOIN 
                        (
                            SELECT BANK_SOAL_ID, BANK_SOAL_PILIHAN_ID, JAWABAN, GRADE_PROSENTASE
                            FROM cat.bank_soal_pilihan
                        ) C ON A.BANK_SOAL_PILIHAN_ID = C.BANK_SOAL_PILIHAN_ID
                        where 1=1 and a.tipe_ujian_id in (8, 9, 10, 11)
                        GROUP BY A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID
                        , A.TIPE_UJIAN_ID, TU.ID, SUBSTR(TU.ID,1,2), A.BANK_SOAL_ID
                    ) A
                    INNER JOIN
                    (
                        SELECT BANK_SOAL_ID, COUNT(1) JUMLAH_CHECK
                        FROM cat.bank_soal_pilihan
                        WHERE GRADE_PROSENTASE > 0
                        GROUP BY BANK_SOAL_ID
                    ) B ON A.BANK_SOAL_ID = B.BANK_SOAL_ID AND A.JUMLAH_CHECK = B.JUMLAH_CHECK
                    WHERE GRADE_PROSENTASE = 100
                    AND A.ID = '0102'
                    GROUP BY A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID, A.PARENT_ID
                ) A2 ON A.JADWAL_TES_ID = A2.D_JTI AND A.PEGAWAI_ID = A2.D_PID AND A.FORMULA_ASSESMENT_ID = A2.D_FAI AND A.ID = A2.D_ID
                LEFT JOIN
                (
                    SELECT
                        A.JADWAL_TES_ID D_JTI, A.PEGAWAI_ID D_PID
                        , A.FORMULA_ASSESMENT_ID D_FAI, A.PARENT_ID D_ID, COUNT(A.PEGAWAI_ID) D_BN
                    FROM
                    (
                        SELECT
                        A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID
                        , A.TIPE_UJIAN_ID, TU.ID, SUBSTR(TU.ID,1,2) PARENT_ID, A.BANK_SOAL_ID
                        , SUM(GRADE_PROSENTASE) GRADE_PROSENTASE
                        , COUNT(1) JUMLAH_CHECK
                        FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                        INNER JOIN cat.tipe_ujian TU ON TU.TIPE_UJIAN_ID = A.TIPE_UJIAN_ID
                        INNER JOIN 
                        (
                            SELECT BANK_SOAL_ID, BANK_SOAL_PILIHAN_ID, JAWABAN, GRADE_PROSENTASE
                            FROM cat.bank_soal_pilihan
                        ) C ON A.BANK_SOAL_PILIHAN_ID = C.BANK_SOAL_PILIHAN_ID
                        where 1=1 and a.tipe_ujian_id in (8, 9, 10, 11)
                        GROUP BY A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID
                        , A.TIPE_UJIAN_ID, TU.ID, SUBSTR(TU.ID,1,2), A.BANK_SOAL_ID
                    ) A
                    INNER JOIN
                    (
                        SELECT BANK_SOAL_ID, COUNT(1) JUMLAH_CHECK
                        FROM cat.bank_soal_pilihan
                        WHERE GRADE_PROSENTASE > 0
                        GROUP BY BANK_SOAL_ID
                    ) B ON A.BANK_SOAL_ID = B.BANK_SOAL_ID AND A.JUMLAH_CHECK = B.JUMLAH_CHECK
                    WHERE GRADE_PROSENTASE = 100
                    AND A.ID = '0103'
                    GROUP BY A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID, A.PARENT_ID
                ) A3 ON A.JADWAL_TES_ID = A3.D_JTI AND A.PEGAWAI_ID = A3.D_PID AND A.FORMULA_ASSESMENT_ID = A3.D_FAI AND A.ID = A3.D_ID
                LEFT JOIN
                (
                    SELECT
                        A.JADWAL_TES_ID D_JTI, A.PEGAWAI_ID D_PID
                        , A.FORMULA_ASSESMENT_ID D_FAI, A.PARENT_ID D_ID, COUNT(A.PEGAWAI_ID) D_BN
                    FROM
                    (
                        SELECT
                        A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID
                        , A.TIPE_UJIAN_ID, TU.ID, SUBSTR(TU.ID,1,2) PARENT_ID, A.BANK_SOAL_ID
                        , SUM(GRADE_PROSENTASE) GRADE_PROSENTASE
                        , COUNT(1) JUMLAH_CHECK
                        FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                        INNER JOIN cat.tipe_ujian TU ON TU.TIPE_UJIAN_ID = A.TIPE_UJIAN_ID
                        INNER JOIN 
                        (
                            SELECT BANK_SOAL_ID, BANK_SOAL_PILIHAN_ID, JAWABAN, GRADE_PROSENTASE
                            FROM cat.bank_soal_pilihan
                        ) C ON A.BANK_SOAL_PILIHAN_ID = C.BANK_SOAL_PILIHAN_ID
                        where 1=1 and a.tipe_ujian_id in (8, 9, 10, 11)
                        GROUP BY A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID
                        , A.TIPE_UJIAN_ID, TU.ID, SUBSTR(TU.ID,1,2), A.BANK_SOAL_ID
                    ) A
                    INNER JOIN
                    (
                        SELECT BANK_SOAL_ID, COUNT(1) JUMLAH_CHECK
                        FROM cat.bank_soal_pilihan
                        WHERE GRADE_PROSENTASE > 0
                        GROUP BY BANK_SOAL_ID
                    ) B ON A.BANK_SOAL_ID = B.BANK_SOAL_ID AND A.JUMLAH_CHECK = B.JUMLAH_CHECK
                    WHERE GRADE_PROSENTASE = 100
                    AND A.ID = '0104'
                    GROUP BY A.JADWAL_TES_ID, A.PEGAWAI_ID, A.FORMULA_ASSESMENT_ID, A.PARENT_ID
                ) A4 ON A.JADWAL_TES_ID = A4.D_JTI AND A.PEGAWAI_ID = A4.D_PID AND A.FORMULA_ASSESMENT_ID = A4.D_FAI AND A.ID = A4.D_ID
                INNER JOIN
                (
                    SELECT A.FORMULA_ASSESMENT_UJIAN_TAHAP_ID UJIAN_TAHAP_ID, B.ID, A.FORMULA_ASSESMENT_ID, A.TIPE_UJIAN_ID
                    FROM formula_assesment_ujian_tahap A
                    INNER JOIN cat.tipe_ujian B ON A.TIPE_UJIAN_ID = B.TIPE_UJIAN_ID
                    WHERE 1=1
                    AND PARENT_ID = '0'
                ) C ON A.FORMULA_ASSESMENT_ID = C.FORMULA_ASSESMENT_ID AND A.ID = C.ID
                INNER JOIN
                (
                    SELECT A.FORMULA_ASSESMENT_ID, SUBSTR(TU.ID,1,2) ID, SUM(A.JUMLAH_SOAL_UJIAN_TAHAP) JUMLAH_SOAL
                    FROM formula_assesment_ujian_tahap A
                    INNER JOIN cat.tipe_ujian TU ON TU.TIPE_UJIAN_ID = A.TIPE_UJIAN_ID
                    GROUP BY A.FORMULA_ASSESMENT_ID, SUBSTR(TU.ID,1,2)
                ) D ON A.FORMULA_ASSESMENT_ID = D.FORMULA_ASSESMENT_ID AND A.ID = D.ID
                WHERE 1=1
                AND C.TIPE_UJIAN_ID = ".$tipeujianid."
            ) HSL ON HSL.PEGAWAI_ID = B.PEGAWAI_ID AND HSL.JADWAL_TES_ID = B.JADWAL_TES_ID
            INNER JOIN
            (
                SELECT a.NO_URUT NOMOR_URUT, A.PEGAWAI_ID, A.LAST_UPDATE_DATE
                FROM jadwal_awal_tes_simulasi_pegawai A
                INNER JOIN jadwal_tes B ON JADWAL_AWAL_TES_SIMULASI_ID = JADWAL_TES_ID
                WHERE JADWAL_AWAL_TES_SIMULASI_ID = ".$jadwaltesid."
            ) JA ON JA.PEGAWAI_ID = A.PEGAWAI_ID
            WHERE 1=1
        ".$statement." 
        ) A
        LEFT JOIN 
        (
            SELECT
                X.LOWONGAN_ID, UJIAN_TAHAP_ID, SUM(1) AS JUMLAH_SOAL
            FROM cat.ujian_bank_soal X
            GROUP BY X.LOWONGAN_ID, UJIAN_TAHAP_ID
        ) B ON A.FORMULA_ASSESMENT_ID = B.LOWONGAN_ID AND B.UJIAN_TAHAP_ID = A.UJIAN_TAHAP_ID
        WHERE 1=1
        ".$statementdetil." ".$order;

          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    function selectByParamsMonitoringPapiHasil($jadwaltesid, $statement='', $sorder="order by NOMOR_URUT_GENERATE asc")
    {
        $query = "
        SELECT
            UJIAN_PEGAWAI_DAFTAR_ID, B.UJIAN_ID, B.PEGAWAI_ID
            , A.NAMA NAMA_PEGAWAI, A.EMAIL NIP_BARU1, A.NIP_BARU
            , COALESCE(HSL.NILAI_W,0) NILAI_W
            , CASE 
            WHEN COALESCE(HSL.NILAI_W,0) < 4 THEN 'Hanya butuh gambaran ttg kerangka tugas scr garis besar, berpatokan pd tujuan, dpt bekerja dlm suasana yg kurang berstruktur, berinsiatif, mandiri. Tdk patuh, cenderung mengabaikan/tdk paham pentingnya peraturan/prosedur, suka membuat peraturan sendiri yg bisa bertentangan dg yg telah ada.'
            WHEN COALESCE(HSL.NILAI_W,0) >= 4 AND COALESCE(HSL.NILAI_W,0) < 6 THEN 'Perlu pengarahan awal dan tolok ukur keberhasilan.'
            WHEN COALESCE(HSL.NILAI_W,0) >= 6 AND COALESCE(HSL.NILAI_W,0) < 8 THEN 'Membutuhkan uraian rinci mengenai tugas, dan batasan tanggung jawab serta wewenang.'
            WHEN COALESCE(HSL.NILAI_W,0) >= 8 AND COALESCE(HSL.NILAI_W,0) < 10 THEN 'Patuh pada kebijaksanaan, peraturan dan struktur organisasi. Ingin segala sesuatunya diuraikan secara rinci, kurang memiliki inisiatif, tdk fleksibel, terlalu tergantung pada organisasi, berharap `disuapi`.'
            END INFO_W
            , COALESCE(HSL.NILAI_F,0) NILAI_F
            , CASE 
            WHEN COALESCE(HSL.NILAI_F,0) < 4 THEN 'Otonom, dapat bekerja sendiri tanpa campur tangan orang lain, motivasi timbul krn pekerjaan itu sendiri - bukan krn pujian dr otoritas. Mempertanyakan otoritas, cenderung tidak puas thdp atasan, loyalitas lebih didasari kepentingan pribadi.'
            WHEN COALESCE(HSL.NILAI_F,0) >= 4 AND COALESCE(HSL.NILAI_F,0) < 7 THEN 'Loyal pada Perusahaan.'
            WHEN COALESCE(HSL.NILAI_F,0) = 7 THEN 'Loyal pada pribadi atasan.'
            WHEN COALESCE(HSL.NILAI_F,0) >= 8 AND COALESCE(HSL.NILAI_F,0) < 10 THEN 'Loyal, berusaha dekat dg pribadi atasan, ingin menyenangkan atasan, sadar akan harapan atasan akan dirinya.  Terlalu memperhatikan cara menyenangkan atasan, tidak berani berpendirian lain, tidak mandiri.'
            END INFO_F
            , COALESCE(HSL.NILAI_K,0) NILAI_K
            , CASE 
            WHEN COALESCE(HSL.NILAI_K,0) < 2 THEN 'Sabar, tidak menyukai konflik. Mengelak atau menghindar dari konflik, pasif, menekan atau menyembunyikan perasaan sesungguhnya,  menghindari konfrontasi, lari dari konflik, tidak mau mengakui adanya konflik.'
            WHEN COALESCE(HSL.NILAI_K,0) >= 2 AND COALESCE(HSL.NILAI_K,0) < 4 THEN 'Lebih suka menghindari konflik, akan mencari rasionalisasi untuk  dapat menerima situasi dan melihat permasalahan dari sudut pandang orang lain.'
            WHEN COALESCE(HSL.NILAI_K,0) >= 4 AND COALESCE(HSL.NILAI_K,0) < 6 THEN 'Tidak mencari atau menghindari konflik, mau mendengarkan pandangan orang lain tetapi dapat menjadi keras kepala saat mempertahankan pandangannya.'
            WHEN COALESCE(HSL.NILAI_K,0) >= 6 AND COALESCE(HSL.NILAI_K,0) < 8 THEN 'Akan menghadapi konflik, mengungkapkan serta memaksakan pandangan dengan cara positif.'
            WHEN COALESCE(HSL.NILAI_K,0) >= 8 AND COALESCE(HSL.NILAI_K,0) < 10 THEN 'Terbuka, jujur, terus terang, asertif, agresif, reaktif, mudah tersinggung, mudah meledak, curiga, berprasangka, suka berkelahi atau berkonfrontasi, berpikir negatif.'
            END INFO_K
            , COALESCE(HSL.NILAI_Z,0) NILAI_Z
            , CASE 
            WHEN COALESCE(HSL.NILAI_Z,0) < 2 THEN 'Mudah beradaptasi dg pekerjaan rutin tanpa merasa bosan, tidak membutuhkan variasi, menyukai lingkungan stabil dan tidak berubah. Konservatif, menolak perubahan, sulit menerima hal-hal baru, tidak dapat beradaptasi dengan situasi yg  berbeda-beda.'
            WHEN COALESCE(HSL.NILAI_Z,0) >= 2 AND COALESCE(HSL.NILAI_Z,0) < 4 THEN 'Enggan berubah, tidak siap untuk beradaptasi, hanya mau menerima perubahan jika alasannya jelas dan meyakinkan.'
            WHEN COALESCE(HSL.NILAI_Z,0) >= 4 AND COALESCE(HSL.NILAI_Z,0) < 6 THEN 'Mudah beradaptasi, cukup menyukai perubahan.'
            WHEN COALESCE(HSL.NILAI_Z,0) >= 6 AND COALESCE(HSL.NILAI_Z,0) < 8 THEN 'Antusias terhadap perubahan dan akan mencari hal-hal baru, tetapi masih selektif ( menilai kemanfaatannya ).'
            WHEN COALESCE(HSL.NILAI_Z,0) >= 8 AND COALESCE(HSL.NILAI_Z,0) < 10 THEN 'Sangat menyukai perubahan, gagasan baru/variasi, aktif mencari perubahan, antusias dg hal-hal baru, fleksibel dlm berpikir, mudah beradaptasi pd situasi yg berbeda-beda. Gelisah, frustasi, mudah bosan, sangat membutuhkan variasi, tidak menyukai tugas/situasi yg rutin-monoton.'
            END INFO_Z
            , COALESCE(HSL.NILAI_O,0) NILAI_O
            , CASE 
            WHEN COALESCE(HSL.NILAI_O,0) < 3 THEN 'Menjaga jarak, lebih memperhatikan hal - hal kedinasan, tdk mudah dipengaruhi oleh individu tertentu, objektif & analitis. Tampil dingin, tdk acuh, tdk ramah, suka berahasia, mungkin tdk sadar akan pe- rasaan org lain, & mungkin sulit menyesuaikan diri.'
            WHEN COALESCE(HSL.NILAI_O,0) >= 3 AND COALESCE(HSL.NILAI_O,0) < 6 THEN 'Tidak mencari atau menghindari hubungan antar pribadi di  lingkungan kerja, masih mampu menjaga jarak.'
            WHEN COALESCE(HSL.NILAI_O,0) >= 6 AND COALESCE(HSL.NILAI_O,0) < 10 THEN 'Peka akan kebutuhan org lain, sangat memikirkan hal - hal yg dibutuhkan org lain, suka menjalin hub persahabatan yg hangat & tulus. Sangat pe- rasa, mudah tersinggung, cenderung subjektif, dpt terlibat terlalu dlm/intim dg individu tertentu dlm pekerjaan, sangat tergantung pd individu tertentu.'
            END INFO_O
            , COALESCE(HSL.NILAI_B,0) NILAI_B
            , CASE 
            WHEN COALESCE(HSL.NILAI_B,0) < 3 THEN 'Mandiri ( dari segi emosi ) , tdk mudah dipengaruhi oleh tekanan kelompok. Penyendiri, kurang peka akan sikap & kebutuhan kelom- pok, mungkin sulit menyesuaikan diri.'
            WHEN COALESCE(HSL.NILAI_B,0) >= 3 AND COALESCE(HSL.NILAI_B,0) < 6 THEN 'Selektif dlm bergabung dg kelompok, hanya mau berhubungan dg kelompok di lingkungan kerja apabila bernilai & sesuai minat, tdk terlalu mudah dipengaruhi.'
            WHEN COALESCE(HSL.NILAI_B,0) >= 6 AND COALESCE(HSL.NILAI_B,0) < 10 THEN 'Suka bergabung dlm kelompok, sadar akan sikap & kebutuhan ke- lompok, suka bekerja sama, ingin menjadi bagian dari kelompok, ingin disukai & diakui oleh lingkungan; sangat tergantung pd kelom- pok, lebih memperhatikan kebutuhan kelompok daripada pekerjaan.'
            END INFO_B
            , COALESCE(HSL.NILAI_X,0) NILAI_X
            , CASE 
            WHEN COALESCE(HSL.NILAI_X,0) < 2 THEN 'Sederhana, rendah hati, tulus, tidak sombong dan tidak suka menam- pilkan diri. Terlalu sederhana, cenderung merendahkan kapasitas diri, tidak percaya diri, cenderung menarik diri dan pemalu.'
            WHEN COALESCE(HSL.NILAI_X,0) >= 2 AND COALESCE(HSL.NILAI_X,0) < 4 THEN 'Sederhana, cenderung diam, cenderung pemalu, tidak suka menon- jolkan diri.'
            WHEN COALESCE(HSL.NILAI_X,0) >= 4 AND COALESCE(HSL.NILAI_X,0) < 6 THEN 'Mengharapkan pengakuan lingkungan dan tidak mau diabaikan tetapi tidak mencari-cari perhatian.'
            WHEN COALESCE(HSL.NILAI_X,0) >= 6 AND COALESCE(HSL.NILAI_X,0) < 10 THEN 'Bangga akan diri dan gayanya sendiri, senang menjadi pusat perha- tian, mengharapkan penghargaan dari lingkungan. Mencari-cari perhatian dan suka menyombongkan diri.'
            END INFO_X
            , COALESCE(HSL.NILAI_P,0) NILAI_P
            , CASE 
            WHEN COALESCE(HSL.NILAI_P,0) < 2 THEN 'Permisif, akan memberikan kesempatan pada orang lain untuk memimpin. Tidak mau mengontrol orang lain dan tidak mau mempertanggung jawabkan hasil kerja bawahannya.'
            WHEN COALESCE(HSL.NILAI_P,0) >= 2 AND COALESCE(HSL.NILAI_P,0) < 4 THEN 'Enggan mengontrol org lain & tidak mau mempertanggung jawabkan hasil kerja bawahannya, lebih memberi kebebasan kpd bawahan utk memilih cara sendiri dlm penyelesaian tugas dan meminta bawahan  utk mempertanggungjawabkan hasilnya masing-masing.'
            WHEN COALESCE(HSL.NILAI_P,0) = 4 THEN 'Cenderung enggan melakukan fungsi pengarahan, pengendalian dan pengawasan, kurang aktif memanfaatkan kapasitas bawahan secara optimal, cenderung bekerja sendiri dalam mencapai tujuan kelompok.'
            WHEN COALESCE(HSL.NILAI_P,0) = 5 THEN 'Bertanggung jawab, akan melakukan fungsi pengarahan, pengendalian dan pengawasan, tapi tidak mendominasi.'
            WHEN COALESCE(HSL.NILAI_P,0) > 5 AND COALESCE(HSL.NILAI_P,0) < 8 THEN 'Dominan dan bertanggung jawab, akan melakukan fungsi pengarahan, pengendalian dan pengawasan.'
            WHEN COALESCE(HSL.NILAI_P,0) >= 8 AND COALESCE(HSL.NILAI_P,0) < 10 THEN 'Sangat dominan, sangat mempengaruhi & mengawasi org lain, bertanggung jawab atas tindakan & hasil kerja bawahan. Posesif, tdk ingin berada di  bawah pimpinan org lain, cemas bila tdk berada di posisi pemimpin,  mungkin sulit utk bekerja sama dgn rekan yg sejajar kedudukannya.'
            END INFO_P
            , COALESCE(HSL.NILAI_A,0) NILAI_A
            , CASE 
            WHEN COALESCE(HSL.NILAI_A,0) < 5 THEN 'Tidak kompetitif, mapan, puas. Tidak terdorong untuk menghasilkan prestasi, tdk berusaha utk mencapai sukses, membutuhkan dorongan dari luar diri, tidak berinisiatif, tidak memanfaatkan kemampuan diri secara optimal, ragu akan tujuan diri, misalnya sbg akibat promosi / perubahan struktur jabatan.'
            WHEN COALESCE(HSL.NILAI_A,0) >= 5 AND COALESCE(HSL.NILAI_A,0) < 8 THEN 'Tahu akan tujuan yang ingin dicapainya dan dapat merumuskannya, realistis akan kemampuan diri, dan berusaha untuk mencapai target.'
            WHEN COALESCE(HSL.NILAI_A,0) >= 8 AND COALESCE(HSL.NILAI_A,0) < 10 THEN 'Sangat berambisi utk berprestasi dan menjadi yg terbaik, menyukai tantangan, cenderung mengejar kesempurnaan, menetapkan target yg tinggi, self-starter merumuskan kerja dg baik. Tdk realistis akan kemampuannya, sulit dipuaskan, mudah kecewa, harapan yg tinggi mungkin mengganggu org lain.'
            END INFO_A
            , COALESCE(HSL.NILAI_N,0) NILAI_N
            , CASE 
            WHEN COALESCE(HSL.NILAI_N,0) < 3 THEN 'Tidak terlalu merasa perlu untuk menuntaskan sendiri tugas-tugasnya, senang  menangani beberapa pekerjaan sekaligus, mudah mendelegasikan tugas. Komitmen rendah, cenderung meninggalkan tugas sebelum tuntas, konsentrasi mudah buyar, mungkin suka berpindah pekerjaan.'
            WHEN COALESCE(HSL.NILAI_N,0) >= 3 AND COALESCE(HSL.NILAI_N,0) < 6 THEN 'Cukup memiliki komitmen untuk menuntaskan tugas, akan tetapi jika memungkinkan akan mendelegasikan sebagian dari pekerjaannya kepada orang lain.'
            WHEN COALESCE(HSL.NILAI_N,0) >= 6 AND COALESCE(HSL.NILAI_N,0) < 8 THEN 'Komitmen tinggi, lebih suka menangani pekerjaan satu demi satu, akan tetapi masih dapat mengubah prioritas jika terpaksa.'
            WHEN COALESCE(HSL.NILAI_N,0) >= 8 AND COALESCE(HSL.NILAI_N,0) < 10 THEN 'Memiliki komitmen yg sangat tinggi thd tugas, sangat ingin menyelesaikan tugas, tekun dan tuntas dlm menangani pekerjaan satu demi satu hingga tuntas. Perhatian terpaku pada satu tugas, sulit utk menangani beberapa pekerjaan sekaligus, sulit di interupsi, tidak melihat masalah sampingan.'
            END INFO_N
            , COALESCE(HSL.NILAI_G,0) NILAI_G
            , CASE 
            WHEN COALESCE(HSL.NILAI_G,0) < 3 THEN 'Santai, kerja adalah sesuatu yang menyenangkan-bukan beban yg membutuhkan usaha besar. Mungkin termotivasi utk mencari cara atau sistem yg dpt mempermudah dirinya dlm menyelesaikan pekerjaan, akan berusaha menghindari kerja keras, sehingga dapat memberi kesan malas.'
            WHEN COALESCE(HSL.NILAI_G,0) >= 3 AND COALESCE(HSL.NILAI_G,0) < 5 THEN 'Bekerja keras sesuai tuntutan, menyalurkan usahanya untuk hal-hal yang bermanfaat / menguntungkan.'
            WHEN COALESCE(HSL.NILAI_G,0) >= 5 AND COALESCE(HSL.NILAI_G,0) < 8 THEN 'Bekerja keras, tetapi jelas tujuan yg ingin dicapainya.'
            WHEN COALESCE(HSL.NILAI_G,0) >= 8 AND COALESCE(HSL.NILAI_G,0) < 10 THEN 'Ingin tampil sbg pekerja keras, sangat suka bila orang lain memandangnya sbg pekerja keras. Cenderung menciptakan pekerjaan    yang tidak perlu agar terlihat tetap sibuk, kadang kala tanpa tujuan yang jelas.'
            END INFO_G
            , COALESCE(HSL.NILAI_L,0) NILAI_L
            , CASE 
            WHEN COALESCE(HSL.NILAI_L,0) < 2 THEN 'Puas dengan peran sebagai bawahan, memberikan kesempatan  pada orang lain untuk memimpin, tidak dominan. Tidak percaya diri; sama sekali tidak berminat untuk berperan sebagai pemimpin; ber- sikap pasif dalam kelompok.'
            WHEN COALESCE(HSL.NILAI_L,0) >= 2 AND COALESCE(HSL.NILAI_L,0) < 4 THEN 'Tidak percaya diri dan tidak ingin memimpin atau mengawasi orang lain.'
            WHEN COALESCE(HSL.NILAI_L,0) = 4 THEN 'Kurang percaya diri dan kurang berminat utk menjadi pemimpin'
            WHEN COALESCE(HSL.NILAI_L,0) = 5 THEN 'Cukup percaya diri, tidak secara aktif mencari posisi kepemimpinan akan tetapi juga tidak akan menghindarinya.'
            WHEN COALESCE(HSL.NILAI_L,0) > 5 AND COALESCE(HSL.NILAI_L,0) < 8 THEN 'Percaya diri dan ingin berperan sebagai pemimpin.'
            WHEN COALESCE(HSL.NILAI_L,0) >= 8 AND COALESCE(HSL.NILAI_L,0) < 10 THEN 'Sangat percaya diri utk berperan sbg atasan & sangat mengharapkan posisi tersebut. Lebih mementingkan citra & status kepemimpinannya dari pada efektifitas kelompok, mungkin akan tampil angkuh atau terlalu percaya diri.'
            END INFO_L
            , COALESCE(HSL.NILAI_I,0) NILAI_I
            , CASE 
            WHEN COALESCE(HSL.NILAI_I,0) < 2 THEN 'Sangat berhati - hati, memikirkan langkah- langkahnya secara ber- sungguh - sungguh. Lamban dlm mengambil keputusan, terlalu lama merenung, cenderung menghindar mengambil keputusan.'
            WHEN COALESCE(HSL.NILAI_I,0) >= 2 AND COALESCE(HSL.NILAI_I,0) < 4 THEN 'Enggan mengambil keputusan.'
            WHEN COALESCE(HSL.NILAI_I,0) >= 4 AND COALESCE(HSL.NILAI_I,0) < 6 THEN 'Berhati - hati dlm pengambilan keputusan.'
            WHEN COALESCE(HSL.NILAI_I,0) >= 6 AND COALESCE(HSL.NILAI_I,0) < 8 THEN 'Cukup percaya diri dlm pengambilan keputusan, mau mengambil resiko, dpt memutuskan dgn cepat, mengikuti alur logika.'
            WHEN COALESCE(HSL.NILAI_I,0) >= 8 AND COALESCE(HSL.NILAI_I,0) < 10 THEN 'Sangat yakin dl mengambil keputusan, cepat tanggap thd situasi, berani mengambil resiko, mau memanfaatkan kesempatan. Impulsif, dpt mem- buat keputusan yg tdk praktis, cenderung lebih mementingkan kecepatan daripada akurasi, tdk sabar, cenderung meloncat pd keputusan.'
            END INFO_I
            , COALESCE(HSL.NILAI_T,0) NILAI_T
            , CASE 
            WHEN COALESCE(HSL.NILAI_T,0) < 4 THEN 'Santai. Kurang peduli akan waktu, kurang memiliki rasa urgensi,membuang-buang waktu, bukan pekerja yang tepat waktu.'
            WHEN COALESCE(HSL.NILAI_T,0) >= 4 AND COALESCE(HSL.NILAI_T,0) < 7 THEN 'Cukup aktif dalam segi mental, dapat menyesuaikan tempo kerjanya dengan tuntutan pekerjaan / lingkungan.'
            WHEN COALESCE(HSL.NILAI_T,0) >= 7 AND COALESCE(HSL.NILAI_T,0) < 10 THEN 'Cekatan, selalu siaga, bekerja cepat, ingin segera menyelesaikantugas.  Negatifnya : Tegang, cemas, impulsif, mungkin ceroboh,banyak gerakan yang tidak perlu.'
            END INFO_T
            , COALESCE(HSL.NILAI_V,0) NILAI_V
            , CASE 
            WHEN COALESCE(HSL.NILAI_V,0) < 3 THEN 'Cocok untuk pekerjaan  di belakang meja. Cenderung lamban,tidak tanggap, mudah lelah, daya tahan lemah.'
            WHEN COALESCE(HSL.NILAI_V,0) >= 3 AND COALESCE(HSL.NILAI_V,0) < 7 THEN 'Dapat bekerja di belakang meja dan senang jika sesekali harusterjun ke lapangan atau melaksanakan tugas-tugas yang bersifat mobile.'
            WHEN COALESCE(HSL.NILAI_V,0) >= 7 AND COALESCE(HSL.NILAI_V,0) < 10 THEN 'Menyukai aktifitas fisik ( a.l. : olah raga), enerjik, memiliki staminauntuk menangani tugas-tugas berat, tidak mudah lelah. Tidak betahduduk lama, kurang dapat konsentrasi di belakang meja.'
            END INFO_V
            , COALESCE(HSL.NILAI_S,0) NILAI_S
            , CASE 
            WHEN COALESCE(HSL.NILAI_S,0) < 3 THEN 'Dpt. bekerja sendiri, tdk membutuhkan kehadiran org lain. Menarik diri, kaku dlm bergaul, canggung dlm situasi sosial, lebih memperha- tikan hal - hal lain daripada manusia.'
            WHEN COALESCE(HSL.NILAI_S,0) >= 3 AND COALESCE(HSL.NILAI_S,0) < 5 THEN 'Kurang percaya diri & kurang aktif dlm menjalin hubungan sosial.'
            WHEN COALESCE(HSL.NILAI_S,0) >= 5 AND COALESCE(HSL.NILAI_S,0) < 10 THEN 'Percaya diri & sangat senang bergaul, menyukai interaksi sosial, bisa men- ciptakan suasana yg menyenangkan, mempunyai inisiatif & mampu men- jalin hubungan & komunikasi, memperhatikan org lain. Mungkin membuang- buang waktu utk aktifitas sosial, kurang peduli akan penyelesaian tugas.'
            END INFO_S
            , COALESCE(HSL.NILAI_R,0) NILAI_R
            , CASE 
            WHEN COALESCE(HSL.NILAI_R,0) < 4 THEN 'Tipe pelaksana, praktis - pragmatis, mengandalkan pengalaman masa lalu dan intuisi. Bekerja tanpa perencanaan, mengandalkanperasaan.'
            WHEN COALESCE(HSL.NILAI_R,0) >= 4 AND COALESCE(HSL.NILAI_R,0) < 6 THEN 'Pertimbangan mencakup aspek teoritis ( konsep atau pemikiran baru ) dan aspek praktis ( pengalaman ) secara berimbang.'
            WHEN COALESCE(HSL.NILAI_R,0) >= 6 AND COALESCE(HSL.NILAI_R,0) < 8 THEN 'Suka memikirkan suatu problem secara mendalam, merujuk pada teori dan konsep.'
            WHEN COALESCE(HSL.NILAI_R,0) >= 8 AND COALESCE(HSL.NILAI_R,0) < 10 THEN 'Tipe pemikir, sangat berminat pada gagasan, konsep, teori,menca-ri alternatif baru, menyukai perencanaan. Mungkin sulit dimengerti oleh orang lain, terlalu teoritis dan tidak praktis, mengawang-awangdan berbelit-belit.'
            END INFO_R
            , COALESCE(HSL.NILAI_D,0) NILAI_D
            , CASE 
            WHEN COALESCE(HSL.NILAI_D,0) < 2 THEN 'Melihat pekerjaan scr makro, membedakan hal penting dari yg kurang penting,  mendelegasikan detil pd org lain, generalis. Menghindari detail, konsekuensinya mungkin bertindak tanpa data yg cukup/akurat, bertindak ceroboh pd hal yg butuh kecermatan. Dpt mengabaikan proses yg vital dlm evaluasi data.'
            WHEN COALESCE(HSL.NILAI_D,0) >= 2 AND COALESCE(HSL.NILAI_D,0) < 4 THEN 'Cukup peduli akan akurasi dan kelengkapan data.'
            WHEN COALESCE(HSL.NILAI_D,0) >= 4 AND COALESCE(HSL.NILAI_D,0) < 7 THEN 'Tertarik untuk menangani sendiri detail.'
            WHEN COALESCE(HSL.NILAI_D,0) >= 7 AND COALESCE(HSL.NILAI_D,0) < 10 THEN 'Sangat menyukai detail, sangat peduli akan akurasi dan kelengkapan data. Cenderung terlalu terlibat dengan detail sehingga melupakan tujuan utama.'
            END INFO_D
            , COALESCE(HSL.NILAI_C,0) NILAI_C
            , CASE 
            WHEN COALESCE(HSL.NILAI_C,0) < 3 THEN 'Lebih mementingkan fleksibilitas daripada struktur, pendekatan kerja lebih ditentukan oleh situasi daripada oleh perencanaan sebelumnya, mudah beradaptasi. Tidak mempedulikan keteraturan   atau kerapihan, ceroboh.'
            WHEN COALESCE(HSL.NILAI_C,0) >= 3 AND COALESCE(HSL.NILAI_C,0) < 5 THEN 'Fleksibel tapi masih cukup memperhatikan keteraturan atau sistematika kerja.'
            WHEN COALESCE(HSL.NILAI_C,0) >= 5 AND COALESCE(HSL.NILAI_C,0) < 7 THEN 'Memperhatikan keteraturan dan sistematika kerja, tapi cukup fleksibel.'
            WHEN COALESCE(HSL.NILAI_C,0) >= 7 AND COALESCE(HSL.NILAI_C,0) < 10 THEN 'Sistematis, bermetoda, berstruktur, rapi dan teratur, dapat menata tugas dengan baik. Cenderung kaku, tidak fleksibel.'
            END INFO_C
            , COALESCE(HSL.NILAI_E,0) NILAI_E
            , CASE 
            WHEN COALESCE(HSL.NILAI_E,0) < 2 THEN 'Sangat terbuka, terus terang, mudah terbaca (dari air muka, tindakan, perkataan, sikap). Tidak dapat mengendalikan emosi, cepat  bereaksi, kurang mengindahkan/tidak mempunyai nilai yg meng- haruskannya menahan emosi.'
            WHEN COALESCE(HSL.NILAI_E,0) >= 2 AND COALESCE(HSL.NILAI_E,0) < 4 THEN 'Terbuka, mudah mengungkap pendapat atau perasaannya menge- nai suatu hal kepada org lain.'
            WHEN COALESCE(HSL.NILAI_E,0) >= 4 AND COALESCE(HSL.NILAI_E,0) < 7 THEN 'Mampu mengungkap atau menyimpan perasaan, dapat mengen- dalikan emosi.'
            WHEN COALESCE(HSL.NILAI_E,0) >= 7 AND COALESCE(HSL.NILAI_E,0) < 10 THEN 'Mampu menyimpan pendapat atau perasaannya, tenang, dapat  mengendalikan emosi, menjaga jarak. Tampil pasif dan tidak acuh, mungkin sulit mengungkapkan emosi/perasaan/pandangan.'
            END INFO_E
            , COALESCE(HSL.NILAI_G,0) + COALESCE(HSL.NILAI_L,0) + COALESCE(HSL.NILAI_I,0) + COALESCE(HSL.NILAI_T,0) + COALESCE(HSL.NILAI_V,0) + COALESCE(HSL.NILAI_S,0) + COALESCE(HSL.NILAI_R,0) + COALESCE(HSL.NILAI_D,0) + COALESCE(HSL.NILAI_C,0) + COALESCE(HSL.NILAI_E,0) TOTAL_1
            , COALESCE(HSL.NILAI_N,0) + COALESCE(HSL.NILAI_A,0) + COALESCE(HSL.NILAI_P,0) + COALESCE(HSL.NILAI_X,0) + COALESCE(HSL.NILAI_B,0) + COALESCE(HSL.NILAI_O,0) + COALESCE(HSL.NILAI_Z,0) + COALESCE(HSL.NILAI_K,0) + COALESCE(HSL.NILAI_F,0) + COALESCE(HSL.NILAI_W,0) TOTAL_2
            , COALESCE(HSL.JUMLAH_TOTAL,0) TOTAL
            , CASE WHEN HSL.JUMLAH_RATA - FLOOR(HSL.JUMLAH_RATA) > .00 THEN HSL.JUMLAH_RATA ELSE CAST(HSL.JUMLAH_RATA AS INTEGER) END RATA_RATA
            ,  JA.NOMOR_URUT NOMOR_URUT_GENERATE
        FROM cat.ujian_pegawai_daftar B
        INNER JOIN simpeg.pegawai A ON B.PEGAWAI_ID = A.PEGAWAI_ID
        INNER JOIN
        (
            SELECT a.no_urut NOMOR_URUT, A.PEGAWAI_ID, A.LAST_UPDATE_DATE
            FROM jadwal_awal_tes_simulasi_pegawai A
            INNER JOIN jadwal_tes B ON JADWAL_AWAL_TES_SIMULASI_ID = JADWAL_TES_ID
            WHERE JADWAL_AWAL_TES_SIMULASI_ID = ".$jadwaltesid."
        ) JA ON JA.PEGAWAI_ID = A.PEGAWAI_ID
        LEFT JOIN
        (
            SELECT
            AA.UJIAN_ID, AA.PEGAWAI_ID, AA.UJIAN_TAHAP_ID
            , COALESCE(W.NILAI,0) NILAI_W, COALESCE(F.NILAI,0) NILAI_F, COALESCE(K.NILAI,0) NILAI_K, COALESCE(Z.NILAI,0) NILAI_Z, COALESCE(O.NILAI,0) NILAI_O, COALESCE(B.NILAI,0) NILAI_B, COALESCE(X.NILAI,0) NILAI_X, COALESCE(P.NILAI,0) NILAI_P, COALESCE(A.NILAI,0) NILAI_A, COALESCE(N.NILAI,0) NILAI_N
            , COALESCE(G.NILAI,0) NILAI_G, COALESCE(L.NILAI,0) NILAI_L, COALESCE(I.NILAI,0) NILAI_I, COALESCE(T.NILAI,0) NILAI_T, COALESCE(V.NILAI,0) NILAI_V, COALESCE(S.NILAI,0) NILAI_S, COALESCE(R.NILAI,0) NILAI_R, COALESCE(D.NILAI,0) NILAI_D, COALESCE(C.NILAI,0) NILAI_C, COALESCE(E.NILAI,0) NILAI_E
            , COALESCE(W.NILAI,0) + COALESCE(F.NILAI,0) + COALESCE(K.NILAI,0) + COALESCE(Z.NILAI,0) + COALESCE(O.NILAI,0) + COALESCE(B.NILAI,0) + COALESCE(X.NILAI,0) + COALESCE(P.NILAI,0) + COALESCE(A.NILAI,0) +COALESCE(N.NILAI,0) + COALESCE(G.NILAI,0) + COALESCE(L.NILAI,0) + COALESCE(I.NILAI,0) + COALESCE(T.NILAI,0) + COALESCE(V.NILAI,0) + COALESCE(S.NILAI,0) + COALESCE(R.NILAI,0) + COALESCE(D.NILAI,0) + COALESCE(C.NILAI,0) + COALESCE(E.NILAI,0) JUMLAH_TOTAL
            , 
            ROUND
            (
                (
                COALESCE(W.NILAI,0) + COALESCE(F.NILAI,0) + COALESCE(K.NILAI,0) + COALESCE(Z.NILAI,0) + COALESCE(O.NILAI,0) + COALESCE(B.NILAI,0) + COALESCE(X.NILAI,0) + COALESCE(P.NILAI,0) + COALESCE(A.NILAI,0) +COALESCE(N.NILAI,0) + COALESCE(G.NILAI,0) + COALESCE(L.NILAI,0) + COALESCE(I.NILAI,0) + COALESCE(T.NILAI,0) + COALESCE(V.NILAI,0) + COALESCE(S.NILAI,0) + COALESCE(R.NILAI,0) + COALESCE(D.NILAI,0) + COALESCE(C.NILAI,0) + COALESCE(E.NILAI,0) 
                ) / 20
            ,2
            ) JUMLAH_RATA
            FROM
            (
                SELECT 
                A.UJIAN_ID, A.PEGAWAI_ID, A.UJIAN_TAHAP_ID
                FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                GROUP BY A.UJIAN_ID, A.PEGAWAI_ID, A.UJIAN_TAHAP_ID
            ) AA
            LEFT JOIN
            (
                SELECT 
                A.UJIAN_ID, A.PEGAWAI_ID, A.UJIAN_TAHAP_ID
                , COALESCE(SUM(GRADE_A),0) NILAI
                FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                AND B.SOAL_PAPI_ID IN (10, 20, 30, 40, 50, 60, 70, 80, 90)
                GROUP BY A.UJIAN_ID, A.PEGAWAI_ID, A.UJIAN_TAHAP_ID
            ) W ON AA.PEGAWAI_ID = W.PEGAWAI_ID AND AA.UJIAN_ID = W.UJIAN_ID AND AA.UJIAN_TAHAP_ID = W.UJIAN_TAHAP_ID AND AA.UJIAN_ID = W.UJIAN_ID
            LEFT JOIN
            (
                SELECT
                A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                , COALESCE(SUM(NILAI),0) NILAI
                FROM
                (
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_A),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (9, 19, 29, 39, 49, 59, 69, 79)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    UNION ALL
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_B),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (10)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                ) A
                GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
            ) F ON AA.PEGAWAI_ID = F.PEGAWAI_ID AND AA.UJIAN_ID = F.UJIAN_ID AND AA.UJIAN_TAHAP_ID = F.UJIAN_TAHAP_ID
            LEFT JOIN
            (
                SELECT
                A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                , COALESCE(SUM(NILAI),0) NILAI
                FROM
                (
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_A),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (8, 18, 28, 38, 48, 58, 68)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    UNION ALL
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_B),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (9, 20)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                ) A
                GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
            ) K ON AA.PEGAWAI_ID = K.PEGAWAI_ID AND AA.UJIAN_ID = K.UJIAN_ID AND AA.UJIAN_TAHAP_ID = K.UJIAN_TAHAP_ID
            LEFT JOIN
            (
                SELECT
                A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                , COALESCE(SUM(NILAI),0) NILAI
                FROM
                (
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_A),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (7, 17, 27, 37, 47, 57)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    UNION ALL
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_B),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (8, 19, 30)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                ) A
                GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
            ) Z ON AA.PEGAWAI_ID = Z.PEGAWAI_ID AND AA.UJIAN_ID = Z.UJIAN_ID AND AA.UJIAN_TAHAP_ID = Z.UJIAN_TAHAP_ID
            LEFT JOIN
            (
                SELECT
                A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                , COALESCE(SUM(NILAI),0) NILAI
                FROM
                (
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_A),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (6, 16, 26, 36, 46)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    UNION ALL
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_B),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (7, 18, 29, 40)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                ) A
                GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
            ) O ON AA.PEGAWAI_ID = O.PEGAWAI_ID AND AA.UJIAN_ID = O.UJIAN_ID AND AA.UJIAN_TAHAP_ID = O.UJIAN_TAHAP_ID
            LEFT JOIN
            (
                SELECT
                A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                , COALESCE(SUM(NILAI),0) NILAI
                FROM
                (
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_A),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (5, 15, 25, 35)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    UNION ALL
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_B),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (6, 17, 28, 39, 50)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                ) A
                GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
            ) B ON AA.PEGAWAI_ID = B.PEGAWAI_ID AND AA.UJIAN_ID = B.UJIAN_ID AND AA.UJIAN_TAHAP_ID = B.UJIAN_TAHAP_ID
            LEFT JOIN
            (
                SELECT
                A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                , COALESCE(SUM(NILAI),0) NILAI
                FROM
                (
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_A),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (4, 14, 24)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    UNION ALL
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_B),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (5, 16, 27, 38, 49, 60)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                ) A
                GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
            ) X ON AA.PEGAWAI_ID = X.PEGAWAI_ID AND AA.UJIAN_ID = X.UJIAN_ID AND AA.UJIAN_TAHAP_ID = X.UJIAN_TAHAP_ID
            LEFT JOIN
            (
                SELECT
                A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                , COALESCE(SUM(NILAI),0) NILAI
                FROM
                (
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_A),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (3, 13)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    UNION ALL
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_B),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (4, 15, 26, 37, 48, 59, 70)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                ) A
                GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
            ) P ON AA.PEGAWAI_ID = P.PEGAWAI_ID AND AA.UJIAN_ID = P.UJIAN_ID AND AA.UJIAN_TAHAP_ID = P.UJIAN_TAHAP_ID
            LEFT JOIN
            (
                SELECT
                A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                , COALESCE(SUM(NILAI),0) NILAI
                FROM
                (
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_A),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (2)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    UNION ALL
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_B),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (3, 14, 25, 36, 47, 58, 69, 80)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                ) A
                GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
            ) A ON AA.PEGAWAI_ID = A.PEGAWAI_ID AND AA.UJIAN_ID = A.UJIAN_ID AND AA.UJIAN_TAHAP_ID = A.UJIAN_TAHAP_ID
            LEFT JOIN
            (
                SELECT
                A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                , COALESCE(SUM(NILAI),0) NILAI
                FROM
                (
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_B),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (2, 13, 24, 35, 46, 57, 68, 79, 90)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                ) A
                GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
            ) N ON AA.PEGAWAI_ID = N.PEGAWAI_ID AND AA.UJIAN_ID = N.UJIAN_ID AND AA.UJIAN_TAHAP_ID = N.UJIAN_TAHAP_ID
            LEFT JOIN
            (
                SELECT
                A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                , COALESCE(SUM(NILAI),0) NILAI
                FROM
                (
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_A),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (81, 71, 61, 51, 41, 31, 21, 11, 1)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                ) A
                GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
            ) G ON AA.PEGAWAI_ID = G.PEGAWAI_ID AND AA.UJIAN_ID = G.UJIAN_ID AND AA.UJIAN_TAHAP_ID = G.UJIAN_TAHAP_ID
            LEFT JOIN
            (
                SELECT
                A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                , COALESCE(SUM(NILAI),0) NILAI
                FROM
                (
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_A),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (82, 72, 62, 52, 42, 32, 22, 12)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    UNION ALL
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_B),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (81)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                ) A
                GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
            ) L ON AA.PEGAWAI_ID = L.PEGAWAI_ID AND AA.UJIAN_ID = L.UJIAN_ID AND AA.UJIAN_TAHAP_ID = L.UJIAN_TAHAP_ID
            LEFT JOIN
            (
                SELECT
                A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                , COALESCE(SUM(NILAI),0) NILAI
                FROM
                (
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_A),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (83, 73, 63, 53, 43, 33, 23)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    UNION ALL
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_B),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (71, 82)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                ) A
                GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
            ) I ON AA.PEGAWAI_ID = I.PEGAWAI_ID AND AA.UJIAN_ID = I.UJIAN_ID AND AA.UJIAN_TAHAP_ID = I.UJIAN_TAHAP_ID
            LEFT JOIN
            (
                SELECT
                A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                , COALESCE(SUM(NILAI),0) NILAI
                FROM
                (
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_A),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (84, 74, 64, 54, 44, 34)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    UNION ALL
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_B),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (61, 72, 83)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                ) A
                GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
            ) T ON AA.PEGAWAI_ID = T.PEGAWAI_ID AND AA.UJIAN_ID = T.UJIAN_ID AND AA.UJIAN_TAHAP_ID = T.UJIAN_TAHAP_ID
            LEFT JOIN
            (
                SELECT
                A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                , COALESCE(SUM(NILAI),0) NILAI
                FROM
                (
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_A),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (85, 75, 65, 55, 45)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    UNION ALL
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_B),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (51, 62, 73, 84)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                ) A
                GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
            ) V ON AA.PEGAWAI_ID = V.PEGAWAI_ID AND AA.UJIAN_ID = V.UJIAN_ID AND AA.UJIAN_TAHAP_ID = V.UJIAN_TAHAP_ID
            LEFT JOIN
            (
                SELECT
                A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                , COALESCE(SUM(NILAI),0) NILAI
                FROM
                (
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_A),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (56, 66, 76, 86)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    UNION ALL
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_B),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (41, 52, 63, 74, 85)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                ) A
                GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
            ) S ON AA.PEGAWAI_ID = S.PEGAWAI_ID AND AA.UJIAN_ID = S.UJIAN_ID AND AA.UJIAN_TAHAP_ID = S.UJIAN_TAHAP_ID
            LEFT JOIN
            (
                SELECT
                A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                , COALESCE(SUM(NILAI),0) NILAI
                FROM
                (
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_A),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (67, 77, 87)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    UNION ALL
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_B),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (31, 42, 53, 64, 75, 86)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                ) A
                GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
            ) R ON AA.PEGAWAI_ID = R.PEGAWAI_ID AND AA.UJIAN_ID = R.UJIAN_ID AND AA.UJIAN_TAHAP_ID = R.UJIAN_TAHAP_ID
            LEFT JOIN
            (
                SELECT
                A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                , COALESCE(SUM(NILAI),0) NILAI
                FROM
                (
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_A),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (78, 88)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    UNION ALL
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_B),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (21, 32, 43, 54, 65, 76, 87)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                ) A
                GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
            ) D ON AA.PEGAWAI_ID = D.PEGAWAI_ID AND AA.UJIAN_ID = D.UJIAN_ID AND AA.UJIAN_TAHAP_ID = D.UJIAN_TAHAP_ID
            LEFT JOIN
            (
                SELECT
                A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                , COALESCE(SUM(NILAI),0) NILAI
                FROM
                (
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_A),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (89)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    UNION ALL
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_B),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (11, 22, 33, 44, 55, 66, 77, 88)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                ) A
                GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
            ) C ON AA.PEGAWAI_ID = C.PEGAWAI_ID AND AA.UJIAN_ID = C.UJIAN_ID AND AA.UJIAN_TAHAP_ID = C.UJIAN_TAHAP_ID
            LEFT JOIN
            (
                SELECT
                A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                , COALESCE(SUM(NILAI),0) NILAI
                FROM
                (
                    SELECT
                    A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                    , COALESCE(SUM(GRADE_B),0) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.papi_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.PAPI_PILIHAN_ID
                    WHERE 1=1 AND A.TIPE_UJIAN_ID = 7
                    AND B.SOAL_PAPI_ID IN (1, 12, 23, 34, 45, 56, 67, 78, 89)
                    GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
                ) A
                GROUP BY A.PEGAWAI_ID, A.UJIAN_ID, A.UJIAN_TAHAP_ID
            ) E ON AA.PEGAWAI_ID = E.PEGAWAI_ID AND AA.UJIAN_ID = E.UJIAN_ID AND AA.UJIAN_TAHAP_ID = E.UJIAN_TAHAP_ID
            WHERE 1=1
        ) HSL ON HSL.PEGAWAI_ID = B.PEGAWAI_ID AND HSL.UJIAN_ID = B.UJIAN_ID
        WHERE 1=1        
        ".$statement." ".$sorder;

        //   echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsMonitoringSJT($jadwaltesid="",$tipeujianid="",$statement="",$statementdetil="", $order="order by pegawai_id asc")
    {
        $query="
        select * from (
            select coalesce(sum(grade_prosentase),0) hasil, a.pegawai_id, sp.nama nama_pegawai, sp.nip_baru nip_baru,sp.last_jabatan ,
			case when utp.ujian_pegawai_daftar_id is null then 'belum mengerjakan'
			when utp.ujian_pegawai_daftar_id is not null and ujian_tahap_status_ujian_id is null then 'proses mengerjakan'
			when ujian_tahap_status_ujian_id is not null then 'selesai mengerjakan' end status
            from cat_Pegawai. ujian_pegawai_".$jadwaltesid." A
            LEFT JOIN cat.bank_soal_pilihan bsp on a.bank_soal_pilihan_id=bsp.bank_soal_pilihan_id
            LEFT JOIN cat.ujian_tahap_status_ujian utsu on utsu.ujian_tahap_id=a.ujian_tahap_id and a.pegawai_id=utsu.pegawai_id
    		LEFT JOIN cat.ujian_tahap_pegawai utp on utp.ujian_pegawai_daftar_id=a.ujian_pegawai_daftar_id and a.pegawai_id=utp.pegawai_id
            left join simpeg.pegawai sp on a.pegawai_id=sp.pegawai_id
            where a.tipe_ujian_id=".$tipeujianid."
            GROUP BY a.pegawai_id, sp.nama, sp.nip_baru,sp.last_jabatan,ujian_tahap_status_ujian_id,utp.ujian_pegawai_daftar_id
            ".$statementdetil."
        ) a
        left join cat.nilai_sjt sjt on sjt.nilai=a.hasil 
        ".$order;

        //   echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsMonitoringKeterangan($jadwaltesid="",$tipeujianid="",$statement="",$statementdetil="", $order="order by pegawai_id asc")
    {
        $query="
        select 
        UJIAN_PEGAWAI_DAFTAR_ID, B.UJIAN_ID, B.PEGAWAI_ID, B.FORMULA_ASSESMENT_ID, B.JADWAL_TES_ID
                , A.NAMA NAMA_PEGAWAI, A.EMAIL NIP_BARU1, A.NIP_BARU, c.keterangan
        FROM cat.ujian_pegawai_daftar B
        INNER JOIN simpeg.pegawai A ON B.PEGAWAI_ID = A.PEGAWAI_ID 
        left join (
                    select pegawai_id, tipe_ujian_id,keterangan
                    FROM cat_pegawai.ujian_pegawai_keterangan_1 
                    WHERE tipe_ujian_id=".$tipeujianid."
        ) c on c.pegawai_id = b.pegawai_id 
        WHERE 1=1
        ".$statementdetil." ".$order;

          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsMonitoringPf16($jadwaltesid="",$statement="", $order="order by pegawai_id asc")
    {
        $query="
        SELECT
            A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID
            , A.NAMA_PEGAWAI, A.NIP_BARU
            , NORMA_NILAI_MD NILAI_MD
            , CASE WHEN NORMA_NILAI_MD <= 7 THEN NORMA_NILAI_A ELSE NORMA_NILAI_A - 1 END NILAI_A
            , NORMA_NILAI_B NILAI_B
            , CASE WHEN NORMA_NILAI_MD <= 6 THEN NORMA_NILAI_C WHEN NORMA_NILAI_MD <= 9 THEN NORMA_NILAI_C - 1 ELSE NORMA_NILAI_C - 2 END NILAI_C
            , NORMA_NILAI_E NILAI_E
            , NORMA_NILAI_F NILAI_F
            , CASE WHEN NORMA_NILAI_MD <= 7 THEN NORMA_NILAI_G ELSE NORMA_NILAI_G - 1 END NILAI_G
            , CASE WHEN NORMA_NILAI_MD <= 7 THEN NORMA_NILAI_H ELSE NORMA_NILAI_H - 1 END NILAI_H
            , NORMA_NILAI_I NILAI_I
            , CASE WHEN NORMA_NILAI_MD <= 7 THEN NORMA_NILAI_L ELSE NORMA_NILAI_L + 1 END NILAI_L
            , NORMA_NILAI_M NILAI_M
            , CASE WHEN NORMA_NILAI_MD <= 7 THEN NORMA_NILAI_N ELSE NORMA_NILAI_N + 1 END NILAI_N
            , CASE WHEN NORMA_NILAI_MD <= 6 THEN NORMA_NILAI_O WHEN NORMA_NILAI_MD <= 9 THEN NORMA_NILAI_O + 1 ELSE NORMA_NILAI_O + 2 END NILAI_O
            , NORMA_NILAI_Q1 NILAI_Q1
            , CASE WHEN NORMA_NILAI_MD <= 7 THEN NORMA_NILAI_Q2 ELSE NORMA_NILAI_Q2 + 1 END NILAI_Q2
            , CASE WHEN NORMA_NILAI_MD <= 6 THEN NORMA_NILAI_Q3 WHEN NORMA_NILAI_MD <= 9 THEN NORMA_NILAI_Q3 - 1 ELSE NORMA_NILAI_Q3 - 2 END NILAI_Q3
            , CASE WHEN NORMA_NILAI_MD <= 6 THEN NORMA_NILAI_Q4 WHEN NORMA_NILAI_MD <= 9 THEN NORMA_NILAI_Q4 + 1 ELSE NORMA_NILAI_Q4 + 2 END NILAI_Q4
            , 
            JA.NOMOR_URUT NOMOR_URUT_GENERATE
        FROM
        (
            SELECT
            A.* 
            , cat.pf16_sw(NORMA_MD, RW_MD_NILAI) NORMA_NILAI_MD
            , cat.pf16_sw((NORMA_PENDIDIKAN || '_A'), RW_A_NILAI) NORMA_NILAI_A
            , cat.pf16_sw((NORMA_PENDIDIKAN || '_B'), RW_B_NILAI) NORMA_NILAI_B
            , cat.pf16_sw((NORMA_PENDIDIKAN || '_C'), RW_C_NILAI) NORMA_NILAI_C
            , cat.pf16_sw((NORMA_PENDIDIKAN || '_E'), RW_E_NILAI) NORMA_NILAI_E
            , cat.pf16_sw((NORMA_PENDIDIKAN || '_F'), RW_F_NILAI) NORMA_NILAI_F
            , cat.pf16_sw((NORMA_PENDIDIKAN || '_G'), RW_G_NILAI) NORMA_NILAI_G
            , cat.pf16_sw((NORMA_PENDIDIKAN || '_H'), RW_H_NILAI) NORMA_NILAI_H
            , cat.pf16_sw((NORMA_PENDIDIKAN || '_I'), RW_I_NILAI) NORMA_NILAI_I
            , cat.pf16_sw((NORMA_PENDIDIKAN || '_L'), RW_L_NILAI) NORMA_NILAI_L
            , cat.pf16_sw((NORMA_PENDIDIKAN || '_M'), RW_M_NILAI) NORMA_NILAI_M
            , cat.pf16_sw((NORMA_PENDIDIKAN || '_N'), RW_N_NILAI) NORMA_NILAI_N
            , cat.pf16_sw((NORMA_PENDIDIKAN || '_O'), RW_O_NILAI) NORMA_NILAI_O
            , cat.pf16_sw((NORMA_PENDIDIKAN || '_Q1'), RW_Q1_NILAI) NORMA_NILAI_Q1
            , cat.pf16_sw((NORMA_PENDIDIKAN || '_Q2'), RW_Q2_NILAI) NORMA_NILAI_Q2
            , cat.pf16_sw((NORMA_PENDIDIKAN || '_Q3'), RW_Q3_NILAI) NORMA_NILAI_Q3
            , cat.pf16_sw((NORMA_PENDIDIKAN || '_Q4'), RW_Q4_NILAI) NORMA_NILAI_Q4
            FROM
            (
                SELECT A.*
                , 'MD_' || PEGAWAI_JENIS_KELAMIN NORMA_MD
                , PEGAWAI_PENDIDIKAN || '_' || PEGAWAI_JENIS_KELAMIN NORMA_PENDIDIKAN
                , COALESCE(RW_MD.NILAI,0) RW_MD_NILAI, COALESCE(RW_A.NILAI,0) RW_A_NILAI, COALESCE(RW_B.NILAI,0) RW_B_NILAI
                , COALESCE(RW_C.NILAI,0) RW_C_NILAI, COALESCE(RW_E.NILAI,0) RW_E_NILAI, COALESCE(RW_F.NILAI,0) RW_F_NILAI
                , COALESCE(RW_G.NILAI,0) RW_G_NILAI, COALESCE(RW_H.NILAI,0) RW_H_NILAI, COALESCE(RW_I.NILAI,0) RW_I_NILAI
                , COALESCE(RW_L.NILAI,0) RW_L_NILAI, COALESCE(RW_M.NILAI,0) RW_M_NILAI, COALESCE(RW_N.NILAI,0) RW_N_NILAI
                , COALESCE(RW_O.NILAI,0) RW_O_NILAI, COALESCE(RW_Q1.NILAI,0) RW_Q1_NILAI, COALESCE(RW_Q2.NILAI,0) RW_Q2_NILAI
                , COALESCE(RW_Q3.NILAI,0) RW_Q3_NILAI, COALESCE(RW_Q4.NILAI,0) RW_Q4_NILAI
                FROM
                (
                    SELECT
                    UJIAN_PEGAWAI_DAFTAR_ID, B.UJIAN_ID, B.PEGAWAI_ID, B.JADWAL_TES_ID
                    , A.JENIS_KELAMIN PEGAWAI_JENIS_KELAMIN
                    , CASE WHEN COALESCE(NULLIF(C.KODE, ''), NULL) IS NULL THEN 'MU' ELSE C.KODE END PEGAWAI_PENDIDIKAN
                    , A.NAMA NAMA_PEGAWAI, A.EMAIL NIP_BARU1, A.NIP_BARU
                    FROM cat.ujian_pegawai_daftar B
                    INNER JOIN simpeg.pegawai A ON B.PEGAWAI_ID = A.PEGAWAI_ID
                    LEFT JOIN simpeg.pendidikan C ON A.PENDIDIKAN = CAST(C.PENDIDIKAN_ID AS character varying)
                    WHERE 1=1
                ) A
                LEFT JOIN
                (
                    SELECT
                    A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, SUM(GRADE_PROSENTASE) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.bank_soal_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.BANK_SOAL_PILIHAN_ID
                    WHERE A.BANK_SOAL_ID IN (664, 681, 698, 715, 732, 749, 766)
                    GROUP BY A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID
                ) RW_MD ON A.UJIAN_ID = RW_MD.UJIAN_ID AND A.PEGAWAI_ID = RW_MD.PEGAWAI_ID AND A.JADWAL_TES_ID = RW_MD.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT
                    A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, SUM(GRADE_PROSENTASE) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.bank_soal_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.BANK_SOAL_PILIHAN_ID
                    WHERE A.BANK_SOAL_ID IN (665, 682, 699, 716, 733, 750, 767)
                    GROUP BY A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID
                ) RW_A ON A.UJIAN_ID = RW_A.UJIAN_ID AND A.PEGAWAI_ID = RW_A.PEGAWAI_ID AND A.JADWAL_TES_ID = RW_A.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT
                    A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, SUM(GRADE_PROSENTASE) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.bank_soal_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.BANK_SOAL_PILIHAN_ID
                    WHERE A.BANK_SOAL_ID IN (666, 683, 700, 717, 734, 751, 768)
                    GROUP BY A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID
                ) RW_B ON A.UJIAN_ID = RW_B.UJIAN_ID AND A.PEGAWAI_ID = RW_B.PEGAWAI_ID AND A.JADWAL_TES_ID = RW_B.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT
                    A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, SUM(GRADE_PROSENTASE) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.bank_soal_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.BANK_SOAL_PILIHAN_ID
                    WHERE A.BANK_SOAL_ID IN (667, 684, 701, 718, 735, 752)
                    GROUP BY A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID
                ) RW_C ON A.UJIAN_ID = RW_C.UJIAN_ID AND A.PEGAWAI_ID = RW_C.PEGAWAI_ID AND A.JADWAL_TES_ID = RW_C.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT
                    A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, SUM(GRADE_PROSENTASE) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.bank_soal_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.BANK_SOAL_PILIHAN_ID
                    WHERE A.BANK_SOAL_ID IN (668, 685, 702, 719, 736, 753)
                    GROUP BY A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID
                ) RW_E ON A.UJIAN_ID = RW_E.UJIAN_ID AND A.PEGAWAI_ID = RW_E.PEGAWAI_ID AND A.JADWAL_TES_ID = RW_E.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT
                    A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, SUM(GRADE_PROSENTASE) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.bank_soal_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.BANK_SOAL_PILIHAN_ID
                    WHERE A.BANK_SOAL_ID IN (669, 686, 703, 720, 737, 754)
                    GROUP BY A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID
                ) RW_F ON A.UJIAN_ID = RW_F.UJIAN_ID AND A.PEGAWAI_ID = RW_F.PEGAWAI_ID AND A.JADWAL_TES_ID = RW_F.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT
                    A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, SUM(GRADE_PROSENTASE) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.bank_soal_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.BANK_SOAL_PILIHAN_ID
                    WHERE A.BANK_SOAL_ID IN (670, 687, 704, 721, 738, 755)
                    GROUP BY A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID
                ) RW_G ON A.UJIAN_ID = RW_G.UJIAN_ID AND A.PEGAWAI_ID = RW_G.PEGAWAI_ID AND A.JADWAL_TES_ID = RW_G.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT
                    A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, SUM(GRADE_PROSENTASE) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.bank_soal_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.BANK_SOAL_PILIHAN_ID
                    WHERE A.BANK_SOAL_ID IN (671, 688, 705, 722, 739, 756)
                    GROUP BY A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID
                ) RW_H ON A.UJIAN_ID = RW_H.UJIAN_ID AND A.PEGAWAI_ID = RW_H.PEGAWAI_ID AND A.JADWAL_TES_ID = RW_H.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT
                    A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, SUM(GRADE_PROSENTASE) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.bank_soal_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.BANK_SOAL_PILIHAN_ID
                    WHERE A.BANK_SOAL_ID IN (672, 689, 706, 723, 740, 757)
                    GROUP BY A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID
                ) RW_I ON A.UJIAN_ID = RW_I.UJIAN_ID AND A.PEGAWAI_ID = RW_I.PEGAWAI_ID AND A.JADWAL_TES_ID = RW_I.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT
                    A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, SUM(GRADE_PROSENTASE) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.bank_soal_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.BANK_SOAL_PILIHAN_ID
                    WHERE A.BANK_SOAL_ID IN (673, 690, 707, 724, 741, 758)
                    GROUP BY A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID
                ) RW_L ON A.UJIAN_ID = RW_L.UJIAN_ID AND A.PEGAWAI_ID = RW_L.PEGAWAI_ID AND A.JADWAL_TES_ID = RW_L.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT
                    A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, SUM(GRADE_PROSENTASE) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.bank_soal_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.BANK_SOAL_PILIHAN_ID
                    WHERE A.BANK_SOAL_ID IN (674, 691, 708, 725, 742, 759)
                    GROUP BY A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID
                ) RW_M ON A.UJIAN_ID = RW_M.UJIAN_ID AND A.PEGAWAI_ID = RW_M.PEGAWAI_ID AND A.JADWAL_TES_ID = RW_M.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT
                    A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, SUM(GRADE_PROSENTASE) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.bank_soal_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.BANK_SOAL_PILIHAN_ID
                    WHERE A.BANK_SOAL_ID IN (675, 692, 709, 726, 743, 760)
                    GROUP BY A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID
                ) RW_N ON A.UJIAN_ID = RW_N.UJIAN_ID AND A.PEGAWAI_ID = RW_N.PEGAWAI_ID AND A.JADWAL_TES_ID = RW_N.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT
                    A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, SUM(GRADE_PROSENTASE) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.bank_soal_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.BANK_SOAL_PILIHAN_ID
                    WHERE A.BANK_SOAL_ID IN (676, 693, 710, 727, 744, 761)
                    GROUP BY A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID
                ) RW_O ON A.UJIAN_ID = RW_O.UJIAN_ID AND A.PEGAWAI_ID = RW_O.PEGAWAI_ID AND A.JADWAL_TES_ID = RW_O.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT
                    A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, SUM(GRADE_PROSENTASE) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.bank_soal_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.BANK_SOAL_PILIHAN_ID
                    WHERE A.BANK_SOAL_ID IN (677, 694, 711, 728, 745, 762)
                    GROUP BY A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID
                ) RW_Q1 ON A.UJIAN_ID = RW_Q1.UJIAN_ID AND A.PEGAWAI_ID = RW_Q1.PEGAWAI_ID AND A.JADWAL_TES_ID = RW_Q1.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT
                    A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, SUM(GRADE_PROSENTASE) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.bank_soal_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.BANK_SOAL_PILIHAN_ID
                    WHERE A.BANK_SOAL_ID IN (678, 695, 712, 729, 746, 763)
                    GROUP BY A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID
                ) RW_Q2 ON A.UJIAN_ID = RW_Q2.UJIAN_ID AND A.PEGAWAI_ID = RW_Q2.PEGAWAI_ID AND A.JADWAL_TES_ID = RW_Q2.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT
                    A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, SUM(GRADE_PROSENTASE) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.bank_soal_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.BANK_SOAL_PILIHAN_ID
                    WHERE A.BANK_SOAL_ID IN (679, 696, 713, 730, 747, 764)
                    GROUP BY A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID
                ) RW_Q3 ON A.UJIAN_ID = RW_Q3.UJIAN_ID AND A.PEGAWAI_ID = RW_Q3.PEGAWAI_ID AND A.JADWAL_TES_ID = RW_Q3.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT
                    A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, SUM(GRADE_PROSENTASE) NILAI
                    FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                    INNER JOIN cat.bank_soal_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.BANK_SOAL_PILIHAN_ID
                    WHERE A.BANK_SOAL_ID IN (680, 697, 714, 731, 748, 765)
                    GROUP BY A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID
                ) RW_Q4 ON A.UJIAN_ID = RW_Q4.UJIAN_ID AND A.PEGAWAI_ID = RW_Q4.PEGAWAI_ID AND A.JADWAL_TES_ID = RW_Q4.JADWAL_TES_ID
                WHERE 1=1
            ) A
        ) A
        INNER JOIN
        (
            SELECT ROW_NUMBER() OVER(ORDER BY A.LAST_UPDATE_DATE) NOMOR_URUT, A.PEGAWAI_ID, A.LAST_UPDATE_DATE
            FROM jadwal_awal_tes_simulasi_pegawai A
            INNER JOIN jadwal_tes B ON JADWAL_AWAL_TES_SIMULASI_ID = JADWAL_TES_ID
            WHERE JADWAL_AWAL_TES_SIMULASI_ID = ".$jadwaltesid."
        ) JA ON JA.PEGAWAI_ID = A.PEGAWAI_ID
        WHERE 1=1
        ".$statement." ".$order;

          // echo  $query; exit;
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsMonitoringMbtiNew($jadwaltesid="",$statement="", $order="order by pegawai_id asc")
    {
        $arrayData= array(
            array("WHERE"=>"60,52,45, 38,35, 31, 29,28, 20, 15, 11, 10,7,5, 2", "BAGI"=>15, "DIMENSI_KIRI"=>"I", "DIMENSI_KANAN"=>"E", "DIMENSI_KIRI_VALUE"=>5, "DIMENSI_KANAN_VALUE"=>9)
            , array("WHERE"=>"53, 51, 46, 43, 41, 36, 34, 27, 25, 22, 18, 16, 13, 8, 6", "BAGI"=>15, "DIMENSI_KIRI"=>"S", "DIMENSI_KANAN"=>"N", "DIMENSI_KIRI_VALUE"=>19, "DIMENSI_KANAN_VALUE"=>14)
            , array("WHERE"=>"58, 57, 55, 49, 48, 42, 39, 37, 23, 32, 30, 17, 9, 4, 14", "BAGI"=>15, "DIMENSI_KIRI"=>"T", "DIMENSI_KANAN"=>"F", "DIMENSI_KIRI_VALUE"=>20, "DIMENSI_KANAN_VALUE"=>6)
            , array("WHERE"=>"59, 56, 54, 50, 47, 44, 40, 33, 26, 24, 21, 19, 12, 3, 1", "BAGI"=>15, "DIMENSI_KIRI"=>"J", "DIMENSI_KANAN"=>"P", "DIMENSI_KIRI_VALUE"=>10, "DIMENSI_KANAN_VALUE"=>16)
        );

        $str = "
        SELECT A.*";

        for($i=0; $i < count($arrayData); $i++)
        {
            $indexData= $i+1;
            $separator= " || '' || ";
            if($i == 0)
                $separator= ", ";

            $str .= $separator." KONVERSI_".$indexData;
        }
        $str .= " KONVERSI_INFO";

        for($i=0; $i < count($arrayData); $i++)
        {
            $indexData= $i+1;
            $separator= " + ";
            if($i == 0)
                $separator= ", ";

            $str .= $separator." KONVERSI_NILAI_".$indexData;
        }
        $str .= " KONVERSI_JUMLAH";

        $str .= " 
        , NILAI_I, NILAI_E, NILAI_S, NILAI_N, NILAI_T, NILAI_F, NILAI_J, NILAI_P 
        , JA.NOMOR_URUT NOMOR_URUT_GENERATE 
        FROM
        (
            SELECT
            UJIAN_PEGAWAI_DAFTAR_ID, B.UJIAN_ID, B.PEGAWAI_ID, B.JADWAL_TES_ID
            , A.JENIS_KELAMIN PEGAWAI_JENIS_KELAMIN
            , CASE WHEN COALESCE(NULLIF(A.PENDIDIKAN, ''), NULL) IS NULL THEN 'MU' ELSE PENDIDIKAN END PEGAWAI_PENDIDIKAN
            , A.NAMA NAMA_PEGAWAI, A.NIP_BARU
            FROM cat.ujian_pegawai_daftar B
            INNER JOIN simpeg.pegawai A ON B.PEGAWAI_ID = A.PEGAWAI_ID
            WHERE 1=1
        ) A
        INNER JOIN
        (
            SELECT ROW_NUMBER() OVER(ORDER BY A.LAST_UPDATE_DATE) NOMOR_URUT, A.PEGAWAI_ID, A.LAST_UPDATE_DATE
            FROM jadwal_awal_tes_simulasi_pegawai A
            INNER JOIN jadwal_tes B ON JADWAL_AWAL_TES_SIMULASI_ID = JADWAL_TES_ID
            WHERE JADWAL_AWAL_TES_SIMULASI_ID = ".$jadwaltesid."
        ) JA ON JA.PEGAWAI_ID = A.PEGAWAI_ID
        ";

        for($i=0; $i < count($arrayData); $i++)
        {
            $indexData= $i+1;
            $str .= " LEFT JOIN
            (
                SELECT
                A.UJIAN_ID, A.PEGAWAI_ID
                , CASE WHEN NILAI_A > NILAI_B THEN '".$arrayData[$i]["DIMENSI_KIRI"]."' ELSE '".$arrayData[$i]["DIMENSI_KANAN"]."' END KONVERSI_".$indexData."
                , CASE WHEN NILAI_A > NILAI_B THEN ".$arrayData[$i]["DIMENSI_KIRI_VALUE"]." ELSE ".$arrayData[$i]["DIMENSI_KANAN_VALUE"]." END KONVERSI_NILAI_".$indexData."
                , NILAI_A AS NILAI_".$arrayData[$i]["DIMENSI_KIRI"]."
                , NILAI_B AS NILAI_".$arrayData[$i]["DIMENSI_KANAN"]."
                FROM
                (
                    SELECT 
                    A.UJIAN_ID, A.PEGAWAI_ID, A.UJIAN_TAHAP_ID
                    , GENERATE_PERSEN(NILAI_A) NILAI_A, GENERATE_PERSEN(NILAI_B) NILAI_B
                    FROM
                    (
                        SELECT 
                        A.UJIAN_ID, A.PEGAWAI_ID, A.UJIAN_TAHAP_ID
                        , ROUND((COALESCE(SUM(GRADE_A),0) / ".$arrayData[$i]["BAGI"].") * 100,0) NILAI_A
                        , ROUND((COALESCE(SUM(GRADE_B),0) / ".$arrayData[$i]["BAGI"].") * 100,0) NILAI_B
                        FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                        INNER JOIN cat.mbti_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.MBTI_PILIHAN_ID
                        WHERE 1=1 AND A.TIPE_UJIAN_ID = 41
                        AND B.MBTI_SOAL_ID IN (".$arrayData[$i]["WHERE"].")
                        GROUP BY A.UJIAN_ID, A.PEGAWAI_ID, A.UJIAN_TAHAP_ID
                    ) A
                ) A
            ) K_".$indexData." ON A.UJIAN_ID = K_".$indexData.".UJIAN_ID AND A.PEGAWAI_ID = K_".$indexData.".PEGAWAI_ID";
        }

        $str .= " WHERE 1=1 ".$statement." ".$order;

          // echo  $query; exit;
        $str = DB::select($str);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsMonitoringDisc($jadwaltesid="",$statement="", $order="order by pegawai_id asc")
    {
        $arrPk= array("P", "K");

        $arrDisk= array(
            array("LABEL"=>"D", "KONDISI"=>"D")
            , array("LABEL"=>"I", "KONDISI"=>"I")
            , array("LABEL"=>"S", "KONDISI"=>"S")
            , array("LABEL"=>"C", "KONDISI"=>"C")
            , array("LABEL"=>"X", "KONDISI"=>"*")
        );

        $arrayData= array(
            array("LOOP_AWAL"=>1, "LOOP_AKHIR"=>8, "LINE"=>"1")
            , array("LOOP_AWAL"=>9, "LOOP_AKHIR"=>16, "LINE"=>"2")
            , array("LOOP_AWAL"=>17, "LOOP_AKHIR"=>24, "LINE"=>"3")
        );

        $str = "
        SELECT A.*
        ,  JA.NOMOR_URUT NOMOR_URUT_GENERATE
        , R.NILAI_P_1, R.D_1, R.I_1, R.S_1, R.C_1, R.X_1
        , R.D_2, R.I_2, R.S_2, R.C_2, R.X_2
        , R.D_3, R.I_3, R.S_3, R.C_3";

        $str .= " FROM
        (
            SELECT
            UJIAN_PEGAWAI_DAFTAR_ID, B.UJIAN_ID, B.PEGAWAI_ID, B.JADWAL_TES_ID
            , A.JENIS_KELAMIN PEGAWAI_JENIS_KELAMIN
            , A.NAMA NAMA_PEGAWAI, A.EMAIL NIP_BARU1, A.NIP_BARU
            FROM cat.ujian_pegawai_daftar B
            INNER JOIN simpeg.pegawai A ON B.PEGAWAI_ID = A.PEGAWAI_ID
            WHERE 1=1
        ) A
        INNER JOIN
        (
            SELECT no_urut NOMOR_URUT, A.PEGAWAI_ID, A.LAST_UPDATE_DATE
            FROM jadwal_awal_tes_simulasi_pegawai A
            INNER JOIN jadwal_tes B ON JADWAL_AWAL_TES_SIMULASI_ID = JADWAL_TES_ID
            WHERE JADWAL_AWAL_TES_SIMULASI_ID = ".$jadwaltesid."
        ) JA ON JA.PEGAWAI_ID = A.PEGAWAI_ID
        ";
            $str .= " 
            LEFT JOIN(
            SELECT
            A.*
            , D_1 - D_2 D_3, I_1 - I_2 I_3, S_1 - S_2 S_3
            , C_1 - C_2 C_3
            FROM
            (
            ";

                $str .= " 
                SELECT
                A.UJIAN_ID, A.PEGAWAI_ID, A.UJIAN_TAHAP_ID, A.NILAI_P_1
                ";
                for($y=1; $y<=2; $y++)
                {
                    $ylabel= $y - 1;
                    for($dc=0; $dc < count($arrDisk); $dc++)
                    {
                        for($l=1; $l<=3; $l++)
                        {
                            $separator= " + ";
                            if($l == 1)
                                $separator= ", ";
                            $str .= $separator.$arrDisk[$dc]["LABEL"]."_".$arrPk[$ylabel]."_".$l;
                        }
                        $str .= " ".$arrDisk[$dc]["LABEL"]."_".$y;
                    }
                }

                $str .= " FROM
                (
                ";

                    $str .= " 
                    SELECT
                    A.UJIAN_ID, A.PEGAWAI_ID, A.UJIAN_TAHAP_ID, A.NILAI_P_1
                    ";
                        for($pk=0; $pk < count($arrPk); $pk++)
                        {
                            for($dc=0; $dc < count($arrDisk); $dc++)
                            {
                                for($i=0; $i < count($arrayData); $i++)
                                {
                                    for($x=$arrayData[$i]["LOOP_AWAL"]; $x <= $arrayData[$i]["LOOP_AKHIR"]; $x++)
                                    {
                                        $separator= " + ";
                                        if($x == $arrayData[$i]["LOOP_AWAL"])
                                            $separator= ", ";

                                        $str .= $separator."(CASE WHEN KONVERSI_NILAI_".$arrPk[$pk]."_".$x." = '".$arrDisk[$dc]["KONDISI"]."' THEN 1 ELSE 0 END)";
                                    }
                                    $str .= " ".$arrDisk[$dc]["LABEL"]."_".$arrPk[$pk]."_".$arrayData[$i]["LINE"];
                                }
                            }
                        }

                    $str .= " FROM
                    (
                    ";

                        $str .= " SELECT A.* ";
                            for($n=1; $n <= 24; $n++)
                            {
                                $str .= ", cat.disk_konversi(".$n.", COALESCE(NILAI_P_".$n.",0), 'P') KONVERSI_NILAI_P_".$n."
                            , cat.disk_konversi(".$n.", COALESCE(NILAI_K_".$n.",0), 'K') KONVERSI_NILAI_K_".$n;
                            }

                            $str .= " FROM
                            (
                                SELECT
                                A.UJIAN_ID, A.PEGAWAI_ID, A.UJIAN_TAHAP_ID
                            ";

                            for($n=1; $n <= 24; $n++)
                            {
                                $str .= " , SUM(CASE WHEN B.TIPE = 1 AND C.NOMOR = ".$n." THEN GRADE_A ELSE 0 END) NILAI_P_".$n."
                                , SUM(CASE WHEN B.TIPE = 2 AND C.NOMOR = ".$n." THEN GRADE_B ELSE 0 END) NILAI_K_".$n."
                                ";
                            }

                            $str .= " FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                            INNER JOIN cat.disk_pilihan B ON A.BANK_SOAL_PILIHAN_ID = B.DISK_PILIHAN_ID
                            INNER JOIN cat.disk_soal C ON C.DISK_SOAL_ID = B.DISK_SOAL_ID
                            WHERE 1=1 AND A.TIPE_UJIAN_ID = 42
                            GROUP BY A.UJIAN_ID, A.PEGAWAI_ID, A.UJIAN_TAHAP_ID
                            ) A
                        ) A
                ) A
            ) A
            ) R ON A.UJIAN_ID = R.UJIAN_ID AND A.PEGAWAI_ID = R.PEGAWAI_ID
        WHERE 1=1 
        ".$statement." ".$order;

          // echo  $str; exit;
        $str = DB::select($str);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    public static function selectByParamsMonitoringIst($jadwaltesid="",$statement="", $order="order by pegawai_id asc")
    {
        $str = "
        SELECT A.*, COALESCE(B.IQ,0) IQ
        FROM
        (
            SELECT
            A.*
            , A.RW_SE + A.RW_WA + A.RW_AN + A.RW_GE + A.RW_ME + A.RW_RA + A.RW_ZR + A.RW_FA + A.RW_WU RW_JUMLAH
            , cat.IST_JENIS_SW(10, A.PEGAWAI_UMUR_NORMA, COALESCE((A.RW_SE + A.RW_WA + A.RW_AN + A.RW_GE + A.RW_ME + A.RW_RA + A.RW_ZR + A.RW_FA + A.RW_WU),0)) SW_JUMLAH
            FROM
            (
                SELECT
                    A.UJIAN_PEGAWAI_DAFTAR_ID, A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID
                    , A.NAMA_PEGAWAI, A.NIP_BARU, A.PEGAWAI_UMUR_NORMA
                    , COALESCE(SE.JUMLAH_BENAR,0) RW_SE
                    , cat.IST_JENIS_SW(1, A.PEGAWAI_UMUR_NORMA, COALESCE(SE.JUMLAH_BENAR,0)) SW_SE
                    , COALESCE(WA.JUMLAH_BENAR,0) RW_WA
                    , cat.IST_JENIS_SW(2, A.PEGAWAI_UMUR_NORMA, COALESCE(WA.JUMLAH_BENAR,0)) SW_WA
                    , COALESCE(AN.JUMLAH_BENAR,0) RW_AN
                    , cat.IST_JENIS_SW(3, A.PEGAWAI_UMUR_NORMA, COALESCE(AN.JUMLAH_BENAR,0)) SW_AN
                    , COALESCE(GE.JUMLAH_BENAR,0) RW_GE
                    , cat.IST_JENIS_SW(4, A.PEGAWAI_UMUR_NORMA, COALESCE(GE.JUMLAH_BENAR,0)) SW_GE
                    , COALESCE(ME.JUMLAH_BENAR,0) RW_ME
                    , cat.IST_JENIS_SW(5, A.PEGAWAI_UMUR_NORMA, COALESCE(ME.JUMLAH_BENAR,0)) SW_ME
                    , COALESCE(RA.JUMLAH_BENAR,0) RW_RA
                    , cat.IST_JENIS_SW(6, A.PEGAWAI_UMUR_NORMA, COALESCE(RA.JUMLAH_BENAR,0)) SW_RA
                    , COALESCE(ZR.JUMLAH_BENAR,0) RW_ZR
                    , cat.IST_JENIS_SW(7, A.PEGAWAI_UMUR_NORMA, COALESCE(ZR.JUMLAH_BENAR,0)) SW_ZR
                    , COALESCE(FA.JUMLAH_BENAR,0) RW_FA
                    , cat.IST_JENIS_SW(8, A.PEGAWAI_UMUR_NORMA, COALESCE(FA.JUMLAH_BENAR,0)) SW_FA
                    , COALESCE(WU.JUMLAH_BENAR,0) RW_WU
                    , cat.IST_JENIS_SW(9, A.PEGAWAI_UMUR_NORMA, COALESCE(WU.JUMLAH_BENAR,0)) SW_WU
                    , xx.no_urut NOMOR_URUT_GENERATE
                FROM
                (
                    SELECT
                    UJIAN_PEGAWAI_DAFTAR_ID, B.UJIAN_ID, B.PEGAWAI_ID, B.JADWAL_TES_ID
                    , cat.NORMA_UMUR(B.UJIAN_ID, B.PEGAWAI_ID) PEGAWAI_UMUR_NORMA
                    , A.NAMA NAMA_PEGAWAI, A.EMAIL NIP_BARU1, A.NIP_BARU
                    FROM cat.ujian_pegawai_daftar B
                    INNER JOIN simpeg.pegawai A ON B.PEGAWAI_ID = A.PEGAWAI_ID
                    WHERE 1=1
                ) A
                LEFT JOIN
                (
                    SELECT 
                    A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.ID, COUNT(A.PEGAWAI_ID) JUMLAH_BENAR
                    FROM
                    (
                        SELECT A.*
                        FROM
                        (
                            SELECT A.*
                            FROM
                            (
                                SELECT
                                A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.TIPE_UJIAN_ID, SUBSTR(TU.ID,1,2) ID, A.BANK_SOAL_ID
                                , SUM(GRADE_PROSENTASE) GRADE_PROSENTASE
                                , COUNT(1) JUMLAH_CHECK
                                FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                                INNER JOIN cat.tipe_ujian TU ON TU.TIPE_UJIAN_ID = A.TIPE_UJIAN_ID
                                INNER JOIN 
                                (
                                    SELECT BANK_SOAL_ID, BANK_SOAL_PILIHAN_ID, JAWABAN, GRADE_PROSENTASE
                                    FROM cat.bank_soal_pilihan
                                ) C ON A.BANK_SOAL_PILIHAN_ID = C.BANK_SOAL_PILIHAN_ID
                                WHERE A.BANK_SOAL_ID >= 188 AND A.BANK_SOAL_ID <= 207
                                GROUP BY A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.TIPE_UJIAN_ID, SUBSTR(TU.ID,1,2), A.BANK_SOAL_ID
                            ) A
                            INNER JOIN
                            (
                                SELECT BANK_SOAL_ID, COUNT(1) JUMLAH_CHECK
                                FROM cat.bank_soal_pilihan
                                WHERE GRADE_PROSENTASE > 0
                                GROUP BY BANK_SOAL_ID
                            ) B ON A.BANK_SOAL_ID = B.BANK_SOAL_ID AND A.JUMLAH_CHECK = B.JUMLAH_CHECK
                            WHERE GRADE_PROSENTASE = 100
                            ORDER BY A.BANK_SOAL_ID
                        ) A
                    ) A
                    WHERE 1=1
                    GROUP BY A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.ID
                ) SE ON A.UJIAN_ID = SE.UJIAN_ID AND A.PEGAWAI_ID = SE.PEGAWAI_ID AND A.JADWAL_TES_ID = SE.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT 
                    A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.ID, COUNT(A.PEGAWAI_ID) JUMLAH_BENAR
                    FROM
                    (
                        SELECT A.*
                        FROM
                        (
                            SELECT A.*
                            FROM
                            (
                                SELECT
                                A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.TIPE_UJIAN_ID, SUBSTR(TU.ID,1,2) ID, A.BANK_SOAL_ID
                                , SUM(GRADE_PROSENTASE) GRADE_PROSENTASE
                                , COUNT(1) JUMLAH_CHECK
                                FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                                INNER JOIN cat.tipe_ujian TU ON TU.TIPE_UJIAN_ID = A.TIPE_UJIAN_ID
                                INNER JOIN 
                                (
                                    SELECT BANK_SOAL_ID, BANK_SOAL_PILIHAN_ID, JAWABAN, GRADE_PROSENTASE
                                    FROM cat.bank_soal_pilihan
                                ) C ON A.BANK_SOAL_PILIHAN_ID = C.BANK_SOAL_PILIHAN_ID
                                WHERE A.BANK_SOAL_ID >= 208 AND A.BANK_SOAL_ID <= 227
                                GROUP BY A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.TIPE_UJIAN_ID, SUBSTR(TU.ID,1,2), A.BANK_SOAL_ID
                            ) A
                            INNER JOIN
                            (
                                SELECT BANK_SOAL_ID, COUNT(1) JUMLAH_CHECK
                                FROM cat.bank_soal_pilihan
                                WHERE GRADE_PROSENTASE > 0
                                GROUP BY BANK_SOAL_ID
                            ) B ON A.BANK_SOAL_ID = B.BANK_SOAL_ID AND A.JUMLAH_CHECK = B.JUMLAH_CHECK
                            WHERE GRADE_PROSENTASE = 100
                            ORDER BY A.BANK_SOAL_ID
                        ) A
                    ) A
                    WHERE 1=1
                    GROUP BY A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.ID
                ) WA ON A.UJIAN_ID = WA.UJIAN_ID AND A.PEGAWAI_ID = WA.PEGAWAI_ID AND A.JADWAL_TES_ID = WA.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT 
                    A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.ID, COUNT(A.PEGAWAI_ID) JUMLAH_BENAR
                    FROM
                    (
                        SELECT A.*
                        FROM
                        (
                            SELECT A.*
                            FROM
                            (
                                SELECT
                                A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.TIPE_UJIAN_ID, SUBSTR(TU.ID,1,2) ID, A.BANK_SOAL_ID
                                , SUM(GRADE_PROSENTASE) GRADE_PROSENTASE
                                , COUNT(1) JUMLAH_CHECK
                                FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                                INNER JOIN cat.tipe_ujian TU ON TU.TIPE_UJIAN_ID = A.TIPE_UJIAN_ID
                                INNER JOIN 
                                (
                                    SELECT BANK_SOAL_ID, BANK_SOAL_PILIHAN_ID, JAWABAN, GRADE_PROSENTASE
                                    FROM cat.bank_soal_pilihan
                                ) C ON A.BANK_SOAL_PILIHAN_ID = C.BANK_SOAL_PILIHAN_ID
                                WHERE A.BANK_SOAL_ID >= 228 AND A.BANK_SOAL_ID <= 247
                                GROUP BY A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.TIPE_UJIAN_ID, SUBSTR(TU.ID,1,2), A.BANK_SOAL_ID
                            ) A
                            INNER JOIN
                            (
                                SELECT BANK_SOAL_ID, COUNT(1) JUMLAH_CHECK
                                FROM cat.bank_soal_pilihan
                                WHERE GRADE_PROSENTASE > 0
                                GROUP BY BANK_SOAL_ID
                            ) B ON A.BANK_SOAL_ID = B.BANK_SOAL_ID AND A.JUMLAH_CHECK = B.JUMLAH_CHECK
                            WHERE GRADE_PROSENTASE = 100
                            ORDER BY A.BANK_SOAL_ID
                        ) A
                    ) A
                    WHERE 1=1
                    GROUP BY A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.ID
                ) AN ON A.UJIAN_ID = AN.UJIAN_ID AND A.PEGAWAI_ID = AN.PEGAWAI_ID AND A.JADWAL_TES_ID = AN.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT
                    A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID
                    , cat.norma_ge(NILAI) JUMLAH_BENAR
                    FROM
                    (
                        SELECT
                        A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, SUM(B.NILAI) NILAI
                        FROM cat_pegawai.UJIAN_PEGAWAI_KETERANGAN_".$jadwaltesid." A
                        INNER JOIN cat.IST_KUNCI_4 B ON A.BANK_SOAL_ID = B.BANK_SOAL_ID AND REPLACE(UPPER(A.KETERANGAN), ' ', '') = REPLACE(UPPER(B.NAMA), ' ', '')
                        WHERE A.BANK_SOAL_ID >= 248 AND A.BANK_SOAL_ID <= 263
                        GROUP BY A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID
                    ) A
                ) GE ON A.UJIAN_ID = GE.UJIAN_ID AND A.PEGAWAI_ID = GE.PEGAWAI_ID AND A.JADWAL_TES_ID = GE.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT 
                    A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.ID, COUNT(A.PEGAWAI_ID) JUMLAH_BENAR
                    FROM
                    (
                        SELECT A.*
                        FROM
                        (
                            SELECT A.*
                            FROM
                            (
                                SELECT
                                A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.TIPE_UJIAN_ID, SUBSTR(TU.ID,1,2) ID, A.BANK_SOAL_ID
                                , SUM(GRADE_PROSENTASE) GRADE_PROSENTASE
                                , COUNT(1) JUMLAH_CHECK
                                FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                                INNER JOIN cat.tipe_ujian TU ON TU.TIPE_UJIAN_ID = A.TIPE_UJIAN_ID
                                INNER JOIN 
                                (
                                    SELECT BANK_SOAL_ID, BANK_SOAL_PILIHAN_ID, JAWABAN, GRADE_PROSENTASE
                                    FROM cat.bank_soal_pilihan
                                ) C ON A.BANK_SOAL_PILIHAN_ID = C.BANK_SOAL_PILIHAN_ID
                                WHERE A.BANK_SOAL_ID >= 344 AND A.BANK_SOAL_ID <= 363
                                GROUP BY A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.TIPE_UJIAN_ID, SUBSTR(TU.ID,1,2), A.BANK_SOAL_ID
                            ) A
                            INNER JOIN
                            (
                                SELECT BANK_SOAL_ID, COUNT(1) JUMLAH_CHECK
                                FROM cat.bank_soal_pilihan
                                WHERE GRADE_PROSENTASE > 0
                                GROUP BY BANK_SOAL_ID
                            ) B ON A.BANK_SOAL_ID = B.BANK_SOAL_ID AND A.JUMLAH_CHECK = B.JUMLAH_CHECK
                            WHERE GRADE_PROSENTASE = 100
                            ORDER BY A.BANK_SOAL_ID
                        ) A
                    ) A
                    WHERE 1=1
                    GROUP BY A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.ID
                ) ME ON A.UJIAN_ID = ME.UJIAN_ID AND A.PEGAWAI_ID = ME.PEGAWAI_ID AND A.JADWAL_TES_ID = ME.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT 
                    A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.ID, COUNT(A.PEGAWAI_ID) JUMLAH_BENAR
                    FROM
                    (
                        SELECT A.*
                        FROM
                        (
                            SELECT A.*
                            FROM
                            (
                                SELECT
                                A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.TIPE_UJIAN_ID, SUBSTR(TU.ID,1,2) ID, A.BANK_SOAL_ID
                                , SUM(GRADE_PROSENTASE) GRADE_PROSENTASE
                                , COUNT(1) JUMLAH_CHECK
                                FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                                INNER JOIN cat.tipe_ujian TU ON TU.TIPE_UJIAN_ID = A.TIPE_UJIAN_ID
                                INNER JOIN 
                                (
                                    SELECT BANK_SOAL_ID, BANK_SOAL_PILIHAN_ID, JAWABAN, GRADE_PROSENTASE
                                    FROM cat.bank_soal_pilihan
                                ) C ON A.BANK_SOAL_PILIHAN_ID = C.BANK_SOAL_PILIHAN_ID
                                WHERE A.BANK_SOAL_ID >= 264 AND A.BANK_SOAL_ID <= 283
                                GROUP BY A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.TIPE_UJIAN_ID, SUBSTR(TU.ID,1,2), A.BANK_SOAL_ID
                            ) A
                            INNER JOIN
                            (
                                SELECT BANK_SOAL_ID, COUNT(1) JUMLAH_CHECK
                                FROM cat.bank_soal_pilihan
                                WHERE GRADE_PROSENTASE > 0
                                GROUP BY BANK_SOAL_ID
                            ) B ON A.BANK_SOAL_ID = B.BANK_SOAL_ID AND A.JUMLAH_CHECK = B.JUMLAH_CHECK
                            WHERE GRADE_PROSENTASE = 100
                            ORDER BY A.BANK_SOAL_ID
                        ) A
                    ) A
                    WHERE 1=1
                    GROUP BY A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.ID
                ) RA ON A.UJIAN_ID = RA.UJIAN_ID AND A.PEGAWAI_ID = RA.PEGAWAI_ID AND A.JADWAL_TES_ID = RA.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT 
                    A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.ID, COUNT(A.PEGAWAI_ID) JUMLAH_BENAR
                    FROM
                    (
                        SELECT A.*
                        FROM
                        (
                            SELECT A.*
                            FROM
                            (
                                SELECT
                                A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.TIPE_UJIAN_ID, SUBSTR(TU.ID,1,2) ID, A.BANK_SOAL_ID
                                , SUM(GRADE_PROSENTASE) GRADE_PROSENTASE
                                , COUNT(1) JUMLAH_CHECK
                                FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                                INNER JOIN cat.tipe_ujian TU ON TU.TIPE_UJIAN_ID = A.TIPE_UJIAN_ID
                                INNER JOIN 
                                (
                                    SELECT BANK_SOAL_ID, BANK_SOAL_PILIHAN_ID, JAWABAN, GRADE_PROSENTASE
                                    FROM cat.bank_soal_pilihan
                                ) C ON A.BANK_SOAL_PILIHAN_ID = C.BANK_SOAL_PILIHAN_ID
                                WHERE A.BANK_SOAL_ID >= 284 AND A.BANK_SOAL_ID <= 303
                                GROUP BY A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.TIPE_UJIAN_ID, SUBSTR(TU.ID,1,2), A.BANK_SOAL_ID
                            ) A
                            INNER JOIN
                            (
                                SELECT BANK_SOAL_ID, COUNT(1) JUMLAH_CHECK
                                FROM cat.bank_soal_pilihan
                                WHERE GRADE_PROSENTASE > 0
                                GROUP BY BANK_SOAL_ID
                            ) B ON A.BANK_SOAL_ID = B.BANK_SOAL_ID AND A.JUMLAH_CHECK = B.JUMLAH_CHECK
                            WHERE GRADE_PROSENTASE = 100
                            ORDER BY A.BANK_SOAL_ID
                        ) A
                    ) A
                    WHERE 1=1
                    GROUP BY A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.ID
                ) ZR ON A.UJIAN_ID = ZR.UJIAN_ID AND A.PEGAWAI_ID = ZR.PEGAWAI_ID AND A.JADWAL_TES_ID = ZR.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT 
                    A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.ID, COUNT(A.PEGAWAI_ID) JUMLAH_BENAR
                    FROM
                    (
                        SELECT A.*
                        FROM
                        (
                            SELECT A.*
                            FROM
                            (
                                SELECT
                                A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.TIPE_UJIAN_ID, SUBSTR(TU.ID,1,2) ID, A.BANK_SOAL_ID
                                , SUM(GRADE_PROSENTASE) GRADE_PROSENTASE
                                , COUNT(1) JUMLAH_CHECK
                                FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                                INNER JOIN cat.tipe_ujian TU ON TU.TIPE_UJIAN_ID = A.TIPE_UJIAN_ID
                                INNER JOIN 
                                (
                                    SELECT BANK_SOAL_ID, BANK_SOAL_PILIHAN_ID, JAWABAN, GRADE_PROSENTASE
                                    FROM cat.bank_soal_pilihan
                                ) C ON A.BANK_SOAL_PILIHAN_ID = C.BANK_SOAL_PILIHAN_ID
                                WHERE A.BANK_SOAL_ID >= 304 AND A.BANK_SOAL_ID <= 323
                                GROUP BY A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.TIPE_UJIAN_ID, SUBSTR(TU.ID,1,2), A.BANK_SOAL_ID
                            ) A
                            INNER JOIN
                            (
                                SELECT BANK_SOAL_ID, COUNT(1) JUMLAH_CHECK
                                FROM cat.bank_soal_pilihan
                                WHERE GRADE_PROSENTASE > 0
                                GROUP BY BANK_SOAL_ID
                            ) B ON A.BANK_SOAL_ID = B.BANK_SOAL_ID AND A.JUMLAH_CHECK = B.JUMLAH_CHECK
                            WHERE GRADE_PROSENTASE = 100
                            ORDER BY A.BANK_SOAL_ID
                        ) A
                    ) A
                    WHERE 1=1
                    GROUP BY A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.ID
                ) FA ON A.UJIAN_ID = FA.UJIAN_ID AND A.PEGAWAI_ID = FA.PEGAWAI_ID AND A.JADWAL_TES_ID = FA.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT 
                    A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.ID, COUNT(A.PEGAWAI_ID) JUMLAH_BENAR
                    FROM
                    (
                        SELECT A.*
                        FROM
                        (
                            SELECT A.*
                            FROM
                            (
                                SELECT
                                A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.TIPE_UJIAN_ID, SUBSTR(TU.ID,1,2) ID, A.BANK_SOAL_ID
                                , SUM(GRADE_PROSENTASE) GRADE_PROSENTASE
                                , COUNT(1) JUMLAH_CHECK
                                FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
                                INNER JOIN cat.tipe_ujian TU ON TU.TIPE_UJIAN_ID = A.TIPE_UJIAN_ID
                                INNER JOIN 
                                (
                                    SELECT BANK_SOAL_ID, BANK_SOAL_PILIHAN_ID, JAWABAN, GRADE_PROSENTASE
                                    FROM cat.bank_soal_pilihan
                                ) C ON A.BANK_SOAL_PILIHAN_ID = C.BANK_SOAL_PILIHAN_ID
                                WHERE A.BANK_SOAL_ID >= 324 AND A.BANK_SOAL_ID <= 343
                                GROUP BY A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.TIPE_UJIAN_ID, SUBSTR(TU.ID,1,2), A.BANK_SOAL_ID
                            ) A
                            INNER JOIN
                            (
                                SELECT BANK_SOAL_ID, COUNT(1) JUMLAH_CHECK
                                FROM cat.bank_soal_pilihan
                                WHERE GRADE_PROSENTASE > 0
                                GROUP BY BANK_SOAL_ID
                            ) B ON A.BANK_SOAL_ID = B.BANK_SOAL_ID AND A.JUMLAH_CHECK = B.JUMLAH_CHECK
                            WHERE GRADE_PROSENTASE = 100
                            ORDER BY A.BANK_SOAL_ID
                        ) A
                    ) A
                    WHERE 1=1
                    GROUP BY A.UJIAN_ID, A.PEGAWAI_ID, A.JADWAL_TES_ID, A.ID
                ) WU ON A.UJIAN_ID = WU.UJIAN_ID AND A.PEGAWAI_ID = WU.PEGAWAI_ID AND A.JADWAL_TES_ID = WU.JADWAL_TES_ID
                LEFT JOIN
                (
                    SELECT jadwal_awal_tes_simulasi_id, pegawai_id, no_urut FROM public.jadwal_awal_tes_simulasi_pegawai
                ) xx on A.PEGAWAI_ID = xx.pegawai_id AND A.JADWAL_TES_ID = xx.jadwal_awal_tes_simulasi_id
                WHERE 1=1
                ".$statement."
            ) A
        ) A
        LEFT JOIN cat.IST_IQ B ON B.SW = A.SW_JUMLAH
        WHERE 1=1
        ".$statement." ".$order;

          // echo  $query; exit;
        $str = DB::select($str);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    function setkonversidisk($statement="")
    {
        $str = "
        SELECT HASIL ROWCOUNT
        FROM cat.DISK_GRAFIK
        WHERE 1=1 ".$statement;
        
          // echo  $str; exit;
        $str = DB::select($str);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    function setnkesimpulandisk($d, $i, $s, $c)
    {
        $str = "
        SELECT cat.DISK_N_KESIMPULAN(".$d.", ".$i.", ".$s.", ".$c.") ROWCOUNT
        "; 

        $str = DB::select($str);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    function selectByParamsDiscKesimpulan($statement='', $sOrder="")
    {
        $str = "
        SELECT
        A.PERIODE_ID, A.LINE, A.JUDUL, A.JUDUL_DETIL, A.DESKRIPSI, A.SARAN, A.STATUS_AKTIF
        FROM cat.DISK_KESIMPULAN A
        WHERE 1=1 ".$statement." ".$sOrder;
        // echo $str;exit;
        $str = DB::select($str);
    
        $query = $str;
        $query=collect($query); 
        return $query; 
    }

    function selectByParamsHasilMMPI($jadwaltesid="", $statement="", $order="ORDER BY A.urut")
    {
        $query = "    

        SELECT
        UJIAN_ID, UJIAN_BANK_SOAL_ID, UJIAN_PEGAWAI_DAFTAR_ID, UJIAN_PEGAWAI_ID, URUT,  UJIAN_TAHAP_ID, jawaban, pertanyaan
        FROM cat_pegawai.ujian_pegawai_".$jadwaltesid." A
        left join cat.mmpi_pilihan mp on a.BANK_SOAL_PILIHAN_ID=mp.mmpi_pilihan_id
        left join cat.mmpi_soal ms on a.BANK_SOAL_ID=ms.mmpi_soal_id
        WHERE 1=1
        ".$statement.' '.$order;
          // echo  $query; exit;
        
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    function selectByParamsHasilSJTKompetensi($jadwaltesid="", $tipeujianid="",$statement="", $order="ORDER BY pegawai_id")
    {
        $query = "    
        select a.*,sk.* ,
				case when  total=0 then 0
				else sk.konversi end  konversi_baru
        from
        (
            select pegawai_id, bs.kategori, coalesce(sum(grade_prosentase),0) total, tu.kategori kategori_soal
            from cat_pegawai.ujian_pegawai_".$jadwaltesid." A
            left join cat.bank_soal bs on bs.bank_soal_id=a.bank_soal_id
            left join cat.bank_soal_pilihan bsp on bsp.bank_soal_pilihan_id=a.bank_soal_pilihan_id
            left join cat.tipe_ujian tu on tu.tipe_ujian_id=a.tipe_ujian_id
            where a.tipe_ujian_id=".$tipeujianid." ".$statement."
            GROUP BY pegawai_id, bs.kategori,tu.kategori ".$order."
        )a
         left join cat.sjt_konversi sk on a.total=sk.nilai and a.kategori_soal= cast(sk.level as VARCHAR)
         ";
        //   echo  $query; exit;
        
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

    function selectByParamsHasilSJTStandartEselon($statement="", $order="ORDER BY pegawai_id")
    {
        $query = "    
        select a.*
        from eselon A
        left join simpeg.pegawai p on p.last_eselon_id=a.eselon_id
        where 1=1 ".$statement." ".$order;
          // echo  $query; exit;
        
        $str = DB::select($query);
    
        $query = $str;
        $query=collect($query);

        return $query; 
    }

}

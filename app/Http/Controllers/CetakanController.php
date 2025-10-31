<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SettingJadwal;
use App\Models\SatuanKerja;
use App\Models\UserLogin;
use App\Models\JadwalAcara;
use App\Models\Penggalian;
use App\Models\JadwalAsesor;
use App\Models\JadwalPegawai;
use App\Models\FormulaAssesmentUjianTahap;
use App\Models\TipeUjian;
use App\Models\HasilUjian;
use App\Models\JadwalTes;
use App\Models\PermohonanFile;
use App\Models\AsesorBaru;
use App\Models\UjianTahapStatusUjian;
use App\Models\EssaySoal;
use App\Models\Pegawai;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\IOFactory;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;

//buat panggil fungsi
use App\Helper\StringFunc;
use App\Helper\DateFunc;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SatuanKerjaController;
use Session;


use Carbon\Carbon;
use Mpdf\Mpdf;

// use Carbon\Carbon;

class CetakanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $stringfunc;
    public function __construct()
    {
        $this->middleware('cek_login');

        $this->middleware(function ($request, $next) {
          $this->user= Session::get('user');
          // $this->user= Auth::user()->load('pegawai.satker_model');

          // $this->ID                   = $this->user->pegawai->pegawai_id;   
          // $this->NAMA                 = $this->user->pegawai->nama;   
          // $this->JABATAN              = $this->user->pegawai->jabatan;   
          // $this->HAK_AKSES            = $this->user->pegawai->hak_akses;   
          // $this->LAST_LOGIN           = $this->user->pegawai->last_login;   
          // $this->USERNAME             = $this->user->pegawai->username;  
          // $this->USER_LOGIN_ID        = $this->user->pegawai->user_login_id;  
          // $this->USER_GROUP           = $this->user->pegawai->user_group;  
          // $this->MULTIROLE            = $this->user->pegawai->multirole;  
          // $this->CABANG_ID            = $this->user->pegawai->satuan_kerja_id;  
          // $this->CABANG               = $this->user->pegawai->cabang;  
          // $this->SATUAN_KERJA_ID_ASAL = $this->user->pegawai->satuan_kerja_id_asal;  
          // $this->SATUAN_KERJA_ASAL    = $this->user->pegawai->satuan_kerja_asal;  
          // $this->SATUAN_KERJA_HIRARKI = $this->user->pegawai->satuan_kerja_hirarki;  
          // $this->SATUAN_KERJA_JABATAN = $this->user->pegawai->satuan_kerja_jabatan;  
          // $this->KD_LEVEL             = $this->user->pegawai->kd_level;  
          // $this->JENIS_KELAMIN        = $this->user->pegawai->jenis_kelamin;

          return $next($request);
        });

        $this->stringfunc = new StringFunc();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    
    public function route_web() {
        Route::get('/app/cetakan/index', [CetakanController::class,'index']);
        Route::get('/app/cetakan/addviewcetakCFID/{reqId?}/{tipeUjian?}', [CetakanController::class,'addviewcetakCFID']);
        Route::get('/app/cetakan/addviewcetak16pf/{reqId?}/{tipeUjian?}/{pegawaiId?}', [CetakanController::class,'addviewcetak16pf']);
        Route::get('/app/cetakan/addviewcetakPapikostik/{reqId?}/{tipeUjian?}/{pegawaiId?}', [CetakanController::class,'addviewcetakPapikostik']);
        Route::get('/app/cetakan/addviewcetakIST/{reqId?}/{tipeUjian?}', [CetakanController::class,'addviewcetakIST']);
        Route::get('/app/cetakan/addviewcetakMSDT/{reqId?}/{tipeUjian?}', [CetakanController::class,'addviewcetakMSDT']);
        Route::get('/app/cetakan/addviewcetakDISC/{reqId?}/{tipeUjian?}/{pegawaiId?}', [CetakanController::class,'addviewcetakDISC']);
        Route::get('/app/cetakan/addviewcetakSJTBaru/{reqId?}/{tipeUjian?}/{pegawaiId?}', [CetakanController::class,'addviewcetakSJTBaru']);
        Route::get('/app/cetakan/addviewcetakRapidBaru/{reqId?}/{tipeUjian?}/{pegawaiId?}', [CetakanController::class,'addviewcetakRapidBaru']);
        Route::get('/app/cetakan/addviewcetakMMPI/{reqId?}/{tipeUjian?}/{pegawaiId?}', [CetakanController::class,'addviewcetakMMPI']);
        Route::get('/app/cetakan/addviewcetakSJT/{reqId?}/{tipeUjian?}/{pegawaiId?}', [CetakanController::class,'addviewcetakSJT']);
        Route::get('/app/cetakan/addviewcetakSJTPDF/{id?}/{tipeUjianId?}/{pegawaiId?}', [CetakanController::class, 'addviewcetakSJTPDF']);
        Route::get('/app/cetakan/addviewcetakPapiSemua/{reqId}/{tipeUjianId?}', [CetakanController::class, 'addviewcetakPapiSemua']);
        Route::get('/app/cetakan/addviewcetakDetilPenilaianSJT/{reqId}/{tipeUjianId?}', [CetakanController::class, 'addviewcetakDetilPenilaianSJT']);

    }

    public function index(request $request) {
     $satuan_kerja = new SatuanKerjaController();
     // $cabangid=$this->CABANG_ID;
     // $satker=$satuan_kerja->combo_cabang($request,$cabangid);

     $jenis='x';
     // dd($jenis);
     // return view("app/pegawai/index",compact('satker','cabangid','jenis'));
     return view("app/setting_jadwal",compact('jenis'));
    }

    public function addviewcetakSJT(request $request)
    {
        $reqTipeUjian = $request->route('tipeUjian');
        $reqId = $request->route('reqId');
        $statement=" and tipe_ujian_id=".$reqTipeUjian;
        $query = new TipeUjian();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $namaUjian=$query->tipe;

        $statement=" and jadwal_tes_id=".$reqId;
        $query = new JadwalTes();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $acara=$query->acara;
        $tempat=$query->tempat;
        $alamat=$query->alamat;
        $status_jenis=$query->status_jenis;
        if($status_jenis==1){
          $status_jenis='Pemetaan';
        }
        else{
          $status_jenis='Seleksi';
        }
        $tanggal=explode(' ', $query->tanggal_tes) ;
        $tanggal=$tanggal[0];
       // Membuat objek spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menulis data ke spreadsheet
        $sheet->setCellValue('A1', 'Nama :');
        $sheet->mergeCells('A1:B1');
        $sheet->setCellValue('A2', 'Tanggal Tes :');
        $sheet->mergeCells('A2:B2');
        $sheet->setCellValue('A3', 'Tempat :');
        $sheet->mergeCells('A3:B3');
        $sheet->setCellValue('A4', 'Alamat :');
        $sheet->mergeCells('A4:B4');
        $sheet->setCellValue('A5', 'Tipe Ujian :');
        $sheet->mergeCells('A5:B5');

        $sheet->setCellValue('C1', $acara);
        $sheet->setCellValue('C2', $tanggal);
        $sheet->setCellValue('C3', $tempat);
        $sheet->setCellValue('C4', $alamat);
        $sheet->setCellValue('C5', $status_jenis);

        $sheet->setCellValue('A7', 'HASIL UJIAN '. $namaUjian);
        $sheet->mergeCells('A7:C7');
        $sheet->getStyle('A7')->getFont()->setBold(true)->setSize(16);
        // Menulis file Excel

        $query= new HasilUjian();      
        $statement= "";
        // $statementdetil= " AND A.JADWAL_TES_ID = ".$reqId;

        $query=$query->selectByParamsMonitoringSJT($reqId,$reqTipeUjian, $statement);
        
        // style head
        $sheet->getStyle('A9:F9')->getFont()->setBold(true)->setSize(14); // Bold dan ukuran font 14
        $sheet->getStyle('A9:F9')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4CAF50'); // Warna latar belakang hijau
        $sheet->getStyle('A9:F9')->getFont()->getColor()->setRGB('FFFFFF'); // Warna teks putih
        $sheet->getStyle('A9:F9')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('A9:F9')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // Border tipis di semua sisi sel

        // head
        $sheet->setCellValue('A9', 'NO');
        $sheet->setCellValue('B9', 'NIP');
        $sheet->setCellValue('C9', 'NAMA');
        $sheet->setCellValue('D9', 'JPM');
        $sheet->setCellValue('E9', 'Kategori Pengisian Jabatan');
        $sheet->setCellValue('F9', 'Kategori Pemetaan Kompetensi');

        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $start=9;
        $i=1;
        foreach ($query as $rowData) {

          $sheet->setCellValue('A'.($start+$i), $i);
          $sheet->setCellValue('B'.($start+$i), "'".$rowData->nip_baru);
          $sheet->getStyle('B'.($start+$i).':B' . $sheet->getHighestRow())
          ->getNumberFormat()
          ->setFormatCode(NumberFormat::FORMAT_TEXT);
          $sheet->setCellValue('C'.($start+$i), $rowData->nama_pegawai);
          $sheet->setCellValue('D'.($start+$i), $rowData->jpm);
          $sheet->setCellValue('E'.($start+$i), $rowData->pengisian_jabatan);
          $sheet->setCellValue('F'.($start+$i), $rowData->pemetaan_kompetensi);

          $sheet->getStyle('A'.($start+$i).':F'.($start+$i))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // Border tipis di semua sisi sel
          $i++;
        }

        $writer = new Xlsx($spreadsheet);
        
        // Menyimpan file Excel ke browser
        $fileName = $acara.'_'.$tanggal.'('.$namaUjian.').xlsx';
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
    }

    public function addviewcetakCFID(request $request)
    {
        $reqTipeUjian = $request->route('tipeUjian');
        $reqId = $request->route('reqId');
        $statement=" and tipe_ujian_id=".$reqTipeUjian;
        $query = new TipeUjian();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $namaUjian=$query->tipe;

        $statement=" and jadwal_tes_id=".$reqId;
        $query = new JadwalTes();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $acara=$query->acara;
        $tempat=$query->tempat;
        $alamat=$query->alamat;
        $status_jenis=$query->status_jenis;
        if($status_jenis==1){
          $status_jenis='Pemetaan';
        }
        else{
          $status_jenis='Seleksi';
        }
        $tanggal=explode(' ', $query->tanggal_tes) ;
        $tanggal=$tanggal[0];
       // Membuat objek spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menulis data ke spreadsheet
        $sheet->setCellValue('A1', 'Nama :');
        $sheet->mergeCells('A1:B1');
        $sheet->setCellValue('A2', 'Tanggal Tes :');
        $sheet->mergeCells('A2:B2');
        $sheet->setCellValue('A3', 'Tempat :');
        $sheet->mergeCells('A3:B3');
        $sheet->setCellValue('A4', 'Alamat :');
        $sheet->mergeCells('A4:B4');
        $sheet->setCellValue('A5', 'Tipe Ujian :');
        $sheet->mergeCells('A5:B5');

        $sheet->setCellValue('C1', $acara);
        $sheet->setCellValue('C2', $tanggal);
        $sheet->setCellValue('C3', $tempat);
        $sheet->setCellValue('C4', $alamat);
        $sheet->setCellValue('C5', $status_jenis);

        $sheet->setCellValue('A7', 'HASIL UJIAN '. $namaUjian);
        $sheet->mergeCells('A7:C7');
        $sheet->getStyle('A7')->getFont()->setBold(true)->setSize(16);
        // Menulis file Excel

        $query= new HasilUjian();      
        $statement= "";
        $statementdetil= " AND A.JADWAL_TES_ID = ".$reqId;

        if($reqTipeUjian==1){
          $query=$query->selectByParamsMonitoringCfitHasilRekapA($reqId,$reqTipeUjian, $statement, $statementdetil);
          
          // style head
          $sheet->getStyle('A9:J9')->getFont()->setBold(true)->setSize(14); // Bold dan ukuran font 14
          $sheet->getStyle('A9:J9')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4CAF50'); // Warna latar belakang hijau
          $sheet->getStyle('A9:J9')->getFont()->getColor()->setRGB('FFFFFF'); // Warna teks putih
          $sheet->getStyle('A9:J9')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
          $sheet->getStyle('A9:J9')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // Border tipis di semua sisi sel

          // head
          $sheet->setCellValue('A9', 'NO');
          $sheet->setCellValue('B9', 'NIP');
          $sheet->setCellValue('C9', 'NAMA');
          $sheet->setCellValue('D9', 'HASIL SUBTES 1');
          $sheet->setCellValue('E9', 'HASIL SUBTES 2');
          $sheet->setCellValue('F9', 'HASIL SUBTES 3');
          $sheet->setCellValue('G9', 'HASIL SUBTES 4');
          $sheet->setCellValue('H9', 'JUMLAH BENAR');
          $sheet->setCellValue('I9', 'NILAI');
          $sheet->setCellValue('J9', 'KESIMPULAN');

          foreach (range('A', 'J') as $columnID) {
              $sheet->getColumnDimension($columnID)->setAutoSize(true);
          }

          $start=9;
          $i=1;
          foreach ($query as $rowData) {

            $sheet->setCellValue('A'.($start+$i), $i);
            $sheet->setCellValue('B'.($start+$i), "'".$rowData->nip_baru);
            $sheet->getStyle('B'.($start+$i).':B' . $sheet->getHighestRow())
            ->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_TEXT);
            $sheet->setCellValue('C'.($start+$i), $rowData->nama_pegawai);
            $sheet->setCellValue('D'.($start+$i), $rowData->jumlah_benar_0101);
            $sheet->setCellValue('E'.($start+$i), $rowData->jumlah_benar_0102);
            $sheet->setCellValue('F'.($start+$i), $rowData->jumlah_benar_0103);
            $sheet->setCellValue('G'.($start+$i), $rowData->jumlah_benar_0104);
            $sheet->setCellValue('H'.($start+$i), $rowData->jumlah_benar);
            $sheet->setCellValue('I'.($start+$i), $rowData->nilai_hasil);
            $sheet->setCellValue('J'.($start+$i), $rowData->kesimpulan);

            $sheet->getStyle('A'.($start+$i).':J'.($start+$i))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // Border tipis di semua sisi sel
            $i++;
          }
        }
        else if($reqTipeUjian==2){
          $query=$query->selectByParamsMonitoringCfitHasilRekapB($reqId,$reqTipeUjian, $statement, $statementdetil);
          
          // style head
          $sheet->getStyle('A9:J9')->getFont()->setBold(true)->setSize(14); // Bold dan ukuran font 14
          $sheet->getStyle('A9:J9')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4CAF50'); // Warna latar belakang hijau
          $sheet->getStyle('A9:J9')->getFont()->getColor()->setRGB('FFFFFF'); // Warna teks putih
          $sheet->getStyle('A9:J9')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
          $sheet->getStyle('A9:J9')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // Border tipis di semua sisi sel

          // head
          $sheet->setCellValue('A9', 'NO');
          $sheet->setCellValue('B9', 'NIP');
          $sheet->setCellValue('C9', 'NAMA');
          $sheet->setCellValue('D9', 'HASIL SUBTES 1');
          $sheet->setCellValue('E9', 'HASIL SUBTES 2');
          $sheet->setCellValue('F9', 'HASIL SUBTES 3');
          $sheet->setCellValue('G9', 'HASIL SUBTES 4');
          $sheet->setCellValue('H9', 'JUMLAH BENAR');
          $sheet->setCellValue('I9', 'NILAI');
          $sheet->setCellValue('J9', 'KESIMPULAN');

          foreach (range('A', 'J') as $columnID) {
              $sheet->getColumnDimension($columnID)->setAutoSize(true);
          }

          $start=9;
          $i=1;
          foreach ($query as $rowData) {

            $sheet->setCellValue('A'.($start+$i), $i);
            $sheet->setCellValue('B'.($start+$i), "'".$rowData->nip_baru);
            $sheet->getStyle('B'.($start+$i).':B' . $sheet->getHighestRow())
            ->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_TEXT);
            $sheet->setCellValue('C'.($start+$i), $rowData->nama_pegawai);
            $sheet->setCellValue('D'.($start+$i), $rowData->jumlah_benar_0101);
            $sheet->setCellValue('E'.($start+$i), $rowData->jumlah_benar_0102);
            $sheet->setCellValue('F'.($start+$i), $rowData->jumlah_benar_0103);
            $sheet->setCellValue('G'.($start+$i), $rowData->jumlah_benar_0104);
            $sheet->setCellValue('H'.($start+$i), $rowData->jumlah_benar);
            $sheet->setCellValue('I'.($start+$i), $rowData->nilai_hasil);
            $sheet->setCellValue('J'.($start+$i), $rowData->kesimpulan);

            $sheet->getStyle('A'.($start+$i).':J'.($start+$i))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // Border tipis di semua sisi sel
            $i++;
          }
        }

        $writer = new Xlsx($spreadsheet);
        
        // Menyimpan file Excel ke browser
        $fileName = $acara.'_'.$tanggal.'('.$namaUjian.').xlsx';
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
    }

    public function addviewcetakIST(request $request)
    {
        $reqTipeUjian = $request->route('tipeUjian');
        $reqId = $request->route('reqId');
        $statement=" and tipe_ujian_id=".$reqTipeUjian;
        $query = new TipeUjian();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $namaUjian=$query->tipe;

        $statement=" and jadwal_tes_id=".$reqId;
        $query = new JadwalTes();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $acara=$query->acara;
        $tempat=$query->tempat;
        $alamat=$query->alamat;
        $status_jenis=$query->status_jenis;
        if($status_jenis==1){
          $status_jenis='Pemetaan';
        }
        else{
          $status_jenis='Seleksi';
        }
        $tanggal=explode(' ', $query->tanggal_tes) ;
        $tanggal=$tanggal[0];
       // Membuat objek spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menulis data ke spreadsheet
        $sheet->setCellValue('A1', 'Nama :');
        $sheet->mergeCells('A1:B1');
        $sheet->setCellValue('A2', 'Tanggal Tes :');
        $sheet->mergeCells('A2:B2');
        $sheet->setCellValue('A3', 'Tempat :');
        $sheet->mergeCells('A3:B3');
        $sheet->setCellValue('A4', 'Alamat :');
        $sheet->mergeCells('A4:B4');
        $sheet->setCellValue('A5', 'Tipe Ujian :');
        $sheet->mergeCells('A5:B5');

        $sheet->setCellValue('C1', $acara);
        $sheet->setCellValue('C2', $tanggal);
        $sheet->setCellValue('C3', $tempat);
        $sheet->setCellValue('C4', $alamat);
        $sheet->setCellValue('C5', $status_jenis);

        $sheet->setCellValue('A7', 'HASIL UJIAN '. $namaUjian);
        $sheet->mergeCells('A7:C7');
        $sheet->getStyle('A7')->getFont()->setBold(true)->setSize(16);
        // Menulis file Excel

        $query= new HasilUjian();      
        $statement= " AND A.JADWAL_TES_ID = ".$reqId;

        $query=$query->selectByParamsMonitoringIst($reqId, $statement);
        // print_r($query);exit;
        // style head
        $sheet->getStyle('A9:W10')->getFont()->setBold(true)->setSize(14); // Bold dan ukuran font 14
        $sheet->getStyle('A9:W10')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4CAF50'); // Warna latar belakang hijau
        $sheet->getStyle('A9:W10')->getFont()->getColor()->setRGB('FFFFFF'); // Warna teks putih
        $sheet->getStyle('A9:W10')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('A9:W10')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // Border tipis di semua sisi sel

        // head
        $sheet->setCellValue('A9', 'NO');
        $sheet->mergeCells('A9:A10');
        $sheet->setCellValue('B9', 'NIP');
        $sheet->mergeCells('B9:B10');
        $sheet->setCellValue('C9', 'NAMA');
        $sheet->mergeCells('C9:C10');
        $sheet->setCellValue('D9', 'SE');
        $sheet->mergeCells('D9:E9');
        $sheet->setCellValue('F9', 'WA');
        $sheet->mergeCells('F9:G9');
        $sheet->setCellValue('H9', 'AN');
        $sheet->mergeCells('H9:I9');
        $sheet->setCellValue('J9', 'GE');
        $sheet->mergeCells('J9:K9');
        $sheet->setCellValue('L9', 'ME');
        $sheet->mergeCells('L9:M9');
        $sheet->setCellValue('N9', 'RA');
        $sheet->mergeCells('N9:O9');
        $sheet->setCellValue('P9', 'ZR');
        $sheet->mergeCells('P9:Q9');
        $sheet->setCellValue('R9', 'FA');
        $sheet->mergeCells('R9:S9');
        $sheet->setCellValue('T9', 'WU');
        $sheet->mergeCells('T9:U9');
        $sheet->setCellValue('V9', 'Jumlah');
        $sheet->mergeCells('V9:V10');
        $sheet->setCellValue('W9', 'IQ');
        $sheet->mergeCells('W9:W10');

        $sheet->setCellValue('D10', 'rw_se');
        $sheet->setCellValue('E10', 'sw_se');
        $sheet->setCellValue('F10', 'rw_wa');
        $sheet->setCellValue('G10', 'sw_wa');
        $sheet->setCellValue('H10', 'rw_an');
        $sheet->setCellValue('I10', 'sw_an');
        $sheet->setCellValue('J10', 'rw_ge');
        $sheet->setCellValue('K10', 'sw_ge');
        $sheet->setCellValue('L10', 'rw_me');
        $sheet->setCellValue('M10', 'sw_me');
        $sheet->setCellValue('N10', 'rw_ra');
        $sheet->setCellValue('O10', 'sw_ra');
        $sheet->setCellValue('P10', 'rw_zr');
        $sheet->setCellValue('Q10', 'sw_zr');
        $sheet->setCellValue('R10', 'rw_fa');
        $sheet->setCellValue('S10', 'sw_fa');
        $sheet->setCellValue('T10', 'rw_wu');
        $sheet->setCellValue('U10', 'sw_wu');

        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(40);

        foreach (range('D', 'U') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $start=10;
        $i=1;
        foreach ($query as $rowData) {

          $sheet->setCellValue('A'.($start+$i), $i);
          $sheet->setCellValue('B'.($start+$i), "'".$rowData->nip_baru);
          $sheet->setCellValue('C'.($start+$i), $rowData->nama_pegawai);
          $sheet->setCellValue('D'.($start+$i), $rowData->rw_se);
          $sheet->setCellValue('E'.($start+$i), $rowData->sw_se);
          $sheet->setCellValue('F'.($start+$i), $rowData->rw_wa);
          $sheet->setCellValue('G'.($start+$i), $rowData->sw_wa);
          $sheet->setCellValue('H'.($start+$i), $rowData->rw_an);
          $sheet->setCellValue('I'.($start+$i), $rowData->sw_an);
          $sheet->setCellValue('J'.($start+$i), $rowData->rw_ge);
          $sheet->setCellValue('K'.($start+$i), $rowData->sw_ge);
          $sheet->setCellValue('L'.($start+$i), $rowData->rw_me);
          $sheet->setCellValue('M'.($start+$i), $rowData->sw_me);
          $sheet->setCellValue('N'.($start+$i), $rowData->rw_ra);
          $sheet->setCellValue('O'.($start+$i), $rowData->sw_ra);
          $sheet->setCellValue('P'.($start+$i), $rowData->rw_zr);
          $sheet->setCellValue('Q'.($start+$i), $rowData->sw_zr);
          $sheet->setCellValue('R'.($start+$i), $rowData->rw_fa);
          $sheet->setCellValue('S'.($start+$i), $rowData->sw_fa);
          $sheet->setCellValue('T'.($start+$i), $rowData->rw_wu);
          $sheet->setCellValue('U'.($start+$i), $rowData->sw_wu);
          $sheet->setCellValue('V'.($start+$i), ($rowData->rw_jumlah+$rowData->sw_jumlah));
          $sheet->setCellValue('W'.($start+$i), $rowData->iq);

          $sheet->getStyle('A'.($start+$i).':W'.($start+$i))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // Border tipis di semua sisi sel
          $i++;
        }

        $writer = new Xlsx($spreadsheet);
        
        // Menyimpan file Excel ke browser
        $fileName = $acara.'_'.$tanggal.'('.$namaUjian.').xlsx';
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
    }

    public function addviewcetakMSDT(request $request)
    {
        $reqTipeUjian = $request->route('tipeUjian');
        $reqId = $request->route('reqId');
        $statement=" and tipe_ujian_id=".$reqTipeUjian;
        $query = new TipeUjian();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $namaUjian=$query->tipe;

        $statement=" and jadwal_tes_id=".$reqId;
        $query = new JadwalTes();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $acara=$query->acara;
        $tempat=$query->tempat;
        $alamat=$query->alamat;
        $status_jenis=$query->status_jenis;
        if($status_jenis==1){
          $status_jenis='Pemetaan';
        }
        else{
          $status_jenis='Seleksi';
        }
        $tanggal=explode(' ', $query->tanggal_tes) ;
        $tanggal=$tanggal[0];
       // Membuat objek spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menulis data ke spreadsheet
        $sheet->setCellValue('A1', 'Nama :');
        $sheet->mergeCells('A1:B1');
        $sheet->setCellValue('A2', 'Tanggal Tes :');
        $sheet->mergeCells('A2:B2');
        $sheet->setCellValue('A3', 'Tempat :');
        $sheet->mergeCells('A3:B3');
        $sheet->setCellValue('A4', 'Alamat :');
        $sheet->mergeCells('A4:B4');
        $sheet->setCellValue('A5', 'Tipe Ujian :');
        $sheet->mergeCells('A5:B5');

        $sheet->setCellValue('C1', $acara);
        $sheet->setCellValue('C2', $tanggal);
        $sheet->setCellValue('C3', $tempat);
        $sheet->setCellValue('C4', $alamat);
        $sheet->setCellValue('C5', $status_jenis);

        $sheet->setCellValue('A7', 'HASIL UJIAN '. $namaUjian);
        $sheet->mergeCells('A7:C7');
        $sheet->getStyle('A7')->getFont()->setBold(true)->setSize(16);
        // Menulis file Excel

        $query= new HasilUjian();      
        $statement= " AND A.JADWAL_TES_ID = ".$reqId;

        $query=$query->selectByParamsMonitoringMbtiNew($reqId, $statement);
        // print_r($query);exit;
        // style head
        $sheet->getStyle('A9:L10')->getFont()->setBold(true)->setSize(14); // Bold dan ukuran font 14
        $sheet->getStyle('A9:L10')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4CAF50'); // Warna latar belakang hijau
        $sheet->getStyle('A9:L10')->getFont()->getColor()->setRGB('FFFFFF'); // Warna teks putih
        $sheet->getStyle('A9:L10')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('A9:L10')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // Border tipis di semua sisi sel

        // head
        $sheet->setCellValue('A9', 'NO');
        $sheet->mergeCells('A9:A10');
        $sheet->setCellValue('B9', 'NIP');
        $sheet->mergeCells('B9:B10');
        $sheet->setCellValue('C9', 'NAMA');
        $sheet->mergeCells('C9:C10');
        $sheet->setCellValue('D9', 'PENILAIAN');
        $sheet->mergeCells('D9:K9');
        $sheet->setCellValue('L9', 'KEPRIBADIAN');
        $sheet->mergeCells('L9:L10');

        $sheet->setCellValue('D10', 'I');
        $sheet->setCellValue('E10', 'E');
        $sheet->setCellValue('F10', 'S');
        $sheet->setCellValue('G10', 'N');
        $sheet->setCellValue('H10', 'T');
        $sheet->setCellValue('I10', 'F');
        $sheet->setCellValue('J10', 'J');
        $sheet->setCellValue('K10', 'P');

        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(40);

        foreach (range('D', 'M') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $start=10;
        $i=1;
        foreach ($query as $rowData) {

          $sheet->setCellValue('A'.($start+$i), $i);
          $sheet->setCellValue('B'.($start+$i), "'".$rowData->nip_baru);
          $sheet->setCellValue('C'.($start+$i), $rowData->nama_pegawai);
          $sheet->setCellValue('D'.($start+$i), $rowData->nilai_i);
          $sheet->setCellValue('E'.($start+$i), $rowData->nilai_e);
          $sheet->setCellValue('F'.($start+$i), $rowData->nilai_s);
          $sheet->setCellValue('G'.($start+$i), $rowData->nilai_n);
          $sheet->setCellValue('H'.($start+$i), $rowData->nilai_t);
          $sheet->setCellValue('I'.($start+$i), $rowData->nilai_f);
          $sheet->setCellValue('J'.($start+$i), $rowData->nilai_j);
          $sheet->setCellValue('K'.($start+$i), $rowData->nilai_p);
          $sheet->setCellValue('l'.($start+$i), $rowData->konversi_info);

          $sheet->getStyle('A'.($start+$i).':L'.($start+$i))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // Border tipis di semua sisi sel
          $i++;
        }

        $writer = new Xlsx($spreadsheet);
        
        // Menyimpan file Excel ke browser
        $fileName = $acara.'_'.$tanggal.'('.$namaUjian.').xlsx';
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
    }

    public function addviewcetak16pf(request $request)
    {
        $reqTipeUjian = $request->route('tipeUjian');
        $reqId = $request->route('reqId');
        $reqPegawaiId = $request->route('pegawaiId');
        $statement=" and tipe_ujian_id=".$reqTipeUjian;
        $query = new TipeUjian();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $namaUjian=$query->tipe;

        $statement=" and jadwal_tes_id=".$reqId;
        $query = new JadwalTes();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $acara=$query->acara;
        $tempat=$query->tempat;
        $alamat=$query->alamat;
        $status_jenis=$query->status_jenis;
        if($status_jenis==1){
          $status_jenis='Pemetaan';
        }
        else{
          $status_jenis='Seleksi';
        }
        $tanggal=explode(' ', $query->tanggal_tes) ;
        $tanggal=$tanggal[0];
       // Membuat objek spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Menulis data ke spreadsheet
        $sheet->setCellValue('A1', 'Nama :');
        $sheet->mergeCells('A1:B1');
        $sheet->setCellValue('A2', 'Tanggal Tes :');
        $sheet->mergeCells('A2:B2');
        $sheet->setCellValue('A3', 'Tempat :');
        $sheet->mergeCells('A3:B3');
        $sheet->setCellValue('A4', 'Alamat :');
        $sheet->mergeCells('A4:B4');
        $sheet->setCellValue('A5', 'Tipe Ujian :');
        $sheet->mergeCells('A5:B5');

        $sheet->setCellValue('C1', $acara);
        $sheet->setCellValue('C2', $tanggal);
        $sheet->setCellValue('C3', $tempat);
        $sheet->setCellValue('C4', $alamat);
        $sheet->setCellValue('C5', $status_jenis);

        $sheet->setCellValue('A7', 'HASIL UJIAN '. $namaUjian);
        $sheet->mergeCells('A7:C7');
        $sheet->getStyle('A7')->getFont()->setBold(true)->setSize(16);
        // Menulis file Excel

        $query= new HasilUjian();  
        $statement= " AND A.JADWAL_TES_ID = ".$reqId. " and a.pegawai_id=".$reqPegawaiId;

        $query=$query->selectByParamsMonitoringPf16($reqId, $statement)->first();
        // print_r($query);exit;
        
        $nip_baru=$query->nip_baru;
        $nama_pegawai=$query->nama_pegawai;
        $nilai_a=$query->nilai_a;
        $nilai_b=$query->nilai_b;
        $nilai_c=$query->nilai_c;
        $nilai_e=$query->nilai_e;
        $nilai_f=$query->nilai_f;
        $nilai_g=$query->nilai_g;
        $nilai_h=$query->nilai_h;
        $nilai_i=$query->nilai_i;
        $nilai_l=$query->nilai_l;
        $nilai_m=$query->nilai_m;
        $nilai_n=$query->nilai_n;
        $nilai_o=$query->nilai_o;
        $nilai_q1=$query->nilai_q1;
        $nilai_q2=$query->nilai_q2;
        $nilai_q3=$query->nilai_q3;
        $nilai_q4=$query->nilai_q4;

        $sheet->setCellValue('A9', 'Nama Peserta :');
        $sheet->mergeCells('A9:B9');
        $sheet->setCellValue('A10', 'NPP Peserta :');
        $sheet->mergeCells('A10:B10');

        $sheet->setCellValue('C9', $nama_pegawai);
        $sheet->setCellValue('C10', "'".$nip_baru);

        // style head
        $sheet->getStyle('A12:M13')->getFont()->setBold(true)->setSize(14); // Bold dan ukuran font 14
        $sheet->getStyle('A12:M13')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4CAF50'); // Warna latar belakang hijau

        $sheet->getStyle('A12:M13')->getFont()->getColor()->setRGB('FFFFFF'); // Warna teks putih
        $sheet->getStyle('A12:M13')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('A12:M13')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // Border tipis di semua sisi sel
        $sheet->getStyle('C12:L29')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // head
        $sheet->setCellValue('A12', 'Faktor');
        $sheet->mergeCells('A12:A13');
        $sheet->setCellValue('B12', 'Skor rendah, uraian singkat:');
        $sheet->getColumnDimension('B')->setWidth(50);
        $sheet->mergeCells('B12:B13');
        $sheet->setCellValue('C12', 'Sangat Rendah');
        $sheet->mergeCells('C12:D12');
        $sheet->setCellValue('E12', 'Rendah');
        $sheet->mergeCells('E12:F12');
        $sheet->setCellValue('G12', 'Cukup');
        $sheet->mergeCells('G12:H12');
        $sheet->setCellValue('I12', 'Baik');
        $sheet->mergeCells('I12:J12');
        $sheet->setCellValue('K12', 'Sangat Baik');
        $sheet->mergeCells('K12:L12');
        $sheet->setCellValue('M12', 'Skor tinggi, uraian singkat:');
        $sheet->mergeCells('m12:m13');
        $sheet->getColumnDimension('M')->setWidth(50);

        $sheet->setCellValue('C13', '1');
        $sheet->setCellValue('D13', '2');
        $sheet->setCellValue('E13', '3');
        $sheet->setCellValue('F13', '4');
        $sheet->setCellValue('G13', '5');
        $sheet->setCellValue('H13', '6');
        $sheet->setCellValue('I13', '7');
        $sheet->setCellValue('J13', '8');
        $sheet->setCellValue('K13', '9');
        $sheet->setCellValue('L13', '10');

        $sheet->setCellValue(StringFunc::getColomsNew((2+$nilai_a)).'14', '✓');
        $sheet->setCellValue(StringFunc::getColomsNew((2+$nilai_b)).'15', '✓');
        $sheet->setCellValue(StringFunc::getColomsNew((2+$nilai_c)).'16', '✓');
        $sheet->setCellValue(StringFunc::getColomsNew((2+$nilai_e)).'17', '✓');
        $sheet->setCellValue(StringFunc::getColomsNew((2+$nilai_f)).'18', '✓');
        $sheet->setCellValue(StringFunc::getColomsNew((2+$nilai_g)).'19', '✓');
        $sheet->setCellValue(StringFunc::getColomsNew((2+$nilai_h)).'20', '✓');
        $sheet->setCellValue(StringFunc::getColomsNew((2+$nilai_i)).'21', '✓');
        $sheet->setCellValue(StringFunc::getColomsNew((2+$nilai_l)).'22', '✓');
        $sheet->setCellValue(StringFunc::getColomsNew((2+$nilai_m)).'23', '✓');
        $sheet->setCellValue(StringFunc::getColomsNew((2+$nilai_n)).'24', '✓');
        $sheet->setCellValue(StringFunc::getColomsNew((2+$nilai_o)).'25', '✓');
        $sheet->setCellValue(StringFunc::getColomsNew((2+$nilai_q1)).'26', '✓');
        $sheet->setCellValue(StringFunc::getColomsNew((2+$nilai_q2)).'27', '✓');
        $sheet->setCellValue(StringFunc::getColomsNew((2+$nilai_q3)).'28', '✓');
        $sheet->setCellValue(StringFunc::getColomsNew((2+$nilai_q4)).'29', '✓');

        $sheet->setCellValue('A14', 'A');
        $sheet->setCellValue('A15', 'B');
        $sheet->setCellValue('A16', 'C');
        $sheet->setCellValue('A17', 'E');
        $sheet->setCellValue('A18', 'F');
        $sheet->setCellValue('A19', 'G');
        $sheet->setCellValue('A20', 'H');
        $sheet->setCellValue('A21', 'I');
        $sheet->setCellValue('A22', 'L');
        $sheet->setCellValue('A23', 'M');
        $sheet->setCellValue('A24', 'N');
        $sheet->setCellValue('A25', 'O');
        $sheet->setCellValue('A26', 'Q1');
        $sheet->setCellValue('A27', 'Q2');
        $sheet->setCellValue('A28', 'Q3');
        $sheet->setCellValue('A29', 'Q4');

        $sheet->setCellValue('B14', 'Berhati-hati,    tidak ramah, pendiam, suka menyendiri, kritis, bersikeras, gigih');
        $sheet->setCellValue('M14', 'Ramah    tamah, lembut hati, tidak suka repot-repot, ikut ambil bagian,    berpartisipasi');
        $sheet->setCellValue('B15', 'Bodoh,    inteligensi rendah, kapasitas mental skolastik rendah.');
        $sheet->setCellValue('M15', 'Pandai,    inteligensi tinggi, kapasitas mental skolastik tinggi.');
        $sheet->setCellValue('B16', 'Dipengaruhi    oleh perasaan, emosi kurang mantap, mudah meledak, ego lemah.');
        $sheet->setCellValue('M16', 'Emosi    mantap, matang, menghadapi realitas, tenang, kekuatan ego tinggi.');
        $sheet->setCellValue('B17', 'Rendah    hati, berwatak halus, mudah dituntun, jinak, patuh, pasrah, suka menolong.');
        $sheet->setCellValue('M17', 'Ketegangan    sikap, agresif, suka bersaing, keras hati, teguh pendiriannya, dominan.');
        $sheet->setCellValue('B18', 'Seadanya,    sederhana, pendiam, serius, tenang, tidak bergelora.');
        $sheet->setCellValue('M18', 'Tidak    kenal susah, suka bersenang-senang, antusias, menggelora.');
        $sheet->setCellValue('B19', 'Bijaksana,    mengabaikan aturan-aturan, superego lemah.');
        $sheet->setCellValue('M19', 'Teliti,    gigih, tekun, bermoral, tenang, serius, superego kuat.');
        $sheet->setCellValue('B20', 'Pemalu,    takut-takut, peka terhadap ancaman-ancaman.');
        $sheet->setCellValue('M20', 'Suka    bertualang, berani, tidak malu-malu, secara sosial berani, tegas, hebat.');
        $sheet->setCellValue('B21', 'Keras    hati, percaya diri, realistik.');
        $sheet->setCellValue('M21', 'Lembut    hati, peka, dependen, terlalu dilindungi.');
        $sheet->setCellValue('B22', 'Menaruh    kepercayaan pada orang lain, menerima semua keadaan.');
        $sheet->setCellValue('M22', 'Memiliki    prasangka pada orang lain, sukar untuk bertindak bodoh.');
        $sheet->setCellValue('B23', 'Praktikal,    berkenan pada hal-hal yang sederhana, biasa dan bersahaja.');
        $sheet->setCellValue('M23', 'Imajinatif,    hidup bebas (Bohemian), pelupa, suka melamun, linglung.');
        $sheet->setCellValue('B24', 'Jujur,    berterus terang, blak-blakan, rendah hati, ikhlas, janggal, kikuk.');
        $sheet->setCellValue('M24', 'Lihai,    cerdik, halus budi bahasanya, memiliki kesadaran sosial.');
        $sheet->setCellValue('B25', 'Yakin    akan dirinya, tenang, aman, puas dengan diri sendiri, tenteram.');
        $sheet->setCellValue('M25', 'Kuatir,    gelisah, menyalahkan diri sendiri, tidak aman, cemas, memiliki kesukaran.');
        $sheet->setCellValue('B26', 'Konservatif,    kuno, tradisional.');
        $sheet->setCellValue('M26', 'Liberal,    suka akan hal-hal baru, berpikir bebas, berpikir radikal.');
        $sheet->setCellValue('B27', 'Tergantung    pada kelompok, pengikut, taat pada kelompok.');
        $sheet->setCellValue('M27', 'Kecukupan    diri, banyak akal, mengambil keputusan sendiri.');
        $sheet->setCellValue('B28', 'Lalai,    lemah, membolehkan, sembrono, kelemahan integrasi dari self-sentiment');
        $sheet->setCellValue('M28', 'Bisa    mengendalikan diri, suka mengikuti aturan, kompulsif.');
        $sheet->setCellValue('B29', 'Santai,    tenang, lamban, tidak frustrasi, penyabar, ketegangan energi rendah.');
        $sheet->setCellValue('M29', 'Tegang,    mudah frustrasi, mudah terangsang, lelah, ketegangan energi tinggi.');

        $sheet->getStyle('A12:M29')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); 

        $writer = new Xlsx($spreadsheet);
        
        // Menyimpan file Excel ke browser
        $fileName = $acara.'_'.$tanggal.'('.$namaUjian.').xlsx';
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
    }

    public function addviewcetakPapikostik(request $request)
    {
        $reqTipeUjian = $request->route('tipeUjian');
        $reqId = $request->route('reqId');
        $reqPegawaiId = $request->route('pegawaiId');
        $statement=" and tipe_ujian_id=".$reqTipeUjian;
        $query = new TipeUjian();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $namaUjian=$query->tipe;

        $statement=" and jadwal_tes_id=".$reqId;
        $query = new JadwalTes();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $acara=$query->acara;
        $tempat=$query->tempat;
        $alamat=$query->alamat;
        $status_jenis=$query->status_jenis;
        if($status_jenis==1){
          $status_jenis='Pemetaan';
        }
        else{
          $status_jenis='Seleksi';
        }
        $tanggal=explode(' ', $query->tanggal_tes) ;
        $tanggal=$tanggal[0];
       // Membuat objek spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Menulis data ke spreadsheet
        $sheet->setCellValue('A1', 'Nama :');
        $sheet->mergeCells('A1:B1');
        $sheet->setCellValue('A2', 'Tanggal Tes :');
        $sheet->mergeCells('A2:B2');
        $sheet->setCellValue('A3', 'Tempat :');
        $sheet->mergeCells('A3:B3');
        $sheet->setCellValue('A4', 'Alamat :');
        $sheet->mergeCells('A4:B4');
        $sheet->setCellValue('A5', 'Tipe Ujian :');
        $sheet->mergeCells('A5:B5');

        $sheet->setCellValue('C1', $acara);
        $sheet->setCellValue('C2', $tanggal);
        $sheet->setCellValue('C3', $tempat);
        $sheet->setCellValue('C4', $alamat);
        $sheet->setCellValue('C5', $status_jenis);

        $sheet->setCellValue('A7', 'HASIL UJIAN '. $namaUjian);
        $sheet->mergeCells('A7:C7');
        $sheet->getStyle('A7')->getFont()->setBold(true)->setSize(16);
        // Menulis file Excel

        $query= new HasilUjian();  
        $statement= " AND B.JADWAL_TES_ID = ".$reqId. " and a.pegawai_id=".$reqPegawaiId;

        $query=$query->selectByParamsMonitoringPapiHasil($reqId, $statement)->first();      
        $nama_pegawai=$query->nama_pegawai;
        $nip_baru=$query->nip_baru;
        $nilai_w=$query->nilai_w;
        $info_w=$query->info_w;
        $nilai_f=$query->nilai_f;
        $info_f=$query->info_f;
        $nilai_k=$query->nilai_k;
        $info_k=$query->info_k;
        $nilai_z=$query->nilai_z;
        $info_z=$query->info_z;
        $nilai_o=$query->nilai_o;
        $info_o=$query->info_o;
        $nilai_b=$query->nilai_b;
        $info_b=$query->info_b;
        $nilai_x=$query->nilai_x;
        $info_x=$query->info_x;
        $nilai_p=$query->nilai_p;
        $info_p=$query->info_p;
        $nilai_a=$query->nilai_a;
        $info_a=$query->info_a;
        $nilai_n=$query->nilai_n;
        $info_n=$query->info_n;
        $nilai_g=$query->nilai_g;
        $info_g=$query->info_g;
        $nilai_l=$query->nilai_l;
        $info_l=$query->info_l;
        $nilai_i=$query->nilai_i;
        $info_i=$query->info_i;
        $nilai_t=$query->nilai_t;
        $info_t=$query->info_t;
        $nilai_v=$query->nilai_v;
        $info_v=$query->info_v;
        $nilai_s=$query->nilai_s;
        $info_s=$query->info_s;
        $nilai_r=$query->nilai_r;
        $info_r=$query->info_r;
        $nilai_d=$query->nilai_d;
        $info_d=$query->info_d;
        $nilai_c=$query->nilai_c;
        $info_c=$query->info_c;
        $nilai_e=$query->nilai_e;
        $info_e=$query->info_e;

        $sheet->setCellValue('A9', 'Nama Peserta :');
        $sheet->mergeCells('A9:B9');
        $sheet->setCellValue('A10', 'NPP Peserta :');
        $sheet->mergeCells('A10:B10');

        $sheet->setCellValue('C9', $nama_pegawai);
        $sheet->setCellValue('C10', "'".$nip_baru);

        // style head
        $sheet->getStyle('A12:C12')->getFont()->setBold(true)->setSize(14); // Bold dan ukuran font 14
        $sheet->getStyle('A12:C12')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4CAF50'); // Warna latar belakang hijau

        $sheet->getStyle('A12:C12')->getFont()->getColor()->setRGB('FFFFFF'); // Warna teks putih
        $sheet->getStyle('A12:C12')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('A12:C12')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // Border tipis di semua sisi sel
        $sheet->getStyle('A13:B32')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // head
        $sheet->setCellValue('A12', 'Faktor');
        $sheet->setCellValue('B12', 'Nilai');
        $sheet->setCellValue('C12', 'Keterangan');
        $sheet->getColumnDimension('C')->setWidth(50);

        $sheet->setCellValue('A13', 'W');
        $sheet->setCellValue('A14', 'F');
        $sheet->setCellValue('A15', 'K');
        $sheet->setCellValue('A16', 'Z');
        $sheet->setCellValue('A17', 'O');
        $sheet->setCellValue('A18', 'B');
        $sheet->setCellValue('A19', 'X');
        $sheet->setCellValue('A20', 'P');
        $sheet->setCellValue('A21', 'A');
        $sheet->setCellValue('A22', 'N');
        $sheet->setCellValue('A23', 'G');
        $sheet->setCellValue('A24', 'L');
        $sheet->setCellValue('A25', 'I');
        $sheet->setCellValue('A26', 'T');
        $sheet->setCellValue('A27', 'V');
        $sheet->setCellValue('A28', 'S');
        $sheet->setCellValue('A29', 'R');
        $sheet->setCellValue('A30', 'D');
        $sheet->setCellValue('A31', 'C');
        $sheet->setCellValue('A32', 'E');

        $sheet->setCellValue('B13', $nilai_w);
        $sheet->setCellValue('B14', $nilai_f);
        $sheet->setCellValue('B15', $nilai_k);
        $sheet->setCellValue('B16', $nilai_z);
        $sheet->setCellValue('B17', $nilai_o);
        $sheet->setCellValue('B18', $nilai_b);
        $sheet->setCellValue('B19', $nilai_x);
        $sheet->setCellValue('B20', $nilai_p);
        $sheet->setCellValue('B21', $nilai_a);
        $sheet->setCellValue('B22', $nilai_n);
        $sheet->setCellValue('B23', $nilai_g);
        $sheet->setCellValue('B24', $nilai_l);
        $sheet->setCellValue('B25', $nilai_i);
        $sheet->setCellValue('B26', $nilai_t);
        $sheet->setCellValue('B27', $nilai_v);
        $sheet->setCellValue('B28', $nilai_s);
        $sheet->setCellValue('B29', $nilai_r);
        $sheet->setCellValue('B30', $nilai_d);
        $sheet->setCellValue('B31', $nilai_c);
        $sheet->setCellValue('B32', $nilai_e);

        $sheet->setCellValue('C13', $info_w);
        $sheet->setCellValue('C14', $info_f);
        $sheet->setCellValue('C15', $info_k);
        $sheet->setCellValue('C16', $info_z);
        $sheet->setCellValue('C17', $info_o);
        $sheet->setCellValue('C18', $info_b);
        $sheet->setCellValue('C19', $info_x);
        $sheet->setCellValue('C20', $info_p);
        $sheet->setCellValue('C21', $info_a);
        $sheet->setCellValue('C22', $info_n);
        $sheet->setCellValue('C23', $info_g);
        $sheet->setCellValue('C24', $info_l);
        $sheet->setCellValue('C25', $info_i);
        $sheet->setCellValue('C26', $info_t);
        $sheet->setCellValue('C27', $info_v);
        $sheet->setCellValue('C28', $info_s);
        $sheet->setCellValue('C29', $info_r);
        $sheet->setCellValue('C30', $info_d);
        $sheet->setCellValue('C31', $info_c);
        $sheet->setCellValue('C32', $info_e);

        $sheet->getStyle('A12:C32')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); 

        $writer = new Xlsx($spreadsheet);
        
        // Menyimpan file Excel ke browser
        $fileName = $acara.'_'.$tanggal.'('.$namaUjian.').xlsx';
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
    }

    public function addviewcetakDISC(request $request)
    {
        $reqTipeUjian = $request->route('tipeUjian');
        $reqId = $request->route('reqId');
        $reqPegawaiId = $request->route('pegawaiId');

        $statement=" and pegawai_id=".$reqPegawaiId;
        $query = new Pegawai();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $nama=$query->nama;
        $nip=$query->nip_baru;
        if($query->jenis_kelamin=='P'){
          $jenis_kelamin='Perempuan';
        }
        else{
          $jenis_kelamin='Laki-laki';
        }

        $statement=" and tipe_ujian_id=".$reqTipeUjian;
        $query = new TipeUjian();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $namaUjian=$query->tipe;

        $statement=" and jadwal_tes_id=".$reqId;
        $query = new JadwalTes();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $acara=$query->acara;
        $tempat=$query->tempat;
        $alamat=$query->alamat;
        $status_jenis=$query->status_jenis;
        if($status_jenis==1){
          $status_jenis='Pemetaan';
        }
        else{
          $status_jenis='Seleksi';
        }
        $tanggal=explode(' ', $query->tanggal_tes) ;
        $tanggal=$tanggal[0];

         // Tentukan path ke file Excel yang ingin dibaca
        $file = 'template/DISC.xlsx';  // Ubah dengan path file Excel Anda

        // Membaca file Excel
        $spreadsheet = IOFactory::load($file);

        // Mengambil sheet pertama (indeks 0)
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('C4', $nama);
        $sheet->setCellValue('C5', $jenis_kelamin);
        $sheet->setCellValue('C6', $tanggal);


        $arrdata= array("d", "i", "s", "c");
        $statement=" and jadwal_tes_id=".$reqId." and a.pegawai_id=".$reqPegawaiId;
        $set = new HasilUjian();
        $set=$set->selectByParamsMonitoringDisc($reqId,$statement)->first();

        $valdata= array();
        $indexdata=0;

        $rowdatarow=10;
        $rowdatanextrow=7;
        for($x=1; $x<=3;$x++)
        {
          $rowdatacolom= 4;
          $rowdatanextcolom= 53;
          for($y=0;$y<count($arrdata);$y++)
          {
            $modestatus= $arrdata[$y];
            $modestatuskondisi= $modestatus.$x;

            $field= $modestatus."_".$x;
            $nilai= $set->$field;
            // $valdata[$indexdata][$field]= $nilai;

            $statementdetil= " AND STATUS_AKTIF = 1 AND MODE_STATUS = UPPER('".$modestatuskondisi."') AND NILAI = ".$nilai;
            $setdetil= new HasilUjian();
            $hasil= $setdetil->setkonversidisk($statementdetil)->first();
            // print_r($hasil);exit;
            unset($setdetil);
            $valdata[$indexdata][$field."_KONVERSI"]= $hasil->rowcount;

            $sheet->setCellValue(StringFunc::getColomsNew($rowdatacolom).$rowdatarow, $nilai);
            $rowdatacolom++;

            // kalau data terakhir ambil data * dan x bukan 3
            if($y == count($arrdata) - 1 && $x < 3)
            {
              $inisialisasi="x_".$x;
              $nilai= $set->$inisialisasi;
              $sheet->setCellValue(StringFunc::getColomsNew($rowdatacolom).$rowdatarow, $nilai);
            }
            // echo $rowdatanextcolom.'-';
            $sheet->setCellValue(StringFunc::getColomsNew($rowdatanextcolom-1).$rowdatanextrow, $hasil->rowcount);
            $rowdatanextcolom++;
          }
          $rowdatarow++;
          $rowdatanextrow= $rowdatanextrow + 2;
        }
        unset($set);
        // print_r($valdata);exit();

        $indexdata= 0;
        $nkesimpulan= array();
        for($x=1; $x<=3;$x++)
        {
          $d= $valdata[0]["d_".$x."_KONVERSI"];
          $i= $valdata[0]["i_".$x."_KONVERSI"];
          $s= $valdata[0]["s_".$x."_KONVERSI"];
          $c= $valdata[0]["c_".$x."_KONVERSI"];

          $setdetil= new HasilUjian();
          $hasil= $setdetil->setnkesimpulandisk($d, $i, $s, $c)->first();
          $hasil=$hasil->rowcount;
            // print_r($hasil->rowcount);exit;
          unset($setdetil);

          $nkesimpulan[$indexdata]= $hasil;
          $indexdata++;
        }
        // print_r($nkesimpulan);exit();

        $infoketerangan= array(
            array("kolomindex"=>13, "rowindex"=>6)
            , array("kolomindex"=>22, "rowindex"=>6)
            , array("kolomindex"=>13, "rowindex"=>21, "deskripsikolomindex"=>12, "deskripsirowindex"=>44, "jobkolomindex"=>12, "jobrowindex"=>59)
        );
        // print_r($infoketerangan);exit();
        // echo StringFunc::getColomsNew(12);exit();

        for($x=0; $x < count($infoketerangan); $x++)
        {
          if($nkesimpulan[$x]!=0){
            $statementdetil= " AND A.LINE = ".$nkesimpulan[$x]." AND A.STATUS_AKTIF = 1";
            $setdetil= new HasilUjian();
            $setdetil=$setdetil->selectByParamsDiscKesimpulan($statementdetil)->first();
            $infokesimpulanjudul= $setdetil->judul;
            $infokesimpulanjuduldetil= $setdetil->judul_detil;
            $infokesimpulandeskripsi= $setdetil->deskripsi;
            $infokesimpulansaran= $setdetil->saran;
            unset($setdetil);

            $colkesimpulan= $infoketerangan[$x]["kolomindex"];
            $rowkesimpulan= $infoketerangan[$x]["rowindex"];
            $sheet->setCellValue(StringFunc::getColomsNew($colkesimpulan).$rowkesimpulan, $infokesimpulanjudul);

            $rowkesimpulan++;
            $arrinfokesimpulanjuduldetil= explode("<br/>", $infokesimpulanjuduldetil);
            // print_r($arrinfokesimpulanjuduldetil);exit();
            $jumlahkesimpulan= count($arrinfokesimpulanjuduldetil);
            for($k=0; $k<$jumlahkesimpulan; $k++)
            {
              $sheet->setCellValue(StringFunc::getColomsNew($colkesimpulan).$rowkesimpulan, $arrinfokesimpulanjuduldetil[$k]);
              // echo StringFunc::getColomsNew($colkesimpulan).$rowkesimpulan.";;".$arrinfokesimpulanjuduldetil[$k]."<br/>";
              $rowkesimpulan++;
            }

            if($x == 2)
            {
              $hasildeskripsi= $infokesimpulandeskripsi;
              $colkesimpulan= $infoketerangan[$x]["deskripsikolomindex"];
              $rowkesimpulan= $infoketerangan[$x]["deskripsirowindex"];
              // echo StringFunc::getColomsNew($colkesimpulan).$rowkesimpulan.";;".$hasildeskripsi."<br/>";exit();
              $sheet->setCellValue(StringFunc::getColomsNew($colkesimpulan).$rowkesimpulan, $hasildeskripsi);

              $hasilsaran= $infokesimpulansaran;
              $colkesimpulan= $infoketerangan[$x]["jobkolomindex"];
              $rowkesimpulan= $infoketerangan[$x]["jobrowindex"];
              // echo StringFunc::getColomsNew($colkesimpulan).$rowkesimpulan.";;".$hasilsaran."<br/>";exit();
              $sheet->setCellValue(StringFunc::getColomsNew($colkesimpulan).$rowkesimpulan, $hasilsaran);
            }
          }
        }

        $writer = new Xlsx($spreadsheet);
        
        // Menyimpan file Excel ke browser
        $fileName = $acara.'_'.$tanggal.'('.$namaUjian.'_'.$nama.'_'.$nip.').xlsx';
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
    }

    public function addviewcetakRapidBaru(request $request)
    {
        $reqTipeUjian = $request->route('tipeUjian');
        $reqId = $request->route('reqId');

        $arrTipeUjian=array();
        $statement=" AND a.formula_assesment_id = (select xx.formula_id from jadwal_tes x  LEFT JOIN formula_eselon xx on x. formula_eselon_id = xx.formula_eselon_id where jadwal_tes_id=". $reqId.") and parent_id='0'";
        $query = new FormulaAssesmentUjianTahap();
        $query=$query->selectByParamsMonitoring($statement);
        foreach ($query as $rowData) {
          array_push($arrTipeUjian, $rowData->tipe_ujian_id);
        }

        $arrayVal=array();

        $query= new HasilUjian();      
        $statement= "";
        $statementdetil= " AND A.JADWAL_TES_ID = ".$reqId;

        if (in_array(1, $arrTipeUjian)){
          $query=$query->selectByParamsMonitoringCfitHasilRekapA($reqId,1, $statement, $statementdetil);
        }
        if (in_array(2, $arrTipeUjian)){
          $query=$query->selectByParamsMonitoringCfitHasilRekapB($reqId,2, $statement, $statementdetil);
        }
        // print_r($query);exit;

        foreach ($query as $rowData) {
          $arrayVal[$rowData->pegawai_id]['nama_pegawai']=$rowData->nama_pegawai;
          $arrayVal[$rowData->pegawai_id]['nip_baru']=$rowData->nip_baru;
          $arrayVal[$rowData->pegawai_id]['last_jabatan']=$rowData->last_jabatan;
          $arrayVal[$rowData->pegawai_id]['nilai_hasil']=$rowData->nilai_hasil;
          $arrayVal[$rowData->pegawai_id]['nama_satker']=$rowData->nama_satker;
          if($rowData->nilai_hasil<79){
            $arrayVal[$rowData->pegawai_id]['rating1']='1';
          }
          else if($rowData->nilai_hasil>=80 and $rowData->nilai_hasil<=89){
            $arrayVal[$rowData->pegawai_id]['rating1']='2';
          }
          else if($rowData->nilai_hasil>=90 and $rowData->nilai_hasil<=109){
            $arrayVal[$rowData->pegawai_id]['rating1']='3';
          }
          else if($rowData->nilai_hasil>=110 and $rowData->nilai_hasil<=119){
            $arrayVal[$rowData->pegawai_id]['rating1']='4';
          }
          else if($rowData->nilai_hasil>=120){
            $arrayVal[$rowData->pegawai_id]['rating1']='5';
          }
          $arrayVal[$rowData->pegawai_id]['jumlah_benar_0102']=$rowData->jumlah_benar_0102;
          if($rowData->jumlah_benar_0102<=2){
            $arrayVal[$rowData->pegawai_id]['rating22']='1';
          }
          else if($rowData->jumlah_benar_0102>=3 and $rowData->jumlah_benar_0102<=5){
            $arrayVal[$rowData->pegawai_id]['rating22']='2';
          }
          else if($rowData->jumlah_benar_0102>=6 and $rowData->jumlah_benar_0102<=8){
            $arrayVal[$rowData->pegawai_id]['rating22']='3';
          }
          else if($rowData->jumlah_benar_0102>=9 and $rowData->jumlah_benar_0102<=10){
            $arrayVal[$rowData->pegawai_id]['rating22']='4';
          }
          else if($rowData->jumlah_benar_0102>=11){
            $arrayVal[$rowData->pegawai_id]['rating22']='5';
          }
          $arrayVal[$rowData->pegawai_id]['jumlah_benar_0103']=$rowData->jumlah_benar_0103;
          if($rowData->jumlah_benar_0103<=2){
            $arrayVal[$rowData->pegawai_id]['rating23']='1';
          }
          else if($rowData->jumlah_benar_0103>=3 and $rowData->jumlah_benar_0103<=5){
            $arrayVal[$rowData->pegawai_id]['rating23']='2';
          }
          else if($rowData->jumlah_benar_0103>=6 and $rowData->jumlah_benar_0103<=8){
            $arrayVal[$rowData->pegawai_id]['rating23']='3';
          }
          else if($rowData->jumlah_benar_0103>=9 and $rowData->jumlah_benar_0103<=11){
            $arrayVal[$rowData->pegawai_id]['rating23']='4';
          }
          else if($rowData->jumlah_benar_0103>=12){
            $arrayVal[$rowData->pegawai_id]['rating23']='5';
          }
        }


        $query= new HasilUjian();  
        $statement= " AND B.JADWAL_TES_ID = ".$reqId;
        $query=$query->selectByParamsMonitoringPapiHasil($reqId, $statement);     
        foreach ($query as $rowData) { 
          $arrayVal[$rowData->pegawai_id]['n']=$rowData->nilai_n;
          $arrayVal[$rowData->pegawai_id]['i']=$rowData->nilai_i;
          $arrayVal[$rowData->pegawai_id]['g']=$rowData->nilai_g;
          $arrayVal[$rowData->pegawai_id]['a']=$rowData->nilai_a;
          $arrayVal[$rowData->pegawai_id]['r']=$rowData->nilai_r;
          $arrayVal[$rowData->pegawai_id]['e']=$rowData->nilai_e;
          $arrayVal[$rowData->pegawai_id]['k']=$rowData->nilai_k;
          $arrayVal[$rowData->pegawai_id]['z']=$rowData->nilai_z;
          $arrayVal[$rowData->pegawai_id]['s']=$rowData->nilai_s;
          $arrayVal[$rowData->pegawai_id]['b']=$rowData->nilai_b;
          $arrayVal[$rowData->pegawai_id]['o']=$rowData->nilai_o;
          $arrayVal[$rowData->pegawai_id]['x']=$rowData->nilai_x;
        }
          // print_r($arrayVal);exit;
          
                  
        $statement=" and tipe_ujian_id=".$reqTipeUjian;
        $query = new TipeUjian();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $standart=$query->kategori;

         // Tentukan path ke file Excel yang ingin dibaca
        $file = 'template/Rapid.xlsx';  // Ubah dengan path file Excel Anda

        // Membaca file Excel
        $spreadsheet = IOFactory::load($file);

        // Mengambil sheet pertama (indeks 0)
        // $sheet = $spreadsheet->getActiveSheet();
        $sheet = $spreadsheet->getSheet(0);
        $colom=4;
        foreach ($arrayVal as $key => $rowData) {
          $rating23 = isset($rowData['rating23']) ? $rowData['rating23'] : 0;
          $rating22 = isset($rowData['rating22']) ? $rowData['rating22'] : 0;
          $sheet->setCellValue('a'.$colom, ($colom-3));
          $sheet->setCellValue('B'.$colom, "'".$rowData['nip_baru']);
          $sheet->setCellValue('C'.$colom, $rowData['nama_pegawai']);
          $sheet->setCellValue('D'.$colom, $rowData['last_jabatan']);
          $sheet->setCellValue('E'.$colom, $rowData['nama_satker']);
          $sheet->setCellValue('F'.$colom, $standart);
          $sheet->setCellValue('G'.$colom, $rowData['nilai_hasil']);
          $sheet->setCellValue('H'.$colom, $rowData['rating1']);
          $sheet->setCellValue('I'.$colom, $rowData['jumlah_benar_0102']);
          $sheet->setCellValue('J'.$colom, $rating22);
          $sheet->setCellValue('K'.$colom, $rowData['jumlah_benar_0103']);
        // print_r($rowData['rating23']);exit;
          $sheet->setCellValue('L'.$colom, $rating23);
          $sheet->setCellValue('M'.$colom, (($rating22+$rating23)/2));
          $sheet->setCellValue('N'.$colom, $rowData['n']);
          $sheet->setCellValue('O'.$colom, $rowData['i']);
          $sheet->setCellValue('P'.$colom, round((($rowData['n']+1)/2)));
          $sheet->setCellValue('Q'.$colom, round((($rowData['i']+1)/2)));
          $sheet->setCellValue('R'.$colom, ((round((($rowData['n']+1)/2))+round((($rowData['i']+1)/2)))/2));
          $sheet->setCellValue('S'.$colom, $rowData['g']);
          $sheet->setCellValue('T'.$colom, $rowData['a']);
          $sheet->setCellValue('U'.$colom, round((($rowData['n']+1)/2)));
          $sheet->setCellValue('V'.$colom, round((($rowData['g']+1)/2)));
          $sheet->setCellValue('W'.$colom, round((($rowData['a']+1)/2)));
          $sheet->setCellValue('X'.$colom, ((round((($rowData['n']+1)/2))+round((($rowData['g']+1)/2))+round((($rowData['a']+1)/2)))/3));
          $sheet->setCellValue('Y'.$colom, $rowData['r']);
          $sheet->setCellValue('Z'.$colom, round((($rowData['n']+1)/2)));
          $sheet->setCellValue('AA'.$colom, round((($rowData['r']+1)/2)));
          $sheet->setCellValue('AB'.$colom, ((round((($rowData['n']+1)/2))+round((($rowData['r']+1)/2)))/2));
          $sheet->setCellValue('AC'.$colom, $rowData['e']);
          $sheet->setCellValue('AD'.$colom, $rowData['k']);
          $sheet->setCellValue('AE'.$colom, round((($rowData['e']+1)/2)));
          $sheet->setCellValue('AF'.$colom, round((($rowData['k']+1)/2)));
          $sheet->setCellValue('AG'.$colom, ((round((($rowData['e']+1)/2))+round((($rowData['k']+1)/2)))/2));
          $sheet->setCellValue('AH'.$colom, $rowData['z']);
          $sheet->setCellValue('AI'.$colom, round((($rowData['z']+1)/2)));
          $sheet->setCellValue('AJ'.$colom, round((($rowData['r']+1)/2)));
          $sheet->setCellValue('AK'.$colom, ((round((($rowData['z']+1)/2))+round((($rowData['r']+1)/2)))/2));
          $sheet->setCellValue('AL'.$colom, $rowData['s']);
          $sheet->setCellValue('AM'.$colom, $rowData['b']);
          $sheet->setCellValue('AN'.$colom, $rowData['o']);
          $sheet->setCellValue('AO'.$colom, $rowData['x']);
          $sheet->setCellValue('AP'.$colom, round((($rowData['s']+1)/2)));
          $sheet->setCellValue('AQ'.$colom, round((($rowData['b']+1)/2)));
          $sheet->setCellValue('AR'.$colom, round((($rowData['o']+1)/2)));
          $sheet->setCellValue('AS'.$colom, round((($rowData['x']+1)/2)));
          $sheet->setCellValue('AT'.$colom, ((round((($rowData['s']+1)/2))+round((($rowData['b']+1)/2))+round((($rowData['o']+1)/2))+round((($rowData['x']+1)/2)))/4));
          $sheet->setCellValue('AU'.$colom, ((
            $rowData['rating1']+
            (($rating22+$rating23)/2)+
            ((round((($rowData['n']+1)/2))+round((($rowData['i']+1)/2)))/2)+
            ((round((($rowData['n']+1)/2))+round((($rowData['g']+1)/2))+round((($rowData['a']+1)/2)))/3)+
            ((round((($rowData['n']+1)/2))+round((($rowData['r']+1)/2)))/2)+
            ((round((($rowData['e']+1)/2))+round((($rowData['k']+1)/2)))/2)+
            ((round((($rowData['z']+1)/2))+round((($rowData['r']+1)/2)))/2)+
            ((round((($rowData['s']+1)/2))+round((($rowData['b']+1)/2))+round((($rowData['o']+1)/2))+round((($rowData['x']+1)/2)))/4))
          /24)*100);
          if(((
            $rowData['rating1']+
            (($rating22+$rating23)/2)+
            ((round((($rowData['n']+1)/2))+round((($rowData['i']+1)/2)))/2)+
            ((round((($rowData['n']+1)/2))+round((($rowData['g']+1)/2))+round((($rowData['a']+1)/2)))/3)+
            ((round((($rowData['n']+1)/2))+round((($rowData['r']+1)/2)))/2)+
            ((round((($rowData['e']+1)/2))+round((($rowData['k']+1)/2)))/2)+
            ((round((($rowData['z']+1)/2))+round((($rowData['r']+1)/2)))/2)+
            ((round((($rowData['s']+1)/2))+round((($rowData['b']+1)/2))+round((($rowData['o']+1)/2))+round((($rowData['x']+1)/2)))/4))
          /24)*100 < 78 ){
            $desc='Kurang Optimal';
          }else if(((
            $rowData['rating1']+
            (($rating22+$rating23)/2)+
            ((round((($rowData['n']+1)/2))+round((($rowData['i']+1)/2)))/2)+
            ((round((($rowData['n']+1)/2))+round((($rowData['g']+1)/2))+round((($rowData['a']+1)/2)))/3)+
            ((round((($rowData['n']+1)/2))+round((($rowData['r']+1)/2)))/2)+
            ((round((($rowData['e']+1)/2))+round((($rowData['k']+1)/2)))/2)+
            ((round((($rowData['z']+1)/2))+round((($rowData['r']+1)/2)))/2)+
            ((round((($rowData['s']+1)/2))+round((($rowData['b']+1)/2))+round((($rowData['o']+1)/2))+round((($rowData['x']+1)/2)))/4))
          /24)*100 >= 78 && ((
            $rowData['rating1']+
            (($rating22+$rating23)/2)+
            ((round((($rowData['n']+1)/2))+round((($rowData['i']+1)/2)))/2)+
            ((round((($rowData['n']+1)/2))+round((($rowData['g']+1)/2))+round((($rowData['a']+1)/2)))/3)+
            ((round((($rowData['n']+1)/2))+round((($rowData['r']+1)/2)))/2)+
            ((round((($rowData['e']+1)/2))+round((($rowData['k']+1)/2)))/2)+
            ((round((($rowData['z']+1)/2))+round((($rowData['r']+1)/2)))/2)+
            ((round((($rowData['s']+1)/2))+round((($rowData['b']+1)/2))+round((($rowData['o']+1)/2))+round((($rowData['x']+1)/2)))/4))
          /24)*100 < 90 ){
            $desc='Cukup Optimal';
          }else if(((
            $rowData['rating1']+
            (($rating22+$rating23)/2)+
            ((round((($rowData['n']+1)/2))+round((($rowData['i']+1)/2)))/2)+
            ((round((($rowData['n']+1)/2))+round((($rowData['g']+1)/2))+round((($rowData['a']+1)/2)))/3)+
            ((round((($rowData['n']+1)/2))+round((($rowData['r']+1)/2)))/2)+
            ((round((($rowData['e']+1)/2))+round((($rowData['k']+1)/2)))/2)+
            ((round((($rowData['z']+1)/2))+round((($rowData['r']+1)/2)))/2)+
            ((round((($rowData['s']+1)/2))+round((($rowData['b']+1)/2))+round((($rowData['o']+1)/2))+round((($rowData['x']+1)/2)))/4))
          /24)*100 >= 90 ){
            $desc='Optimal';
          }
          $sheet->setCellValue('AV'.$colom, $desc);

          $colom++;
        }

        $sheet->getStyle('A4:AV'.($colom-1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); 

        $sheet = $spreadsheet->getSheet(1);

        $query= new HasilUjian();  
        $query=$query->selectByParamsHasilSJTKompetensi($reqId, $reqTipeUjian); 
        // print_r($query);exit;    
        foreach ($query as $rowData) { 
          $arrayVal[$rowData->pegawai_id][$rowData->kategori]=$rowData->konversi_baru;
        }

        $query= new HasilUjian();  
        $query=$query->selectByParamsMonitoringSJT($reqId,$reqTipeUjian);
        foreach ($query as $rowData) { 
          $arrayVal[$rowData->pegawai_id]['nilai']=$rowData->nilai;
          $arrayVal[$rowData->pegawai_id]['jpm2']=$rowData->jpm;
          $arrayVal[$rowData->pegawai_id]['pengisian_jabatan']=$rowData->pengisian_jabatan;
          $arrayVal[$rowData->pegawai_id]['pemetaan_kompetensi']=$rowData->pemetaan_kompetensi;
        } 

        $colom=4;

        // print_r($queryStandart->kategori);exit;
        
        foreach ($arrayVal as $key => $rowData) {
          // print_r($arrayVal);exit;
          $sheet->setCellValue('A'.$colom, ($colom-3));
          $sheet->setCellValue('B'.$colom, "'".$rowData['nip_baru']);
          $sheet->setCellValue('C'.$colom, $rowData['nama_pegawai']);
          $sheet->setCellValue('D'.$colom, $rowData['last_jabatan']);
          $sheet->setCellValue('E'.$colom, $rowData['nama_satker']);
          $sheet->setCellValue('F'.$colom, $standart);
          $sheet->setCellValue('G'.$colom, $rowData['int']);
          $sheet->setCellValue('H'.$colom, $rowData['kjsm']);
          $sheet->setCellValue('I'.$colom, $rowData['kom']);
          $sheet->setCellValue('J'.$colom, $rowData['oph']);
          $sheet->setCellValue('K'.$colom, $rowData['pp']);
          $sheet->setCellValue('L'.$colom, $rowData['pdol']);
          $sheet->setCellValue('M'.$colom, $rowData['mp']);
          $sheet->setCellValue('N'.$colom, $rowData['pk']);
          $sheet->setCellValue('O'.$colom, $rowData['pb']);
          $total=$rowData['int']+$rowData['kjsm']+$rowData['kom']+$rowData['oph']+$rowData['pp']+$rowData['pdol']+$rowData['mp']+$rowData['pk']+$rowData['pb'];
          $sheet->setCellValue('P'.$colom, $total);
          $jpm=( $total / (9*$standart))*100;
          $sheet->setCellValue('Q'.$colom, round($jpm,2));
          
          $query = new JadwalTes();
            $statement=" and jadwal_tes_id=".$reqId;
            $query=$query->selectByParamsMonitoring($statement)->first();
            $status_jenis=$query->status_jenis;
            if($status_jenis==1){
                // pemetaan
              if($jpm>=90){
              
                $desc='Optimal';
                  
              }
              else if($jpm<78){
                  
                $desc='Kurang Optimal';
              }
              else{
                  
                $desc='Cukup Optimal';
              }
            }
            else{
                // Seleksi
              if($jpm>=80){
              
                $desc='Memenuhi Syarat';
                  
              }
              else if($jpm<68){
                  
                $desc='Kurang Memenuhi Syarat';
              }
              else{
                  
                $desc='Masih Memenuhi Syarat';
              }
            }
        
          $sheet->setCellValue('R'.$colom, $desc);
          $colom++;
        }
        $sheet->getStyle('E4:R'.($colom-1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah

        $sheet->getStyle('A4:R'.($colom-1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); 


        $writer = new Xlsx($spreadsheet);
        // Menyimpan file Excel ke browser
        $fileName = 'RAPID.xlsx';
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
    }

    public function addviewcetakSJTBaru(request $request)
    {
        $reqTipeUjian = $request->route('tipeUjian');
        $reqId = $request->route('reqId');

        $arrTipeUjian=array();
        $statement=" AND a.formula_assesment_id = (select xx.formula_id from jadwal_tes x  LEFT JOIN formula_eselon xx on x. formula_eselon_id = xx.formula_eselon_id where jadwal_tes_id=". $reqId.") and parent_id='0'";
        $query = new FormulaAssesmentUjianTahap();
        $query=$query->selectByParamsMonitoring($statement);
        foreach ($query as $rowData) {
          array_push($arrTipeUjian, $rowData->tipe_ujian_id);
        }

        $arrayVal=array();
         // Tentukan path ke file Excel yang ingin dibaca
        $file = 'template/SJT.xlsx';  // Ubah dengan path file Excel Anda

        // Membaca file Excel
        $spreadsheet = IOFactory::load($file);

        // Mengambil sheet pertama (indeks 0)
        // $sheet = $spreadsheet->getActiveSheet();
        $sheet = $spreadsheet->getSheet(0);

        $query= new HasilUjian();  
        $query=$query->selectByParamsHasilSJTKompetensi($reqId, $reqTipeUjian); 
        foreach ($query as $rowData) { 
          $arrayVal[$rowData->pegawai_id][$rowData->kategori]=$rowData->konversi_baru;
        }

        $query= new HasilUjian();  
        $query=$query->selectByParamsMonitoringSJT($reqId,$reqTipeUjian);
        foreach ($query as $rowData) { 
          $arrayVal[$rowData->pegawai_id]['nama_pegawai']=$rowData->nama_pegawai;
          $arrayVal[$rowData->pegawai_id]['nip_baru']=$rowData->nip_baru;
          $arrayVal[$rowData->pegawai_id]['last_jabatan']=$rowData->last_jabatan;
          $arrayVal[$rowData->pegawai_id]['nilai']=$rowData->nilai;
          $arrayVal[$rowData->pegawai_id]['jpm2']=$rowData->jpm;
          $arrayVal[$rowData->pegawai_id]['pengisian_jabatan']=$rowData->pengisian_jabatan;
          $arrayVal[$rowData->pegawai_id]['pemetaan_kompetensi']=$rowData->pemetaan_kompetensi;
        } 
        // print_r($arrayVal);exit;    

        $colom=4;
        
        $statement=" and tipe_ujian_id=".$reqTipeUjian;
        $query = new TipeUjian();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $standart=$query->kategori;
        
        foreach ($arrayVal as $key => $rowData) {
          // print_r($arrayVal);exit;
          $sheet->setCellValue('a'.$colom, ($colom-3));
          $sheet->setCellValue('B'.$colom, "'".$rowData['nip_baru']);
          $sheet->setCellValue('C'.$colom, $rowData['nama_pegawai']);
          $sheet->setCellValue('D'.$colom, $rowData['last_jabatan']);
          $sheet->setCellValue('E'.$colom, $rowData['int']);
          $sheet->setCellValue('F'.$colom, $rowData['kjsm']);
          $sheet->setCellValue('G'.$colom, $rowData['kom']);
          $sheet->setCellValue('H'.$colom, $rowData['oph']);
          $sheet->setCellValue('I'.$colom, $rowData['pp']);
          $sheet->setCellValue('J'.$colom, $rowData['pdol']);
          $sheet->setCellValue('K'.$colom, $rowData['mp']);
          $sheet->setCellValue('L'.$colom, $rowData['pk']);
          $sheet->setCellValue('M'.$colom, $rowData['pb']);
          $total=$rowData['int']+$rowData['kjsm']+$rowData['kom']+$rowData['oph']+$rowData['pp']+$rowData['pdol']+$rowData['mp']+$rowData['pk']+$rowData['pb'];
          $sheet->setCellValue('N'.$colom, $total);
          $jpm=( $total / (9*$standart))*100;
          $sheet->setCellValue('o'.$colom, $jpm);
          $query = new JadwalTes();
            $statement=" and jadwal_tes_id=".$reqId;
            $query=$query->selectByParamsMonitoring($statement)->first();
            $status_jenis=$query->status_jenis;
            if($status_jenis==1){
                // pemetaan
              if($jpm>=90){
              
                $desc='Optimal';
                  
              }
              else if($jpm<78){
                  
                $desc='Kurang Optimal';
              }
              else{
                  
                $desc='Cukup Optimal';
              }
            }
            else{
                // Seleksi
              if($jpm>=80){
              
                $desc='Memenuhi Syarat';
                  
              }
              else if($jpm<68){
                  
                $desc='Kurang Memenuhi Syarat';
              }
              else{
                  
                $desc='Masih Memenuhi Syarat';
              }
            }
          
          $sheet->setCellValue('P'.$colom, $desc);
        
            $colom++;
          
        }
        $sheet->getStyle('E4:P'.($colom-1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah

        $sheet->getStyle('A4:P'.($colom-1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); 


        $writer = new Xlsx($spreadsheet);
        // Menyimpan file Excel ke browser
        $fileName = 'SJT.xlsx';
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
        
    }

    public function addviewcetakMMPI(request $request)
    {
        
        $reqTipeUjian = $request->route('tipeUjian');
        $reqId = $request->route('reqId');
        $reqPegawaiId = $request->route('pegawaiId');
        $statement=" and tipe_ujian_id=".$reqTipeUjian;
        $query = new TipeUjian();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $namaUjian=$query->tipe;

        $statement=" and jadwal_tes_id=".$reqId;
        $query = new JadwalTes();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $acara=$query->acara;
        $tempat=$query->tempat;
        $alamat=$query->alamat;
        $status_jenis=$query->status_jenis;
        if($status_jenis==1){
          $status_jenis='Pemetaan';
        }
        else{
          $status_jenis='Seleksi';
        }
        $tanggal=explode(' ', $query->tanggal_tes) ;
        $tanggal=$tanggal[0];
       // Membuat objek spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Menulis data ke spreadsheet
        $sheet->setCellValue('A1', 'Nama :');
        $sheet->mergeCells('A1:B1');
        $sheet->setCellValue('A2', 'Tanggal Tes :');
        $sheet->mergeCells('A2:B2');
        $sheet->setCellValue('A3', 'Tempat :');
        $sheet->mergeCells('A3:B3');
        $sheet->setCellValue('A4', 'Alamat :');
        $sheet->mergeCells('A4:B4');
        $sheet->setCellValue('A5', 'Tipe Ujian :');
        $sheet->mergeCells('A5:B5');

        $sheet->setCellValue('C1', $acara);
        $sheet->setCellValue('C2', $tanggal);
        $sheet->setCellValue('C3', $tempat);
        $sheet->setCellValue('C4', $alamat);
        $sheet->setCellValue('C5', $status_jenis);

        $sheet->setCellValue('A7', 'HASIL UJIAN '. $namaUjian);
        $sheet->mergeCells('A7:C7');
        $sheet->getStyle('A7')->getFont()->setBold(true)->setSize(16);
        // Menulis file Excel
        $statement=" and pegawai_id=".$reqPegawaiId;
        $query = new Pegawai();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $nama_pegawai=$query->nama;
        $nip_baru=$query->nip_baru;

        $sheet->setCellValue('A9', 'Nama Peserta :');
        $sheet->mergeCells('A9:B9');
        $sheet->setCellValue('A10', 'NPP Peserta :');
        $sheet->mergeCells('A10:B10');

        $sheet->setCellValue('C9', $nama_pegawai);
        $sheet->setCellValue('C10', "'".$nip_baru);

        $query= new HasilUjian();  
        $statement= " AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.TIPE_UJIAN_ID = ".$reqTipeUjian;
        $query=$query->selectByParamsHasilMMPI($reqId, $statement);
        // print_r(count($query));exit;

        // style head
        $sheet->getStyle('A12:D12')->getFont()->setBold(true)->setSize(14); // Bold dan ukuran font 14
        $sheet->getStyle('A12:D12')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4CAF50'); // Warna latar belakang hijau

        $sheet->getStyle('A12:D12')->getFont()->getColor()->setRGB('FFFFFF'); // Warna teks putih
        $sheet->getStyle('A12:D12')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('A12:D12')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // Border tipis di semua sisi sel
        // $sheet->getStyle('A13:B32')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // head
        $sheet->setCellValue('A12', 'No');
        $sheet->mergeCells('B12:C12');
        $sheet->setCellValue('B12', 'IndiKator');
        $sheet->setCellValue('D12', 'Pilihan');
        $sheet->getColumnDimension('C')->setWidth(100);
        $sheet->getColumnDimension('D')->setWidth(20);

        $row=13;
        $no=1;
        foreach ($query as $rowData) {
          // print_r($rowData->pertanyaan);exit;
          $sheet->setCellValue('A'.$row, $no);
          $sheet->mergeCells('B'.$row.':C'.$row);
          $sheet->setCellValue('B'.$row, $rowData->pertanyaan);
          $sheet->setCellValue('D'.$row, $rowData->jawaban);
          $row++;
          $no++;
        }  

        $sheet->getStyle('A12:D'.($row-1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); 

        $writer = new Xlsx($spreadsheet);
        
        // Menyimpan file Excel ke browser
        $fileName = $acara.'_'.$tanggal.'('.$nama_pegawai.'_'.$nip_baru.').xlsx';
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
    }



    public function addviewcetakSJTPDF(request $request)
    {
        $reqId= $request->route('id');
        $tipeUjianId= $request->route('tipeUjianId');
        $reqPegawaiId= $request->route('pegawaiId');
        
        $statement=" and jadwal_tes_id=".$reqId;
        $query = new SettingJadwal();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $tipe_formula=$query->tipe_formula;
    

        $statement=" and jadwal_tes_id=".$reqId;
        $query = new JadwalTes();
        $queryJadwal=$query->selectByParamsMonitoring($statement)->first();
        // print_r($queryJadwal);exit;

        $queryIdentitas= new Pegawai();  
        $statement= " and a.pegawai_id=".$reqPegawaiId;
        $queryIdentitas=$queryIdentitas->selectByParamsMonitoring( $statement)->first();

        $arrTipeUjian=array();
        $statement=" AND a.formula_assesment_id = (select xx.formula_id from jadwal_tes x  LEFT JOIN formula_eselon xx on x. formula_eselon_id = xx.formula_eselon_id where jadwal_tes_id=". $reqId.") and parent_id='0'";
        $query = new FormulaAssesmentUjianTahap();
        $query=$query->selectByParamsMonitoring($statement);
        foreach ($query as $rowData) {
          array_push($arrTipeUjian, $rowData->tipe_ujian_id);
        }

        $arrayVal=array();

        $query= new HasilUjian();      
        $statement= "";
        $statementdetil= " AND A.JADWAL_TES_ID = ".$reqId." AND A.pegawai_id = ".$reqPegawaiId;

        if (in_array(1, $arrTipeUjian)){
          $rowData=$query->selectByParamsMonitoringCfitHasilRekapA($reqId,1, $statement, $statementdetil)->first();
            $arrayVal['nama_pegawai']=$rowData->nama_pegawai;
            $arrayVal['nip_baru']=$rowData->nip_baru;
            $arrayVal['last_jabatan']=$rowData->last_jabatan;
            $arrayVal['nilai_hasil']=$rowData->nilai_hasil;
            $arrayVal['nama_satker']=$rowData->nama_satker;
        }
        else if (in_array(2, $arrTipeUjian)){
          $rowData=$query->selectByParamsMonitoringCfitHasilRekapB($reqId,2, $statement, $statementdetil)->first();
            $arrayVal['nama_pegawai']=$rowData->nama_pegawai;
            $arrayVal['nip_baru']=$rowData->nip_baru;
            $arrayVal['last_jabatan']=$rowData->last_jabatan;
            $arrayVal['nilai_hasil']=$rowData->nilai_hasil;
            $arrayVal['nama_satker']=$rowData->nama_satker;
        }
        else{
            $rowData= new Pegawai();  
            $statement= " and a.pegawai_id=".$reqPegawaiId;
            $rowData=$rowData->selectByParamsMonitoring( $statement)->first();
            $arrayVal['nama_pegawai']=$rowData->nama;
            $arrayVal['nip_baru']=$rowData->nip_baru;
            $arrayVal['last_jabatan']=$rowData->last_jabatan;
            $arrayVal['nama_satker']=$rowData->nama_satker;
            $arrayVal['nilai_hasil']='0';
        }
        // print_r($rowData);exit;
        if($tipe_formula==2){
            if($arrayVal['nilai_hasil']<79){
              $arrayVal['rating1']='1';
            }
            else if($rowData->nilai_hasil>=80 and $rowData->nilai_hasil<=89){
              $arrayVal['rating1']='2';
            }
            else if($rowData->nilai_hasil>=90 and $rowData->nilai_hasil<=109){
              $arrayVal['rating1']='3';
            }
            else if($rowData->nilai_hasil>=110 and $rowData->nilai_hasil<=119){
              $arrayVal['rating1']='4';
            }
            else if($rowData->nilai_hasil>=120){
              $arrayVal['rating1']='5';
            }
            $arrayVal['jumlah_benar_0102']=$rowData->jumlah_benar_0102;
            if($rowData->jumlah_benar_0102<=2){
              $arrayVal['rating22']='1';
            }
            else if($rowData->jumlah_benar_0102>=3 and $rowData->jumlah_benar_0102<=5){
              $arrayVal['rating22']='2';
            }
            else if($rowData->jumlah_benar_0102>=6 and $rowData->jumlah_benar_0102<=8){
              $arrayVal['rating22']='3';
            }
            else if($rowData->jumlah_benar_0102>=9 and $rowData->jumlah_benar_0102<=10){
              $arrayVal['rating22']='4';
            }
            else if($rowData->jumlah_benar_0102>=11){
              $arrayVal['rating22']='5';
            }
            $arrayVal['jumlah_benar_0103']=$rowData->jumlah_benar_0103;
            if($rowData->jumlah_benar_0103<=2){
              $arrayVal['rating23']='1';
            }
            else if($rowData->jumlah_benar_0103>=3 and $rowData->jumlah_benar_0103<=5){
              $arrayVal['rating23']='2';
            }
            else if($rowData->jumlah_benar_0103>=6 and $rowData->jumlah_benar_0103<=8){
              $arrayVal['rating23']='3';
            }
            else if($rowData->jumlah_benar_0103>=9 and $rowData->jumlah_benar_0103<=11){
              $arrayVal['rating23']='4';
            }
            else if($rowData->jumlah_benar_0103>=12){
              $arrayVal['rating23']='5';
            }
    
            $query= new HasilUjian();  
            $statement= " AND B.JADWAL_TES_ID = ".$reqId." AND b.pegawai_id = ".$reqPegawaiId;
            $rowData=$query->selectByParamsMonitoringPapiHasil($reqId, $statement)->first(); 
            $arrayVal['n']=$rowData->nilai_n;
            $arrayVal['i']=$rowData->nilai_i;
            $arrayVal['g']=$rowData->nilai_g;
            $arrayVal['a']=$rowData->nilai_a;
            $arrayVal['r']=$rowData->nilai_r;
            $arrayVal['e']=$rowData->nilai_e;
            $arrayVal['k']=$rowData->nilai_k;
            $arrayVal['z']=$rowData->nilai_z;
            $arrayVal['s']=$rowData->nilai_s;
            $arrayVal['b']=$rowData->nilai_b;
            $arrayVal['o']=$rowData->nilai_o;
            $arrayVal['x']=$rowData->nilai_x;
            $arrayVal['rating2']=round(($arrayVal['rating22']+$arrayVal['rating23'])/2,2);
            $arrayVal['rating3']=round((round((($arrayVal['n']+1)/2))+round((($arrayVal['i']+1)/2)))/2,2);
            $arrayVal['rating4']=round((round((($arrayVal['n']+1)/2))+round((($arrayVal['g']+1)/2))+round((($arrayVal['a']+1)/2)))/3,2);
            $arrayVal['rating5']=round((round((($arrayVal['n']+1)/2))+round((($arrayVal['r']+1)/2)))/2,2);
            $arrayVal['rating6']=round((round((($arrayVal['e']+1)/2))+round((($arrayVal['k']+1)/2)))/2,2);
            $arrayVal['rating7']=round((round((($arrayVal['z']+1)/2))+round((($arrayVal['r']+1)/2)))/2,2);
            $arrayVal['rating8']=round((round((($arrayVal['s']+1)/2))+round((($arrayVal['b']+1)/2))+round((($arrayVal['o']+1)/2))+round((($arrayVal['x']+1)/2)))/4,2);
            $arrayVal['jpm']=((
                $arrayVal['rating1']+
                (($arrayVal['rating22']+$arrayVal['rating23'])/2)+
                ((round((($arrayVal['n']+1)/2))+round((($arrayVal['i']+1)/2)))/2)+
                ((round((($arrayVal['n']+1)/2))+round((($arrayVal['g']+1)/2))+round((($arrayVal['a']+1)/2)))/3)+
                ((round((($arrayVal['n']+1)/2))+round((($arrayVal['r']+1)/2)))/2)+
                ((round((($arrayVal['e']+1)/2))+round((($arrayVal['k']+1)/2)))/2)+
                ((round((($arrayVal['z']+1)/2))+round((($arrayVal['r']+1)/2)))/2)+
                ((round((($arrayVal['s']+1)/2))+round((($arrayVal['b']+1)/2))+round((($arrayVal['o']+1)/2))+round((($arrayVal['x']+1)/2)))/4))
              /24)*100;
            if(((
              $arrayVal['rating1']+
              (($arrayVal['rating22']+$arrayVal['rating23'])/2)+
              ((round((($arrayVal['n']+1)/2))+round((($arrayVal['i']+1)/2)))/2)+
              ((round((($arrayVal['n']+1)/2))+round((($arrayVal['g']+1)/2))+round((($arrayVal['a']+1)/2)))/3)+
              ((round((($arrayVal['n']+1)/2))+round((($arrayVal['r']+1)/2)))/2)+
              ((round((($arrayVal['e']+1)/2))+round((($arrayVal['k']+1)/2)))/2)+
              ((round((($arrayVal['z']+1)/2))+round((($arrayVal['r']+1)/2)))/2)+
              ((round((($arrayVal['s']+1)/2))+round((($arrayVal['b']+1)/2))+round((($arrayVal['o']+1)/2))+round((($arrayVal['x']+1)/2)))/4))
            /24)*100 < 78 ){
              $desc='Kurang Optimal';
            }else if(((
              $arrayVal['rating1']+
              (($arrayVal['rating22']+$arrayVal['rating23'])/2)+
              ((round((($arrayVal['n']+1)/2))+round((($arrayVal['i']+1)/2)))/2)+
              ((round((($arrayVal['n']+1)/2))+round((($arrayVal['g']+1)/2))+round((($arrayVal['a']+1)/2)))/3)+
              ((round((($arrayVal['n']+1)/2))+round((($arrayVal['r']+1)/2)))/2)+
              ((round((($arrayVal['e']+1)/2))+round((($arrayVal['k']+1)/2)))/2)+
              ((round((($arrayVal['z']+1)/2))+round((($arrayVal['r']+1)/2)))/2)+
              ((round((($arrayVal['s']+1)/2))+round((($arrayVal['b']+1)/2))+round((($arrayVal['o']+1)/2))+round((($arrayVal['x']+1)/2)))/4))
            /24)*100 >= 78 ){
              $desc='Optimal';
            }
            else{
              $desc='Cukup Optimal';
            }
            $arrayVal['kategori']=$desc;
        }
        $query= new HasilUjian();  
        $statement=" and pegawai_id= ".$reqPegawaiId;
        $query=$query->selectByParamsHasilSJTKompetensi($reqId, $tipeUjianId, $statement); 
        foreach ($query as $rowData) { 
          $arrayVal[$rowData->kategori]=$rowData->konversi;
        }
        
        $query= new HasilUjian();  
        $statement=" and pegawai_id= ".$reqPegawaiId;
        $query=$query->selectByParamsMonitoringSJT($reqId,$tipeUjianId,$statement);
        foreach ($query as $rowData) { 
          $arrayVal['nilai']=$rowData->nilai;
          $arrayVal['jpm2']=$rowData->jpm;
          $arrayVal['pengisian_jabatan']=$rowData->pengisian_jabatan;
          $arrayVal['pemetaan_kompetensi']=$rowData->pemetaan_kompetensi;
        } 
        // print_r($arrayVal);exit;

        $query= new HasilUjian();  
        $statement=" and pegawai_id= ".$reqPegawaiId;
        $queryStandar=$query->selectByParamsHasilSJTStandartEselon($statement)->first();
        
        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 15,     // Margin kiri (mm)
            'margin_right' => 15,    // Margin kanan (mm)
            'margin_top' => 30,      // Margin atas (mm)
            'margin_bottom' => 20,   // Margin bawah (mm)
            'margin_header' => 10,   // Jarak antara header dan konten (mm)
            'margin_footer' => 10,   // Jarak antara footer dan konten (mm)
        ]);

        $data = [
            'title' => 'Contoh PDF',
            'content' => 'Ini adalah contoh konten untuk PDF yang dihasilkan menggunakan mPDF di Laravel.',
            'queryIdentitas' => $queryIdentitas,
            'arrayVal' => $arrayVal,
            'queryStandar' => $queryStandar,
            'queryJadwal' => $queryJadwal,
        ];
        
          if($tipe_formula==2){
              
        // echo'xxxx';exit;
            $html = view('cetakan/laporan_rapid', $data)->render();
          }
          else{
            //   echo'xxxx';exit;
              $html = view('cetakan/laporan_sjt', $data)->render();
          }


        $mpdf->SetHTMLHeader('
          <table style="width:100%">
            <tr>
              <td style="width:50%"><img src="images/logobps.png" style="height:50px"></td>
              <td style="text-align:right"><img src="images/logoassesment.png" style="height:50px"></td>
            </tr>
          </table>
        ');

        $mpdf->WriteHTML($html);
        $mpdf->Output('document.pdf', 'I');
    }
    
    

    public function addviewcetakPapiSemua(request $request)
    {
        $reqTipeUjian = $request->route('tipeUjianId');
        $reqId = $request->route('reqId');
        
        $statement=" and tipe_ujian_id=".$reqTipeUjian;
        $query = new TipeUjian();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $namaUjian=$query->tipe;

        $statement=" and jadwal_tes_id=".$reqId;
        $query = new JadwalTes();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $acara=$query->acara;
        $tempat=$query->tempat;
        $alamat=$query->alamat;
        $status_jenis=$query->status_jenis;
        if($status_jenis==1){
          $status_jenis='Pemetaan';
        }
        else{
          $status_jenis='Seleksi';
        }
        $tanggal=explode(' ', $query->tanggal_tes) ;
        $tanggal=$tanggal[0];
       // Membuat objek spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Menulis data ke spreadsheet
        $sheet->setCellValue('A1', 'Nama :');
        $sheet->mergeCells('A1:B1');
        $sheet->setCellValue('A2', 'Tanggal Tes :');
        $sheet->mergeCells('A2:B2');
        $sheet->setCellValue('A3', 'Tempat :');
        $sheet->mergeCells('A3:B3');
        $sheet->setCellValue('A4', 'Alamat :');
        $sheet->mergeCells('A4:B4');
        $sheet->setCellValue('A5', 'Tipe Ujian :');
        $sheet->mergeCells('A5:B5');

        $sheet->setCellValue('C1', $acara);
        $sheet->setCellValue('C2', $tanggal);
        $sheet->setCellValue('C3', $tempat);
        $sheet->setCellValue('C4', $alamat);
        $sheet->setCellValue('C5', $status_jenis);

        $sheet->setCellValue('A7', 'HASIL UJIAN '. $namaUjian);
        $sheet->mergeCells('A7:C7');
        $sheet->getStyle('A7')->getFont()->setBold(true)->setSize(16);
        // Menulis file Excel

        $query= new HasilUjian();  
        $statement= " AND B.JADWAL_TES_ID = ".$reqId;
        
        // style head
        $sheet->getStyle('A9:AQ10')->getFont()->setBold(true)->setSize(14); // Bold dan ukuran font 14
        $sheet->getStyle('A9:AQ10')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('4CAF50'); // Warna latar belakang hijau
        $sheet->getStyle('A9:AQ10')->getFont()->getColor()->setRGB('FFFFFF'); // Warna teks putih
        $sheet->getStyle('A9:AQ10')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('A9:AQ10')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); // Border tipis di semua sisi sel
        $sheet->getStyle('A13:AQ32')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // head
        $sheet->setCellValue('A9', 'No');
        $sheet->mergeCells('A9:A10');
        $sheet->setCellValue('B9', 'Nama');
        $sheet->mergeCells('B9:B10');
        $sheet->setCellValue('C9', 'Npp');
        $sheet->mergeCells('C9:C10');
        $sheet->setCellValue('D9', 'Faktor W');
        $sheet->mergeCells('D9:E9');
        $sheet->setCellValue('F9', 'Faktor F');
        $sheet->mergeCells('F9:G9');
        $sheet->setCellValue('H9', 'Faktor K');
        $sheet->mergeCells('H9:I9');
        $sheet->setCellValue('J9', 'Faktor Z');
        $sheet->mergeCells('J9:K9');
        $sheet->setCellValue('L9', 'Faktor O');
        $sheet->mergeCells('L9:M9');
        $sheet->setCellValue('N9', 'Faktor B');
        $sheet->mergeCells('N9:O9');
        $sheet->setCellValue('P9', 'Faktor X');
        $sheet->mergeCells('P9:Q9');
        $sheet->setCellValue('R9', 'Faktor P');
        $sheet->mergeCells('R9:S9');
        $sheet->setCellValue('T9', 'Faktor A');
        $sheet->mergeCells('T9:U9');
        $sheet->setCellValue('V9', 'Faktor N');
        $sheet->mergeCells('V9:W9');
        $sheet->setCellValue('X9', 'Faktor G');
        $sheet->mergeCells('X9:Y9');
        $sheet->setCellValue('Z9', 'Faktor L');
        $sheet->mergeCells('Z9:AA9');
        $sheet->setCellValue('AB9', 'Faktor I');
        $sheet->mergeCells('AB9:AC9');
        $sheet->setCellValue('AD9', 'Faktor T');
        $sheet->mergeCells('AD9:AE9');
        $sheet->setCellValue('AF9', 'Faktor V');
        $sheet->mergeCells('AF9:AG9');
        $sheet->setCellValue('AH9', 'Faktor S');
        $sheet->mergeCells('AH9:AI9');
        $sheet->setCellValue('AJ9', 'Faktor R');
        $sheet->mergeCells('AJ9:AK9');
        $sheet->setCellValue('AL9', 'Faktor D');
        $sheet->mergeCells('AL9:AM9');
        $sheet->setCellValue('AN9', 'Faktor C');
        $sheet->mergeCells('AN9:AO9');
        $sheet->setCellValue('AP9', 'Faktor E');
        $sheet->mergeCells('AP9:AQ9');
        
        
        $sheet->setCellValue('D10', 'Nilai');
        $sheet->setCellValue('E10', 'Keterangan');
        $sheet->getColumnDimension('E')->setWidth(50);
        $sheet->setCellValue('F10', 'Nilai');
        $sheet->setCellValue('G10', 'Keterangan');
        $sheet->getColumnDimension('G')->setWidth(50);
        $sheet->setCellValue('H10', 'Nilai');
        $sheet->setCellValue('I10', 'Keterangan');
        $sheet->getColumnDimension('I')->setWidth(50);
        $sheet->setCellValue('J10', 'Nilai');
        $sheet->setCellValue('K10', 'Keterangan');
        $sheet->getColumnDimension('K')->setWidth(50);
        $sheet->setCellValue('L10', 'Nilai');
        $sheet->setCellValue('M10', 'Keterangan');
        $sheet->getColumnDimension('M')->setWidth(50);
        $sheet->setCellValue('N10', 'Nilai');
        $sheet->setCellValue('O10', 'Keterangan');
        $sheet->getColumnDimension('O')->setWidth(50);
        $sheet->setCellValue('P10', 'Nilai');
        $sheet->setCellValue('Q10', 'Keterangan');
        $sheet->getColumnDimension('Q')->setWidth(50);
        $sheet->setCellValue('R10', 'Nilai');
        $sheet->setCellValue('S10', 'Keterangan');
        $sheet->getColumnDimension('S')->setWidth(50);
        $sheet->setCellValue('T10', 'Nilai');
        $sheet->setCellValue('U10', 'Keterangan');
        $sheet->getColumnDimension('U')->setWidth(50);
        $sheet->setCellValue('V10', 'Nilai');
        $sheet->setCellValue('W10', 'Keterangan');
        $sheet->getColumnDimension('W')->setWidth(50);
        $sheet->setCellValue('X10', 'Nilai');
        $sheet->setCellValue('Y10', 'Keterangan');
        $sheet->getColumnDimension('Y')->setWidth(50);
        $sheet->setCellValue('Z10', 'Nilai');
        $sheet->setCellValue('AA10', 'Keterangan');
        $sheet->getColumnDimension('AA')->setWidth(50);
        $sheet->setCellValue('AB10', 'Nilai');
        $sheet->setCellValue('AC10', 'Keterangan');
        $sheet->getColumnDimension('AC')->setWidth(50);
        $sheet->setCellValue('AD10', 'Nilai');
        $sheet->setCellValue('AE10', 'Keterangan');
        $sheet->getColumnDimension('AE')->setWidth(50);
        $sheet->setCellValue('AF10', 'Nilai');
        $sheet->setCellValue('AG10', 'Keterangan');
        $sheet->getColumnDimension('AG')->setWidth(50);
        $sheet->setCellValue('AH10', 'Nilai');
        $sheet->setCellValue('AI10', 'Keterangan');
        $sheet->getColumnDimension('AI')->setWidth(50);
        $sheet->setCellValue('AJ10', 'Nilai');
        $sheet->setCellValue('AK10', 'Keterangan');
        $sheet->getColumnDimension('AK')->setWidth(50);
        $sheet->setCellValue('AL10', 'Nilai');
        $sheet->setCellValue('AM10', 'Keterangan');
        $sheet->getColumnDimension('AM')->setWidth(50);
        $sheet->setCellValue('AN10', 'Nilai');
        $sheet->setCellValue('AO10', 'Keterangan');
        $sheet->getColumnDimension('AO')->setWidth(50);
        $sheet->setCellValue('AP10', 'Nilai');
        $sheet->setCellValue('AQ10', 'Keterangan');
        $sheet->getColumnDimension('AQ')->setWidth(50);

        $query=$query->selectByParamsMonitoringPapiHasil($reqId, $statement);

        $start=10;
        $i=1;
        foreach ($query as $rowData) {
            $nama_pegawai=$rowData->nama_pegawai;
            $nip_baru=$rowData->nip_baru;
            $nilai_w=$rowData->nilai_w;
            $info_w=$rowData->info_w;
            $nilai_f=$rowData->nilai_f;
            $info_f=$rowData->info_f;
            $nilai_k=$rowData->nilai_k;
            $info_k=$rowData->info_k;
            $nilai_z=$rowData->nilai_z;
            $info_z=$rowData->info_z;
            $nilai_o=$rowData->nilai_o;
            $info_o=$rowData->info_o;
            $nilai_b=$rowData->nilai_b;
            $info_b=$rowData->info_b;
            $nilai_x=$rowData->nilai_x;
            $info_x=$rowData->info_x;
            $nilai_p=$rowData->nilai_p;
            $info_p=$rowData->info_p;
            $nilai_a=$rowData->nilai_a;
            $info_a=$rowData->info_a;
            $nilai_n=$rowData->nilai_n;
            $info_n=$rowData->info_n;
            $nilai_g=$rowData->nilai_g;
            $info_g=$rowData->info_g;
            $nilai_l=$rowData->nilai_l;
            $info_l=$rowData->info_l;
            $nilai_i=$rowData->nilai_i;
            $info_i=$rowData->info_i;
            $nilai_t=$rowData->nilai_t;
            $info_t=$rowData->info_t;
            $nilai_v=$rowData->nilai_v;
            $info_v=$rowData->info_v;
            $nilai_s=$rowData->nilai_s;
            $info_s=$rowData->info_s;
            $nilai_r=$rowData->nilai_r;
            $info_r=$rowData->info_r;
            $nilai_d=$rowData->nilai_d;
            $info_d=$rowData->info_d;
            $nilai_c=$rowData->nilai_c;
            $info_c=$rowData->info_c;
            $nilai_e=$rowData->nilai_e;
            $info_e=$rowData->info_e;
            
            $sheet->setCellValue('A'.($start+$i), $i);
            $sheet->setCellValue('B'.($start+$i), $nama_pegawai);
            $sheet->setCellValue('C'.($start+$i), "'".$nip_baru);
    
            $sheet->setCellValue('D'.($start+$i), $nilai_w);
            $sheet->setCellValue('F'.($start+$i), $nilai_f);
            $sheet->setCellValue('H'.($start+$i), $nilai_k);
            $sheet->setCellValue('J'.($start+$i), $nilai_z);
            $sheet->setCellValue('L'.($start+$i), $nilai_o);
            $sheet->setCellValue('N'.($start+$i), $nilai_b);
            $sheet->setCellValue('P'.($start+$i), $nilai_x);
            $sheet->setCellValue('R'.($start+$i), $nilai_p);
            $sheet->setCellValue('T'.($start+$i), $nilai_a);
            $sheet->setCellValue('V'.($start+$i), $nilai_n);
            $sheet->setCellValue('X'.($start+$i), $nilai_g);
            $sheet->setCellValue('Z'.($start+$i), $nilai_l);
            $sheet->setCellValue('AB'.($start+$i), $nilai_i);
            $sheet->setCellValue('AD'.($start+$i), $nilai_t);
            $sheet->setCellValue('AF'.($start+$i), $nilai_v);
            $sheet->setCellValue('AH'.($start+$i), $nilai_s);
            $sheet->setCellValue('AJ'.($start+$i), $nilai_r);
            $sheet->setCellValue('AL'.($start+$i), $nilai_d);
            $sheet->setCellValue('AN'.($start+$i), $nilai_c);
            $sheet->setCellValue('AP'.($start+$i), $nilai_e);
    
            $sheet->setCellValue('E'.($start+$i), $info_w);
            $sheet->setCellValue('G'.($start+$i), $info_f);
            $sheet->setCellValue('I'.($start+$i), $info_k);
            $sheet->setCellValue('K'.($start+$i), $info_z);
            $sheet->setCellValue('M'.($start+$i), $info_o);
            $sheet->setCellValue('O'.($start+$i), $info_b);
            $sheet->setCellValue('Q'.($start+$i), $info_x);
            $sheet->setCellValue('S'.($start+$i), $info_p);
            $sheet->setCellValue('U'.($start+$i), $info_a);
            $sheet->setCellValue('W'.($start+$i), $info_n);
            $sheet->setCellValue('Y'.($start+$i), $info_g);
            $sheet->setCellValue('AA'.($start+$i), $info_l);
            $sheet->setCellValue('AC'.($start+$i), $info_i);
            $sheet->setCellValue('AE'.($start+$i), $info_t);
            $sheet->setCellValue('AG'.($start+$i), $info_v);
            $sheet->setCellValue('AI'.($start+$i), $info_s);
            $sheet->setCellValue('AK'.($start+$i), $info_r);
            $sheet->setCellValue('AM'.($start+$i), $info_d);
            $sheet->setCellValue('AO'.($start+$i), $info_c);
            $sheet->setCellValue('AQ'.($start+$i), $info_e);
            $i++;
        }

        $sheet->getStyle('A10:AQ'.($start+($i-1)))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN); 
        $sheet->getStyle('A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('B')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Rata tengah
        $sheet->getStyle('C')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Rata tengah
        $sheet->getStyle('D')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('E')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Rata tengah
        $sheet->getStyle('F')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('G')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Rata tengah
        $sheet->getStyle('H')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('I')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Rata tengah
        $sheet->getStyle('J')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('K')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Rata tengah
        $sheet->getStyle('L')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('M')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Rata tengah
        $sheet->getStyle('N')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('O')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Rata tengah
        $sheet->getStyle('P')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('Q')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Rata tengah
        $sheet->getStyle('R')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('S')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Rata tengah
        $sheet->getStyle('T')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('U')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Rata tengah
        $sheet->getStyle('V')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('W')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Rata tengah
        $sheet->getStyle('X')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('Y')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Rata tengah
        $sheet->getStyle('Z')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('AA')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Rata tengah
        $sheet->getStyle('AB')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('AC')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Rata tengah
        $sheet->getStyle('AD')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('AE')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Rata tengah
        $sheet->getStyle('AF')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('AG')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Rata tengah
        $sheet->getStyle('AH')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('AI')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Rata tengah
        $sheet->getStyle('AJ')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('AK')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Rata tengah
        $sheet->getStyle('AL')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('AM')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Rata tengah
        $sheet->getStyle('AN')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('AO')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Rata tengah
        $sheet->getStyle('AP')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Rata tengah
        $sheet->getStyle('AQ')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT); // Rata tengah

        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(25);

        $writer = new Xlsx($spreadsheet);
        
        // Menyimpan file Excel ke browser
        $fileName = $acara.'_'.$tanggal.'('.$namaUjian.').xlsx';
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
    }
    
    public function addviewcetakDetilPenilaianSJT(request $request)
    {
        $reqTipeUjian = $request->route('tipeUjianId');
        $reqId = $request->route('reqId');
        
        $statement=" and tipe_ujian_id=".$reqTipeUjian;
        $query = new TipeUjian();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $namaUjian=$query->tipe;

        $statement=" and jadwal_tes_id=".$reqId;
        $query = new JadwalTes();
        $query=$query->selectByParamsMonitoring($statement)->first();
        $acara=$query->acara;
        $tempat=$query->tempat;
        $alamat=$query->alamat;
        $status_jenis=$query->status_jenis;
        if($status_jenis==1){
          $status_jenis='Pemetaan';
        }
        else{
          $status_jenis='Seleksi';
        }
        $tanggal=explode(' ', $query->tanggal_tes) ;
        $tanggal=$tanggal[0];
        
        $statement= " AND a.TIPE_UJIAN_ID =".$reqTipeUjian;
     
        // $statement.=" and a.pegawai_id =".$reqId;
        $querySoal = new JadwalTes();
        $querySoal=$querySoal->selectByParamsDetilPenilaianSJT($reqId,$statement);
        $arrdata=array();
        $arrsimpan='';
        foreach ($querySoal as $key => $rowData) {
            // print_r($rowData);exit;
            
            if(empty($arrdata)){
                $kosong='ya';
            }
            else if(empty($arrdata[$rowData->pegawai_id]['nama'])){
                $kosong='ya';
            }
            else{
                $kosong='tidak';
            }

            if($kosong=='ya'){
                $nilai=1;
                // print_r($rowData->pegawai_id);exit;
                $arrdata[$rowData->pegawai_id]['nama']=$rowData->nama_pegawai;
                $arrdata[$rowData->pegawai_id][$nilai]=$rowData->grade_prosentase;
            }
            else{
                $nilai++;
                $arrdata[$rowData->pegawai_id][$nilai]=$rowData->grade_prosentase;
            }
        }
        // print_r($arrdata);exit;
       // Membuat objek spreadsheet baru
        $file = 'template/detil_penilaian_sjt.xlsx';  // Ubah dengan path file Excel Anda

        // Membaca file Excel
        $spreadsheet = IOFactory::load($file);

        // Mengambil sheet pertama (indeks 0)
        // $sheet = $spreadsheet->getActiveSheet();
        $sheet = $spreadsheet->getSheet(0);
        $writer = new Xlsx($spreadsheet);

        $start=2;
        $i=0;
        foreach ($arrdata as $rowData) {
            // print_r($rowData['nama']);exit;
            $sheet->setCellValue('a'.($start+$i), $i+1);
            $sheet->setCellValue('b'.($start+$i), $rowData['nama']);
            $space=2;
            $total=0;
            for($x=1;$x<count($rowData);$x++){
                $sheet->setCellValue(StringFunc::getColomsNew(($x+$space))."".($start+$i), $rowData[$x]);
                $total=$total+$rowData[$x];
                if(fmod($x,6) == 0){
                    $sheet->setCellValue(StringFunc::getColomsNew(($x+$space+1))."".($start+$i), $total);
                    $space++;
                    $total=0;
                }
            }
            // print_r(count($rowData));exit;
            
            $i++;
        }
        
        // Menyimpan file Excel ke browser
        $fileName = 'penilaian_detil_'.$acara.'_'.$tanggal.'('.$namaUjian.').xlsx';
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
    }
}
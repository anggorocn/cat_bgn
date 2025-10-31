<?php
namespace App\Helper;
use App\Models\ProsesSurat;
use App\Models\ProsesDisposisi;
use App\Models\ProsesWa;
use App\Models\JenisNaskahWa;
use App\Models\InfoDinamis;
use App\Helper\DateFunc;

class KirimWa
{
	public static function arrparam($key, $arrparam)
	{
		return array_key_exists($key, $arrparam) ? $arrparam[$key] : null;
	}

	public static function getconcatseparator($var, $vadd, $separator=",")
	{
		$vreturn= "";
		if(empty($var))
			$vreturn = $vadd;
		else
		{
			$vreturn = $var.$separator.$vadd;
		}

		return $vreturn;
	}

	public static function getphone($var, $vadd)
	{
		$stf= new KirimWa();

		$arrphone= explode(";", $var);
		if(!in_array($vadd, $arrphone))
		{
			$var= $stf->getconcatseparator($var, $vadd, ";");
		}

		return $var;
	}

	public static function gettemplate($arrparam)
	{
		$stf= new KirimWa();

		$vasset= asset('/');
		$reqId= $stf->arrparam("reqId", $arrparam);
		$vsuratid= $stf->arrparam("vsuratid", $arrparam);
		$reqJenis= $stf->arrparam("reqJenis", $arrparam);
		$vjenis= $stf->arrparam("vjenis", $arrparam);
		$vjenisnaskahid= $stf->arrparam("vjenisnaskahid", $arrparam);
		$vjenisdetil= $stf->arrparam("vjenisdetil", $arrparam);
		$vnomor= $stf->arrparam("vnomor", $arrparam);
		$vdari= $stf->arrparam("vdari", $arrparam);
		$vtanggal= $stf->arrparam("vtanggal", $arrparam);
		$vperihal= $stf->arrparam("vperihal", $arrparam);

		$builder = new \AshAllenDesign\ShortURL\Classes\Builder();

		$arrjenisnaskahwa= JenisNaskahWa::where("JENIS_NASKAH_ID", $vjenisnaskahid)
		->where("VMODE", $reqJenis)
		->orderBy("VMODE")->orderBy("NOMOR")
		->get();
		// dd($arrjenisnaskahwa);

		$vtemplate= "";
		$arrharusjenis= ["revisi", "persetujuan", "kotak_masuk", "kotak_disposisi"];
      	if(in_array(strtolower($reqJenis), $arrharusjenis))
		{
			foreach ($arrjenisnaskahwa as $key => $value) 
			{
				if(empty($value->status))
				{
					$vtipeid= $value->tipe_id;
					$vtipenama= $value->tipe_nama;

					$visi= "";
					if($value->nomor == 0)
					{
						$vtemplate= $stf->getconcatseparator($vtemplate, $vtipenama, "\n");
						// tambahan ganti bari
						$vtemplate.= "\n";
					}
					else
					{
						// $visi= "-".$vtipenama."\t";
						// tambahan ganti bari
						$visi= $vtipenama;

						// if($vtipeid == 3 || $vtipeid == 6)
						// {
						// 	$visi.= "\t";
						// }
						$visi.= " :";
						// tambahan ganti bari
						$visi.= "\n";

						if($vtipeid == 1)
						{
							$visi.= $vjenis;
						}
						else if($vtipeid == 2)
						{
							$visi.= $vnomor;
						}
						else if($vtipeid == 3)
						{
							$visi.= $vdari;
						}
						else if($vtipeid == 4)
						{
							$visi.= $vtanggal;
						}
						else if($vtipeid == 5)
						{
							$visi.= $vperihal;
						}
						else if($vtipeid == 6)
						{
							$vlinkdetil= "";
							if($reqJenis == "revisi")
							{
								$vlinkdetil= $vasset."app/draft/add/".$vsuratid."/".$vjenisnaskahid;
							}
							else if($reqJenis == "persetujuan")
							{
								$vlinkdetil= $vasset."app/perlu_persetujuan/viewdetil/".$vsuratid;
							}
							else if($reqJenis == "kotak_masuk")
							{
								$vlinkdetil= $vasset."app/surat_detil/view/kotak_masuk/".$vsuratid;
							}
							else if($reqJenis == "kotak_disposisi")
							{
								$vlinkdetil= $vasset."app/surat_detil/viewdisposisi/kotak_masuk_disposisi/".$vsuratid;
							}
							// echo $vlinkdetil;exit;

							if(!empty($vlinkdetil))
							{
								$shortURLObject= $builder->destinationUrl($vlinkdetil)->make();
								$vlinkdetil= $shortURLObject->default_short_url;
								$visi.= $vlinkdetil;
							}
						}
						$visi.= "\n";

						$vtemplate= $stf->getconcatseparator($vtemplate, $visi, "\n");	
					}
				}
			}
		}

		if(!empty($vtemplate))
		{
			$footer= "*Pastikan anda sudah login terlebih dahulu untuk dapat langsung melihat isi dari link diatas.";
			$vtemplate= $stf->getconcatseparator($vtemplate, $footer, "\n");
		}
		// echo $vtemplate;exit;
		return $vtemplate;
	}

	public static function kirimpesan($arrparam)
	{
		$setinfodinamis= InfoDinamis::findOrFail(1)->first();
		$infostatuswa= $setinfodinamis["status"];
		// echo $infostatuswa;exit;
		
		// kalau status wa 1 maka bisa kirim
		if($infostatuswa == "1")
		{
			$dtf= new DateFunc();
			$stf= new KirimWa();

			$reqId= $stf->arrparam("reqId", $arrparam);
			$reqJenis= $stf->arrparam("reqJenis", $arrparam);

			if(empty($reqId)) $reqId= -1;

			$vdisposisikirimwa= "";
			$vsuratid= $reqId;
			$set= new ProsesSurat;
			if($reqJenis == "kotak_masuk_teruskan" || $reqJenis == "kotak_disposisi")
			{
				$setdetil= new ProsesDisposisi;
				$ds= $setdetil->find($vsuratid);
				// dd($ds);
				if(!empty($ds))
				{
					$vsuratid= $ds->surat_masuk_id;
					$vdisposisikirimwa= $ds->kirim_wa;
					// echo $vdisposisikirimwa;exit;
				}
			}
			$sm= $set->find($vsuratid);
	      	// dd($sm);

			$vtemplate= $vtemplatedetil= $vnohp= "";
	      	if(!empty($sm))
	      	{
	      		$vnomor= $sm->nomor;
	  			if(empty($vnomor))
	  			{
	  				$vnomor= $sm->info_nomor_surat;
	  			}

	  			$vjenis= $sm->jenis;
	  			$vjenisnaskahid= $sm->jenis_naskah_id;
	  			$vuseratasan= $sm->user_atasan;
	  			$vdari= $sm->user_atasan_jabatan;
	  			if(!empty($vuseratasan))
	  			{
	  				$vdari.= "( ".$vuseratasan." )";
	  			}
	  			// $vtanggal= $dtf->dateToPageCheck($dtf->datetimeToPage($sm->tanggal, "date"));
	  			$vtanggal= $dtf->getFormattedDateTime($sm->tanggal, false);

	  			$vperihal= $sm->perihal;
	  			$vsuratkirimwa= $sm->kirim_wa;
	  			// echo $vsuratkirimwa;exit;

	  			if($reqJenis == "revisi")
	      		{
	      			$arrparam= [];
	      			$arrparam= ["vsuratid"=>$vsuratid, "reqId"=>$reqId, "reqJenis"=>$reqJenis, "vjenisnaskahid"=>$vjenisnaskahid, "vjenis"=>$vjenis, "vnomor"=>$vnomor, "vdari"=>$vdari, "vtanggal"=>$vtanggal, "vperihal"=>$vperihal];
	      			$vtemplate= KirimWa::gettemplate($arrparam);
	      			// $vtemplate= "Notifikasi Perlu Persetujuan E-office ASDP\n- Tipe Surat	: ".$vjenis."\n- No Surat	: ".$vnomor."\n- Dari	: ".$vdari."\n- Tanggal	: ".$vtanggal."\n- Perihal	: ".$vperihal;

					// $vnohp= "085748554844";
					$vnohp= "085748554844;081230583802";
					// $vnohp= "085748554844;081230583802;085156098589";
					// $vnohp= "";

					$statement= " AND A.SURAT_MASUK_ID = ".$reqId;
					$obj= new ProsesWa();
					$obj= $obj->selectrevisi($statement);
	      			// dd($obj);

					foreach($obj as $keyeach => $valeach)
					{
						// print_r($valeach);exit;
						$vphone= $valeach->phone;
						$vnohp= $stf->getphone($vnohp, $vphone);
					}
	      		}
	      		else if($reqJenis == "persetujuan")
	      		{
	      			// surat masuk kirim wa harus 1, baru bisa kirim
	      			if($vsuratkirimwa == "1")
	      			{
		      			$arrparam= [];
		      			$arrparam= ["vsuratid"=>$vsuratid, "reqId"=>$reqId, "reqJenis"=>$reqJenis, "vjenisnaskahid"=>$vjenisnaskahid, "vjenis"=>$vjenis, "vnomor"=>$vnomor, "vdari"=>$vdari, "vtanggal"=>$vtanggal, "vperihal"=>$vperihal];
		      			$vtemplate= KirimWa::gettemplate($arrparam);
		      			// $vtemplate= "Notifikasi Perlu Persetujuan E-office ASDP\n- Tipe Surat	: ".$vjenis."\n- No Surat	: ".$vnomor."\n- Dari	: ".$vdari."\n- Tanggal	: ".$vtanggal."\n- Perihal	: ".$vperihal;

						// $vnohp= "085748554844";
						$vnohp= "085748554844;081230583802";
						// $vnohp= "085748554844;081230583802;085156098589";
						// $vnohp= "";

						$statement= " AND A.SURAT_MASUK_ID = ".$reqId;
						$obj= new ProsesWa();
						$obj= $obj->selectpersetujuan($statement);
		      			// dd($obj);

						foreach($obj as $keyeach => $valeach)
						{
							// print_r($valeach);exit;
							$vphone= $valeach->phone;
							$vnohp= $stf->getphone($vnohp, $vphone);
						}
	      			}
	      		}
	      		else if($reqJenis == "kotak_masuk_teruskan")
	      		{
	      			$reqJenis= "kotak_masuk";
	      			$statement= " AND A.DISPOSISI_ID = ".$reqId;
					$obj= new ProsesWa();
					$obj= $obj->selectkotakmasukteruskan($statement);
	      			// dd($obj);

					foreach($obj as $keyeach => $valeach)
					{
						// print_r($valeach);exit;
						$vnohp= $valeach->phone;
						// $vnohp= "085748554844";
						$vstatusdisposisinama= $valeach->status_disposisi_nama;

						$vjenisdetil= $vjenis;
						if(!empty($vstatusdisposisinama))
						{
							$vjenisdetil.= " ".$vstatusdisposisinama;
						}

						$arrparam= [];
						$arrparam= ["vsuratid"=>$vsuratid, "reqId"=>$reqId, "reqJenis"=>$reqJenis, "vjenisnaskahid"=>$vjenisnaskahid, "vjenis"=>$vjenisdetil, "vnomor"=>$vnomor, "vdari"=>$vdari, "vtanggal"=>$vtanggal, "vperihal"=>$vperihal];
						$vtemplatedetil= KirimWa::gettemplate($arrparam);
						// $vtemplatedetil= "Notifikasi E-office ASDP\n- Tipe Surat	: ".$vjenisdetil."\n- No Surat	: ".$vnomor."\n- Dari	: ".$vdari."\n- Tanggal	: ".$vtanggal."\n- Perihal	: ".$vperihal;
						// echo $vtemplatedetil;exit;

						$arrparam= [];
						$arrparam= ["hp"=>$vnohp, "isi"=>$vtemplatedetil];
						// print_r($arrparam);exit;
						KirimWa::apiwa($arrparam);
					}

					if(!empty($vtemplatedetil))
					{
						$vnohp= "085748554844;081230583802";

						$arrparam= [];
						$arrparam= ["hp"=>$vnohp, "isi"=>$vtemplatedetil];
						// print_r($arrparam);exit;
						KirimWa::apiwa($arrparam);
					}
	      		}
	      		else if($reqJenis == "kotak_masuk")
	      		{
	      			// surat masuk kirim wa harus 1, baru bisa kirim
	      			if($vsuratkirimwa == "1")
	      			{
		      			// $vtemplate= "Notifikasi E-office ASDP\n- Tipe Surat	: ".$vjenis."\n- No Surat	: ".$vnomor."\n- Dari		: ".$vdari."\n- Tanggal		: ".$vtanggal."\n- Perihal		: ".$vperihal;

						// $vnohp= "085748554844";
						// $vnohp= "085748554844;081230583802";
						// $vnohp= "085748554844;081230583802;085156098589";
						// $vnohp= "";

						$statement= " AND A.SURAT_MASUK_ID = ".$reqId;
						$obj= new ProsesWa();
						$obj= $obj->selectkotakmasuk($statement);
		      			// dd($obj);

						/*
						// model lama
		      			foreach($obj as $keyeach => $valeach)
						{
							// print_r($valeach);exit;
							$vphone= $valeach->phone;
							$vnohp= $stf->getphone($vnohp, $vphone);
						}*/

						foreach($obj as $keyeach => $valeach)
						{
							// print_r($valeach);exit;
							$vnohp= $valeach->phone;
							// $vnohp= "085748554844";
							$vstatusdisposisinama= $valeach->status_disposisi_nama;

							$vjenisdetil= $vjenis;
							if(!empty($vstatusdisposisinama))
							{
								$vjenisdetil.= " ".$vstatusdisposisinama;
							}

							$arrparam= [];
							$arrparam= ["vsuratid"=>$vsuratid, "reqId"=>$reqId, "reqJenis"=>$reqJenis, "vjenisnaskahid"=>$vjenisnaskahid, "vjenis"=>$vjenisdetil, "vnomor"=>$vnomor, "vdari"=>$vdari, "vtanggal"=>$vtanggal, "vperihal"=>$vperihal];
							$vtemplatedetil= KirimWa::gettemplate($arrparam);
							// $vtemplatedetil= "Notifikasi E-office ASDP\n- Tipe Surat	: ".$vjenisdetil."\n- No Surat	: ".$vnomor."\n- Dari	: ".$vdari."\n- Tanggal	: ".$vtanggal."\n- Perihal	: ".$vperihal;
							// echo $vtemplatedetil;exit;

							$arrparam= [];
							$arrparam= ["hp"=>$vnohp, "isi"=>$vtemplatedetil];
							// print_r($arrparam);exit;
							KirimWa::apiwa($arrparam);
						}

						if(!empty($vtemplatedetil))
						{
							$vnohp= "085748554844;081230583802";

							$arrparam= [];
							$arrparam= ["hp"=>$vnohp, "isi"=>$vtemplatedetil];
							// print_r($arrparam);exit;
							KirimWa::apiwa($arrparam);
						}
					}
	      		}
	      		else if($reqJenis == "kotak_disposisi")
	      		{
	      			$vdisposisikirimwa= "";
	      			// disposisi kirim wa harus 1, baru bisa kirim
	      			
	      			$statement= " AND A2.KIRIM_WA = '1' AND A.DISPOSISI_PARENT_ID = ".$reqId;
					$obj= new ProsesWa();
					$obj= $obj->selectkotakdisposisi($statement);
	      			// dd($obj);

					foreach($obj as $keyeach => $valeach)
					{
						// print_r($valeach);exit;
						$vnohp= $valeach->phone;
						// $vnohp= "085748554844";
						$vstatusdisposisinama= $valeach->status_disposisi_nama;

						$vjenisdetil= $vjenis;
						if(!empty($vstatusdisposisinama))
						{
							$vjenisdetil.= " ".$vstatusdisposisinama;
						}

						$arrparam= [];
						$arrparam= ["vsuratid"=>$vsuratid, "reqId"=>$reqId, "reqJenis"=>$reqJenis, "vjenisnaskahid"=>$vjenisnaskahid, "vjenis"=>$vjenisdetil, "vnomor"=>$vnomor, "vdari"=>$vdari, "vtanggal"=>$vtanggal, "vperihal"=>$vperihal];
						$vtemplatedetil= KirimWa::gettemplate($arrparam);
						// $vtemplatedetil= "Notifikasi E-office ASDP\n- Tipe Surat	: ".$vjenisdetil."\n- No Surat	: ".$vnomor."\n- Dari	: ".$vdari."\n- Tanggal	: ".$vtanggal."\n- Perihal	: ".$vperihal;
						// echo $vtemplatedetil;exit;

						$arrparam= [];
						$arrparam= ["hp"=>$vnohp, "isi"=>$vtemplatedetil];
						// print_r($arrparam);exit;
						KirimWa::apiwa($arrparam);
					}

					if(!empty($vtemplatedetil))
					{
						$vnohp= "085748554844;081230583802";

						$arrparam= [];
						$arrparam= ["hp"=>$vnohp, "isi"=>$vtemplatedetil];
						// print_r($arrparam);exit;
						KirimWa::apiwa($arrparam);
					}
	      		}
	      	}
	      	// echo $vnohp;exit;
	      	// echo $vtemplate;exit;

	      	$arrkecuali= ["kotak_masuk"];
	      	$statuskirim= "1";
	      	if(in_array(strtolower($reqJenis), $arrkecuali))
	      	{
	      		$statuskirim= "";
	      	}

	      	if(!empty($vtemplate) && !empty($statuskirim))
	      	{
	      		$arrparam= [];
	      		$arrparam= ["hp"=>$vnohp, "isi"=>$vtemplate];
	      		KirimWa::apiwa($arrparam);
	      	}
	    }
		// echo $reqJenis;exit;
	}

	public static function apiwa($arrparam)
	{
		$env= $_ENV;

		$stf= new KirimWa();
		$hp= $stf->arrparam("hp", $arrparam);
		$isi= $stf->arrparam("isi", $arrparam);

		$urlwa= $env["wa_text"];
		$boleh_kirim_wa= $env["wa_linux"];
		// kirim pakai shell_exec

		if($boleh_kirim_wa == "1")
		{
			$urlexec= getcwd()."/one.php";
	        $vexec= "php ".$urlexec." ".urlencode($urlwa)." ".urlencode($hp)." ".urlencode($isi)." getdownload 0 false > /dev/null 2>/dev/null &";
	        shell_exec($vexec);
	    }

		// kirim manual
		/*$data= [
			"to" => $hp,
			"body" => $isi,
			"instance" => "1",
			"appname" => "asdp_whatsapp"
		];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $urlwa);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

		// curl_setopt($ch, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');

		// curl_setopt($ch, CURLOPT_TIMEOUT, 500);
		// curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// execute post
		$result = curl_exec($ch);
		// close connection
		curl_close($ch);
		// print_r($result);exit();

		$rs= json_decode($result);*/
		// print_r($rs);exit();

		/*{
			"to": "6285748554844",
			"body": "tes lagi, lek ke kirim wa nak 085748554844 ojo di lapor ne spam",
			"instance": "1",
			"appname": "asdp_whatsapp"
		}*/
	}
}
?>
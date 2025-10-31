<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cache;
// use App\Models\UserLogin;
// use App\Models\SatuanKerjaFix;
// use App\Models\SatuanKerja;
// use App\Models\Disposisi;
// use App\Models\InfoConfDinamis;
use App\Models\UserApp;
use App\Models\UserAppCat;


// use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Helper\StringFunc;
use JKD\SSO\Client\Provider\Keycloak;

class AuthController extends Controller
{
    public function __construct()
    {
        // $this->env= $_ENV;
        $rkey= array(
            array("id"=>1, "key"=>"sso_uri")
            , array("id"=>2, "key"=>"sso_redirect_uri")
            , array("id"=>3, "key"=>"sso_client_id")
            , array("id"=>4, "key"=>"sso_client_secret")
        )
        ;

        $arrenv= [];
        // foreach ($rkey as $key => $value)
        // {
        //     $vkey= $value["id"];
        //     $set= InfoConfDinamis::findOrFail($vkey);
        //     // dd($set);
        //     if(!empty($set))
        //     {
        //         $arrenv[$value["key"]]= $set->keterangan;
        //     }
        // }
        // print_r($arrenv);exit;
        $this->env= $arrenv;
        // print_r($this->env);exit;
        
    }

    public function index()
    {

        // return view('app/login');

        $provider = new Keycloak([
            'authServerUrl'         => 'https://sso.bps.go.id',
            'realm'                 => 'pegawai-bps',
            'clientId'              => '03340-assesment-3vs',
            'clientSecret'          => '3a23a60e-fd82-48ed-acca-e84dce9952f7',
            'redirectUri'           => 'http://localhost:8000/'
        ]);


        if (!isset($_GET['code'])) {
            // Untuk mendapatkan authorization code
            $authUrl = $provider->getAuthorizationUrl();
            $_SESSION['oauth2state'] = $provider->getState();
            header('Location: '.$authUrl);
            exit;

        // Mengecek state yang disimpan saat ini untuk memitigasi serangan CSRF
        } else {
            $token = $provider->getAccessToken('authorization_code', [
                    'code' => $_GET['code']
                ]);
            echo $_GET['code'];exit;
            try {
                $token = $provider->getAccessToken('authorization_code', [
                    'code' => $_GET['code']
                ]);
            } catch (Exception $e) {
                exit('Gagal mendapatkan akses token : '.$e->getMessage());
            }

            // Opsional: Setelah mendapatkan token, anda dapat melihat data profil pengguna
            try {

                $user = $provider->getResourceOwner($token);
                    echo "Nama : ".$user->getName();
                    echo "E-Mail : ". $user->getEmail();
                    echo "Username : ". $user->getUsername();
                    echo "NIP : ". $user->getNip();
                    echo "NIP Baru : ". $user->getNipBaru();
                    echo "Kode Organisasi : ". $user->getKodeOrganisasi();
                    echo "Kode Provinsi : ". $user->getKodeProvinsi();
                    echo "Kode Kabupaten : ". $user->getKodeKabupaten();
                    echo "Alamat Kantor : ". $user->getAlamatKantor();
                    echo "Provinsi : ". $user->getProvinsi();
                    echo "Kabupaten : ". $user->getKabupaten();
                    echo "Golongan : ". $user->getGolongan();
                    echo "Jabatan : ". $user->getJabatan();
                    echo "Eselon : ". $user->getEselon();

            } catch (Exception $e) {
                exit('Gagal Mendapatkan Data Pengguna: '.$e->getMessage());
            }

            // Gunakan token ini untuk berinteraksi dengan API di sisi pengguna
            echo $token->getToken();
        }
        exit;
    }

    public function indexSSO()
    {
        // echo "assasa";exit;

        // return view('app/login');
        $provider = new Keycloak([
            'authServerUrl'         => 'https://sso.bps.go.id',
            'realm'                 => 'pegawai-bps',
            'clientId'              => '03340-assesment-3vs',
            'clientSecret'          => '3a23a60e-fd82-48ed-acca-e84dce9952f7',
            'redirectUri'           => 'http://localhost:8000/'
        ]);


        if (!isset($_GET['code'])) {
            // Untuk mendapatkan authorization code
            session_start();
            $authUrl = $provider->getAuthorizationUrl();
            $_SESSION['oauth2state'] = $provider->getState();
            header('Location: '.$authUrl);
            exit;

        // Mengecek state yang disimpan saat ini untuk memitigasi serangan CSRF
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
            unset($_SESSION['oauth2state']);
            exit('Invalid state');

        } else {
            try {
                $token = $provider->getAccessToken('authorization_code', [
                    'code' => $_GET['code']
                ]);
            } catch (Exception $e) {
                exit('Gagal mendapatkan akses token : '.$e->getMessage());
            }

            // Opsional: Setelah mendapatkan token, anda dapat melihat data profil pengguna
            try {

                $user = $provider->getResourceOwner($token);
                    echo "Nama : ".$user->getName();
                    echo "E-Mail : ". $user->getEmail();
                    echo "Username : ". $user->getUsername();
                    echo "NIP : ". $user->getNip();
                    echo "NIP Baru : ". $user->getNipBaru();
                    echo "Kode Organisasi : ". $user->getKodeOrganisasi();
                    echo "Kode Provinsi : ". $user->getKodeProvinsi();
                    echo "Kode Kabupaten : ". $user->getKodeKabupaten();
                    echo "Alamat Kantor : ". $user->getAlamatKantor();
                    echo "Provinsi : ". $user->getProvinsi();
                    echo "Kabupaten : ". $user->getKabupaten();
                    echo "Golongan : ". $user->getGolongan();
                    echo "Jabatan : ". $user->getJabatan();
                    echo "Eselon : ". $user->getEselon();

            } catch (Exception $e) {
                exit('Gagal Mendapatkan Data Pengguna: '.$e->getMessage());
            }

            // Gunakan token ini untuk berinteraksi dengan API di sisi pengguna
            echo $token->getToken();
        }
        exit;
    }

    public function home()
    {
        return view('app/home');
    }

    public function capcha(request $request)
    {
        // dd(1);
        $reqId= $request->route('id');
        $kode=$reqId;
        // dd($kode);
        return view('capcha', compact('reqId','kode'));
    }

    public function getCapcha(request $request)
    {
        // dd(1);
        $reqId = StringFunc::generteCapcha();
        // $this->user->setAttribute('CAPCHA',$reqId);
        Session::put('capcha',  $reqId);

        return  $reqId;
        
    }

    public function actionSSO(Request $request)
    {

        request()->validate(
        [
            'reqUser' => 'required',
            'reqPass' => 'required',
        ]);

        $provider = new Keycloak([
            'authServerUrl'         => 'https://sso.bps.go.id',
            'realm'                 => 'pegawai-bps',
            'clientId'              => '03340-assesment-3vs',
            'clientSecret'          => '3a23a60e-fd82-48ed-acca-e84dce9952f7',
            'redirectUri'           => 'https://assessment.web.bps.go.id/'
        ]);


        if (!isset($_GET['code'])) {
// echo $provider->getAuthorizationUrl();
// exit;
            // Untuk mendapatkan authorization code
            $authUrl = $provider->getAuthorizationUrl();
            $_SESSION['oauth2state'] = $provider->getState();
            header('Location: '.$authUrl);
            exit;

        // Mengecek state yang disimpan saat ini untuk memitigasi serangan CSRF
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
echo "2";
exit;
            unset($_SESSION['oauth2state']);
            exit('Invalid state');

        } else {

echo "3";
exit;
            try {
                $token = $provider->getAccessToken('authorization_code', [
                    'code' => $_GET['code']
                ]);
            } catch (Exception $e) {
                exit('Gagal mendapatkan akses token : '.$e->getMessage());
            }

            // Opsional: Setelah mendapatkan token, anda dapat melihat data profil pengguna
            try {

                $user = $provider->getResourceOwner($token);
                    echo "Nama : ".$user->getName();
                    echo "E-Mail : ". $user->getEmail();
                    echo "Username : ". $user->getUsername();
                    echo "NIP : ". $user->getNip();
                    echo "NIP Baru : ". $user->getNipBaru();
                    echo "Kode Organisasi : ". $user->getKodeOrganisasi();
                    echo "Kode Provinsi : ". $user->getKodeProvinsi();
                    echo "Kode Kabupaten : ". $user->getKodeKabupaten();
                    echo "Alamat Kantor : ". $user->getAlamatKantor();
                    echo "Provinsi : ". $user->getProvinsi();
                    echo "Kabupaten : ". $user->getKabupaten();
                    echo "Golongan : ". $user->getGolongan();
                    echo "Jabatan : ". $user->getJabatan();
                    echo "Eselon : ". $user->getEselon();

            } catch (Exception $e) {
                exit('Gagal Mendapatkan Data Pengguna: '.$e->getMessage());
            }

            // Gunakan token ini untuk berinteraksi dengan API di sisi pengguna
            echo $token->getToken();
        }
        exit;

        $checkpass = $request->reqPass;
        $arrparam= ["vuser"=>$request->reqUser, "vpass"=>$checkpass, "vmode"=>""];
        $vreturn= $this->loginsso($arrparam);
        // print_r($vreturn);exit;
        if($vreturn == "1")
        {
            return redirect()->intended('/app/index');
        }
        else
        {
            return Redirect::back()->withErrors(
                [
                    'login_gagal' => 'User / Password tidak ditemukan'
                ]
            );
        }
    }

    public function action(Request $request)
    {
        $checkpass = $request->reqPass;
        $arrparam= ["vuser"=>$request->reqUser, "vpass"=>$checkpass, "vmode"=>""];
        $vreturn= $this->loginsso($arrparam);
        // print_r($vreturn);exit;
        if($vreturn == "1")
        {
            return redirect()->intended('/app/index');
        }
        else
        {
            return Redirect::back()->withErrors(
                [
                    'login_gagal' => 'User / Password tidak ditemukan'
                ]
            );
        }
    }

    public static function loginsso($arrparam)
    {
        $vuser= $arrparam["vuser"];
        $vpass= md5($arrparam["vpass"]);

        $user = UserApp::where('user_login', $vuser)->where('user_pass', $vpass)->first();

        if($user)
        {
            //comment dulu
            $infousergroupid=$user->user_group_id;
            // $user->setAttribute('NAMA', $user->nama);

            auth::login($user,false);
            Session::put('user', $user);
            // return redirect()->intended('/app');
            return 1;
        } 
        else
        {
            return 0;
        }
    }

    public function logout(Request $request)
    {
        $venv= $this->env;
       

        $vuser= Session::get('user');
        

        // Cache::flush();
        $request->session()->flush();
        Auth::logout();

       return Redirect('/');
       
    }


   
}

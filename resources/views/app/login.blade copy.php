<?php
// dd($errors->first('reqUser'));exit;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="{{ asset('/') }}">
        <meta charset="utf-8" />
        <title>Aplikasi Assesment | BPS</title>
        <meta name="description" content="Login page example" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="canonical" href="https://keenthemes.com/metronic" />
        <link href="assets/css/pages/login/classic/login-4.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="images/logo-title.png" />
        <link href="assets/css/new-style.css" rel="stylesheet" type="text/css" />

        <!-- PWA  -->
        <meta name="theme-color" content="#6777ef"/>
        <link rel="apple-touch-icon" href="{{ asset('logo.PNG') }}">
        <link rel="manifest" href="{{ asset('/manifest.json') }}">
        
        <style>
            /*.area-kiri-login {
                height: 100vh; 
                background-image: url('images/bg-login.png'); 
                background-size: auto 100%; 
                background-position: right bottom;
                display: flex; justify-content: center; align-items: center; 
            }
            .nama-aplikasi {
                color:  #fff;
                padding: 20px;
                text-align: center;
            }
            .nama-aplikasi h4 {
                font-size: 24px !important;
               
                color:  #333333;
            }
            .area-kanan-login {
                height: 100vh; 
                display: flex; justify-content: center; align-items: center; 
                background: #FFFFFF;
            }
            @media screen and (max-width:767px) {
                .d-flex.flex-center.flex-row-fluid.bgi-size-cover.bgi-position-top.bgi-no-repeat {
                }
                .area-kiri-login {
                    position: absolute;
                    top: 0;
                    height: 30vh;
                    width: 100%;
                    display: inline-block;
                    background-size: 100% 100%; 
                }
                .area-kanan-login {
                    position: absolute;
                    bottom: 0;
                    height: 70vh;
                    width: 100%;
                    display: inline-block;
                }
            }*/

            

        </style>

        <!-- VALSIX -->
        <link href="assets/css/gaya.css" rel="stylesheet" type="text/css" />

    </head>

    <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
        <div class="d-flex flex-column flex-root">
            <div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
                <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat">
                    <div class="col-md-12">
                        <div class="area-login">
                            <div class="inner">
                                <div class="logo"><img src="../../assets/media/images/img-logo-login.png"></div>
                                <form class="form" id="kt_login_signin_form" action="app/login/action" method="post">
                                    @csrf
                                    <div class="form-group mb-5">
                                        <input style='font-size: 17px;' class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Username" name="reqUser" autocomplete="off" value="" />
                                    </div>
                                    <div class="form-group mb-5">
                                        <input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Password" name="reqPass" value="" />
                                    </div>

                                    @if ($errors->has('login_gagal'))
                                    <div class="form-group mb-5">
                                        <label class="text-danger">{{ $errors->first('login_gagal') }}</label>
                                    </div>
                                    @endif

                                    @if ($errors->first('reqUser'))
                                    <div class="form-group mb-5">
                                        <label class="text-danger">Username Harus diisi</label>
                                    </div>
                                    @endif

                                    @if ($errors->first('reqPass'))
                                    <div class="form-group mb-5">
                                        <label class="text-danger">Password Harus diisi</label>
                                    </div>
                                    @endif

                                    <button id="kt_login_signin_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">LOGIN</button>

                                    <input type="hidden" name="reqMode" value="submitLogin"/>
                                   
                                </form>
                            </div>
                            <div class="copyright"> © 2024 BPS </div>
                            
                        </div>
                    </div>
                    <!-- <div class="col-md-7 area-kiri-login">
                        
                    </div> -->
                    <div class="col-md-5 area-kanan-login" style="display: none !important;">
                        <div class="login-form text-center p-7 position-relative overflow-hidden">
                            
                            <div class="d-flex flex-center mb-5">
                                <a href="#">
                                </a>
                            </div>
                            <div class="nama-aplikasi">
                                <h4><strong> E-OFFICE LOGIN</strong></h4>
                            </div>
                            <div class="login-signin">
                                <form class="form" id="kt_login_signin_form" action="app/login/action" method="post">
                                	@csrf
                                    <div class="form-group mb-5">
                                        <input style='font-size: 17px;' class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Username" name="reqUser" autocomplete="off" value="" />
                                    </div>
                                    <div class="form-group mb-5">
                                        <input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Password" name="reqPass" value="" />
                                    </div>

                                    @if ($errors->has('login_gagal'))
                                    <div class="form-group mb-5">
                                        <label class="text-danger">{{ $errors->first('login_gagal') }}</label>
                                    </div>
                                    @endif

                                    @if ($errors->first('reqUser'))
                                    <div class="form-group mb-5">
                                        <label class="text-danger">Username Harus diisi</label>
                                    </div>
                                    @endif

                                    @if ($errors->first('reqPass'))
                                    <div class="form-group mb-5">
                                        <label class="text-danger">Password Harus diisi</label>
                                    </div>
                                    @endif

                                    <button id="kt_login_signin_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">LOGIN</button>

                                    <input type="hidden" name="reqMode" value="submitLogin"/>
                                   
                                </form>
                                <br>
                                <br>
								<footer class="container">
                                    © 2024 BPS
     	                        </footer>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('/sw.js') }}"></script>
        <script>
            if (!navigator.serviceWorker.controller) {
                navigator.serviceWorker.register("/sw.js").then(function (reg) {
                    console.log("Service worker has been registered for scope: " + reg.scope);
                });
            }
        </script>

    </body>
</html>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="{{ asset('/images/logopwa.png') }}">
    <!-- <link rel="manifest" href="{{ asset('/manifest.json') }}"> -->
    <link rel="manifest" href="{{ asset('/manifest.webmanifest') }}" />

    <title>Aplikasi Assesment BPS</title>

    <!-- Bootstrap core CSS -->
    <link href="/libraries/bootstrap-3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="/libraries/bootstrap-3.3.7/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/libraries/bootstrap-3.3.7/docs/examples/signin/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="/libraries/bootstrap-3.3.7/docs/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="/libraries/font-awesome-4.7.0/css/font-awesome.css">
    <style type="text/css">
        body {
            background: url(/images/bg-login.jpg);
            background-size: 100% 100vh;
            position: relative;
        }
        @media screen and (max-width:767px) {
            body {
                background: url(/images/bg-login.jpg) center center no-repeat;
                background-size: auto 100vh;
            }
        }
        .container {
            display: flex;
            justify-content: center; /* align horizontal */
            align-items: center; /* align vertical */

            height: 100vh;
        }
        .logo-login {
            position: absolute;
            background: #FFFFFF;
            padding: 15px 30px;

            -webkit-border-radius: 0px;
            -webkit-border-bottom-right-radius: 30px;
            -moz-border-radius: 0px;
            -moz-border-radius-bottomright: 30px;
            border-radius: 0px;
            border-bottom-right-radius: 30px;
        }
        .logo-login img {
            width: 100px;
        }
        .form-signin {
            background: #FFFFFF;
            padding: 30px 30px;

            -webkit-border-radius: 30px; 
            -moz-border-radius: 30px;
            border-radius: 30px; 

            
        }
        .form-signin button[type="submit"] {
            margin-bottom: inherit;
            height: 60px;
            line-height: 60px;
            /*background: #1d388d;*/

            -webkit-border-radius: 20px; 
            -moz-border-radius: 20px;
            border-radius: 20px; 

            font-size: 18px;
            letter-spacing: 1px;
            font-weight: bold;
            padding: 0 24px;
        }
        .form-signin button[type="button"] {
            margin-bottom: inherit;
            height: 60px;
            line-height: 60px;
            /*background: #1d388d;*/

            -webkit-border-radius: 20px; 
            -moz-border-radius: 20px;
            border-radius: 20px; 

            font-size: 18px;
            letter-spacing: 1px;
            font-weight: bold;
            padding: 0 24px;
        }
        .form-signin input[type=text],
        .form-signin input[type=password] {
            border: 1px solid #dadada;

            -webkit-border-radius: 20px; 
            -moz-border-radius: 20px;
            border-radius: 20px; 

            padding: 0 30px 0 50px;
            position: relative;
            margin-bottom: 0px;

            width: 22vw;
            height: 60px;
            line-height: 60px;
        }
        @media screen and (max-width:767px) {
            .form-signin input[type=text],
            .form-signin input[type=password] {
                width: 100%;
            }
        }
        .logo-eoffice-login {
            margin-bottom: 30px;
        }
        .logo-eoffice-login img {
            width: 250px;
        }
        .form-group {
            position: relative;
        }
        .form-group i {
            cursor: pointer; 
            position: absolute; 
            right: 15px; 
            top: 23px;
            z-index: 2;
        }
        .ikon-input {
            position: absolute;
            top: 17px;
            left: 15px;
            z-index: 3;
        }
        .ikon-input img {
            width: 25px;
        }
        .copyright {
            position: absolute;
            bottom: 50px;
        }

        .wrapper-signin {
            width: calc(22vw + 90px);

            background: #FFFFFF;
            padding: 30px 30px;
            -webkit-border-radius: 30px;
            -moz-border-radius: 30px;
            border-radius: 30px;

            padding: 15px 0px;
        }
        .btn-tautan {
            height: 60px;
            line-height: 60px;

            -webkit-border-radius: 20px;
            -moz-border-radius: 20px;
            border-radius: 20px;

            font-size: 15px;
            letter-spacing: 1px;
            font-weight: bold;
            padding: 0 10px;

            width: 100%;
            /*margin-bottom: 15px;*/
        }
    </style>
  </head>

  <body id="kt_body">
    <div class="logo-login"><img src="/images/logo.png"></div>
    <div class="container">

        

        <!-- <div id="myDIV">
          This is my DIV element.
        </div>  -->

        <script type="text/javascript">
            function myFunction() {
              var x = document.getElementById("myDIV");
              if (x.style.display === "none") {
                x.style.display = "block";
              } else {
                x.style.display = "none";
              }
            } 
        </script>

        <div class="row wrapper-signin">
            <div class="col-md-5"><button type="button" onclick="loginsso()" class="btn btn-warning btn-tautan">Login SSO</button></div>
            <div class="col-md-7" style="padding-left: 0px;"><button onclick="myFunction()" class="btn btn-primary btn-tautan">Login credential E-Office</button></div>
            <div class="col-md-12" id="myDIV" style="display: none;">
                <form class="form-signin" id="kt_login_signin_form" action="../app/login/action" method="post">
                    
                    
                        <div class="logo-eoffice-login"><img src="/images/img-eoffice-login.png"></div>
                        @csrf
                        <div class="form-group">
                            <div class="ikon-input"><img src="../../assets/media/images/icon-username.png"></div>
                            <input style='font-size: 17px;' class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Username" name="reqUser" autocomplete="off" value="" />
                        </div>
                        <div class="form-group">
                            <div class="ikon-input"><img src="../../assets/media/images/icon-password.png"></div>
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Password" name="reqPass"  id="id_password" value="" />
                            <i id="togglePassword" class="fa fa-eye" style="font-size: 16px" aria-hidden="true"></i>
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

                    
                        <!-- <button type="button" onclick="loginsso()" class="btn btn-warning pull-left">Login SSO</button> -->
                        <button type="submit" class="btn btn-primary pull-right">Login</button>
                        <input type="hidden" name="reqMode" value="submitLogin"/>
                        <div class="clearfix"></div>
                    
                </form>
            </div>
        </div>
        
        
        
        
        <div class="copyright"> © 2024 BPS</div>

    </div> <!-- /container -->

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/libraries/bootstrap-3.3.7/docs/assets/js/ie10-viewport-bug-workaround.js"></script>
    <script type="text/javascript">
       
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#id_password');

          togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            this.classList.toggle('fa-eye-slash');
        });
    </script>

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
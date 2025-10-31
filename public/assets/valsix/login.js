// if (!navigator.serviceWorker.controller) {
//     navigator.serviceWorker.register("/sw.js").then(function (reg) {
//         console.log("Service worker has been registered for scope: " + reg.scope);
//     });
// }

$(function(){
    $('#logincridential').on('click', function () {
        logincridential();
    });

    $('#loginsso').on('click', function () {
        loginsso();
    });

    $('#loginback').on('click', function () {
        loginback();
    });
});

function loginsso()
{
	login_sso_uri= document.getElementById("login_sso_uri").value;
	login_sso_client_id= document.getElementById("login_sso_client_id").value;
	login_sso_redirect_uri= document.getElementById("login_sso_redirect_uri").value;

	// if(typeof login_sso_uri == "undefined") login_sso_uri= "";
	// if(typeof login_sso_client_id == "undefined") login_sso_client_id= "";
	// if(typeof login_sso_redirect_uri == "undefined") login_sso_redirect_uri= "";

    vurl= login_sso_uri+"oauth2/authorize?client_id="+login_sso_client_id+"&redirect_uri="+login_sso_redirect_uri+"&response_type=code&scope=openid email profile&state=123123";
    // console.log(vurl);
    document.location.href= vurl;
}

function logincridential() {
    window.location = '/app/logineoffice/login/';
}

function loginback() {
    // console.log('xxxx');
    window.location = '/app';
} 
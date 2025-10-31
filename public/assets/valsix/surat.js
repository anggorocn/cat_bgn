function kembali() 
{
    if(typeof vurlkembali == "undefined")
    {
        vurlkembali= "";
    }

    if(vurlkembali == ""){}
    else
    window.location.href= vurlkembali;
}

function setagenda()
{
    if(typeof vurlagenda == "undefined")
    {
        vurlagenda= "";
    }

    if(vurlagenda == ""){}
    else
    document.location.href = vurlagenda;
}

function setundefined(val)
{
    if(typeof val == "undefined" || val == "  ")
        val= "";
    return val;
}

function addmultisatuanKerja(JENIS, multiinfoid, multiinfonama, IDFIELD) 
{
    batas= multiinfoid.length;

    
    if(JENIS == 'PENGIRIM')
    {
        $("#divPengirimSurat").empty();
    }
    else if(JENIS == 'PEMESAN')
    {
        $("#divPemesanSurat").empty();
    }
    else if(JENIS == 'PETIKAN')
    {
        $("#divPetikanSurat").empty();
    }
    else if(JENIS == 'PEMERIKSA')
    {
        $("#divPemeriksaSurat").empty();
    }
    else if(JENIS == 'TUJUAN')
    {
        $("#divTujuanSurat").empty();
    }
    else if(JENIS == 'TEMBUSAN')
    {
        $("#divTembusanSurat").empty();
    }

    if(JENIS == 'PEMESAN')
    {
        vmultiinfoid= multiinfoid[0];
        vmultiinfonama= multiinfonama[0];
        if(JENIS == 'PEMESAN')
        {
            nama='reqPemesanSatuanKerjaId';
        }

        $("#"+IDFIELD).empty().append(`
            <span class="col-lg-10 col-sm-12 row" id="divpilihansurat`+JENIS+`-`+vmultiinfoid+`">
            <input class="form-control" type='text' value="`+vmultiinfonama+`" style="width:90%; margin-left: 2%;" disabled />
            <input type='hidden' value="`+vmultiinfoid+`" id='`+nama+`' name='`+nama+`' />
            </span>
        `);
    }
    else if(JENIS == 'PETIKAN')
    {
        vmultiinfoid= multiinfoid[0];
        vmultiinfonama= multiinfonama[0];
        if(JENIS == 'PETIKAN')
        {
            nama='reqSatuanKerjaIdPetikan';
        }

        $("#"+IDFIELD).empty().append(`
            <span class="col-lg-10 col-sm-12 row" id="divpilihansurat`+JENIS+`-`+vmultiinfoid+`">
            <input class="form-control" type='text' value="`+vmultiinfonama+`" style="width:90%; margin-left: 2%;" disabled />
            <input type='hidden' value="`+vmultiinfoid+`" id='`+nama+`' name='`+nama+`' />
            </span>
        `);
    }
    else
    {
        rekursivemultisatuanKerja(0, JENIS, multiinfoid, multiinfonama, IDFIELD);
    }
}

var vreqJenis= []; var vreqSatkerId= []; var vreqNama= [];
function rekursivemultisatuanKerja(index, JENIS, multiinfoid, multiinfonama, IDFIELD) 
{
    batas= multiinfoid.length;
    // console.log(index+" >= "+batas);

    if(index == 0)
    {
        vreqJenis= [];
        vreqSatkerId= [];
        vreqNama= [];
    }

    if(index < batas)
    {
        SATUAN_KERJA_ID= multiinfoid[index];
        NAMA= multiinfonama[index];

        // vajaxlink= "app/template/tujuan_surat?reqJenis="+JENIS+"&reqSatkerId="+SATUAN_KERJA_ID+"&reqNama="+encodeURIComponent(NAMA);
        // method= "GET";

        var rv = true;
        if(JENIS == "PENGIRIM" || JENIS == "PEMERIKSA")
        {
            $('[name^=reqTujuanSuratParafValidasi]').each(function() {

                if ($(this).val() == SATUAN_KERJA_ID) {
                    Swal.fire("Warning", "Pemeriksa tidak boleh sama dengan pengirim", "warning");
                    rv = false;
                    return false;
                }

            });
        }
        else
        {
            $('[name^=reqTujuanSuratValidasi]').each(function() {

                if ($(this).val() == SATUAN_KERJA_ID) {
                    rv = false;
                    return false;
                }

            });
        }

        if (rv == true) 
        {
            vreqJenis.push(String(JENIS));
            vreqSatkerId.push(String(SATUAN_KERJA_ID));
            vreqNama.push(NAMA);
            /*$.ajaxSetup({
                 beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf_token"]').attr('content'));
                }
            });

            $.ajax({
                url: vajaxlink,
                method: method,
                "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                data: {
                    reqJenis: JENIS
                    , reqSatkerId: SATUAN_KERJA_ID
                    , reqNama: NAMA
                },
                success: function (response) {

                    $("#"+IDFIELD).append(response).append(function() {
                        setinfovalidasi();

                        index= parseInt(index) + 1;
                        rekursivemultisatuanKerja(index, JENIS, multiinfoid, multiinfonama, IDFIELD);
                    });

                    // $("#"+IDFIELD).append(response);
                    // setinfovalidasi();

                    // index= parseInt(index) + 1;
                    // rekursivemultisatuanKerja(index, JENIS, multiinfoid, multiinfonama, IDFIELD);
                },
                error: function (response) {
                },
                complete: function () {
                }
            });*/
        }
        /*else
        {
            index= parseInt(index) + 1;
            rekursivemultisatuanKerja(index, JENIS, multiinfoid, multiinfonama, IDFIELD);
        }*/

        index= parseInt(index) + 1;
        rekursivemultisatuanKerja(index, JENIS, multiinfoid, multiinfonama, IDFIELD);
    }
    else if (index >= batas)
    {
        vajaxlink= "app/template/new_tujuan_surat";
        method= "POST";

        // console.log(vreqJenis);
        // console.log(vreqSatkerId);
        // console.log(vreqNama);

        $.ajaxSetup({
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf_token"]').attr('content'));
            }
        });

        $.ajax({
            url: vajaxlink,
            method: method,
            "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
            data: {
                reqJenis: vreqJenis
                , reqSatkerId: vreqSatkerId
                , reqNama: vreqNama
            },
            success: function (response) {

                $("#"+IDFIELD).append(response).append(function() {
                    setinfovalidasi();
                });
            },
            error: function (response) {
            },
            complete: function () {
            }
        });
    }
}

function setinfodetilpopup(rec)
{
    // console.log(rec);
    $('#reqSatuanKerjaId').val(rec.id);
    $('#reqUserAtasanId').val(rec.NIP);
    $('#reqAsalSuratInstansi').val(rec.SATUAN_KERJA);
}

function removePilihan(id) 
{
    $("#divpilihansurat"+id).remove();
}

function removePemeriksaPilihan(id) 
{
    $("#divpilihanpemeriksasurat"+id).remove();
}

function removebyid(id) 
{
    // console.log(id);
    $("#"+id).remove();
}

function hapuspasal()
{
    var arrnomorbap= ["BAB I <span class='text-danger'>*</span>", "BAB II", "BAB III", "BAB IV", "BAB V", "BAB VI", "BAB VII", "BAB VIII", "BAB IX", "BAB X", "BAB XI", "BAB XII", "BAB XIII", "BAB XIV", "BAB XV", "BAB XVI", "BAB XVII", "BAB XVIII", "BAB XIX", "BAB XX", "BAB XXI", "BAB XXII", "BAB XXIII", "BAB XXIV", "BAB XXV"];
    var arrnomorpasal= ["PASAL 1 <span class='text-danger'>*</span>", "PASAL 2", "PASAL 3", "PASAL 4", "PASAL 5", "PASAL 6", "PASAL 7", "PASAL 8", "PASAL 9", "PASAL 10", "PASAL 11", "PASAL 12", "PASAL 13", "PASAL 14", "PASAL 15", "PASAL 16", "PASAL 17", "PASAL 18", "PASAL 19", "PASAL 20", "PASAL 21", "PASAL 22", "PASAL 23", "PASAL 24", "PASAL 25"];

    $('.infonomorpasal').each(function(index, obj){
        if(parseInt(index) > 0)
            $(this).html(arrnomorpasal[index]);
    });

    nomorpasal= 0;
    $('.infonomorbap').each(function(index, obj){
        if(parseInt(index) > 0)
            $(this).html(arrnomorbap[index]);

        nomorpasal= index;
    });
    nomorpasal++;
    $("#total_chq").val(nomorpasal);
}

function hapusgeneralpasal()
{
    var arrnomor= ["Pertama", "Kedua", "Ketiga", "Keempat", "Kelima", "Keenam", "Ketujuh", "Kedelapan", "Kesembilan", "Kesepuluh", "Kesebelas", "Keduabelas", "Ketigabelas", "Keempatbelas", "Kelimabelas", "Keenambelas", "Ketujuhbelas", "Kedelapanbelas", "Kesembilanbelas", "Keduapuluh", "Keduapuluhsatu", "Keduapuluhdua", "Keduapuluhtiga", "Keduapuluhempat", "Keduapuluhlima"];

    nomorpasal= 0;
    $('.infonomor').each(function(index, obj){
        if(parseInt(index) > 0)
            $(this).html(arrnomor[index]);

        nomorpasal= index;
    });
    nomorpasal++;
    $("#total_chq").val(nomorpasal);
}

function setsimpan()
{
    $('#btsubmit').click();
}

function submitform(vbtnid, reqStatusSurat) {
      
    $("#reqStatusSurat").val(reqStatusSurat);

    reqvalidasibaru= "";
    if($("#tab-informasi-success").is(":visible") && $("#tab-isi-success").is(":visible") && $("#tab-atribut-success").is(":visible"))
    {
        reqvalidasibaru= "1";
    }

    if(reqvalidasibaru == "")
    {
        if($("#tab-informasi-danger").is(":visible"))
        {
            Swal.fire("Infomasi Surat belum valid.", "");
            return false;
        }

        if($("#tab-isi-danger").is(":visible"))
        {
            Swal.fire("Isi Surat belum valid.", "");
            return false;
        }

        if($("#tab-atribut-danger").is(":visible"))
        {
            Swal.fire("Atribut Surat belum valid.", "");
            return false;
        }
        // return false;
    }

    var pesan = "";
    pesan = "Simpan surat sebagai draft?";
    if (reqStatusSurat == "POSTING")
    {
        var pesan = "Kirim surat ke tujuan?";
    }

    infopesandetil= "";
    if (reqStatusSurat == "REVISI")
    {
        infopesandetil= " Kembalikan surat ke staff anda?";
    }

    // tambahan khusus
    if (reqStatusSurat == "PARAF")
    {
        infopesandetil= " Paraf naskah?";
    }



    if (reqStatusSurat == "POSTING" || reqStatusSurat == "PARAF" || reqStatusSurat == "REVISI" || reqStatusSurat == "UBAHDATAPOSTING" || reqStatusSurat == "UBAHDATADRAFTPARAF")
    {
        infocontent= '<form action="" class="formName">' +
        '<div class="form-group">' +
        '<label>Isi komentar jika ingin mengirim dokumen ini!</label>' +
        '<input type="hidden" id="infoStatusApprove" value="" />' +
        '<input type="text" placeholder="Tuliskan komentar anda..." class="name form-control" required />' +
        '</div>' +
        '</form>';

        $.confirm({
            title: 'Komentar'+infopesandetil,
            content: '' + infocontent
            ,
            buttons: {
                formSubmit: {
                    text: 'OK',
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('.name').val();
                        if (!name) {
                            $.alert('<span style= color:red>Komentar wajib diisi !</span>');
                            return false;
                        }
                        $("#reqInfoLog").val(name);

                        if (reqId == "" || (reqStatusSurat == "DRAFT" && reqId !== "") )
                        {
                            infoStatusApprove= $("#infoStatusApprove").val();
                            $("#reqStatusApprove").val(infoStatusApprove);
                        }
                        // return false;

                        formSubmitButton= KTUtil.getById(vbtnid);
                        setsimpan();
                    }
                },
                cancel: function () {
                },
            },
            onContentReady: function () {
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click');
                });
            }
        });
    }
    else if (reqStatusSurat == "UBAHDATAPARAF" || reqStatusSurat == "UBAHDATAREVISI" || reqStatusSurat == "UBAHDATAVALIDASI")
    {
        formSubmitButton= KTUtil.getById(vbtnid);
        setsimpan();
    }
    else
    {
        Swal.fire({
            title: pesan,
            text: "",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yakin",
            cancelButtonText: "Batal",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) 
            {
                formSubmitButton= KTUtil.getById(vbtnid);
                setsimpan();
            }
            else if (result.dismiss === "cancel") 
            {
                Swal.fire(
                    "Batal "+pesan,
                    "",
                    ""
                )
            }
        });
    }
}

function setinfovalidasi()
{
    reqPerihal= reqSatuanKerjaIdTujuan= reqSatuanKerjaId= reqSatuanKerjaIdParaf=
    reqKeterangan= reqButuhAksiId= reqSifatNaskah= reqJenisNaskahID="";

    reqPerihal= $("#reqPerihal").val();
    reqJenisNaskahID= $("#reqJenisNaskahID").val();
    reqUserAtasanId= setundefined($("#reqUserAtasanId").val());
    // reqSatuanKerjaId= setundefined($("#reqSatuanKerjaId").val());
    // reqSatuanKerjaId= setundefined($('[name^=reqSatuanKerjaId]').val());
    reqSatuanKerjaId= setundefined($('[name=reqSatuanKerjaId]').val());
    reqSatuanKerjaIdTujuan= setundefined($('[name^=reqSatuanKerjaIdTujuan]').val());
    reqButuhAksiId= setundefined($("#reqButuhAksiId").val());
    reqSifatNaskah= setundefined($("#reqSifatNaskah").val());
    reqKlasifikasiId= setundefined($("#reqKlasifikasiId").val());

    // reqMenimbang= setundefined($("#reqMenimbang").val());
    // reqKeterangan= setundefined($("#reqKeterangan").val());
    // reqMengingat= setundefined($("#reqMengingat").val());
    // reqMenetapkan= setundefined($("#reqMenetapkan").val());
    // reqPertama= setundefined($("#reqPertama").val());
    // reqDasar= setundefined($("#reqDasar").val());
    // reqIsiPerintah= setundefined($("#reqIsiPerintah").val());

    reqKeterangan= setundefined($("#reqKeterangan").froalaEditor('html.get'));
    reqMenimbang= setundefined($("#reqMenimbang").froalaEditor('html.get'));
    reqMengingat= setundefined($("#reqMengingat").froalaEditor('html.get'));
    reqMenetapkan= setundefined($("#reqMenetapkan").froalaEditor('html.get'));
    reqPertama= setundefined($("#reqPertama").froalaEditor('html.get'));
    reqDasar= setundefined($("#reqDasar").froalaEditor('html.get'));
    reqIsiPerintah= setundefined($("#reqIsiPerintah").froalaEditor('html.get'));

    $("#tab-informasi-danger").hide();
    $("#tab-informasi-success").show();

    // console.log(reqJenisNaskahID);
    
    if
    (
        (
            reqSatuanKerjaIdTujuan == "" || reqPerihal == "" || reqSatuanKerjaId == "" || reqUserAtasanId == ""
        )
        ||
        (
            reqKlasifikasiId == "" && (reqJenisNaskahID == 8 || reqJenisNaskahID == 13 || reqJenisNaskahID == 17 || reqJenisNaskahID == 18 || reqJenisNaskahID == 19 || reqJenisNaskahID == 20 || reqJenisNaskahID == 15)
        )
        // (
        //     (reqSatuanKerjaIdTujuan == "" || reqPerihal == "" || reqSatuanKerjaId == "" || reqUserAtasanId == "") && reqId == ""
        // ) 
        // ||
        // (
        //     (
        //         reqSatuanKerjaIdTujuan == "" || reqPerihal == "" || reqSatuanKerjaId == "" || reqUserAtasanId == ""
        //     ) && reqId !== ""
        // )
    )
    {
        $("#tab-informasi-danger").show();
        $("#tab-informasi-success").hide();
    }

    // khusus surat keluar
    if(reqJenisNaskahID == 15)
    {
        reqKotaTujuan= $("#reqKotaTujuan").val();
        reqEksternalKepadaInfo= $("#reqEksternalKepadaId").val();

        $("#tab-informasi-danger").hide();
        $("#tab-informasi-success").show();

        if
        (
            reqPerihal == "" || reqSatuanKerjaId == "" 
            || (reqSatuanKerjaIdTujuan == "" && reqEksternalKepadaInfo == "") 
            || reqUserAtasanId == "" || reqKlasifikasiId == "" || reqKotaTujuan == ""
        )
        {
            $("#tab-informasi-danger").show();
            $("#tab-informasi-success").hide();
        }
        // console.log(reqPerihal);
        // console.log(reqSatuanKerjaId);
        // console.log(reqSatuanKerjaIdTujuan);
        // console.log(reqEksternalKepadaInfo);
        // console.log(reqUserAtasanId);
        // console.log(reqKlasifikasiId);
        // console.log(reqKotaTujuan);
    }

    $("#tab-isi-danger").hide();
    $("#tab-isi-success").show();

    /*if(reqJenisNaskahID==17||reqJenisNaskahID==8){

        if(reqMenimbang == "")
        {
            $("#tab-isi-danger").show();
            $("#tab-isi-success").hide();
        } 
    }*/
    // untuk surat perintah
    if(reqJenisNaskahID == 18)
    {
        if(reqDasar == "Powered by Froala Editor" || reqDasar == "" || reqIsiPerintah == "Powered by Froala Editor" || reqIsiPerintah == "")
        {
            $("#tab-isi-danger").show();
            $("#tab-isi-success").hide();
        }
    }
    // untuk keputusan direksi
    else if(reqJenisNaskahID == 8)
    {
        if(reqMenimbang == "Powered by Froala Editor" || reqMenimbang == "" || reqMengingat == "Powered by Froala Editor" || reqMengingat == "" || reqMenetapkan == "Powered by Froala Editor" || reqMenetapkan == "" || reqPertama == "Powered by Froala Editor" || reqPertama == "")
        {
            $("#tab-isi-danger").show();
            $("#tab-isi-success").hide();
        }   
    }
    // untuk surat keputusan direksi
    else if(reqJenisNaskahID == 17)
    {
        if(reqMenimbang == "Powered by Froala Editor" || reqMenimbang == "" || reqMengingat == "Powered by Froala Editor" || reqMengingat == "" || reqMenetapkan == "Powered by Froala Editor" || reqMenetapkan == "" || reqPertama == "Powered by Froala Editor" || reqPertama == "")
        {
            $("#tab-isi-danger").show();
            $("#tab-isi-success").hide();
        }   
    }
    // untuk intruksi direksi
    else if(reqJenisNaskahID == 19)
    {
        if(reqMenimbang == "Powered by Froala Editor" || reqMenimbang == "" || reqMengingat == "Powered by Froala Editor" || reqMengingat == "" || reqMenetapkan == "Powered by Froala Editor" || reqMenetapkan == "" || reqPertama == "Powered by Froala Editor" || reqPertama == "")
        {
            $("#tab-isi-danger").show();
            $("#tab-isi-success").hide();
        }   
    }
    else if(reqJenisNaskahID == 20)
    {
        if(reqMenimbang == "Powered by Froala Editor" || reqMenimbang == "" || reqMengingat == "Powered by Froala Editor" || reqMengingat == "" || reqMenetapkan == "Powered by Froala Editor" || reqMenetapkan == "" || reqPertama == "Powered by Froala Editor" || reqPertama == "")
        {
            $("#tab-isi-danger").show();
            $("#tab-isi-success").hide();
        }   
    }
    else
    {
        if(reqKeterangan == "Powered by Froala Editor" || reqKeterangan == "")
        {
            $("#tab-isi-danger").show();
            $("#tab-isi-success").hide();
        }        
    }
    
    $("#tab-atribut-danger").hide();
    $("#tab-atribut-success").show();
    if(reqButuhAksiId == "" || reqSifatNaskah == "")
    {
        $("#tab-atribut-danger").show();
        $("#tab-atribut-success").hide();
    }
}

function infolampiran(mode)
{
    var infolampiran= "";
    infolampiran= setundefined($("#infolampiran").text());
    if(infolampiran == "")
        infolampiran= 0;

    if(mode == "plus")
        infolampiran= parseInt(infolampiran) + 1;
    else if(mode == "min" && parseInt(infolampiran) > 0)
        infolampiran= parseInt(infolampiran) - 1;

    $("#infolampiran").text(infolampiran);
}

function setatasnama(info)
{
    $("#reqAnStatus").val("");
    $("#reqAnStatusNama").attr("readonly", true);
    if($("#reqAnStatusChecked").prop('checked')) 
    {
        $("#reqAnStatus").val("1");
        $("#reqAnStatusNama").attr("readonly", false);
    }
    else
    {
        if(info == 2)
        {
            $("#reqAnStatusNama").val("");
        }
    }
}

function setkirimwa(info)
{
    $("#reqKirimWa").val("");
    if($("#reqKirimWaChecked").prop('checked')) 
    {
        $("#reqKirimWa").val("1");
        if(info == 2)
        {
            Swal.fire("Warning", "Apakah anda yakin akan memberikan notif WhatsApp pada surat ini?", "warning");
        }
    }
    else
    {
        if(info == 2)
        {
        }
    }
}

function selectNamaBagian() {
    var Filter = document.getElementById("reqBagianNama").value;
    // console.log(nomorpasal);

    if(Filter=='BAB')
    {
        $('.infonomorpasal').each(function(index, obj){
            // console.log(index);
            // console.log(obj);
            // console.log($(this).text());
            obj.style.display = "none";
        });
        $('.infonomorbap').each(function(index, obj){
            // console.log(index);
            // console.log(obj);
            // console.log($(this).text());
            obj.style.display = "";
        });
    }
    else
    {
        $('.infonomorpasal').each(function(index, obj){
            // console.log(index);
            // console.log(obj);
            // console.log($(this).text());
            obj.style.display = "";
        });
        $('.infonomorbap').each(function(index, obj){
            // console.log(index);
            // console.log(obj);
            // console.log($(this).text());
            obj.style.display = "none";
        });
    }
}

function setdatakepada(vdetil)
{
    if(vdetil == "PEMERIKSA")
    {
        getinfoid= [];
        getinfonama= [];
        $('[id^="divpilihanpemeriksasurat"]').each(function(){
            vid= $(this).attr('id');
            vid= vid.replace("divpilihanpemeriksasurat", "");
            vtujuan= $("#val-"+vid).val();

            getinfoid.push(String(vid));
            getinfonama.push(String(vtujuan));
        });

        return [getinfoid, getinfonama];
    }
    else if(vdetil == "TUJUAN")
    {
        getinfoid= [];
        getinfonama= [];
        $('[id^="divpilihansuratTUJUAN"]').each(function(){
            vid= $(this).attr('id');
            vid= vid.replace("divpilihansurat", "");
            vtujuan= $("#val-"+vid).val();
            vid= vid.replace("TUJUAN", "");

            getinfoid.push(String(vid));
            getinfonama.push(String(vtujuan));
        });

        return [getinfoid, getinfonama];
    }
    else if(vdetil == "TEMBUSAN")
    {
        getinfoid= [];
        getinfonama= [];
        $('[id^="divpilihansuratTEMBUSAN"]').each(function(){
            vid= $(this).attr('id');
            vid= vid.replace("divpilihansurat", "");
            vtujuan= $("#val-"+vid).val();
            vid= vid.replace("TEMBUSAN", "");

            getinfoid.push(String(vid));
            getinfonama.push(String(vtujuan));
        });

        return [getinfoid, getinfonama];
    }
}

$(function(){
    // buat validasi text dari froala
    if(typeof froalaid !== "undefined" && typeof froalaheight !== "undefined")
    {
        froaladinamis.init(froalaid, froalaheight);
        setinfovalidasi();
    }

    reqJenisNaskahID= setundefined($("#reqJenisNaskahID").val());
    if(reqJenisNaskahID == "1")
    {
        infolampiran("");

        $("#reqFile").change(function(e) {
            infolampiran("plus");
        });
    }

    setatasnama(1);
    $("#reqAnStatusChecked").click(function () {
        setatasnama(2);
    });

    setkirimwa(1);
    $("#reqKirimWaChecked").click(function () {
        setkirimwa(2);
    });

    $("#reqPerihal, #reqKotaTujuan").keyup(function () {
        setinfovalidasi();
    });

    $("#reqKlasifikasiId").change(function() {
        setinfovalidasi();
    });

    // froaladinamis

    Array.prototype.has_element = function(element) {
        return $.inArray(element, this) !== -1;
    };

    if(typeof filecheckvalidasi !== "undefined")
    {
        $(filecheckvalidasi).on("change", function () {
            file1mb= 1000000;
            file1mb= parseFloat(file1mb) * 10;

            typefilecheck= ["application/pdf", "application/vnd.ms-powerpoint", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "image/png", "image/jpeg", "image/jpg"];

            lewati= 0;
            $.each(this.files, function( index, value ) {
                if(lewati == 0)
                {
                    vtype= value["type"];
                    vsize= value["size"];
                    // console.log(vtype);

                    if(vsize > file1mb) {
                        lewati= 1;
                    }

                    if(typefilecheck.has_element(vtype)){}
                    else 
                    {
                        lewati= 2;
                    }
                }
            });

            if(parseFloat(lewati) > 0)
            {
                if(lewati == 1)
                {
                    Swal.fire("", "check file upload harus di bawah 10 MB", "");
                }

                if(lewati == 2)
                {
                    Swal.fire("", "check file upload, harus Jenis file (word, excel, ppt, pdf, jpg, jpeg, png)", "");
                }

                $(this).val('');
            }

        });
    }

});

$("#vlxbrowsefile").on("click",function(e){
    e.preventDefault();
});

if(typeof vbuttonupload == "undefined")
{
    vbuttonupload= "";
}

if(vbuttonupload == "1") 
{
    var vlxfilestoupload = []; // Array to store files
    const vlxfileinput = document.getElementById('reqVlsxFile');

    var filenotallowed = ["pdf", "doc", "docx", "xls", "xlsx", "ppt", "png", "jpeg", "jpg"];

    vlxfileinput.addEventListener('change', (e) => {
      e.preventDefault();

      for (let i = 0; i < e.target.files.length; i++) {
        // let vfiles = e.target.files[i];
        // // let myFileSize = vfiles[0].name;
        // let myFileType = vfiles[0].type;

        let myFile = e.target.files[i];

        var sFileName = myFile.name;
        var sFileExtension = sFileName.split('.')[sFileName.split('.').length - 1].toLowerCase();
        var iFileSize = myFile.size;
        var iConvert = (myFile.size / 1048576).toFixed(2);
        // console.log(iConvert+"-"+sFileExtension);
        let myFileID = "FID" + (1000 + Math.random() * 9000).toFixed(0);

        filesize= iConvert;
        filetype= sFileExtension;
        if(parseFloat(filesize) > 10)
        {
            $.alert('<span style= color:red>Check file upload harus di bawah 10 MB !</span>');
        }
        else if (filenotallowed.indexOf(filetype) > -1)
        {
            vlxfilestoupload.push({
              file: myFile
              , FID: myFileID
            });

            reqJenisNaskahID= setundefined($("#reqJenisNaskahID").val());
            if(reqJenisNaskahID == "1")
            {
                infolampiran("plus");
            }   
        }
        else
        {
            $.alert('<span style= color:red>Check file upload Jenis file diterima: word, excel, ppt, pdf, jpg, jpeg, png !</span>');
        }
      };
      vlxfiledisplay();
      //reset the input to null - nice little chrome bug!
      e.target.value = null;
    });
}

$("#vlxbrowsefile").click(function (e) {
    document.getElementById('reqVlsxFile').click();
});

const vlxremovefile = (x) => {
  for (let i = 0; i < vlxfilestoupload.length; i++) {
    if (vlxfilestoupload[i].FID === x)
    {
      vlxfilestoupload.splice(i, 1);

      reqJenisNaskahID= setundefined($("#reqJenisNaskahID").val());
      if(reqJenisNaskahID == "1")
      {
        infolampiran("min");
      }
    }
  }
  vlxfiledisplay();
}

const vlxfiledisplay = () => {
  document.getElementById("vlxmyfiles").innerHTML = "";
  for (let i = 0; i < vlxfilestoupload.length; i++) 
  {
    // document.getElementById("vlxmyfiles").innerHTML += `<li>${vlxfilestoupload[i].file.name}<button onclick="vlxremovefile('${vlxfilestoupload[i].FID}')">Remove</button></li>`;
    document.getElementById("vlxmyfiles").innerHTML += `<li>${vlxfilestoupload[i].file.name} <button class="btn btn-danger btn-sm " type="button" onclick="vlxremovefile('${vlxfilestoupload[i].FID}')"><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></button> </li>`;
  }
}

var ajaxserverselectsingle = function() {
    var cekreturn = function(checkvaldata) {
        valreturn= true;
        if(checkvaldata == "1")
            valreturn= false;

        return valreturn;
    };
    var initdynamistable = function(valtableid, valjsonurl, valarrdata, valgroup) {
        infocolumnsdef= [];
        infocolumns= [];
        infotargets= [];
        valarrdata.forEach(function (item, index) {

            if(item["field"]=='DT_RowIndex')
            {
                infofield= item["field"];
            }
            else
            {
                infofield= item["field"].toLowerCase();
            }

            //searching jika menggunakan query builder

            if(item["alias"])
            {
                infoname= item["alias"].toLowerCase();
            }
            else
            {
                infoname= '';
            }

            infodisplay= item["display"];
            infowidth= item["width"];

            infocolumnsdef.push(infofield);

            setdisplay= true;
            if(infodisplay == "1")
            {
                infotargets.push(index);
                setdisplay= false;
            }

            var infodetil= {};
            infodetil.data= infofield;
            infodetil.visible= setdisplay;
            infodetil.name= infoname;

            if(infowidth !== "")
            {
                infodetil.width= infowidth;
            }
           
            infocolumns.push(infodetil);
            // console.log(infocolumns);
        });
        infogroupfield= valarrdata[0]["field"];
        // console.log(valarrdata[0]["field"]);
        // console.log(infocolumns);

        responsiveinfo=true;

        if(typeof datainfopage == "undefined")
        {
            datainfopage= 10;
        }
        // console.log(infopage);

        if(typeof dataTablewarna == "undefined")
        {
            dataTablewarna= "";
        }

        if(typeof tempTanggalTmt == "undefined")
        {
            tempTanggalTmt= "";
        }

        if(typeof aktifwarna == "undefined")
        {
            aktifwarna= "";
        }

        if(typeof datainfoscrollx == "undefined")
        {
            infoscrollx= cekreturn("1");
        }
        else
        {
            infoscrollx= cekreturn(datainfoscrollx);
            responsiveinfo=false;
        }

        if(typeof infoscrolly == "undefined")
        {
            infoscrolly= "";
        }

        // infoscrolly= cekreturn(datainfoscrolly);
        // console.log(infoscrollx);  

        setchangeorder= [];
        var valorderdefault= valarrdata.length - 2;
        if(typeof datachangeorder == "undefined")
        {
            setchangeorder= [valorderdefault, "asc"];
        }
        else
        {
            if(Array.isArray(datachangeorder) && datachangeorder.length)
            {
                setchangeorder= [];
                datachangeorder.forEach(function (item, index) {
                    // console.log(item);
                    // console.log(index);
                    setchangeorder.push(item);
                });
            }
            // setchangeorder= [[4, "desc"], [5, "desc"]];
        }
        // console.log([2, "asc"]);
        // console.log([[4, "desc"], [5, "desc"]]);
        // console.log(vcb);
        // console.log(setchangeorder);

        var table; var groupColumn = valorderdefault;
        var collapsedGroups = {};
        datanewtable= $('#'+valtableid);


        if(valgroup == "1")
        {
            table= datanewtable.DataTable({
                responsive: true
                ,"search": {
                    "caseInsensitive": true // Pastikan pencarian tidak membedakan huruf besar/kecil
                }
                // , searchDelay: 500
                , processing: true
                , serverSide: true
                , rowGroup: {
                    dataSrc: infogroupfield,
                    startRender: function ( rows, group ) {
                        var collapsed = !!collapsedGroups[group];
                        rows.nodes().each(function (r) {
                            r.style.display = collapsed ? 'none' : '';
                        });
         
                        return $('<tr/>')
                            .append('<td colspan="'+valarrdata.length+'">' + group + '</td>')
                            // .append('<td colspan="'+valarrdata.length+'">' + group + ' (' + rows.count() + ')</td>')
                            .attr('data-name', group)
                            .toggleClass('collapsed', collapsed);
                      },
                }
                , order: setchangeorder
                , columnDefs: [
                    // { className: 'never', targets: infotargets },
                    // { className: 'dt-center', targets: [ 0 ] },
                ]

                , ajax: 
                {
                    url: valjsonurl
                    , type: 'GET'
                    , "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')}
                    , data: {columnsDef: infocolumnsdef},
                }
                , columns: infocolumns
                , "fnDrawCallback": function( oSettings ) {
                    $('#'+infotableid+'_filter input').unbind();
                    $('#'+infotableid+'_filter input').bind('keyup', function(e) {
                        if(e.keyCode == 13) {
                            carijenis= "1";
                            calltriggercari();
                        }
                    });

                    reloadglobalklikcheck();
                    // $(this).find('thead input[type=checkbox]').removeAttr('checked');
                }
                , "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    // console.log(aData);
                    /*var valueStyle= loopIndex= "";
                    valueStyle= nRow % 2;
                    loopIndex= 6;
                    
                    if( aData[7] == '1')
                    {
                        $($(nRow).children()).attr('class', 'hukumanstyle');
                    }
                    else if( aData[7] == '2')
                    {
                        $($(nRow).children()).attr('class', 'hukumanpernahstyle');
                    }*/
                    
                    // $($(nRow).children()).attr('class', 'warnatandamerah');
                }

            });

            $('#'+valtableid+' tbody').on('click', 'tr.dtrg-start', function() {
                var name = $(this).data('name');
                collapsedGroups[name] = !collapsedGroups[name];
                table.draw(false);
            });
        }
        else
        {
            // console.log(infocolumns);
            table= datanewtable.DataTable({
                responsive: responsiveinfo
                ,"search": {
                    "caseInsensitive": true // Pastikan pencarian tidak membedakan huruf besar/kecil
                }
                // , searchDelay: 500
                , processing: true
                , serverSide: true
                , "scrollY": infoscrolly+"vh"
                , "scrollX": infoscrollx
                , pageLength: datainfopage
                , order: setchangeorder
                , columnDefs: [
                    // { className: 'never', targets: infotargets },
                    // { className: 'dt-center', targets: [ 0 ] },
                    { searchable: false, targets: 0 }
                ]
                , ajax: 
                {
                    url: valjsonurl
                    , type: 'GET'
                    , "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')}
                    , data: {columnsDef: infocolumnsdef},
                }
                , columns: infocolumns
                , "fnDrawCallback": function( oSettings ) {
                    $('#'+infotableid+'_filter input').unbind();
                    $('#'+infotableid+'_filter input').bind('keyup', function(e) {
                        if(e.keyCode == 13) {
                            carijenis= "1";
                            calltriggercari();
                        }
                    });

                    reloadglobalklikcheck();
                }
                , "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    var valueStyle= loopIndex= maxLoop= "";
                    maxLoop= 11;
                    valueStyle= nRow % 2;
                    loopIndex= 6;

                    color= bold= "";
                    if(typeof infobold == "undefined"){}
                    else
                    {
                        vbold= aData[valarrdata[infobold]["field"].toLowerCase()];
                        bold= "bold";
                        if(vbold == "1")
                        {
                            bold= "";
                        }
                    }

                    if(typeof infocolor == "undefined"){}
                    else
                    {
                        vcolor= aData[valarrdata[infocolor]["field"].toLowerCase()];
                        if( vcolor == 'Rahasia')
                        {
                            color= "fdd6d6";
                        }
                        else if( vcolor == 'Sangat Segera')
                        {
                            color= "ffeeba";
                        }
                        else if( vcolor == 'Segera')
                        {
                            color= "b4ebff";
                        }
                    }

                    if(typeof infobold !== "undefined" || typeof infocolor == "undefined")
                    {
                        $($(nRow).children()).attr('style', 'font-weight:'+bold+'; background-color:#'+color);
                    }
                    
                    if(dataTablewarna != ""){
                        if( tempTanggalTmt == aData[dataTablewarna])
                        {

                            $($(nRow).children()).attr('class', 'alertstyle');
                        }
                    }

                    if(aktifwarna != "")
                    {
                        if(valueStyle == "1") 
                        {
                           $($(nRow).children()).attr('class', 'oddwarna');
                        }
                        else
                        {
                            $($(nRow).children()).attr('class', 'evenWarna');
                        }


                        if( aData["STATUS_KGB"] == '1')
                        {
                            $($(nRow).children()).attr('class', 'usulanWarna');
                        }
                        else if( aData["STATUS_KGB"] == '2')
                        {
                            $($(nRow).children()).attr('class', 'prosesWarna');
                        }
                        else if( aData["STATUS_KGB"] == '3')
                        {
                            $($(nRow).children()).attr('class', 'selesaiWarna');
                        }
                        else if( aData["STATUS_KGB"] == '4')
                        {
                            $($(nRow).children()).attr('class', 'tidakWarna');
                        }

                        if( aData["STATUS"] == '1')
                        {
                            $($(nRow).children()).attr('class', 'prosesWarna');
                        }
                        else if( aData["STATUS"] == '2')
                        {
                            $($(nRow).children()).attr('class', 'tolakWarna');
                        }
                        else if( aData["STATUS"] == '3')
                        {
                            $($(nRow).children()).attr('class', 'tidakWarna');
                        }
                        else if( aData["STATUS"] == '4')
                        {
                            $($(nRow).children()).attr('class', 'selesaiWarna');
                        }
                    }
                }

            });
        }
    };

    return {
        init: function(valtableid, valjsonurl, valarrdata, valgroup) {
            if(typeof valgroup==='undefined' || valgroup===null || valgroup == "") 
            {
                valgroup= "";
            }

            initdynamistable(valtableid, valjsonurl, valarrdata, valgroup);
        },
    };

}();

var ajaxserverselectsingle1 = function() {
    var cekreturn = function(checkvaldata) {
        valreturn= true;
        if(checkvaldata == "1")
            valreturn= false;

        return valreturn;
    };
    var initdynamistable = function(valtableid, valjsonurl, valarrdata, valgroup) {
        infocolumnsdef= [];
        infocolumns= [];
        infotargets= [];
        valarrdata.forEach(function (item, index) {

            if(item["field"]=='DT_RowIndex')
            {
                infofield= item["field"];
            }
            else
            {
                infofield= item["field"].toLowerCase();
            }

            //searching jika menggunakan query builder

            if(item["alias"])
            {
                infoname= item["alias"].toLowerCase();
            }
            else
            {
                infoname= '';
            }

            infodisplay= item["display"];
            infowidth= item["width"];

            infocolumnsdef.push(infofield);

            setdisplay= true;
            if(infodisplay == "1")
            {
                infotargets.push(index);
                setdisplay= false;
            }

            var infodetil= {};
            infodetil.data= infofield;
            infodetil.visible= setdisplay;
            infodetil.name= infoname;

            if(infowidth !== "")
            {
                infodetil.width= infowidth;
            }
           
            infocolumns.push(infodetil);
            // console.log(infocolumns);
        });
        infogroupfield= valarrdata[0]["field"];
        // console.log(valarrdata[0]["field"]);
        // console.log(infocolumns);

        responsiveinfo=true;

        if(typeof datainfopage == "undefined")
        {
            datainfopage= 10;
        }
        // console.log(infopage);

        if(typeof dataTablewarna == "undefined")
        {
            dataTablewarna= "";
        }

        if(typeof tempTanggalTmt == "undefined")
        {
            tempTanggalTmt= "";
        }

        if(typeof aktifwarna == "undefined")
        {
            aktifwarna= "";
        }

        if(typeof datainfoscrollx == "undefined")
        {
            infoscrollx= cekreturn("1");
        }
        else
        {
            infoscrollx= cekreturn(datainfoscrollx);
            responsiveinfo=false;
        }

        if(typeof infoscrolly == "undefined")
        {
            infoscrolly= "";
        }

        // infoscrolly= cekreturn(datainfoscrolly);
        // console.log(infoscrollx);

        setchangeorder1= [];
        var valorderdefault= valarrdata.length - 2;
        if(typeof datachangeorder1 == "undefined")
        {
            setchangeorder1= [valorderdefault, "asc"];
        }
        else
        {
            if(Array.isArray(datachangeorder1) && datachangeorder1.length)
            {
                setchangeorder1= [];
                datachangeorder1.forEach(function (item, index) {
                    // console.log(item);
                    // console.log(index);
                    setchangeorder1.push(item);
                });
            }
            // setchangeorder= [[4, "desc"], [5, "desc"]];
        }

        var table; var groupColumn = valorderdefault;
        var collapsedGroups = {};
        datanewtable1= $('#'+valtableid);

        if(valgroup == "1")
        {
            table= datanewtable1.DataTable({
                responsive: true
                // , searchDelay: 500
                ,"search": {
                    "caseInsensitive": true // Pastikan pencarian tidak membedakan huruf besar/kecil
                }
                , processing: true
                , serverSide: true
                , rowGroup: {
                    dataSrc: infogroupfield,
                    startRender: function ( rows, group ) {
                        var collapsed = !!collapsedGroups[group];
                        rows.nodes().each(function (r) {
                            r.style.display = collapsed ? 'none' : '';
                        });
         
                        return $('<tr/>')
                            .append('<td colspan="'+valarrdata.length+'">' + group + '</td>')
                            // .append('<td colspan="'+valarrdata.length+'">' + group + ' (' + rows.count() + ')</td>')
                            .attr('data-name', group)
                            .toggleClass('collapsed', collapsed);
                      },
                }
                , order: setchangeorder1
                , columnDefs: [
                    // { className: 'never', targets: infotargets },
                    // { className: 'dt-center', targets: [ 0 ] },
                ]

                , ajax: 
                {
                    url: valjsonurl
                    , type: 'GET'
                    , "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')}
                    , data: {columnsDef: infocolumnsdef},
                }
                , columns: infocolumns
                , "fnDrawCallback": function( oSettings ) {
                    $('#'+infotableid1+'_filter input').unbind();
                    $('#'+infotableid1+'_filter input').bind('keyup', function(e) {
                        if(e.keyCode == 13) {
                            carijenis1= "1";
                            calltriggercari1();
                        }
                    });

                    reloadglobalklikcheck();
                    // $(this).find('thead input[type=checkbox]').removeAttr('checked');
                }
                , "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    // console.log(aData);
                    /*var valueStyle= loopIndex= "";
                    valueStyle= nRow % 2;
                    loopIndex= 6;
                    
                    if( aData[7] == '1')
                    {
                        $($(nRow).children()).attr('class', 'hukumanstyle');
                    }
                    else if( aData[7] == '2')
                    {
                        $($(nRow).children()).attr('class', 'hukumanpernahstyle');
                    }*/
                    
                    // $($(nRow).children()).attr('class', 'warnatandamerah');
                }

            });

            $('#'+valtableid+' tbody').on('click', 'tr.dtrg-start', function() {
                var name = $(this).data('name');
                collapsedGroups[name] = !collapsedGroups[name];
                table.draw(false);
            });
        }
        else
        {
            // console.log(infocolumns);
            table= datanewtable1.DataTable({
                responsive: responsiveinfo
                // , searchDelay: 500
                ,"search": {
                    "caseInsensitive": true // Pastikan pencarian tidak membedakan huruf besar/kecil
                }
                , processing: true
                , serverSide: true
                , "scrollY": infoscrolly+"vh"
                , "scrollX": infoscrollx
                , pageLength: datainfopage
                , order: setchangeorder1
                , columnDefs: [
                    // { className: 'never', targets: infotargets },
                    { searchable: false, targets: 0 },
                    // { className: 'dt-center', targets: [ 0 ] },
                ]
                , ajax: 
                {
                    url: valjsonurl
                    , type: 'GET'
                    , "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')}
                    , data: {columnsDef: infocolumnsdef},
                }
                , columns: infocolumns
                , "fnDrawCallback": function( oSettings ) {
                    $('#'+infotableid1+'_filter input').unbind();
                    $('#'+infotableid1+'_filter input').bind('keyup', function(e) {
                        if(e.keyCode == 13) {
                            carijenis1= "1";
                            calltriggercari1();
                        }
                    });

                    reloadglobalklikcheck();
                }
                , "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    var valueStyle= loopIndex= maxLoop= "";
                    maxLoop= 11;
                    valueStyle= nRow % 2;
                    loopIndex= 6;

                    color= bold= "";
                    if(typeof infobold1 == "undefined"){}
                    else
                    {
                        vbold= aData[valarrdata[infobold1]["field"].toLowerCase()];
                        bold= "bold";
                        if(vbold == "1")
                        {
                            bold= "";
                        }
                    }

                    if(typeof infocolor == "undefined"){}
                    else
                    {
                        vcolor= aData[valarrdata[infocolor]["field"].toLowerCase()];
                        if( vcolor == 'Rahasia')
                        {
                            color= "fdd6d6";
                        }
                        else if( vcolor == 'Sangat Segera')
                        {
                            color= "ffeeba";
                        }
                        else if( vcolor == 'Segera')
                        {
                            color= "b4ebff";
                        }
                    }

                    if(typeof infobold1 !== "undefined" || typeof infocolor == "undefined")
                    {
                        $($(nRow).children()).attr('style', 'font-weight:'+bold+'; background-color:#'+color);
                    }
                    
                    if(dataTablewarna != ""){
                        if( tempTanggalTmt == aData[dataTablewarna])
                        {

                            $($(nRow).children()).attr('class', 'alertstyle');
                        }
                    }

                    if(aktifwarna != "")
                    {
                        if(valueStyle == "1") 
                        {
                           $($(nRow).children()).attr('class', 'oddwarna');
                        }
                        else
                        {
                            $($(nRow).children()).attr('class', 'evenWarna');
                        }


                        if( aData["STATUS_KGB"] == '1')
                        {
                            $($(nRow).children()).attr('class', 'usulanWarna');
                        }
                        else if( aData["STATUS_KGB"] == '2')
                        {
                            $($(nRow).children()).attr('class', 'prosesWarna');
                        }
                        else if( aData["STATUS_KGB"] == '3')
                        {
                            $($(nRow).children()).attr('class', 'selesaiWarna');
                        }
                        else if( aData["STATUS_KGB"] == '4')
                        {
                            $($(nRow).children()).attr('class', 'tidakWarna');
                        }

                        if( aData["STATUS"] == '1')
                        {
                            $($(nRow).children()).attr('class', 'prosesWarna');
                        }
                        else if( aData["STATUS"] == '2')
                        {
                            $($(nRow).children()).attr('class', 'tolakWarna');
                        }
                        else if( aData["STATUS"] == '3')
                        {
                            $($(nRow).children()).attr('class', 'tidakWarna');
                        }
                        else if( aData["STATUS"] == '4')
                        {
                            $($(nRow).children()).attr('class', 'selesaiWarna');
                        }
                    }
                }

            });
        }
    };

    return {
        init: function(valtableid, valjsonurl, valarrdata, valgroup) {
            if(typeof valgroup==='undefined' || valgroup===null || valgroup == "") 
            {
                valgroup= "";
            }

            initdynamistable(valtableid, valjsonurl, valarrdata, valgroup);
        },
    };

}();

var ajaxserverselectsingle2 = function() {
    var cekreturn = function(checkvaldata) {
        valreturn= true;
        if(checkvaldata == "1")
            valreturn= false;

        return valreturn;
    };
    var initdynamistable = function(valtableid, valjsonurl, valarrdata, valgroup) {
        infocolumnsdef= [];
        infocolumns= [];
        infotargets= [];
        valarrdata.forEach(function (item, index) {

            if(item["field"]=='DT_RowIndex')
            {
                infofield= item["field"];
            }
            else
            {
                infofield= item["field"].toLowerCase();
            }

            //searching jika menggunakan query builder

            if(item["alias"])
            {
                infoname= item["alias"].toLowerCase();
            }
            else
            {
                infoname= '';
            }

            infodisplay= item["display"];
            infowidth= item["width"];

            infocolumnsdef.push(infofield);

            setdisplay= true;
            if(infodisplay == "1")
            {
                infotargets.push(index);
                setdisplay= false;
            }

            var infodetil= {};
            infodetil.data= infofield;
            infodetil.visible= setdisplay;
            infodetil.name= infoname;

            if(infowidth !== "")
            {
                infodetil.width= infowidth;
            }
           
            infocolumns.push(infodetil);
            // console.log(infocolumns);
        });
        infogroupfield= valarrdata[0]["field"];
        // console.log(valarrdata[0]["field"]);
        // console.log(infocolumns);

        responsiveinfo=true;

        if(typeof datainfopage == "undefined")
        {
            datainfopage= 10;
        }
        // console.log(infopage);

        if(typeof dataTablewarna == "undefined")
        {
            dataTablewarna= "";
        }

        if(typeof tempTanggalTmt == "undefined")
        {
            tempTanggalTmt= "";
        }

        if(typeof aktifwarna == "undefined")
        {
            aktifwarna= "";
        }

        if(typeof datainfoscrollx == "undefined")
        {
            infoscrollx= cekreturn("1");
        }
        else
        {
            infoscrollx= cekreturn(datainfoscrollx);
            responsiveinfo=false;
        }

        if(typeof infoscrolly == "undefined")
        {
            infoscrolly= "";
        }

        // infoscrolly= cekreturn(datainfoscrolly);
        // console.log(infoscrollx);

        setchangeorder2= [];
        var valorderdefault= valarrdata.length - 2;
        if(typeof datachangeorder2 == "undefined")
        {
            setchangeorder2= [valorderdefault, "asc"];
        }
        else
        {
            if(Array.isArray(datachangeorder2) && datachangeorder2.length)
            {
                setchangeorder2= [];
                datachangeorder2.forEach(function (item, index) {
                    // console.log(item);
                    // console.log(index);
                    setchangeorder2.push(item);
                });
            }
            // setchangeorder= [[4, "desc"], [5, "desc"]];
        }

        var table; var groupColumn = valorderdefault;
        var collapsedGroups = {};
        datanewtable2= $('#'+valtableid);


        if(valgroup == "1")
        {
            table= datanewtable2.DataTable({
                responsive: true
                // , searchDelay: 500
                ,"search": {
                    "caseInsensitive": true // Pastikan pencarian tidak membedakan huruf besar/kecil
                }
                , processing: true
                , serverSide: true
                , rowGroup: {
                    dataSrc: infogroupfield,
                    startRender: function ( rows, group ) {
                        var collapsed = !!collapsedGroups[group];
                        rows.nodes().each(function (r) {
                            r.style.display = collapsed ? 'none' : '';
                        });
         
                        return $('<tr/>')
                            .append('<td colspan="'+valarrdata.length+'">' + group + '</td>')
                            // .append('<td colspan="'+valarrdata.length+'">' + group + ' (' + rows.count() + ')</td>')
                            .attr('data-name', group)
                            .toggleClass('collapsed', collapsed);
                      },
                }
                , order: setchangeorder2
                , columnDefs: [
                    // { className: 'never', targets: infotargets },
                    // { className: 'dt-center', targets: [ 0 ] },
                ]

                , ajax: 
                {
                    url: valjsonurl
                    , type: 'GET'
                    , "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')}
                    , data: {columnsDef: infocolumnsdef},
                }
                , columns: infocolumns
                , "fnDrawCallback": function( oSettings ) {
                    $('#'+infotableid2+'_filter input').unbind();
                    $('#'+infotableid2+'_filter input').bind('keyup', function(e) {
                        if(e.keyCode == 13) {
                            carijenis2= "1";
                            calltriggercari2();
                        }
                    });

                    reloadglobalklikcheck();
                    // $(this).find('thead input[type=checkbox]').removeAttr('checked');
                }
                , "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    // console.log(aData);
                    /*var valueStyle= loopIndex= "";
                    valueStyle= nRow % 2;
                    loopIndex= 6;
                    
                    if( aData[7] == '1')
                    {
                        $($(nRow).children()).attr('class', 'hukumanstyle');
                    }
                    else if( aData[7] == '2')
                    {
                        $($(nRow).children()).attr('class', 'hukumanpernahstyle');
                    }*/
                    
                    // $($(nRow).children()).attr('class', 'warnatandamerah');
                }

            });

            $('#'+valtableid+' tbody').on('click', 'tr.dtrg-start', function() {
                var name = $(this).data('name');
                collapsedGroups[name] = !collapsedGroups[name];
                table.draw(false);
            });
        }
        else
        {
            // console.log(infocolumns);
            table= datanewtable2.DataTable({
                responsive: responsiveinfo
                // , searchDelay: 500
                ,"search": {
                    "caseInsensitive": true // Pastikan pencarian tidak membedakan huruf besar/kecil
                }
                , processing: true
                , serverSide: true
                , "scrollY": infoscrolly+"vh"
                , "scrollX": infoscrollx
                , pageLength: datainfopage
                , order: setchangeorder2
                , columnDefs: [
                    // { className: 'never', targets: infotargets },
                    { searchable: false, targets: 0 },
                    // { className: 'dt-center', targets: [ 0 ] },
                ]
                , ajax: 
                {
                    url: valjsonurl
                    , type: 'GET'
                    , "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')}
                    , data: {columnsDef: infocolumnsdef},
                }
                , columns: infocolumns
                , "fnDrawCallback": function( oSettings ) {
                    $('#'+infotableid2+'_filter input').unbind();
                    $('#'+infotableid2+'_filter input').bind('keyup', function(e) {
                        if(e.keyCode == 13) {
                            carijenis2= "1";
                            calltriggercari2();
                        }
                    });

                    reloadglobalklikcheck();
                }
                , "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    var valueStyle= loopIndex= maxLoop= "";
                    maxLoop= 11;
                    valueStyle= nRow % 2;
                    loopIndex= 6;

                    color= bold= "";
                    if(typeof infobold2 == "undefined"){}
                    else
                    {
                        vbold= aData[valarrdata[infobold2]["field"].toLowerCase()];
                        bold= "bold";
                        if(vbold == "1")
                        {
                            bold= "";
                        }
                    }

                    if(typeof infocolor == "undefined"){}
                    else
                    {
                        vcolor= aData[valarrdata[infocolor]["field"].toLowerCase()];
                        if( vcolor == 'Rahasia')
                        {
                            color= "fdd6d6";
                        }
                        else if( vcolor == 'Sangat Segera')
                        {
                            color= "ffeeba";
                        }
                        else if( vcolor == 'Segera')
                        {
                            color= "b4ebff";
                        }
                    }

                    if(typeof infobold2 !== "undefined" || typeof infocolor == "undefined")
                    {
                        $($(nRow).children()).attr('style', 'font-weight:'+bold+'; background-color:#'+color);
                    }
                    
                    if(dataTablewarna != ""){
                        if( tempTanggalTmt == aData[dataTablewarna])
                        {

                            $($(nRow).children()).attr('class', 'alertstyle');
                        }
                    }

                    if(aktifwarna != "")
                    {
                        if(valueStyle == "1") 
                        {
                           $($(nRow).children()).attr('class', 'oddwarna');
                        }
                        else
                        {
                            $($(nRow).children()).attr('class', 'evenWarna');
                        }


                        if( aData["STATUS_KGB"] == '1')
                        {
                            $($(nRow).children()).attr('class', 'usulanWarna');
                        }
                        else if( aData["STATUS_KGB"] == '2')
                        {
                            $($(nRow).children()).attr('class', 'prosesWarna');
                        }
                        else if( aData["STATUS_KGB"] == '3')
                        {
                            $($(nRow).children()).attr('class', 'selesaiWarna');
                        }
                        else if( aData["STATUS_KGB"] == '4')
                        {
                            $($(nRow).children()).attr('class', 'tidakWarna');
                        }

                        if( aData["STATUS"] == '1')
                        {
                            $($(nRow).children()).attr('class', 'prosesWarna');
                        }
                        else if( aData["STATUS"] == '2')
                        {
                            $($(nRow).children()).attr('class', 'tolakWarna');
                        }
                        else if( aData["STATUS"] == '3')
                        {
                            $($(nRow).children()).attr('class', 'tidakWarna');
                        }
                        else if( aData["STATUS"] == '4')
                        {
                            $($(nRow).children()).attr('class', 'selesaiWarna');
                        }
                    }
                }

            });
        }
    };

    return {
        init: function(valtableid, valjsonurl, valarrdata, valgroup) {
            if(typeof valgroup==='undefined' || valgroup===null || valgroup == "") 
            {
                valgroup= "";
            }

            initdynamistable(valtableid, valjsonurl, valarrdata, valgroup);
        },
    };

}();

function openreference()
{
    reqCheckId= "";
    $('input[id^="reqSmRefMultiId"]').each(function(){
        var id= $(this).attr('id');
        id= id.replace("reqSmRefMultiId", "");
        // $(this).prop('checked', true);
        // console.log(id);
        if(reqCheckId == "")
            reqCheckId= id;
        else
            reqCheckId= reqCheckId+","+id;
    });
    if(reqCheckId=="")
    {
         top.openAdd('app/popup/referensi/KOTAK_MASUK');
    }
    else
    {
        top.openAdd('app/popup/referensi/KOTAK_MASUK/'+reqCheckId);
    }
    
}

function setreference(reqPilihId)
{
    $.ajax({
        url: "app/popup/inforeference/"+reqPilihId,
        "headers": {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
        method: 'GET',
        success: function (response) {
            response= JSON.parse(response);

            infodetilparaf= "<ol class='list-unstyled'>";
            $.each(response, function( key, value) {
                infodetilparaf+= "<li><i class='fa fa-times-circle' onclick='$(this).parent().remove();'></i><input type='hidden' name='reqSmRefMultiId[]' id='reqSmRefMultiId"+value.id+"' value='"+value.id+"' /> "+value.nomor+"</li>";
            });
            infodetilparaf+= "</ol>";

            $("#infodetilreference").empty();
            $("#infodetilreference").html(infodetilparaf);
        },
        error: function (response) {
            // geni.unblock('body');
            // swal('', response.responseJSON.message, 'error');
        },
        complete: function () {
        }
    });

    if (typeof top.setreference === 'function')
    {
        top.closePopup();
    }
}

var infoglobalarrid= [];
function reloadglobalklikcheck()
{
    if(typeof infoglobalarrid == "undefined")
    {
        return false;
    }
    
    reqinfoglobalid= String($("#reqGlobalValidasiCheck").val());
    // console.log(reqinfoglobalid);
    arrinfoglobalid= reqinfoglobalid.split(',');

    var i= "";
    if(reqinfoglobalid == ""){}
    else
    {
        infoglobalarrid= arrinfoglobalid;

        for(var i=0; i<infoglobalarrid.length; i++) 
        {
            $("#reqPilihCheck"+infoglobalarrid[i]).prop('checked', true);
            // console.log("#reqPilihCheck"+infoglobalarrid[i]);
        }
    }
}

function setglobalklikcheck()
{
    if(typeof infoglobalarrid == "undefined")
    {
        return false;
    }

    reqinfoglobalid= String($("#reqGlobalValidasiCheck").val());
    // console.log(reqinfoglobalid);
    arrinfoglobalid= reqinfoglobalid.split(',');

    var i= "";
    if(reqinfoglobalid == ""){}
    else
    {
        infoglobalarrid= arrinfoglobalid;
        i= infoglobalarrid.length - 1;
        i= infoglobalarrid.length;
    }

    reqPilihCheck= reqpilihcheckval= reqNominalBantuan= reqNominalBantuanVal= reqCatatan= reqCatatanVal= "";
    $('input[id^="reqPilihCheck"]:checkbox:checked').each(function(i){
        reqPilihCheck= $(this).val();
        var id= $(this).attr('id');
        id= id.replace("reqPilihCheck", "");

        if(reqpilihcheckval == "")
        {
            reqpilihcheckval= reqPilihCheck;
            // reqNominalBantuanVal= reqNominalBantuan;
            // reqCatatanVal= reqCatatan;
        }
        else
        {
            reqpilihcheckval= reqpilihcheckval+","+reqPilihCheck;
            // reqNominalBantuanVal= reqNominalBantuanVal+","+reqNominalBantuan;
            // reqCatatanVal= reqCatatanVal+"||"+reqCatatan;
        }

        var elementRow= infoglobalarrid.indexOf(reqPilihCheck);
        if(elementRow == -1)
        {
            i= infoglobalarrid.length;

            infoglobalarrid[i]= reqPilihCheck;
        }

    });

    $('input[id^="reqPilihCheck"]:checkbox:not(:checked)').each(function(i){
        reqPilihCheck= $(this).val();
        var id= $(this).attr('id');
        id= id.replace("reqPilihCheck", "");

        var elementRow= infoglobalarrid.indexOf(reqPilihCheck);
        if(parseInt(elementRow) >= 0)
        {
            infoglobalarrid.splice(elementRow, 1);
        }
    });

    reqPilihCheck= reqpilihcheckval= reqNominalBantuan= reqNominalBantuanVal= reqCatatan= reqCatatanVal= "";
    reqTotalNominal= reqTotalOrang= 0;

    for(var i=0; i<infoglobalarrid.length; i++) 
    {
        if(reqpilihcheckval == "")
        {
            reqpilihcheckval= infoglobalarrid[i];
        }
        else
        {
            reqpilihcheckval= reqpilihcheckval+","+infoglobalarrid[i];
        }
    }
    // console.log(reqpilihcheckval);

    $("#reqGlobalValidasiCheck").val(reqpilihcheckval);
    // $("#reqValidasiForm").val(reqPilihCheckForm);
}
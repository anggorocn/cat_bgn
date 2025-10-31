
var froaladinamis = function() {
    var initdinamisfroala = function(valtextid,height) {

        // console.log(height);
        if(height=="" || height==undefined )
        {
            height=200;
        }

        // event keyup
        $(valtextid).on('froalaEditor.keyup', function (e, editor, keyupEvent) {
            setinfovalidasi();
        });

        // event like ready
        $(valtextid).on('froalaEditor.html.set', function (e, editor) {
            setinfovalidasi();
        });

        // event paste after
        $(valtextid).on('froalaEditor.paste.after', function (e, editor) {
            setinfovalidasi();
        });


        $(function(){
            $(valtextid).froalaEditor({
                heightMin: height,
                
                // key: "cC10A7C6B5B3C2C-8C2H2C4D4B6B2D2C4B1D1qkd1vwB-11pqD1J-7yA-16vtE-11otC-7yespzF4lb==",
                // key: "MA3A1A1G2H5A3nA16B10C7C6F2D4H4I2H3C8aD-17pfgki1aC8oilfdnC-7doiucf1jB1I-8r==",
                // key: "qB1G1C1C1A1A2E7mD6F5F4E4E1B9D6C3C4A4g1Rd1Rb1MKF1AKUBWBOR==",
                key: "TB16A11C8E7E5C3E3fG3A7A6C6A3B3C2G3D2J2yIBEVFBOHC1d2UNYVM==",
                
                imageUploadParam: 'image_param',
                
                // Set the image upload URL.
                imageUploadURL: '<?=base_url()?>upload',
                
                // Additional upload params.
                imageUploadParams: {id: 'my_editor'},
                
                // Set request type.
                imageUploadMethod: 'POST',
                
                // Set max image size to 5MB.
                imageMaxSize: 5 * 1024 * 1024,
                
                // Allow to upload PNG and JPG.
                imageAllowedTypes: ['jpeg', 'jpg', 'png'],
                
                events: {
                    'image.beforeUpload': function (images) {
                    console.log(images)
                    // Return false if you want to stop the image upload.
                    },
                    'image.uploaded': function (response) {
                    console.log(response)
                    // Image was uploaded to the server.
                    },
                    'image.inserted': function ($img, response) {
                    console.log($img, response)
                    // Image was inserted in the editor.
                    },
                    'image.replaced': function ($img, response) {
                    console.log($img, response)
                    // Image was replaced in the editor.
                    },
                    'image.error': function (error, response) {
                    console.log(error, response)
                    // Bad link.
                    // if (error.code == 1) { ... }
                    
                    // // No link in upload response.
                    // else if (error.code == 2) { ... }
                    
                    // // Error during image upload.
                    // else if (error.code == 3) { ... }
                    
                    // // Parsing response failed.
                    // else if (error.code == 4) { ... }
                    
                    // // Image too text-large.
                    // else if (error.code == 5) { ... }
                    
                    // // Invalid image type.
                    // else if (error.code == 6) { ... }
                    
                    // // Image can be uploaded only to same domain in IE 8 and IE 9.
                    // else if (error.code == 7) { ... }
                    
                    // Response contains the original server response to the request if available.
                    }
                    // ,
                    // 'keyup': function (keyupEvent) {
                    // // Do something here.
                    // // this is the editor instance.
                    // console.log(keyupEvent);
                    //     setinfovalidasi();
                    // }
                },
                tableCellStyles: {
                    borderAll: "Border All",
                    borderTop: "Border Top",
                    borderBottom: "Border Bottom",
                    borderLeft: "Border Left",
                    borderRight: "Border Right",
                }
              
            });

            if(typeof froaladisabled == "undefined") froaladisabled= "";
            // console.log(froaladisabled);

            if(froaladisabled !== "")
            {
                $(valtextid).froalaEditor('edit.off');
            }
        });
       
    };

    return {
        init: function(valtextid,height) {
            initdinamisfroala(valtextid,height);
        },
    };

}();
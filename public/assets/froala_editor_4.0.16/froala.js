
var froaladinamis = function() {
    var initdinamisfroala = function(valtextid,height) {
        // console.log(height);
        if(height=="" || height==undefined )
        {
            height=200;
        }
        new FroalaEditor(valtextid, {
        key: "qc1H2pF1C3A2B6D7B5D5hBi1a2d2Za1IXBh1f1THTBPLIIWBORpF1F1E1H4F1C11C7C2B5G5==",
            height: height,
            events: {
                'keyup': function (keyupEvent) {
                      // Do something here.
                      // this is the editor instance.
                      setinfovalidasi();
                  },
                  'html.set': function () {
                      // this is the editor instance.
                      setinfovalidasi();
                  },
                  'paste.after': function () {
                      // Do something here.
                      // this is the editor instance.
                      setinfovalidasi();
                  },
             }
        });

        const editorInstance = new FroalaEditor(valtextid, {
            // key: "qc1H2pF1C3A2B6D7B5D5hBi1a2d2Za1IXBh1f1THTBPLIIWBORpF1F1E1H4F1C11C7C2B5G5==",

            imageUploadParam: 'image_param',

            // Set the image upload URL.
            imageUploadURL: '/uploads',

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
                }
            },
            tableCellStyles: {
                borderAll: "Border All",
                borderTop: "Border Top",
                borderBottom: "Border Bottom",
                borderLeft: "Border Left",
                borderRight: "Border Right",
            },

            enter: FroalaEditor.ENTER_P,
            placeholderText: null,
            events: {
                initialized: function () {
                    const editor = this
                    this.el.closest('form').addEventListener('submit', function (e) {
                        console.log(editor.$oel.val())
                        e.preventDefault()
                    })
                }
            }
        })
       
    };

    return {
        init: function(valtextid,height) {
            initdinamisfroala(valtextid,height);
        },
    };

}();
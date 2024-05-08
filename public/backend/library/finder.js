(function ($) {
    "use strict";
    var HT = {};

    HT.setUpCkEditor = () => {
        if($('.ck-editor')){
            $('.ck-editor').each(function(){
                let editor = $(this)
                let elementId = editor.attr('id')
                let elementHeight = editor.attr('data-height')
                HT.ckeditor4(elementId, elementHeight)
            })
        }
    }
    HT.multipleUploadImageCkeditor = () => {
        $(document).on('click','.multipleUploadImageCkeditor',function(e){
            let object = $(this)
            let target = object.attr('data-target')
            HT.browseServeCkeditor(object,"Images",target)
            e.preventDefault()
        });
    }

    HT.ckeditor4 = (elementId, elementHeight) => {
        if(typeof(elementHeight) == 'undefined'){
            elementHeight = 300;
        }
        CKEDITOR.replace( elementId, {
            language: 'vi', // Đặt ngôn ngữ là tiếng Việt
            height: elementHeight,
            removeButtons: '',
            entities: true,
            allowedContent: true,
            toolbarGroups: [
                { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker','undo' ] },
                { name: 'links' },
                { name: 'insert' },
                { name: 'forms' },
                { name: 'tools' },
                { name: 'document',    groups: [ 'mode', 'document', 'doctools'] },
                { name: 'others' },
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup','colors','styles','indent'  ] },
                { name: 'paragraph',   groups: [ 'list', '', 'blocks', 'align', 'bidi' ] },
            ],
            removeButtons: 'Save,NewPage,Pdf,Preview,Print,Find,Replace,CreateDiv,SelectAll,Symbol,Block,Button,Language',
            removePlugins: "exportpdf",

        });
    }

    HT.uploadFileToInput = () =>{
        $('.upload-image').click(function () {
        let input = $(this);
        let type = $(this).attr('data-type');
        HT.setUpCkFinder2(input, type);
    });
    }
    HT.uploadImageAvatar = () =>{
        $('.image-target').click(function () {
            let input = $(this);
            let type = 'Images';
            HT.browseServeAvatar(input, type);
        })
    }
    HT.uploadAlbum = () =>{
        $(document).on('click','.upload-picture',function (e) {
            HT.browseServeAlbum()
            e.preventDefault()
        })
    }
    HT.setUpCkFinder2 = (object,type) => {
        if(typeof(type) == 'underfined'){
            type = 'Images';
        }
        var finder = new CKFinder();
        finder.resourceType = type;
        finder.selectActionFunction = function(fileUrl,data) {
            var fileUrl2 = fileUrl.replace("/public", "");
            object.val(fileUrl2);
        };
        finder.popup();
    };
    HT.browseServeAvatar = (object,type) => {
        if(typeof(type) == 'underfined'){
            type = 'Images';
        }
        var finder = new CKFinder();
        finder.resourceType = type;
        finder.selectActionFunction = function(fileUrl,data) {
            var fileUrl2 = fileUrl.replace("/public", "");
            object.find('img').attr('src', fileUrl2);
            object.siblings('input').val(fileUrl2);
        };
        finder.popup();
    };
    HT.browseServeCkeditor = (object,type,target) => {
        if(typeof(type) == 'underfined'){
            type = 'Images';
        }
        var finder = new CKFinder();
        finder.resourceType = type;
        finder.selectActionFunction = function(fileUrl,data, allFiles) {
            let html = '';
            for (var i = 0; i < allFiles.length; i++) {
                var image = allFiles[i].url
                html += '<div class ="image-content"><figure>'
                html += '<img src="' + image + '" alt="' +image +'" >'
                html += '<figcaption> Nhập vào mô tả cho ảnh </figcation>'
                html += '</figure></div>';
                console.log(html);
            }
            CKEDITOR.instances[target].insertHtml(html)
        };
        finder.popup();
    }
    HT.browseServeAlbum = () => {
        var type = 'Images';
        var finder = new CKFinder();
        finder.resourceType = type;
        finder.selectActionFunction = function(fileUrl,data, allFiles) {
            let html = '';
            for (var i = 0; i < allFiles.length; i++) {
                var image = allFiles[i].url
                html +=  '<li class="ui-state-default">'
                html +=  '<div class="thumb">'
                html +=  '<span class="span image img-scaledown">'
                html +=  '<img src="'+image+'" alt="'+image+'">'
                html +=  '<input type="hidden" name="album[]" value="'+image+'">'
                html +=  '</span>'
                html +=  '<button class="delete-image"><i class="fa fa-trash"></i></button>'
                html +=  '</div>'
                html +=  '</li>'
            }
            $('#sortable').append(html)
            $('.click-to-upload').addClass('hidden')
            $('.upload-list').removeClass('hidden')
        };
        finder.popup();
    };
    HT.deleteImage = () => {
        $(document).on('click', '.delete-image',function(e) {
            var _this = $(this)
            _this.parents('.ui-state-default').remove()
            if($('.ui-state-default').length ==0){
                $('.upload-list').addClass('hidden')
                $('.click-to-upload').removeClass('hidden')
            }
        })

    };
    $(document).ready(function () {
        HT.uploadFileToInput();
        HT.setUpCkEditor();
        HT.uploadImageAvatar();
        HT.multipleUploadImageCkeditor();
        HT.uploadAlbum();
        HT.deleteImage();
    });
})(jQuery);

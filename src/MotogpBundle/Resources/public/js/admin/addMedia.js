$(document).ready(function () {

    Dropzone.autoDiscover = false;

    window.mediaIndex = $('.collection .row').size();

    var newMedia = function (imageUrl) {
        var prototypeText = $('.data-prototype').attr('data-prototype').replace(/__index__/g, window.mediaIndex);

        var pt = $(prototypeText);

        pt.find('.uploadFile').val(imageUrl);

        $('.collection').append(pt);
        window.mediaIndex ++;
    };

    //$('.add').click(newMedia);


    $('.medias-dropzone').each(function () {

        var url = $(this).attr('url');
        var multiple = $(this).attr('multiple') === 'true';
        var maxFiles = parseInt($(this).attr('maxfiles'));

        var inputs = $(this).parent().find('input');


        var testImages = $(this).parent().find('.imgtest');

        var DZ = new Dropzone('#' + $(this).attr('id'), {
            url: url,
            timeout: 75000,
            uploadMultiple : false,
            maxFiles: maxFiles,
            acceptedFiles: 'image/*',
            addRemoveLinks : true,
            dictDefaultMessage : "Arrastra imagenes aquí",
            dictFallbackMessage : "Navegador no soportado",
            dictFallbackText : "",
            dictFileTooBig : "Fichero demasiado grande ({{filesize}}MiB). Tamaño máximo: {{maxFilesize}}MiB.",
            dictInvalidFileType : "Tipo de fichero no permitido.",
            dictResponseError : "Error {{statusCode}} ",
            dictCancelUpload : "Cancelar subida",
            dictCancelUploadConfirmation : "¿Seguro que quieres cancelar?",
            dictRemoveFile : "Eliminar",
            dictMaxFilesExceeded : "No puedes subir mas ficheros",
            previewTemplate: "<div class=\"dz-preview dz-file-preview\">\n  <div class=\"details dz-details\">Detalles</div>\n<div class=\"dz-image\"><img data-dz-thumbnail /></div>\n  <div class=\"dz-details\">\n    <div class=\"dz-size\"><span data-dz-size></span></div>\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n  </div>\n  <div class=\"dz-progress\"><span class=\"dz-upload\" data-dz-uploadprogress></span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n  <div class=\"dz-success-mark\">\n    <svg width=\"54px\" height=\"54px\" viewBox=\"0 0 54 54\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" xmlns:sketch=\"http://www.bohemiancoding.com/sketch/ns\">\n      <title>Check</title>\n      <defs></defs>\n      <g id=\"Page-1\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" sketch:type=\"MSPage\">\n        <path d=\"M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z\" id=\"Oval-2\" stroke-opacity=\"0.198794158\" stroke=\"#747474\" fill-opacity=\"0.816519475\" fill=\"#FFFFFF\" sketch:type=\"MSShapeGroup\"></path>\n      </g>\n    </svg>\n  </div>\n  <div class=\"dz-error-mark\">\n    <svg width=\"54px\" height=\"54px\" viewBox=\"0 0 54 54\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" xmlns:sketch=\"http://www.bohemiancoding.com/sketch/ns\">\n      <title>Error</title>\n      <defs></defs>\n      <g id=\"Page-1\" stroke=\"none\" stroke-width=\"1\" fill=\"none\" fill-rule=\"evenodd\" sketch:type=\"MSPage\">\n        <g id=\"Check-+-Oval-2\" sketch:type=\"MSLayerGroup\" stroke=\"#747474\" stroke-opacity=\"0.198794158\" fill=\"#FFFFFF\" fill-opacity=\"0.816519475\">\n          <path d=\"M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z\" id=\"Oval-2\" sketch:type=\"MSShapeGroup\"></path>\n        </g>\n      </g>\n    </svg>\n  </div>\n</div>",
            init: function() {

                this.on('maxfilesexceeded', function (file) {
                    if (!file.mock)
                        this.removeFile(file);
                });

                this.on('addedfile', function (data, data2) {

                    $(data.previewElement).on('click', function () {
                        $('.collection-row').addClass('hidden');
                        $('.collection-row[index="'+ data.index + '"]').removeClass('hidden');
                        $('.collection-row[index="'+ data.index + '"]').find('img').attr('src', data.dataURL)
                    });

                    if (data.mock === true) {
                        this.files.push(data);
                    }


                });

                this.on('removedfile', function (file, data) {
                    $('.collection-row[index="'+ file.index +'"]').remove();
                }) ;

                this.on('maxfilesreached', function (file) {
                    $(this.element).addClass('dz-max-files-reached');

                });
            },
            success : function (file, data) {
                if (typeof data.files.url != 'undefined')
                {
                    file.index = window.mediaIndex ;
                    newMedia(data.files.url);
                }

            }
        });

        console.error('DZ', DZ);

        var previous = $('.collection .row');

        if ( previous.size() ) {
            var i = 0;

            previous.each(function () {

                var previousValue = $(this).attr('path');

                if (previousValue) {

                    var mock = {'name': 'Foto' + i, size : null, index : i, mock : true};

                    // console.error('index', mock.index);

                    DZ.emit('addedfile', mock);
                    DZ.emit('thumbnail', mock, previousValue);
                    DZ.emit("complete",  mock);

                    //console.error('maxfiles', DZ.options.maxFiles, i);

                    if (DZ.options.maxFiles == i) {

                        DZ.emit('maxfilesreached', mock);
                        DZ.emit('maxfilesexceeded', mock);
                    }
                }

                i++;
            });
        }


    });


});
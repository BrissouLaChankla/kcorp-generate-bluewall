@extends('layouts.app')
@section('content')
    <div class="w-100 h-100 container d-flex flex-column justify-content-around overflow-hidden" id="app">
        <div class="text-center">
            <img style="width:120px" loading="lazy" class=" border-primary mt-4" src="{{ asset('img/logo-detonate.webp') }}"
                alt="Detonate G2">
            <h1 class="text-uppercase text-white my-2"><strong>Detonate <br> Profile Picture</strong></h1>
        </div>
        <div class="row justify-content-center align-items-center my-3">
            <div class="col-sm-6">
                {!! Form::open([
                    'url' => route('post-transparency'),
                    'files' => true,
                    'id' => 'g2',
                    'class' => 'ajax-and-picture',
                ]) !!}

                <div class="drop-zone bg-blur">
                    <span class="drop-zone__prompt">Drag and drop your picture here <br><small>(Will automatically remove
                            background)</small></span>
                    {{ Form::file('image_file', ['id' => 'file-input', 'class' => 'drop-zone__input']) }}
                </div>
                {!! Form::close() !!}
            </div>
            <div class="col-sm-6 mt-3 mt-sm-0 d-flex justify-content-center">
                <div id="background-g2" class="m-0 rounded shadow-sm position-relative"
                    style="background-image:url({{ asset('img/detonate.webp') }})">
                    <div id="ur-pic"></div>
                </div>
            </div>
        </div>
        <img class="logo-white-bottom d-none d-md-block" loading="lazy" class=" border-primary mt-4"
            src="{{ asset('img/logo-white.webp') }}" alt="Logo white G2">
        <div class="text-center">
            <div class="btn btn-primary btn-lg my-3" id="pic-download">
                Download your picture 💣
            </div>
        </div>
    </div>
    <style>
        .bg-blur {
            backdrop-filter: blur(5px);
        }

        body {
            background-image: url("img/background.webp");
            background-position: center;
            background-size: cover;
        }

        h1 {
            font-family: 'Bebas Neue', cursive;
            letter-spacing: 2px;
            font-size: 3rem;
            line-height: 1;
        }

        .drop-zone {
            margin: auto;
            width: 75%;
            padding: 4%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-family: "Quicksand", sans-serif;
            font-weight: 500;
            font-size: 20px;
            cursor: pointer;
            color: #cccccc;

            border: 4px dashed #ee3d23;
            border-radius: 10px;
        }

        @media only screen and (min-width: 576px) {
            .drop-zone {
                height: 250px !important;
                width: 250px !important;
            }

            h1 {
                font-size: 4.5rem;
            }

            #background-g2 {
                height: 250px !important;
                width: 250px !important;
            }
        }

        @media only screen and (min-width: 768px) {
            .drop-zone {
                height: 340px !important;
                width: 340px !important;
            }

            h1 {
                font-size: 5rem;
            }

            #background-g2 {
                height: 340px !important;
                width: 340px !important;
            }
        }

        @media only screen and (min-width: 992px) {
            .drop-zone {
                height: 450px !important;
                width: 450px !important;
            }

            #background-g2 {
                height: 450px !important;
                width: 450px !important;
            }
        }

        @media only screen and (min-width: 1200px) {
            .drop-zone {
                height: 500px !important;
                width: 500px !important;
            }

            #background-g2 {
                height: 500px !important;
                width: 500px !important;
            }
        }


        .drop-zone__prompt {
            color: white !important;
        }

        .drop-zone--over {
            border-style: solid;
        }

        .drop-zone__input {
            display: none;
        }

        .drop-zone__thumb {
            width: 100%;
            height: 100%;
            border-radius: 10px;
            overflow: hidden;
            background-color: #cccccc;
            background-size: cover;
            position: relative;
            background-position: center;
        }

        .drop-zone__thumb::after {
            content: attr(data-label);
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 5px 0;
            color: #ffffff;
            background: rgba(0, 0, 0, 0.75);
            font-size: 14px;
            text-align: center;
        }

        #ur-pic {
            background-position: center;
            background-size: cover;
            height: 100%;
            width: 100%;
        }

        #background-g2 {
            width: 75%;
            margin: auto;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        #pic-download {
            display: none;
        }

        .logo-white-bottom {
            z-index: -1;
            width: 4vw;
            max-width: 110px;
            min-width: 60px;
            position: fixed;
            left: 10px;
            bottom: 10px;
        }
    </style>
@endsection

@section('scripts')
    <script defer>
        $(function() {

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            if (Cookies.get('limit') == 0) {
                Toast.fire({
                    icon: 'error',
                    title: 'You\'ve used up all your credits, come back tomorrow!'
                });

            } else if (Cookies.get('limit')) {
                Toast.fire({
                    icon: 'info',
                    title: "You have " + Cookies.get('limit') + " credits left !"
                });
            } else {
                Cookies.set('limit', 10, {
                    expires: 1
                });
                Toast.fire({
                    icon: 'info',
                    title: "You have " + Cookies.get('limit') + " credits left !"
                });
            }
            var $window = $(window);
            var $pane = $('#pane1');

            function checkWidth() {
                var windowsize = $window.width();
                if (windowsize < 576) {
                    $('.drop-zone').height($(".drop-zone").width());
                    $('#background-g2').height($("#background-g2").width());
                }
            }
            // Execute on load
            checkWidth();
            // Bind event listener
            $(window).resize(checkWidth);
            document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
                const dropZoneElement = inputElement.closest(".drop-zone");
                dropZoneElement.addEventListener("click", (e) => {
                    inputElement.click();
                });
                inputElement.addEventListener("change", (e) => {
                    if (inputElement.files.length) {
                        updateThumbnail(dropZoneElement, inputElement.files[0]);
                        if (Cookies.get('limit') > 0) {
                            submitForm();
                            Cookies.set('limit', Cookies.get('limit') - 1);
                            Toast.fire({
                                icon: 'info',
                                title: "You have " + Cookies.get('limit') +
                                    " credits left !"
                            });
                        } else {
                            Toast.fire({
                                icon: 'danger',
                                title: 'You\'ve used up all your credits, come back tomorrow!'
                            });
                            $('#ur-pic').css('background-image',
                                'url("{{ asset('img/stop.webp') }}")');
                        }
                    }
                });

                dropZoneElement.addEventListener("dragover", (e) => {
                    e.preventDefault();
                    dropZoneElement.classList.add("drop-zone--over");
                });
                ["dragleave", "dragend"].forEach((type) => {
                    dropZoneElement.addEventListener(type, (e) => {
                        dropZoneElement.classList.remove("drop-zone--over");
                    });
                });
                dropZoneElement.addEventListener("drop", (e) => {
                    e.preventDefault();
                    if (e.dataTransfer.files.length) {
                        inputElement.files = e.dataTransfer.files;
                        updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
                        if (Cookies.get('limit') > 0) {
                            submitForm();
                            Cookies.set('limit', Cookies.get('limit') - 1);
                            Toast.fire({
                                icon: 'info',
                                title: "You have " + Cookies.get('limit') +
                                    " credits left !"
                            });
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'You\'ve used up all your credits, come back tomorrow!'
                            });
                            $('#ur-pic').css('background-image',
                                'url("{{ asset('img/stop.webp') }}")');
                        }
                    }
                    dropZoneElement.classList.remove("drop-zone--over");
                });
            });

            /**
             * Updates the thumbnail on a drop zone element.
             *
             * @param {HTMLElement} dropZoneElement
             * @param {File} file
             */
            function updateThumbnail(dropZoneElement, file) {
                let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

                // First time - remove the prompt
                if (dropZoneElement.querySelector(".drop-zone__prompt")) {
                    dropZoneElement.querySelector(".drop-zone__prompt").remove();
                }

                // First time - there is no thumbnail element, so lets create it
                if (!thumbnailElement) {
                    thumbnailElement = document.createElement("div");
                    thumbnailElement.classList.add("drop-zone__thumb");
                    dropZoneElement.appendChild(thumbnailElement);
                }
                thumbnailElement.dataset.label = file.name;
                // Show thumbnail for image files
                if (file.type.startsWith("image/")) {
                    const reader = new FileReader();

                    reader.readAsDataURL(file);
                    reader.onload = () => {
                        thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
                    };
                } else {
                    thumbnailElement.style.backgroundImage = null;
                }
            }


            function submitForm() {
                var myForm = $("#g2")[0];
                var url = $("#g2").attr('action');
                jQuery.ajax({
                    type: "POST",
                    url: url,
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: new FormData(myForm),
                    xhr: function() {
                        var xhr = new XMLHttpRequest();
                        xhr.responseType = 'blob'
                        return xhr;
                    },
                    success: function(data) {
                        var img = document.getElementById('img');
                        var url = window.URL || window.webkitURL;
                        $('#ur-pic').css('background-image', 'url(' + url.createObjectURL(data) + ')');
                        $("html, body").animate({
                            scrollTop: $(document).height()
                        }, 1000);
                        $('#pic-download').fadeIn().css("display", "inline-block");
                    },
                    error: function() {}
                });
            }

            $("form.ajax-and-picture").submit(function(e) {
                e.preventDefault();
                var myForm = $(this)[0];
                var url = $(this).attr('action');
                jQuery.ajax({
                    type: "POST",
                    url: url,
                    cache: false,
                    processData: false,
                    contentType: false,
                    data: new FormData(myForm),
                    xhr: function() {
                        var xhr = new XMLHttpRequest();
                        xhr.responseType = 'blob'
                        return xhr;
                    },
                    success: function(data) {
                        var img = document.getElementById('img');
                        var url = window.URL || window.webkitURL;
                        $('#ur-pic').css('background-image', 'url(' + url.createObjectURL(
                            data) + ')')
                    },
                    error: function() {}
                });
            });



            $('#pic-download').on('click', function() {
                let element = document.getElementById('background-g2')
                let scale = 2
                if ($(window).width() > 768) {
                    scale = 1.5
                }
                domtoimage.toJpeg(element, {
                        width: element.offsetWidth * scale,
                        height: element.offsetHeight * scale,
                        style: {
                            transform: 'scale(' + scale + ')',
                            transformOrigin: 'top left',
                            width: element.offsetWidth + "px",
                            height: element.offsetHeight + "px"
                        }
                    })
                    .then(function(dataUrl) {
                        var link = document.createElement('a');
                        link.download = 'G2-DETONATE-PP.jpeg';
                        link.href = dataUrl;
                        link.click();
                    });
            });
        });

        let msg = "%c Dev with ❤️ by Brissou"; 
        let msg2 = "%c https://brice-eliasse.com"; 
        
        let styles= [ 
    'font-size: 12px', 
    'font-family: monospace', 
    'background: black', 
    'display: inline-block', 
    'color: #ee3d23', 
    'padding: 8px 19px', 
    'border: 1px dashed white;' 
].join(';') 
let styles2= [ 
    'font-size: 10.85px', 
    'font-family: monospace', 
    'background: black', 
    'display: inline-block', 
    'color: #ee3d23', 
    'padding: 8px 19px', 
    'border: 1px dashed white;' 
].join(';') 
console.log(msg, styles);
console.log(msg2, styles2);
    </script>
@endsection

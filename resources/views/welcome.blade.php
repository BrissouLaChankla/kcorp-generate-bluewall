@extends("layouts.app")
@section('content')
<div class="w-100 h-100 container d-flex flex-column justify-content-around overflow-hidden" id="app">
    <div class="text-center" >
        <img style="width:120px" class="border-primary border-bottom mt-4" src="{{asset('img/supporter.webp')}}" alt="Supporter KCorp">
        <h1 class="text-uppercase text-white my-2"><strong>KCorp <br> Blue wall</strong></h1>
    </div>
    <div class="row justify-content-center align-items-center my-3" >
        <div class="col-sm-6">
            {!! Form::open(['url' => 'https://sdk.photoroom.com/v1/segment', "id" =>"kcorp",'class' => ' ajax-and-picture', 'files' => true]) !!}
                <div class="drop-zone">
                    <span class="drop-zone__prompt">Drag and drop your picture here <br><small>(Will automatically remove background)</small></span>
                    {{Form::file('image_file', ['id' => "file-input", "class" => "drop-zone__input"])}}
                </div>
            {!! Form::close() !!}
        </div>
        <div class="col-sm-6 mt-3 mt-sm-0">
          <div class="background-kc rounded shadow-sm position-relative" style="background-image:url({{asset('img/wall.webp')}})">
                <div id="ur-pic"></div>
            </div>
        </div>
    </div> 
        <div class="text-center">
            <div class="btn btn-primary btn-lg my-3"  id="pic-download">
              Télécharger ta nouvelle PP
            </div>
        </div>
</div>
<style>
h1 {
  font-family: 'Bebas Neue', cursive;
  letter-spacing: 2px;
  font-size:3rem;
  line-height: 1;
}
    
.drop-zone {
    margin:auto;
    width:75%;
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
    border: 4px dashed #00d8ec;
    border-radius: 10px;
}

@media only screen and (min-width: 576px) {
  .drop-zone {
    height: 250px!important;
    width: 250px!important;
  }

  h1 {
    font-size:4.5rem;
  }

  .background-kc {
    height: 250px!important;
    width: 250px!important;
  }
}

@media only screen and (min-width: 768px) {
  .drop-zone {
    height: 340px!important;
    width: 340px!important;
  }
  h1 {
    font-size:5rem;
  }
  .background-kc {
    height: 340px!important;
    width: 340px!important;
  }
}

@media only screen and (min-width: 992px) {
  .drop-zone {
    height: 450px!important;
    width: 450px!important;
  }

  .background-kc {
    height: 450px!important;
    width: 450px!important;
  }
}

@media only screen and (min-width: 1200px) {
  .drop-zone {
    height: 500px!important;
    width: 500px!important;
  }

  .background-kc {
    height: 500px!important;
    width: 500px!important;
  }
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
        width:100%;
    }

    .background-kc {
      width:75%;
      margin:auto;
        background-size:cover;
        background-position: center;
        position: relative;
    }

    #pic-download {
      display:none;
    }
</style>
@endsection
      
@section("scripts")
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script>
    $(function() {

      const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 5000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})
      if(Cookies.get('limit') == 0) {
        Toast.fire({
          icon: 'error',
          title: 'You\'ve used up all your credits, come back tomorrow!'
        });
      } else if(Cookies.get('limit')) {
        Toast.fire({
            icon: 'info',
            title: "You have "+Cookies.get('limit')+" credits left !"
          });
      } else {
        Cookies.set('limit', 3, { expires: 1 });
        Toast.fire({
            icon: 'info',
            title: "You have "+Cookies.get('limit')+" credits left !"
          });
      }
    var $window = $(window);
    var $pane = $('#pane1');
    function checkWidth() {
        var windowsize = $window.width();
        if (windowsize < 576) {
              $('.drop-zone').height($(".drop-zone").width());
              $('.background-kc').height($(".background-kc").width());
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
      if(Cookies.get('limit') > 0) {
        submitForm();
        Cookies.set('limit', Cookies.get('limit')-1);
        Toast.fire({
          icon: 'info',
          title: "You have "+Cookies.get('limit')+" credits left !"
        });
      } else {
        Toast.fire({
          icon: 'danger',
          title: 'You\'ve used up all your credits, come back tomorrow!'
        });
        $('#ur-pic').css('background-image','url("{{asset('img/stop.webp')}}")');
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
      if(Cookies.get('limit') > 0) {
        submitForm();
        Cookies.set('limit', Cookies.get('limit')-1);
        Toast.fire({
            icon: 'info',
            title: "You have "+Cookies.get('limit')+" credits left !"
          });
      } else {
        Toast.fire({
          icon: 'error',
          title: 'You\'ve used up all your credits, come back tomorrow!'
        });
        $('#ur-pic').css('background-image','url("{{asset('img/stop.webp')}}")');
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
            var myForm = $("#kcorp")[0];
            var url = $("#kcorp").attr('action');
            jQuery.ajax({
                type: "POST",
                url:url,
                cache:false,
                processData: false,
                contentType: false,
                headers: { 'x-api-key': '147d07b083abc001c55bbc9ba5c3138c79711358' },
                data: new FormData(myForm),
                xhr:function(){
                    var xhr = new XMLHttpRequest();
                    xhr.responseType= 'blob'
                    return xhr;
                },
                success: function(data){
                    var img = document.getElementById('img');
                    var url = window.URL || window.webkitURL;
                    $('#ur-pic').css('background-image','url('+url.createObjectURL(data)+')');
                    $("html, body").animate({ scrollTop: $(document).height() }, 1000);
                    $('#pic-download').fadeIn().css("display","inline-block");
                    $('.frais').fadeIn();
                },
                error:function(){
                }
            });
    }
        $("form.ajax-and-picture").submit(function(e) {
                e.preventDefault();
                var myForm = $(this)[0];
                var url = $(this).attr('action');
                jQuery.ajax({
                    type: "POST",
                    url:url,
                    cache:false,
                    processData: false,
                    contentType: false,
                    headers: { 'x-api-key': '147d07b083abc001c55bbc9ba5c3138c79711358' },
                    data: new FormData(myForm),
                    xhr:function(){
                        var xhr = new XMLHttpRequest();
                        xhr.responseType= 'blob'
                        return xhr;
                    },
                    success: function(data){
                        var img = document.getElementById('img');
                        var url = window.URL || window.webkitURL;
                        $('#ur-pic').css('background-image','url('+url.createObjectURL(data)+')')
                    },
                    error:function(){
                    }
                });
    });
    $('#pic-download').on('click', function() {
        html2canvas($(".background-kc")[0], {scale:2}).then((canvas) => {
            var a = document.createElement('a');
                a.href = canvas.toDataURL("image/jpeg").replace("image/jpeg");
                a.download = 'PP-KC-Twitter.jpg';
                a.click();
        });

    });
});
</script>
@endsection
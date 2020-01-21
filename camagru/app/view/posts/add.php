<?php require APPROOT . '/view/include/header.php'; ?>
<a href="<?php echo URLROOT; ?>/pages/about" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<div class="card bg-light mt-5">
    <div class="card-body camera">
        <form action="<?php echo URLROOT; ?>/posts/add" method="post">
        <h2 class="card-title text-center">Add Photo</h2>
        <video class="card-img-top" id="video" autoplay>Video stream not available.</video>
        <input type="file" name="image" id="photo">
        <button id="snap" class="btn btn-primary float-right">Snap Photo</button>
        </form>
    </div>

    <canvas id="canvas" style="display: none">
    </canvas>
</div>
<script>
    let width = 640;  // We will scale the photo width to this
    let height = 0;   // This will be computed based on the input stream

7    // |streaming| indicates whether or not we're currently streaming
    // video from the camera. Obviously, we start at false.

    let streaming = false;

    // The various HTML elements we need to configure or control. These
    // will be set by the startup() function.

    let video = null;
    let canvas = null;
    let photo = null;

    // function startup() {
    video = document.getElementById('video');
    canvas = document.getElementById('canvas');
    photo = document.getElementById('photo');
    button = document.getElementById('snap');

    // Get access to the camera!
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        // Not adding `{ audio: true }` since we only want video now
        navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
            //video.src = window.URL.createObjectURL(stream);
            video.srcObject = stream;
            video.play();
        }).catch(console.error);
    }

    video.addEventListener('canplay', function () {
        if (!streaming) {
            height = video.videoHeight / (video.videoWidth / width);

            // Firefox currently has a bug where the height can't be read from
            // the video, so we will make assumptions if this happens.

            if (isNaN(height)) {
                height = width / (4 / 3);
            }

            video.setAttribute('width', width);
            video.setAttribute('height', height);
            canvas.setAttribute('width', width);
            canvas.setAttribute('height', height);
            streaming = true;
        }
    });

    document.getElementById("snap").addEventListener('click', function () {
        takepicture();
    });

    function takepicture() {
        const context = canvas.getContext('2d');
        if (width && height) {
            canvas.width = width;
            canvas.height = height;
            context.drawImage(video, 0, 0, width, height);

            const data = canvas.toDataURL('image/png');
            console.log(data);

            // Send image data to form
            // const send = new FormData();
            // send.append('testphoto', data);
            // const xmlhttp=new XMLHttpRequest();
            // xmlhttp.send(send);

            photo.setAttribute('value', data);
            // photo.setAttribute('width', 100);
            // photo.setAttribute('height', 100);
        }
    }


    // // Grab elements, create settings, etc.
    // const video = document.getElementById('video');
    //
    // // Elements for taking the snapshot
    // // var canvas = document.getElementById('canvas');
    // // var context = canvas.getContext('2d');
    // // var video = document.getElementById('video');
    //
    //
    // console.log(navigator.mediaDevices);
    // // Get access to the camera!
    // if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    //     // Not adding `{ audio: true }` since we only want video now
    //     navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
    //         //video.src = window.URL.createObjectURL(stream);
    //         video.srcObject = stream;
    //         video.play();
    //     }).catch(console.error);
    // }
    //
    // // Trigger photo take
    // document.getElementById("snap").addEventListener("click", function() {
    //     let canvas = document.createElement("canvas");
    //     canvas.width = video.getBoundingClientRect().width;
    //     canvas.height = video.getBoundingClientRect().height;
    //
    //     console.log(canvas);
    //
    //     let context = canvas.getContext('2d');
    //     context.drawImage(video, 0, 0, canvas.width, canvas.height, 0, 0, canvas.width, canvas.height);
    //     // context.drawImage(video, 0, 0, canvas.width, canvas.height);
    //     console.log(canvas.toDataURL());
    //
    // });
    //
    // function addElement(newDiv) {
    //     let currentDiv = document.getElementById("corediv");
    //     currentDiv.appendChild(newDiv);
    // }
</script>
<?php require APPROOT . '/view/include/footer.php'; ?>

<?php require APPROOT . '/view/include/header.php'; ?>
<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>

<!--Modal-->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Create Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="image" class="img-fluid" alt="Your photo" src="">
                <input type="text" id="body" class="form-control" value="Your comment">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Take another</button>
                <input id="send" type="submit" value="Save post" class="btn btn-success">
            </div>
        </div>
    </div>
</div>

<!--Webcam-->
<div class="card bg-light mt-5">
    <div class="card-body camera">
        <h2 class="card-title text-center">Snap Photo</h2>
        <video class="card-img-top" id="video" autoplay>Video stream not available.</video>
        <button id="snap" class="btn btn-primary float-right" data-toggle="modal" data-target="#Modal">Snap Photo
        </button>
    </div>
</div>

<script>
    let width = 640;  // Scale the photo width to this
    let height = 0;   // This will be computed based on the input stream

    // indicates whether or not we're currently streaming
    // video from the camera. Obviously, we start at false.

    let streaming = false;

    let video = document.getElementById('video');
    let canvas = document.createElement('canvas');
    let image = document.getElementById('image');

    // Get access to the camera!
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        // Not adding `{ audio: true }` since we only want video now
        navigator.mediaDevices.getUserMedia({video: true}).then(function (stream) {
            //video.src = window.URL.createObjectURL(stream);
            video.srcObject = stream;
            video.play();
        }).catch(console.error);
    }

    video.addEventListener('canplay', function () {
        if (!streaming) {
            height = video.videoHeight / (video.videoWidth / width);

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
        takePicture();
        image.setAttribute('src', canvas.toDataURL());
    });

    document.getElementById('send').addEventListener('click', function () {
        let body = document.getElementById('body');

        // Check if user entered comment
        if (body.value === 'Your comment') {
            alert('Please enter your comment!');
            return;
        }

        // Create form to send
        let form = new FormData;

        canvas.toBlob(function (blob) {
            // Add photo to form
            form.append('photo', blob, 'photo.png');
            // Add body to form
            form.append('body', body.value);
            // console.log(form.get('body'));
            // console.log(form.get('photo'));

            let response = fetch('<?php echo URLROOT; ?>/posts/add', {
                method: 'POST',
                body: form
            }).then(response => response.text())
                // .then(response => console.log(response))
                .then(response => window.location.replace('<?php echo URLROOT; ?>/posts'))

        }, 'image/png');
    });

    function takePicture() {
        const context = canvas.getContext('2d');
        if (width && height) {
            canvas.width = width;
            canvas.height = height;
            context.drawImage(video, 0, 0, width, height);
        }
    }
</script>
<?php require APPROOT . '/view/include/footer.php'; ?>

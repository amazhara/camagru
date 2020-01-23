let width = 640;  // We will scale the photo width to this
let height = 0;   // This will be computed based on the input stream

// indicates whether or not we're currently streaming
// video from the camera. Obviously, we start at false.

let streaming = false;

let video = document.getElementById('video');
let canvas = document.getElementById('canvas');
let photo = document.getElementById('photo');
let button = document.getElementById('snap');
let link = document.getElementById('link');
let push = document.getElementById('push');
let form = document.getElementById('form');

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
    push.value = canvas.toDataURL();
    form.submit();
});

// Fetch (ajax) image to php
// document.getElementById("snap").addEventListener('click', async function () {
//     takePicture();
//     // Create blob instance to send photo
//     let blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/png'));
//
//     // Send photo
//     let response = await fetch('http://localhost:8080/posts/add', {
//         method: 'POST',
//         body: blob
//     });
//
//     // Wait for response from php
//     let result = await response.text();
//
//     // window.location = "http://localhost:8080/posts/add";
//     // Convert blob to png
//     // result = result.slice(0, blob.size, 'image/png');
//
//     console.log(result);
//     // link.href = URL.createObjectURL(result);
//     // console.log(link);
// });

function takePicture() {
    const context = canvas.getContext('2d');
    if (width && height) {
        canvas.width = width;
        canvas.height = height;
        context.drawImage(video, 0, 0, width, height);
    }
}
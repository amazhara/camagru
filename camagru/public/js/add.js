let width = 640;  // Scale the photo width to this
let height = 0;   // This will be computed based on the input stream

// indicates whether or not we're currently streaming
// video from the camera. Obviously, we start at false.

let streaming = false;

let video = document.getElementById('video');
let canvas = document.getElementById('canvas');
let image = document.getElementById('image');
let picture = document.getElementById('pic');
let paste = document.getElementById('paste');
let color = '';


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

document.getElementById('place').addEventListener('click', function () {
    const newImage = document.createElement('img');
    newImage.setAttribute('src', image.src);
    newImage.setAttribute('class', 'rounded float-left mt-2 ml-2');
    newImage.setAttribute('width', '200px');
    newImage.setAttribute('height', '200px');
    newImage.setAttribute('data-toggle', 'modal');
    newImage.setAttribute('data-target', '#Modal');
    newImage.onclick = function () {
        image.src = newImage.src;
    };
    paste.appendChild(newImage);
});

picture.addEventListener('change', function () {
    image.src = URL.createObjectURL(picture.files[0]);
});

document.getElementById("snap").addEventListener('click', function () {
    takePicture();
    image.setAttribute('src', canvas.toDataURL());
});

document.getElementById("sepia").addEventListener('click', function () {
    color = 'sepia(1)';
});
document.getElementById("invert").addEventListener('click', function () {
    color = 'invert(50)';
});
document.getElementById("blur").addEventListener('click', function () {
    color = 'blur(5px)';
});
document.getElementById("strongblur").addEventListener('click', function () {
    color = 'blur(20px)';
});
document.getElementById("default").addEventListener('click', function () {
    color = '';
});

window.setInterval(function() {
    takePicture();
}, 8);

document.getElementById('send').addEventListener('click', function () {
    let body = document.getElementById('body');
    let saveCanvas = document.createElement('canvas');
    let context = saveCanvas.getContext('2d');

    // Check if user entered comment
    if (body.value === 'Your comment') {
        alert('Please enter your comment!');
        return;
    }

    // Create form to send
    let form = new FormData;

    // Initialise image
    saveCanvas.width = width;
    saveCanvas.height = height;
    context.drawImage(image, 0, 0, width, height);

    saveCanvas.toBlob(function (blob) {
        // Add photo to form
        form.append('photo', blob, 'photo.png');
        // Add body to form
        form.append('body', body.value);

        let response = fetch('http://localhost:8080/posts/add', {
            method: 'POST',
            body: form
        }).then(response => response.text())
        // .then(response => console.log(response))
            .then(response => window.location.replace('http://localhost:8080/posts'))

    }, 'image/png');
});

function takePicture() {
    const context = canvas.getContext('2d');
    if (width && height) {

        canvas.width = width;
        canvas.height = height;
        context.filter = color;
        context.fillRect(0,0,width,height);
        context.drawImage(video, 0, 0, width, height);
    }
}

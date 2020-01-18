<?php require APPROOT . '/view/include/header.php'; ?>
<a href="<?php echo URLROOT; ?>/pages/about" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<div class="card card-body bg-light mt-5">
    <h2>Add Post</h2>
    <p>Create a post with this form</p>
        <div id="corediv" class="form-group">
            <video id="video" width="640" height="480" autoplay></video>
            <button id="snap">Snap Photo</button>
</div>
<script>
    // Grab elements, create settings, etc.
    const video = document.getElementById('video');

    // Elements for taking the snapshot
    // var canvas = document.getElementById('canvas');
    // var context = canvas.getContext('2d');
    // var video = document.getElementById('video');


    console.log(navigator.mediaDevices);
    // Get access to the camera!
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        // Not adding `{ audio: true }` since we only want video now
        navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
            //video.src = window.URL.createObjectURL(stream);
            video.srcObject = stream;
            video.play();
        }).catch(console.error);
    }

    // Trigger photo take
    document.getElementById("snap").addEventListener("click", function() {
        let newDiw = document.createElement("canvas");

        newDiw.style.width = "200px";
        newDiw.style.height = "150px";
        newDiw.style.margin = "none";

        addElement(newDiw);

        let context = newDiw.getContext('2d');
        context.drawImage(video, 0, 0, 200, 150);
    });

    function addElement(newDiv) {
        let currentDiv = document.getElementById("corediv");
        currentDiv.appendChild(newDiv);
    }

</script>
<?php require APPROOT . '/view/include/footer.php'; ?>

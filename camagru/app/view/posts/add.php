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
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="place">Take another</button>
                <input id="send" type="submit" value="Save post" class="btn btn-success">
            </div>
        </div>
    </div>
</div>

<!--Webcam-->
<div class="card bg-light mt-5" style="max-width: 800px;">
    <div class="card-body camera">
        <h2 class="card-title text-center">Snap Photo</h2>
        <canvas class="card-img" id="canvas"></canvas>
        <div class="card-body btn-group-sm" role="group">
            <button id="sepia" type="button" class="btn btn-secondary">Sepia</button>
            <button id="invert" type="button" class="btn btn-secondary">Invert</button>
            <button id="blur" type="button" class="btn btn-secondary">Blur</button>
            <button id="strongblur" type="button" class="btn btn-secondary">Strong Blur</button>
            <button id="default" type="button" class="btn btn-secondary">Default</button>
            <button id="snap" class="btn btn-primary float-right" data-toggle="modal" data-target="#Modal">Snap Photo
            </button>
        </div>
        <input type="file" name="pic" id="pic" accept=".jpg, .jpeg, .png" data-toggle="modal" data-target="#Modal">
    </div>
</div>

<div class="container mt-5" id="paste">
</div>

<!--Hidden original video stream-->
<video style="display: none;" id="video" autoplay></video>

<!--Add js -->
<script src="<?php URLROOT; ?>/js/add.js"></script>
<?php require APPROOT . '/view/include/footer.php'; ?>

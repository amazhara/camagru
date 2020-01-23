<?php require APPROOT . '/view/include/header.php'; ?>
<a href="<?php echo URLROOT; ?>/pages/about" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<div class="card bg-light mt-5">
    <div class="card-body camera">
        <h2 class="card-title text-center">Add Photo</h2>
        <video class="card-img-top" id="video" autoplay>Video stream not available.</video>
        <button id="snap" class="btn btn-primary float-right">Snap Photo</button>
    </div>

    <!--Hidden elements to process photo-->
    <canvas id="canvas" style="display: none">
    </canvas>
    <form id="form" style="display: none" action="<?php echo URLROOT?>/posts/add " method="post" enctype="multipart/form-data">
        <input id="push" type="text" name="photo">
    </form>
</div>
<script src="<?php echo URLROOT; ?>/public/js/snap.js"></script>
<?php require APPROOT . '/view/include/footer.php'; ?>

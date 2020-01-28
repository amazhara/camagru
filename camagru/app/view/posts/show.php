<?php require APPROOT . '/view/include/header.php'; ?>

<a href="<?php echo URLROOT; ?>/posts/" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<div class="card card-body mx-auto" style="width: 620px">
    <img alt="Post photo" class="card-img-top" src="<?php echo URLROOT . '/public/data/' . $data['post']->photo ?>">
    <p class="card-text text-center">
        <?php echo $data['post']->body; ?>
    </p>
</div>
<?php if ($data['post']->user_id == $_SESSION['user_id']) : ?>

    <form action="<?php echo URLROOT; ?>/posts/comment">
        <div class="form-group">
            <label for="Body">Write comment to post</label>
            <input type="text" class="form-control" id="Body">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

<?php endif; ?>


<?php require APPROOT . '/view/include/footer.php'; ?>

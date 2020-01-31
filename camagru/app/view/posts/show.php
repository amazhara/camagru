<?php require APPROOT . '/view/include/header.php'; ?>

<a href="<?php echo URLROOT; ?>/posts/" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
<div class="card card-body mx-auto" style="width: 620px">
    <img alt="Post photo" class="card-img-top" src="<?php echo URLROOT . '/public/data/' . $data['post']->photo ?>">
    <p class="card-text text-center">
        <?php echo $data['post']->body; ?>
    </p>
</div>

<!--Comment form-->

<form action="<?php echo URLROOT; ?>/posts/comment" method="post">
    <div class="form-group">
        <label for="Body">Write comment to post</label>
        <input type="text" class="form-control" id="body" name="body" value="">
        <input type="text" class="form-control" name="post_id" value="<?php echo $data['post']->id; ?>"
               style="display: none">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>


<!--List comments-->
<?php foreach ($data['comments'] as $comment) : ?>

    <div class="card card-body mb-3">
        <div class="bg-light p-2 mb-3">
            written by <?php echo $comment->user_name; ?> on <?php echo $comment->created_at; ?>
        </div>
        <p class="card-text">
            <?php echo $comment->body; ?>
        </p>
    </div>

<?php endforeach; ?>



<?php require APPROOT . '/view/include/footer.php'; ?>

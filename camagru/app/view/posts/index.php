<?php require APPROOT . '/view/include/header.php'; ?>

<?php flash('post_message'); ?>
    <div class="row mb-3">
        <div class="mx-auto">
            <h1>Posts</h1>
        </div>
        <div class="mx-auto">
            <a href="<?php echo URLROOT; ?>/posts/add" class="btn btn-primary pull-right">
                <i class="fa fa-pencil"></i>Add Post
            </a>
        </div>
    </div>
<?php foreach($data['posts'] as $post) :?>
    <div class="card card-body mx-auto" style="width: 620px">
        <img alt="Post photo" class="card-img-top" src="<?php echo URLROOT . '/public/data/' . $post->photo ?>">
        <div class="bg-light p-2 mb-3">
            written by <?php echo $post->name; ?> on <?php echo $post->postCreated; ?>
        </div>
        <p class="card-text">
            <?php echo $post->body; ?>
        </p>
        <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->postId; ?>" class="btn btn-dark">See comments</a>
    </div>
<?php endforeach; ?>

<?php require APPROOT . '/view/include/footer.php'; ?>

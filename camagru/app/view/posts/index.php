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
        <a href="<?php echo URLROOT ?>/posts/like/?id=<?php echo $post->postId; ?>">
            <?php if(isset($post->isLiked)) : ?>
            <img src="https://www.transparentpng.com/thumb/instagram-heart/DlYWow-instagram-heart-hd-image.png" style="width: 50px; height: 50px;">
            <?php else : ?>
            <img src="https://www.transparentpng.com/thumb/instagram-heart/OtpLVC-heart-shaped-instagram-transparent-image.png" style="width: 50px; height: 50px;">
            <?php endif; ?>
        </a>
        <p class="card-text">
            <?php echo 'Total likes: ' . $post->likes_count; ?>
        </p>
        <a href="<?php echo URLROOT; ?>/posts/show/?id=<?php echo $post->postId; ?>" class="btn btn-dark">Comments</a>
    </div>
<?php endforeach; ?>

<?php require APPROOT . '/view/include/footer.php'; ?>

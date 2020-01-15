<?php require APPROOT . '/view/include/header.php'; ?>
<div class="alert alert-info text-center" role="alert">
    <h1 class="font-weight-normal"><?php echo $data['title']; ?></h1>
    <p class="text-light"><?php echo $data['description']; ?></p>
</div>
<hr>
<div class="container text-center">
    <a class="btn btn-sm btn-success" href="https://github.com/amazhara"
       target="_blank"><?php echo $data['author']; ?></a>
</div>
<?php require APPROOT . '/view/include/footer.php'; ?>

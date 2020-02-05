<?php require APPROOT . '/view/include/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <p>Reinitialisation link will sent to associated email</p>
            <form action="<?php echo URLROOT; ?>/users/recover" method="post">
                <div class="form-group">
                    <label for="email">Email: <sup>*</sup></label>
                    <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
                    <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/view/include/footer.php'; ?>

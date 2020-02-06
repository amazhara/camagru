<?php require APPROOT . '/view/include/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Change your account information</h2>
            <form action="<?php echo URLROOT; ?>/users/settings" method="post">
                <div class="form-group">
                    <label for="email">Change Email: <sup>*</sup></label>
                    <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="">
                    <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                </div>
                <div class="form-group">
                    <label for="name">Change Name: <sup>*</sup></label>
                    <input type="text" name="name"
                           class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>"
                           value="">
                    <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                </div>
                <div class="form-group">
                    <label for="password">Change Password: <sup>*</sup></label>
                    <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="">
                    <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                </div>
                <div class="form-check">
                    <?php if($data['checked']): ?>
                        <input type="checkbox" class="form-check-input" name="check" id="check" checked>
                    <?php else: ?>
                        <input type="checkbox" class="form-check-input" name="check" id="check">
                    <?php endif; ?>
                    <label class="form-check-label" for="check">Receive notifications via email</label>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="submit" value="Save" class="btn btn-success btn-block">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/view/include/footer.php'; ?>

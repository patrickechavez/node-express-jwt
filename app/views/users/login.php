<?php require APPROOT . '/views/inc/header.php';?>


<div class="row">
    <div class=" col-md-6 mx-auto">
        <div class="card card-body bg-light mt-4">

           <?php flash('register_success')?>
            <h1>Login</h1>
            <p>Please fill out this form to login<p>

            <form action="<?php echo URLROOT; ?>/users/login" method = "POST">
                <div class="form-group">
                    <label for="email">Email: <sup>*</sup></label>
                    <input type="text" name = "email" class = "form-control form-control-lg
                    <?php echo (!empty($data['email_err'])) ? 'is-invalid' : '' ?>" value = "<?php echo $data['email']; ?> ">
                    <span class = "invalid-feedback"><?php echo $data['email_err']; ?></span>
                </div>
                <div class="form-group">
                    <label for="password">Password: <sup>*</sup></label>
                    <input type="text" name = "password" class = "form-control form-control-lg
                    <?php echo (!empty($data['password_err'])) ? 'is-invalid' : '' ?>" value = "<?php echo $data['password']; ?> ">
                    <span class = "invalid-feedback"><?php echo $data['password_err']; ?></span>
                </div>
                <div class=" d-flex justify-content-around mt-3">
                    <button class="btn btn-primary btn-block">Login</button>
                    <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-block">No account? Register</a>

                </div>

            </form>


        </div>
    </div>
</div>


<?php require APPROOT . '/views/inc/footer.php';?>
<?php require APPROOT . '/views/inc/header.php';?>


<div class="row">
    <div class=" col-md-8 mx-auto">
        <div class="card card-body bg-light mt-4">
            <h1>Create an Account</h1>
            <p>Please fill out this form to register with us</p>
            <form action="<?php echo URLROOT; ?>/users/register" method = "POST">
                <div class="form-group">
                    <label for="name">Name: <sup>*</sup></label>
                    <input type="text" name = "name" class = "form-control
                    <?php echo (!empty($data['name_err'])) ? 'is-invalid' : '' ?>" value = "<?php echo $data['name']; ?>">
                    <span class = "invalid-feedback"><?php echo $data['name_err']; ?></span>
                </div>
                <div class="form-group">
                    <label for="email">Email: <sup>*</sup></label>
                    <input type="text" name = "email" class = "form-control
                    <?php echo (!empty($data['email_err'])) ? 'is-invalid' : '' ?>" value = "<?php echo $data['email']; ?>">
                    <span class = "invalid-feedback"><?php echo $data['email_err']; ?></span>
                </div>
                <div class="form-group">
                    <label for="password">Password: <sup>*</sup></label>
                    <input type="password" name = "password" class = "form-control
                    <?php echo (!empty($data['password_err'])) ? 'is-invalid' : '' ?>" value = "<?php echo $data['password']; ?>">
                    <span class = "invalid-feedback"><?php echo $data['password_err']; ?></span>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password: <sup>*</sup></label>
                    <input type="password" name = "confirm_password" class = "form-control
                    <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : '' ?>" value = "<?php echo $data['confirm_password']; ?>">
                    <span class = "invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
                </div>

                <div class=" d-flex justify-content-around mt-3">
                    <button class="btn btn-primary btn-block">Register</button>
                    <a href="<?php echo URLROOT; ?>/users/login" class="btn  btn-block">Already have an account? Login</a>
                </div>

            </form>


        </div>
    </div>
</div>


<?php require APPROOT . '/views/inc/footer.php';?>
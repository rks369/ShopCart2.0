<?php
include('views/partials/head.php');
include('views/partials/seller_header.php'); ?>
<div class="container">
    <div class="left">
        <img src="../static/images/forgot_password.jpg">
    </div>
    <div class="right card">
        <br>
        <h1 class="heading">Forgot Password?</h1>
        <br>
        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email">
                <div>
                    <span id='email_err' class="error_span"></span>
                </div>
            </div>
        </div>

        <div class=" text-center">
            <span id='error_msg' class="error_span"></span>
        </div>
        <br>
        <button id="reset_password" class="primaryButton">Reset Password</button>
        <br>
    </div>
</div>
<script src="forgot_password.js"></script>

<?php
include('views/partials/tail.php');

<?php
include('views/partials/head.php');
include('views/partials/header.php');?>
<div class="container">
    <div class="left">
        <img src="static/images/user_login.jpg">
    </div>
    <div class="right card">
        <br>
        <h1 class="heading">Login Your Self In</h1>
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
        <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password">
                <div>
                    <span id='password_err' class="error_span"></span>
                </div>
            </div>

        </div>

        <a class="text-end" href='forgot_password'>Forgot Password?</a>
        <div class=" text-center">
            <span id='error_msg' class="error_span"></span>
        </div>
        <br>
        <button id="loginBtn" class="primaryButton">Login</button>
        <br>
    </div>
</div>
<script src="static/js/login.js"></script>
<?php
include('views/partials/tail.php');
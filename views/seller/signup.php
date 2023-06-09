<?php
include('views/partials/head.php');
include('views/partials/seller_header.php'); ?>
<div class="container">
    <div class="left">
        <img src="../static/images/seller_signup.png"">
            </div>
            <div class=" right card">
        <br>
        <h1 class="heading">Become A Seller</h1>
        <br>
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="name" class="form-control" id="name">
                <div>
                    <span id='name_err' class="error_span"></span>
                </div>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Bussines Name</label>
            <div class="col-sm-10">
                <input type="bname" class="form-control" id="bname">
                <div>
                    <span id='bname_err' class="error_span"></span>
                </div>
            </div>
        </div>
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
            <label for="mobile" class="col-sm-2 col-form-label">Mobile </label>
            <div class="col-sm-10">
                <input type="mobile" class="form-control" id="mobile">
                <div>
                    <span id='mobile_err' class="error_span"></span>
                </div>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="gst" class="col-sm-2 col-form-label">GST</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="gst">
                <div>
                    <span id='gst_err' class="error_span"></span>
                </div>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="address" class="col-sm-2 col-form-label">Address</label>
            <div class="col-sm-10">
                <input type="address" class="form-control" id="address">
                <div>
                    <span id='address_err' class="error_span"></span>
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

        <div class="text-center">
            <span id='error_msg' class="error_span"></span>
        </div>
        <br>
        <button id="signUpBtn" class="primaryButton">Sign Up</button>
        <br>
    </div>
</div>
<script src="../static/js/seller_signup.js"></script>
<?php
include('views/partials/tail.php');

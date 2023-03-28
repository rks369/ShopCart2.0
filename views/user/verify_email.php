<?php
include('views/partials/head.php');
include('views/partials/header.php'); ?>
<div class="container">

    <?php

    if (isset($message)) {
    ?>
        <div class=" right card">
            <br><br>
            <h1 class="heading"><?= $message ?></h1>
            <br><br>
            <a href="login" class="primaryButton">
                Login
            </a>
            <br><br>
        </div>
    <?php
    } else {
    ?>
        <div class="left">
            <img src="static/images/verify-email.png">
        </div>
        <div class="right card">
            <br>
            <h1 class="heading">Verify E-mail First</h1>
            <br>
            <br>
            <a id="loginBtn" class="primaryButton">Verify</a>
            <br>
        </div>
    <?php
    }
    ?>


</div>
<script src="static/js/login.js"></script>
<?php
include('views/partials/tail.php');

<?php
include('views/partials/head.php');
include('views/partials/header.php'); ?>

<div class="popup" id="popup">
    <div class="popup_card" id="product_details">
    </div>
</div>
<img id="bg_img" src="static/images/bg.png" alt="">
<div class="contain" id="products">
</div>
<?php
if (isset($_SESSION['id'])) {
?>
    <div class="contain">
        <button class="primaryButton" id="load_more">Load More</button>
        <br><br>
    </div>
<?php
}
?>


<footer class="footer">
    All Rights Are Reserved © 2023
</footer>

<script src="static/js/script.js"></script>




<?php
include('views/partials/tail.php');

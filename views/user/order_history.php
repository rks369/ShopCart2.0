<?php
include('views/partials/head.php');
include('views/partials/header.php'); ?>

<div class="popup" id="popup">

    <div class="" id="order_items_card">
        <h1 class="heading"> Order Details</h1>
        <div id="order_items_list"></div>
        <span>Total Amount : Rs.
            <span id="total_amount" class="product_price"></span>/-</span>
        <!-- <a class="secondaryButton">Print</a> -->
    </div>
</div>

<div class="cartBox" id="order_history">


</div>


<script src="order_history.js"></script>
<?php
include('views/partials/tail.php');

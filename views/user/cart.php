<?php
include('views/partials/head.php');
include('views/partials/header.php'); ?>
<div class="cartBox">

    <div id="cart_items">

    </div>
    <div id="oderdetails">
        <p class="heading">Order Datails</p>

        <span class="heading">Total Amount : </span>

        <sapn class="product_price" style="display: contents;" id="total_amount"></sapn>
        <span class="heading">Billing Addres</span>

        <textarea class="form-control" name="address" id="billing_address" cols="10" rows="3"></textarea>
        <br>

        <a class="primaryButton" id="Order_now">Oder Now</a>
    </div>
</div>


<script src="cart.js"></script>
<?php
include('views/partials/tail.php');

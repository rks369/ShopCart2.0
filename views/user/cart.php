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
        <br>
        <span class="error_span" id="error_msg"></span>
        <select id="selectAddress" class="form-select">
            <option value="-1" default>Select Billing Address</option>
        </select>
        <br>
        <textarea class="form-control" name="address" id="billing_address" cols="10" rows="2" placeholder="Add New Address"></textarea>
        <br>
        <a class="primaryButton" id="add_address">Add New Address</a>
        <br>
        <a class="primaryButton" id="Order_now">Oder Now</a>
    </div>
</div>


<script src="static/js/cart.js"></script>
<?php
include('views/partials/tail.php');

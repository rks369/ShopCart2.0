<?php
require_once('views/partials/head.php');
require_once('views/partials/seller_header.php');
?>
<br><br>
<div class="" id="order_items_card">
    <h1 class="heading"> Orders</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Product Id</th>
                <th scope="col">Title</th>
                <th scope="col">Quantity</th>
                <th scope="col">Billling Address</th>
                <th scope="col">Order Time</th>
                <th scope="col">Current Status</th>
            </tr>
        </thead>
        <tbody id="order_items_list">

        </tbody>
    </table>

</div>
<div class="contain">
    <button class="primaryButton" id="load_more_orders">Load More</button>
    <br><br>
</div>
<script src="../static/js/all_orders.js"></script>

<?php
require_once('views/partials/tail.php');

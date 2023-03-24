<?php
require_once ('views/partials/head.php');
require_once ('views/partials/seller_header.php');
?>

    <div class="popup" id="popup">

      <div class="" id="order_items_card">
        <h1 class="heading"> Orders</h1>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Quantity</th>
              <th scope="col">Billling Address</th>
              <th scope="col">Order Time</th>
              <th scope="col">Current Status</th>
            </tr>
          </thead>
          <tbody  id="order_items_list">
         
          </tbody>
        </table>
     
      </div>
    </div>
    <div class="popup" id="add_product_popup">
      <div class=" popup_card" id="popup_card">
        <div>
          <br>
          <h1 class="text-center heading" id="popup_heading">Add Products</h1>
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
            <label for="description" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="description">
              <div>
                <span id='description_err' class="error_span"></span>
              </div>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="price" class="col-sm-2 col-form-label">Price</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" id="price">
              <div>
                <span id='price_err' class="error_span"></span>
              </div>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="stock" class="col-sm-2 col-form-label">Stock</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" id="stock">
              <div>
                <span id='stock_err' class="error_span"></span>
              </div>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="image" class="col-sm-2 col-form-label">Image</label>
            <div class="col-sm-10">
              <input type="file" class="form-control" id="image">
              <div>
                <span id='file_err' class="error_span"></span>
              </div>
            </div>
            <div class="text-center">
              <span id='error_msg' class="error_span"></span>
            </div>
            <br>
            <br>
          </div>
          <div class="contain">
            <button id="addProductBtn" class="primaryButton">Add Product</button>

          </div>
          <br>
        </div>
      </div>
    </div>



    <div class="contain">
      <button class="primaryButton" id="add_product">Add Product</button>
      <br><br>
    </div>
    <div class="contain" id="productsList">

    </div>
    <div class="contain">
      <button class="primaryButton" id="load_more">Load More</button>
      <br><br>
    </div>
    <script src="../static/js/add_product.js"></script>
<?php
require_once('views/partials/tail.php');
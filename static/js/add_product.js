const product_name = document.getElementById("name");
const product_description = document.getElementById("description");
const product_price = document.getElementById("price");
const product_stock = document.getElementById("stock");
const product_image = document.getElementById("image");

const popup = document.getElementById("popup");
const order_items_list = document.getElementById("order_items_list");

popup.addEventListener("click", () => {
  order_items_list.innerHTML = "";
  popup.style["display"] = "none";
});

let productsList = document.getElementById("productsList");

const err_msg = document.getElementById("error_msg");

let addProductBtn = document.getElementById("addProductBtn");
let add_product = document.getElementById("add_product");
let add_product_popup = document.getElementById("add_product_popup");

let popup_heading = document.getElementById("popup_heading");
let popup_card = document.getElementById("popup_card");
let current_index = 0;
const count = 8;
let no_more_product = false;

getProductList();

load_more.addEventListener("click", () => {
  if (!no_more_product) {
    getProductList();
  }
});

add_product.addEventListener("click", () => {
  popup_heading.innerHTML = "Add Product";
  addProductBtn.innerHTML = "Add Product";
  add_product_popup.style["display"] = "block";
});

popup_card.addEventListener("click", (event) => {
  event.stopPropagation();
});

add_product_popup.addEventListener("click", () => {
  add_product_popup.style["display"] = "none";
  product_name.value = "";
  product_description.value = "";
  product_price.value = "";
  product_stock.value = "";
  product_image.value = "";
});

addProductBtn.addEventListener("click", () => {
  err_msg.innerHTML = "";

  const title = product_name.value.trim();
  const description = product_description.value.trim();
  const price = product_price.value.trim();
  const stock = product_stock.value.trim();
  const image = product_image.files[0];

  if (title.length < 3) {
    err_msg.innerHTML = "Please Enter A Valid Name";
  } else if (description < 5) {
    err_msg.innerHTML = "Please Enter A Valid Deescription";
  } else if (price.length < 1) {
    err_msg.innerHTML = "Please Enter A Valid Price";
  } else if (stock.length < 1) {
    err_msg.innerHTML = "Please Enter A Valid Stock";
  } else {
    let formData = new FormData();
    formData.append("title", title);
    formData.append("description", description);
    formData.append("price", price);
    formData.append("stock", stock);
    formData.append("image", image);
    if (addProductBtn.innerHTML == "Add Product") {
      if (product_image.files[0] == null) {
        err_msg.innerHTML = "Please Select A File";
      } else {
        fetch("/seller/addProduct", { method: "POST", body: formData })
          .then((response) => response.json())
          .then((result) => {
            console.log(result);
            if (result["msg"] == "Done") {
              product_name.value = "";
              product_description.value = "";
              product_price.value = "";
              product_stock.value = "";
              product_image.value = "";
            } else {
              err_msg.innerHTML = result["data"];
            }
          });
      }
    } else {
      formData.append("product_id", product_name.key);
      formData.append("imageurl", product_image.key);
      fetch("/seller/editProduct", { method: "POST", body: formData })
        .then((response) => response.json())
        .then((result) => {
          console.log(result);
          if (result["msg"] == "Done") {
            window.location.reload();
            product_name.value = "";
            product_description.value = "";
            product_price.value = "";
            product_stock.value = "";
            product_image.value = "";
            add_product_popup.style["display"] = "none";
          } else if(result['msg']=="Error") {
            err_msg.innerHTML = result["data"];
          }
        });
    }
  }
});

function getProductList() {
  let div = document.createElement("div");

  div.innerHTML = "";
  fetch("products", {
    method: "POST",
    headers: {
      "Content-type": "application/json;charset=utf-8",
    },
    body: JSON.stringify({ current_index, count }),
  })
    .then((response) => response.json())
    .then((result) => {
      if (result["msg"] == "Done") {
        current_index += count;
        result = result["data"];
        if (result.length == 0) {
          load_more.innerHTML = "No More Products";
          load_more.classList.remove("primaryButton");
          load_more.classList.add("secondaryButton");
          no_more_product = true;
        } else {
          result.forEach((product) => {
            console.log(product);
            createProductUI(product);
          });
        }
      } else if(result['msg']=='Error') {
        load_more.innerHTML = result['data'];
        load_more.classList.remove('primarybutton');
        load_more.classList.add('secondarybutton');
      }
    });
}

function createProductUI(product) {
  const productUI = document.createElement("div");
  productUI.classList.add("product_card");

  const productImg = document.createElement("img");
  productImg.classList.add("product_img");
  productImg.src = "../uploads/" + product.imageurl;

  const div1 = document.createElement("div");

  const title = document.createElement("p");
  title.classList.add("product_title");
  title.innerHTML = product.title;
  div1.appendChild(title);

  const price = document.createElement("p");
  price.classList.add("product_price");
  price.innerHTML = `Rs. ${product.price}/-`;
  div1.appendChild(price);

  const description = document.createElement("p");
  description.classList.add("product_desc");
  description.innerHTML = product.description;

  const stock = document.createElement("p");
  stock.classList.add("product_stock");
  stock.innerHTML = `Stocks : ${product.stock}`;

  const div2 = document.createElement("div");

  const edit = document.createElement("button");
  edit.classList.add("secondaryButton");
  edit.innerHTML = "Edit";
  div2.appendChild(edit);

  edit.addEventListener("click", () => {
    popup_heading.innerHTML = "Edit Product";
    addProductBtn.innerHTML = "Update Details";
    add_product_popup.style["display"] = "block";

    product_name.key = product.product_id;
    product_name.value = product.title;
    product_description.value = product.description;
    product_price.value = product.price;
    product_stock.value = product.stock;
    product_image.key = product.imageurl;
  });

  const status = document.createElement("button");
  status.classList.add("primaryButton");
  status.innerHTML = product.status == 1 ? "Enable" : "Disable";
  div2.appendChild(status);

  status.addEventListener("click", () => {
    status.disabled = true;
    const statusValue = status.innerHTML == "Enable" ? 0 : 1;
    fetch("updateProductStatus", {
      method: "POST",
      headers: {
        "Content-type": "application/json;charset=utf-8",
      },
      body: JSON.stringify({ product_id: product.product_id, status: statusValue }),
    })
      .then((response) => response.json())
      .then((result) => {
        console.log(result);
        if(result['msg']=="Done")
        {
          status.disabled = false;
          status.innerHTML = status.innerHTML == "Enable" ? "Disable" : "Enable";
        }else if(result['msg']=="Error")
        {
          alert('Something Went Wrong !!!');
        }
      });
  });

  const orders = document.createElement("button");
  orders.classList.add("primaryButton");
  orders.innerHTML = "Orders";
  div2.appendChild(orders);

  orders.addEventListener("click", () => {
    popup.style["display"] = "block";
    fetch("/seller/productOrders", {
      method: "POST",
      headers: {
        "Content-type": "application/json;charset=utf-8",
      },
      body: JSON.stringify({ product_id: product.pid }),
    })
      .then((response) => response.json())
      .then((result) => {
        console.log(result);
        result["data"].forEach((orderDetails) => {
          createOrderDetailsTile(orderDetails);
        });
      });
  });

  productUI.appendChild(productImg);
  productUI.appendChild(div1);
  productUI.appendChild(description);
  productUI.appendChild(stock);
  productUI.appendChild(div2);
  productUI.appendChild(document.createElement("br"));

  productsList.appendChild(productUI);
}

function createOrderDetailsTile(orderDetails) {
  const orderrow = document.createElement("tr");

  const rowValue1 = document.createElement("td");
  rowValue1.innerHTML = orderDetails.name;
  orderrow.appendChild(rowValue1);

  const rowValue2 = document.createElement("td");
  rowValue2.innerHTML = orderDetails.quantity;
  orderrow.appendChild(rowValue2);

  const rowValue3 = document.createElement("td");
  rowValue3.innerHTML = JSON.parse(orderDetails.billing_address)["address"];
  orderrow.appendChild(rowValue3);

  const rowValue4 = document.createElement("td");
  rowValue4.innerHTML = new Date(orderDetails.order_time).toLocaleDateString();
  orderrow.appendChild(rowValue4);

  let status = JSON.parse(orderDetails.activity);
  const rowValue5 = document.createElement("td");
  rowValue5.innerHTML = status[status.length - 1]["title"];
  orderrow.appendChild(rowValue5);

  order_items_list.appendChild(orderrow);
}

const cart_items = document.getElementById("cart_items");
const total_amount_tag = document.getElementById("total_amount");
const billing_address = document.getElementById("billing_address");
const Order_now = document.getElementById("Order_now");
const add_address = document.getElementById("add_address");
const selectAddress = document.getElementById("selectAddress");
let error_msg = document.getElementById('error_msg');

let total_amount = 0;
let cart_id_list = [];

getCartList();
getAddressList();

billing_address.style["display"] = "none";

add_address.addEventListener("click", (event) => {
  if (add_address.innerHTML == "Add New Address") {
    add_address.innerHTML = "Add Address";
    billing_address.style["display"] = "block";
  } else {
    if (false) {
      alert("Please Ente A Billing Address");
    } else {
      fetch("addAddress", {
        method: "POST",
        body: JSON.stringify({ address: billing_address.value.trim() }),
      })
        .then((res) => res.json())
        .then((result) => {
          console.log(result);
          if (result["msg"] == "Done") {
            add_address.innerHTML = "Add New Address";
            billing_address.style["display"] = "none";
            createAddressTile(result["data"]);
            error_msg.innerHTML="";
            billing_address.value="";
          } else if (result["msg"] == "Error") {
            alert("Something Went Wrong !!!");
          }
        });
    }
  }
});

function getCartList() {
  fetch("cartItems", { method: "GET" })
    .then((response) => response.json())
    .then((result) => {
      if (result["msg"] == "Error") {
        cart_items.innerHTML = result["data"];
      } else {
        result["data"].forEach((cartItem) => {
          cart_id_list.push(cartItem.cart_id);
          createCartItem(cartItem);
        });
      }
    });
}

function getAddressList() {
  fetch("getAddress", { method: "GET" })
    .then((res) => res.json())
    .then((result) => {
      console.log(result);
      if (result["msg"] == "Done") {
        result["data"].forEach((address) => {
          createAddressTile(address);
        });
      } else if (result["msg"] == "Error") {
      
        error_msg.innerHTML = "No Address Saved";

      }
    });
}

// function createAddressTile(address) {
//   let radioButton = document.createElement("input");
//   radioButton.classList.add("form-check-input");
//   radioButton.name = "address";
//   radioButton.type = "radio";
//   radioButton.value = address["address_id"];
//   radioButton.id = address["address_id"];

//   let addressLable = document.createElement("label");
//   addressLable.classList.add("form-check-label");
//   addressLable.innerHTML = address["address"];
//   addressLable.htmlFor = address["address_id"];

//   selectAddress.appendChild(radioButton);
//   selectAddress.appendChild(addressLable);
//   selectAddress.appendChild(document.createElement("br"));
// }


function createAddressTile(address) {
  let option = document.createElement("option");
  option.classList.add("form-check-input");
  option.innerHTML = address['address'];
  option.value = address["address_id"];
  option.id = address["address_id"];
  selectAddress.appendChild(option);
}



Order_now.addEventListener("click", () => {
  if (selectAddress.value==-1) {
    alert("Please Fill the Address");
  } else {
    let reqObj = {
      cart_id_list: cart_id_list,
      billing_address: selectAddress.value,
    };
    console.log(reqObj);
    fetch("/order", {
      method: "POST",
      headers: {
        "Content-type": "application/json;charset=utf-8",
      },
      body: JSON.stringify(reqObj),
    })
      .then((response) => response.json())
      .then((result) => {
        if (result["msg"] == "Done") {
          window.location.href = "/order_history";
        } else if(result['msg']=="Error") {
          
          alert("can't Place Order");
        }
        console.log(result);
      });
  }
});

function createCartItem(cartItem) {
  cartItem.quantity = parseInt(cartItem.quantity);
  cartItem.price = parseInt(cartItem.price);
  cartItem.stock = parseInt(cartItem.stock);
  const status = cartItem.quantity <= cartItem.stock;

  total_amount += cartItem.quantity * cartItem.price;

  total_amount_tag.innerHTML = `Rs.${total_amount}/-`;

  const cartItemBox = document.createElement("div");
  cartItemBox.classList.add("cart_product_card");
  cartItemBox.classList.add("box");

  const productsImg = document.createElement("img");
  productsImg.classList.add("item");
  productsImg.classList.add("cart_product_img");
  productsImg.src = "uploads/" + cartItem.imageurl;

  const div1 = document.createElement("div");
  div1.classList.add("item");

  const title = document.createElement("p");
  title.classList.add("cart_product_title");
  title.innerHTML = cartItem.title;
  div1.appendChild(title);

  const description = document.createElement("p");
  description.classList.add("product_desc");
  description.innerHTML = cartItem.description;
  div1.appendChild(description);

  const price = document.createElement("p");
  price.classList.add("product_price");
  price.innerHTML = `Rs. ${cartItem.price}/-`;
  div1.appendChild(price);

  const div2 = document.createElement("div");
  div2.classList.add("item");

  const grossPrice = document.createElement("p");
  grossPrice.classList.add("product_price");
  grossPrice.innerHTML = `Rs. ${cartItem.price * cartItem.quantity}/-`;
  div2.appendChild(grossPrice);

  div2.appendChild(document.createElement("br"));

  const decreaseQuantity = document.createElement("a");
  decreaseQuantity.classList.add("circularButton");
  decreaseQuantity.innerHTML =
    '<span class="material-symbols-outlined"> remove</span>';
  div2.appendChild(decreaseQuantity);

  decreaseQuantity.addEventListener("click", () => {
    fetch("/decreaseQuantity", {
      method: "POST",
      headers: {
        "Content-type": "application/json;charset=utf-8",
      },
      body: JSON.stringify({ cart_id: cartItem.cart_id }),
    })
      .then((response) => response.json())
      .then((result) => {
        if (result["msg"] == "Done") {
          cartItem.quantity--;
          if (cartItem.quantity == 0) {
            cart_items.removeChild(cartItemBox);
          }
          quantity.innerHTML = cartItem.quantity;
          total_amount -= cartItem.price;
          grossPrice.innerHTML = `Rs. ${cartItem.price * cartItem.quantity}/-`;
          total_amount_tag.innerHTML = `Rs.${total_amount}/-`;
        } else if (result["msg"] == "Error") {
          err.innerHTML = result["data"];
        }
      });
  });

  const quantity = document.createElement("span");
  quantity.classList.add("product_quantity");
  quantity.innerHTML = cartItem.quantity;
  div2.appendChild(quantity);

  const increaseQuantity = document.createElement("a");
  increaseQuantity.classList.add("circularButton");
  increaseQuantity.innerHTML =
    '<span class="material-symbols-outlined"> add</span>';
  div2.appendChild(increaseQuantity);

  increaseQuantity.addEventListener("click", () => {
    fetch("/increaseQuantity", {
      method: "POST",
      headers: {
        "Content-type": "application/json;charset=utf-8",
      },
      body: JSON.stringify({ cart_id: cartItem.cart_id }),
    })
      .then((response) => response.json())
      .then((result) => {
        console.log(result);
        if (result["msg"] == "Done") {
          cartItem.quantity++;
          quantity.innerHTML = cartItem.quantity;
          total_amount += cartItem.price;
          grossPrice.innerHTML = `Rs. ${cartItem.price * cartItem.quantity}/-`;
          total_amount_tag.innerHTML = `Rs.${total_amount}/-`;
        } else if (result["msg"] == "Error") {
          err.innerHTML = result["data"];
        }
      });
  });

  div2.appendChild(document.createElement("br"));

  const err = document.createElement("span");
  err.classList.add("error_span");
  if (!status) {
    err.innerHTML = "Out of Stock";
  }
  div2.appendChild(err);

  div2.appendChild(document.createElement("br"));
  div2.appendChild(document.createElement("br"));

  const removeItem = document.createElement("a");
  removeItem.classList.add("secondaryButton");
  removeItem.innerHTML = "Remove";
  div2.appendChild(removeItem);

  removeItem.addEventListener("click", () => {
    fetch("/removeFromCart", {
      method: "POST",
      headers: {
        "Content-type": "application/json;charset=utf-8",
      },
      body: JSON.stringify({ product_id: cartItem.product_id }),
    })
      .then((response) => response.json())
      .then((result) => {
        console.log(result);
        if (result["msg"] == "Done") {
          cart_items.removeChild(cartItemBox);
          cart_id_list = cart_id_list.filter((id) => {
            return id != cartItem.cid;
          });
          total_amount -= cartItem.price * cartItem.quantity;

          total_amount_tag.innerHTML = `Rs.${total_amount}/-`;
        } else if (result["msg"] == "Error") {
          err.innerHTML = result["data"];
        }
      });
  });

  const buyNow = document.createElement("a");
  buyNow.classList.add("primaryButton");
  buyNow.innerHTML = "Buy Now";
  div2.appendChild(buyNow);

  buyNow.addEventListener("click", () => {
    console.log()
    if (selectAddress.value==-1) {
      alert("Please Fill the Address");
    } else {
      let reqObj = {
        cart_id_list: [cartItem.cart_id],
        billing_address: selectAddress.value,
      };
      console.log(reqObj);
      fetch("/order", {
        method: "POST",
        headers: {
          "Content-type": "application/json;charset=utf-8",
        },
        body: JSON.stringify(reqObj),
      })
        .then((response) => response.json())
        .then((result) => {
          if (result["msg"] == "Done") {
            window.location.href = "/order_history";
          } else if(result['msg']=="Error") {
            alert(result['data']);
          }
          console.log(result);
        });
    }
  });

  cartItemBox.appendChild(productsImg);
  cartItemBox.appendChild(div1);
  cartItemBox.appendChild(div2);
  cart_items.appendChild(cartItemBox);
}

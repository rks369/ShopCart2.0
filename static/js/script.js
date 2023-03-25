let items = document.getElementById("products");
let loadModeButton = document.getElementById("load_more");

let pop_up = document.getElementById("popup");
let product_details = document.getElementById("product_details");

let current_index = 0;
let count = 8;

let no_more_product = false;
getProducts();

load_more.addEventListener("click", (event) => {
  if (!no_more_product) {
    getProducts();
  }
});

pop_up.addEventListener("click", () => {
  pop_up.style.display = "none";
});

function getProducts() {
  fetch("/product", {
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
        result["data"].forEach((product) => {
          createProductItem(product);
        });
      } else if (result["msg"] == "Error") {
        load_more.classList.remove("primarybutton");
        load_more.classList.add("secondarybutton");
        no_more_product = true;
        load_more.innerHTML = result["data"];
      }
    });
}

function createProductItem(product) {
  const productUI = document.createElement("div");
  productUI.classList.add("product_card");

  const productImg = document.createElement("img");
  productImg.classList.add("product_img");
  productImg.src = "uploads/" + product.imageurl;

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

  const div2 = document.createElement("div");

  const addToCart = document.createElement("button");
  addToCart.classList.add("secondaryButton");
  addToCart.innerHTML = "Add To Cart";
  div2.appendChild(addToCart);

  addToCart.addEventListener("click", () => {
    if (addToCart.innerHTML == "Add To Cart") {
      fetch("/addToCart", {
        method: "POST",
        headers: {
          "Content-type": "application/json;charset=utf-8",
        },
        body: JSON.stringify({ pid: product.pid }),
      })
        .then((response) => response.json())
        .then((result) => {
          if (result["err"]) {
            alert("Something Went Wrong");
          } else if (result["data"] == "Not Login") {
            window.location.href = "./login";
          } else {
            addToCart.innerHTML = "Remove From Cart";
          }
          console.log(result);
        });
    } else if (p.innerHTML == "Remove From Cart") {
      fetch("/removeFromCart", {
        method: "POST",
        headers: {
          "Content-type": "application/json;charset=utf-8",
        },
        body: JSON.stringify({ pid: product.pid }),
      })
        .then((response) => response.json())
        .then((result) => {
          if (result["err"]) {
            alert("Something Went Wrong");
          } else {
            addToCart.innerHTML = "Add To Cart";
          }
          console.log(result);
        });
    }
  });

  const viewMore = document.createElement("button");
  viewMore.classList.add("primaryButton");
  viewMore.innerHTML = "View More";
  div2.appendChild(viewMore);

  viewMore.addEventListener("click", () => {
    pop_up.style.display = "block";

    product_details.innerHTML = "";

    fetch("/getProduct", {
      method: "POST",
      headers: {
        "Content-type": "application/json;charset=utf-8",
      },
      body: JSON.stringify({ product_id: product.product_id }),
    })
      .then((response) => response.json())
      .then((result) => {
        let product = result["data"];
        let img = document.createElement("img");
        img.src = "uploads/" + product.imageurl;
        img.classList.add("product_img");

        let div = document.createElement("div");
        div.classList.add("product_card_side");

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
        div1.appendChild(description);

        const div2 = document.createElement("div");

        const addToCart = document.createElement("button");
        addToCart.classList.add("secondaryButton");
        addToCart.innerHTML = "Add To Cart";
        div2.appendChild(addToCart);

        addToCart.addEventListener("click", (event) => {
          event.stopPropagation();
          if (addToCart.innerHTML == "Add To Cart") {
            fetch("/addToCart", {
              method: "POST",
              headers: {
                "Content-type": "application/json;charset=utf-8",
              },
              body: JSON.stringify({ pid: product.pid }),
            })
              .then((response) => response.json())
              .then((result) => {
                if (result["err"]) {
                  alert("Something Went Wrong");
                } else if (result["data"] == "Not Login") {
                  window.location.href = "./login";
                } else {
                  addToCart.innerHTML = "Remove From Cart";
                }
                console.log(result);
              });
          } else if (p.innerHTML == "Remove From Cart") {
            fetch("/removeFromCart", {
              method: "POST",
              headers: {
                "Content-type": "application/json;charset=utf-8",
              },
              body: JSON.stringify({ pid: product.pid }),
            })
              .then((response) => response.json())
              .then((result) => {
                if (result["err"]) {
                  alert("Something Went Wrong");
                } else {
                  addToCart.innerHTML = "Add To Cart";
                }
                console.log(result);
              });
          }
        });

        const buyNow = document.createElement("button");
        buyNow.classList.add("primaryButton");
        buyNow.innerHTML = "Buy Now";
        div2.appendChild(buyNow);

        buyNow.addEventListener("click", (event) => {
          event.stopPropagation();
          fetch("/addToCart", {
            method: "POST",
            headers: {
              "Content-type": "application/json;charset=utf-8",
            },
            body: JSON.stringify({ pid: product.pid }),
          })
            .then((response) => response.json())
            .then((result) => {
              if (result["err"]) {
                alert("Something Went Wrong");
              } else if (result["data"] == "Not Login") {
                window.location.href = "./login";
              } else {
                window.location.href = "./cart";
              }
              console.log(result);
            });
        });

        div.append(div1);
        div.append(div2);

        product_details.append(img);
        product_details.append(div);
      });
  });

  productUI.appendChild(productImg);
  productUI.appendChild(div1);
  productUI.appendChild(description);
  productUI.appendChild(div2);
  productUI.appendChild(document.createElement("br"));
  items.appendChild(productUI);
}

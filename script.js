// SEARCH DAN KERANJANG START

// Variables to handle DOM elements
const openShopping = document.querySelector(".fa-shopping-cart");
const list = document.querySelector(".menu-row");
const listCart = document.querySelector(".listCart");
const body = document.querySelector("body");
const total = document.querySelector(".total");
const quantity = document.querySelector(".cart-count");
const cart = document.querySelector(".cart");
const searchIcon = document.querySelector(".search-icon");
const searchContent = document.querySelector(".search-content");
const searchInput = document.getElementById("searchInput");

let products = []; // To store products from the API
let listCarts = {}; // To store items in the cart

// Toggle the cart visibility
openShopping.addEventListener("click", () => {
  body.classList.toggle("active");
});

// Close the cart when clicking outside of it
document.addEventListener("click", (e) => {
  if (
    !cart.contains(e.target) &&
    !openShopping.contains(e.target) &&
    !isQuantityButton(e.target)
  ) {
    body.classList.remove("active");
  }
});

// Event listener to toggle search bar visibility
searchIcon.addEventListener("click", () => {
  searchContent.style.display =
    searchContent.style.display === "none" || searchContent.style.display === ""
      ? "flex"
      : "none";
});

// Event listener to close search bar when clicking outside
document.addEventListener("click", (e) => {
  if (!searchIcon.contains(e.target) && !searchContent.contains(e.target)) {
    searchContent.style.display = "none";
  }
});

// Function to check if the target element is a quantity button
function isQuantityButton(target) {
  return target.classList.contains("count") || target.tagName === "BUTTON";
}

// Function to initialize the app by fetching and displaying products
async function initApp() {
  try {
    const response = await fetch("produk.php"); // Adjust the path to your API
    if (!response.ok) {
      throw new Error("Failed to fetch products");
    }
    products = await response.json();
    displayProducts(products);
  } catch (error) {
    console.error("Error fetching products:", error);
    // Handle error condition (e.g., display an error message to the user)
  }
}

// Function to handle search functionality
function searchProducts() {
  const searchTerm = searchInput.value.trim().toLowerCase();
  const filteredProducts = products.filter((product) =>
    product.nama_produk.toLowerCase().includes(searchTerm)
  );
  displayProducts(filteredProducts);
}

// Close search bar when Enter is pressed
searchInput.addEventListener("keydown", function (e) {
  if (e.keyCode === 13) {
    e.preventDefault();
    searchProducts();
  }
});

// Event listener for clearing search input
searchInput.addEventListener("input", function () {
  if (this.value.trim() === "") {
    displayProducts(products);
  }
});

// Function to add products to the cart
function addToCart(produkId) {
  const key = produkId; // Using produk_id as key
  const selectedProduct = products.find(
    (product) => product.produk_id === produkId
  );

  if (!listCarts[key]) {
    listCarts[key] = { ...selectedProduct, quantity: 1 }; // Initialize with quantity 1
  } else {
    listCarts[key].quantity += 1; // Increment quantity if already in cart
  }
  reloadCart(); // Update cart UI
}

// Reload cart and display updated contents
function reloadCart() {
  listCart.innerHTML = "";
  let count = 0;
  let totalPrice = 0;

  Object.keys(listCarts).forEach((key) => {
    const value = listCarts[key];
    totalPrice += value.harga * value.quantity;
    count += value.quantity;

    const newDiv = document.createElement("li");
    newDiv.innerHTML = `
      <div><img src="${value.img}" alt="${value.nama_produk}" /></div>
      <div>${value.nama_produk}</div>
      <div>Rp ${(value.harga * value.quantity).toLocaleString()}</div>
      <div>
        <button onclick="changeQuantity('${key}', ${
      value.quantity - 1
    })">-</button>
        <div class="count">${value.quantity}</div>
        <button onclick="changeQuantity('${key}', ${
      value.quantity + 1
    })">+</button>
      </div>`;
    listCart.appendChild(newDiv);
  });

  total.innerText = "Rp " + totalPrice.toLocaleString();
  quantity.innerText = count;
}

async function changeQuantity(key, qty) {
  if (qty === 0) {
    delete listCarts[key]; // Hapus dari listCarts lokal
    await removeFromCart(key); // Hapus dari database
  } else {
    listCarts[key].quantity = qty; // Update quantity di listCarts lokal
  }
  reloadCart(); // Perbarui UI keranjang
}

// Fungsi untuk menghapus item dari keranjang di database
async function removeFromCart(produkId) {
  try {
    const response = await fetch("deletecart.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        produk_id: produkId,
      }),
    });
    if (!response.ok) {
      throw new Error("Failed to remove item from cart");
    }
    console.log("Item removed successfully");
  } catch (error) {
    console.error("Error removing item from cart:", error);
  }
}

// Function to display products or "Product not found" message based on search results
function displayProducts(productsToShow) {
  list.innerHTML = "";

  if (productsToShow.length === 0) {
    const notFoundDiv = document.createElement("div");
    notFoundDiv.classList.add("not-found");
    notFoundDiv.textContent = "Produk yang anda cari tidak ditemukan";
    list.appendChild(notFoundDiv);
  } else {
    productsToShow.forEach((product) => {
      const newDiv = document.createElement("div");
      newDiv.classList.add("menu");
      newDiv.innerHTML = `
        <div class="img">
          <img src="${product.img}" alt="${product.nama_produk}" />
        </div>
        <div class="product-content">
          <h3>${product.nama_produk}</h3>
          <p>${product.deskripsi}</p>
          <span class="price">Rp ${parseFloat(
            product.harga
          ).toLocaleString()}</span>
          <div class="orderNow">
            <button data-key="${product.produk_id}" onclick="addToCart('${
        product.produk_id
      }')">Order Now</button>
          </div>
        </div>`;
      list.appendChild(newDiv);
    });
  }
}

// Function to initialize cart items from the server
async function initCart() {
  try {
    const response = await fetch("cart.php"); // Adjust the path to your API
    if (!response.ok) {
      throw new Error("Failed to fetch cart items");
    }
    const cartItems = await response.json();
    listCarts = cartItems.reduce((acc, item) => {
      acc[item.produk_id] = item;
      return acc;
    }, {});
    reloadCart(); // Update cart UI
  } catch (error) {
    console.error("Error fetching cart items:", error);
    // Handle error condition (e.g., display an error message to the user)
  }
}

// Initialize the application
initApp();
initCart(); // Initialize the cart items

// Function to submit cart items to the backend
async function submitCart() {
  const response = await fetch("submit_cart.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      items: Object.values(listCarts),
    }),
  });

  if (response.ok) {
    alert("Cart successfully submitted!");
    listCarts = [];
    reloadCart();
    window.location.href = "beli.php"; // Redirect to beli.php after successful submission
  } else {
    const result = await response.json();
    console.error(`Failed to submit cart: ${result.message}`);
  }
}

// Attach the submitCart function to the form submission
document.querySelector(".cart").addEventListener("submit", (e) => {
  e.preventDefault();
  submitCart();
});

//
// BLOGS
var swiper = new Swiper(".blogs-row", {
  spaceBetween: 30,
  loop: true,
  centeredSlides: true,
  autoplay: {
    delay: 9500,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextE1: ".swiper-button-next",
    prevE1: ".swiper-button-prev",
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
    768: {
      slidesPerView: 1,
    },
    1024: {
      slidesPerView: 1,
    },
  },
});

// REVIEW
var swiper = new Swiper(".review-row", {
  spaceBetween: 30,
  loop: true,
  centeredSlides: true,
  autoplay: {
    delay: 9500,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
    768: {
      slidesPerView: 2,
    },
    1024: {
      slidesPerView: 3,
    },
  },
});

// Sidebar
// Mendapatkan elemen ikon menu
const menuBar = document.getElementById("menu-bar");
// Mendapatkan elemen sidebar
const sidebar = document.getElementById("mySidebar");

// Menambahkan event listener untuk mengaktifkan fungsi toggleSidebar saat ikon menu diklik
menuBar.addEventListener("click", () => {
  if (sidebar.style.right === "0px") {
    sidebar.style.right = "-500px";
  } else {
    sidebar.style.right = "0px";
  }
});
// Menambahkan event listener untuk menutup sidebar saat klik di sembarang bagian
document.addEventListener("click", (e) => {
  if (!sidebar.contains(e.target) && e.target !== menuBar) {
    sidebar.style.right = "-500px";
  }
});

// USER MENU
document.getElementById("user").addEventListener("click", function () {
  var userMenu = document.getElementById("user-menu");
  if (userMenu.style.display === "block") {
    userMenu.style.display = "none";
  } else {
    userMenu.style.display = "block";
  }
});

// Optional: Close the menu when clicking outside of it
window.addEventListener("click", function (event) {
  if (!event.target.matches("#user")) {
    var userMenu = document.getElementById("user-menu");
    if (userMenu.style.display === "block") {
      userMenu.style.display = "none";
    }
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll(".add-to-cart");

  buttons.forEach((button) => {
    button.addEventListener("click", function () {
      const id = this.dataset.id;

      fetch("api/add-to-cart.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "id=" + id,
      })
        .then((response) => response.json())
        .then((data) => {
          document.getElementById("cart-count").textContent = Object.values(
            data.cart,
          ).reduce((a, b) => a + b, 0);

          alert(data.message);
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    });
  });
});

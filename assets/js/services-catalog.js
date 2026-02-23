document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".add-to-cart").forEach((button) => {
    button.addEventListener("click", function () {
      let serviceId = this.dataset.id;

      fetch("api/add-to-cart.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "id=" + serviceId,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            // Actualizar contador dinámico
            document.getElementById("cart-count").textContent = Object.values(
              data.cart,
            ).reduce((a, b) => a + b, 0);
          }

          alert(data.message);
        });
    });
  });
});

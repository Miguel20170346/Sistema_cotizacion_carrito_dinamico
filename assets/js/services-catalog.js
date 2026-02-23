document.addEventListener("DOMContentLoaded", function () {
  const cartContent = document.getElementById("cart-content");
  const cartTotals = document.getElementById("cart-totals");

  // Función para actualizar la vista del carrito
  function refreshCartUI(cartData) {
    let totalItems = Object.values(cartData).reduce((a, b) => a + b, 0);
    document.getElementById("cart-count").textContent = totalItems;

    if (totalItems === 0) {
      cartContent.innerHTML =
        '<p class="text-center">El carrito está vacío</p>';
      cartTotals.classList.add("d-none");
      return;
    }

    // Aquí deberías hacer un fetch para obtener los nombres/precios
    // o manejar un array de servicios en JS. Por ahora, mostramos IDs y Cantidad:
    cartContent.innerHTML = "";
    for (const [id, qty] of Object.entries(cartData)) {
      cartContent.innerHTML += `
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                    <div>
                        <small class="d-block fw-bold">Servicio ID: ${id}</small>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary update-qty" data-id="${id}" data-action="remove">-</button>
                            <span class="px-3 border">${qty}</span>
                            <button class="btn btn-outline-secondary update-qty" data-id="${id}" data-action="add">+</button>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-danger remove-item" data-id="${id}">🗑</button>
                </div>`;
    }
    cartTotals.classList.remove("d-none");
  }

  // Evento: Añadir al carrito
  document.querySelectorAll(".add-to-cart").forEach((button) => {
    button.addEventListener("click", function () {
      let id = this.dataset.id;
      fetch("api/add-to-cart.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "id=" + id,
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) refreshCartUI(data.cart);
          alert(data.message);
        });
    });
  });

  // Delegación de eventos para botones dentro del carrito (+, -, eliminar)
  cartContent.addEventListener("click", function (e) {
    if (e.target.classList.contains("update-qty")) {
      const id = e.target.dataset.id;
      const action = e.target.dataset.action;
      fetch("api/update-cart.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id=${id}&action=${action}`,
      })
        .then((res) => res.json())
        .then((data) => refreshCartUI(data.cart));
    }

    if (e.target.classList.contains("remove-item")) {
      const id = e.target.dataset.id;
      fetch("api/remove-from-cart.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id=${id}`,
      })
        .then((res) => res.json())
        .then((data) => refreshCartUI(data.cart));
    }
  });
});

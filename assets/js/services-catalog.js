document.addEventListener("DOMContentLoaded", function () {
  const cartContent = document.getElementById("cart-content");
  const cartTotals = document.getElementById("cart-totals");
  const categoryFilter = document.getElementById("category-filter");
  // NUEVO: Cargar el carrito usando los datos inyectados desde PHP al recargar
  if (window.initialCartData) {
      refreshCartUI(window.initialCartData);
  }

  // Función para filtrar servicios por categoría
  function filterByCategory(category) {
    const cards = document.querySelectorAll(".custom-card");
    cards.forEach((card) => {
      const categoryElement = card.querySelector(".text-primary");
      if (!category || categoryElement.textContent.trim() === category) {
        card.parentElement.style.display = "block";
      } else {
        card.parentElement.style.display = "none";
      }
    });
  }

  // Evento: Cambiar categoría en el selector
  if (categoryFilter) {
    categoryFilter.addEventListener("change", function () {
      filterByCategory(this.value);
    });
  }

  // Función para actualizar la vista del carrito
  // Actualizamos la firma para recibir el objeto completo 'data'
function refreshCartUI(data) {
  const cartData = data.cart;
  let totalItems = Object.values(cartData).reduce((a, b) => a + b, 0);
  document.getElementById("cart-count").textContent = totalItems;

  if (totalItems === 0) {
    cartContent.innerHTML = '<p class="text-center">El carrito está vacío</p>';
    cartTotals.classList.add("d-none");
    return;
  }

  cartContent.innerHTML = "";
  for (const [id, qty] of Object.entries(cartData)) {
    
    // Variables por defecto por si el backend tarda en responder
    let nombre = `Servicio ID: ${id}`;
    let subtotalItem = "0.00";

    // Extraemos los datos hermosos que nos acaba de mandar PHP
    if (data.totals && data.totals.itemsDetalle && data.totals.itemsDetalle[id]) {
        nombre = data.totals.itemsDetalle[id].nombre;
        subtotalItem = data.totals.itemsDetalle[id].subtotal;
    }

    // Nuevo diseño con nombre y subtotal individual a la par de los botones
    cartContent.innerHTML += `
              <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                  <div class="flex-grow-1 pe-3">
                      <small class="d-block fw-bold mb-1 text-dark">${nombre}</small>
                      <div class="d-flex align-items-center justify-content-between mt-1">
                          <div class="btn-group btn-group-sm shadow-sm">
                              <button class="btn btn-outline-secondary update-qty fw-bold" data-id="${id}" data-action="remove">-</button>
                              <span class="px-3 border d-flex align-items-center bg-light">${qty}</span>
                              <button class="btn btn-outline-secondary update-qty fw-bold" data-id="${id}" data-action="add">+</button>
                          </div>
                          <span class="text-success fw-bold small ms-2">$${subtotalItem}</span>
                      </div>
                  </div>
                  <button class="btn btn-sm btn-danger remove-item shadow-sm" data-id="${id}" title="Eliminar servicio">🗑</button>
              </div>`;
  }
  cartTotals.classList.remove("d-none");

  // NUEVO: Mostrar los cálculos automáticos en el HTML
  if (data.totals) {
    const subtotalEl = document.getElementById('st-val');
    const descuentoEl = document.getElementById('ds-val');
    const ivaEl = document.getElementById('iva-val');
    const totalEl = document.getElementById('total-val');

    if (subtotalEl) subtotalEl.textContent = '$' + data.totals.subtotal;
    if (descuentoEl) descuentoEl.textContent = '-$' + data.totals.descuento;
    if (ivaEl) ivaEl.textContent = '$' + data.totals.iva;
    if (totalEl) totalEl.textContent = '$' + data.totals.total;
}
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
            if (data.success) {
                refreshCartUI(data); // Pasamos 'data' completo
                Swal.fire({
                    toast: true, position: 'top-begin', icon: 'success',
                    title: data.message, showConfirmButton: false, timer: 3000
                });
            } else {
                Swal.fire({ icon: 'warning', title: 'Atención', text: data.message });
            }
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
        .then((data) => refreshCartUI(data)); // Pasamos 'data' completo
    }

    if (e.target.classList.contains("remove-item")) {
        const id = e.target.dataset.id;
        fetch("api/remove-from-cart.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${id}`,
        })
        .then((res) => res.json())
        .then((data) => refreshCartUI(data)); // Pasamos 'data' completo
    }
});

const checkoutForm = document.getElementById("checkout-form");
  const cartTotalsBox = document.getElementById("cart-totals");

  // Mostrar el formulario solo si el carrito no está vacío
  function toggleCheckoutForm() {
      const currentCount = parseInt(document.getElementById("cart-count").textContent) || 0;
      if (currentCount > 0) {
          checkoutForm.classList.remove("d-none");
          cartTotalsBox.classList.remove("d-none");
      } else {
          checkoutForm.classList.add("d-none");
      }
  }
  
  // Ejecutarlo al cargar la página o mutar el carrito
  const observer = new MutationObserver(toggleCheckoutForm);
  observer.observe(document.getElementById("cart-count"), { childList: true });

 // Procesar cotización con Validación Frontend (Requerimiento Dual)
  checkoutForm.addEventListener("submit", function (e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      const nombre = formData.get('nombre').trim();
      const email = formData.get('email').trim();
      const telefono = formData.get('telefono').trim();

      // 1. Validar subtotal >= $100 desde el Frontend
      const subtotalText = document.getElementById('st-val').textContent.replace('$', '').replace(',', '');
      if (parseFloat(subtotalText) < 100) {
          Swal.fire({ icon: 'warning', title: 'Monto insuficiente', text: 'El subtotal debe ser mínimo de $100.00' });
          return;
      }

      // 2. Validación con Expresiones Regulares (Regex)
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
          Swal.fire({ icon: 'error', title: 'Correo Inválido', text: 'Por favor, ingresa un correo electrónico válido.' });
          return;
      }

      const phoneRegex = /^[\d\s\-+]{8,}$/; // Mínimo 8 caracteres, acepta números, espacios, guiones y +
      if (!phoneRegex.test(telefono)) {
          Swal.fire({ icon: 'error', title: 'Teléfono Inválido', text: 'El teléfono debe tener al menos 8 dígitos.' });
          return;
      }

      // Si todo está correcto, enviamos por AJAX
      fetch("api/process-quote.php", {
          method: "POST",
          body: formData
      })
      .then(res => res.json())
      .then(data => {
          if (data.success) {
              refreshCartUI({ cart: {}, totals: null });
              this.reset();
              
              const offcanvasEl = document.getElementById('cartPanel');
              bootstrap.Offcanvas.getInstance(offcanvasEl).hide();

              // Llenar datos en el Modal Mejorado
              document.getElementById("modal-codigo").textContent = data.quote.codigo;
              document.getElementById("modal-cliente").textContent = data.quote.cliente.nombre;
              document.getElementById("modal-empresa").textContent = data.quote.cliente.empresa || "N/A";
              
              // Formatear fechas para que se vean bonitas (DD/MM/YYYY)
              const fEmision = new Date(data.quote.fecha).toLocaleDateString('es-ES');
              const fValidez = new Date(data.quote.validez).toLocaleDateString('es-ES');
              document.getElementById("modal-fecha").textContent = fEmision;
              document.getElementById("modal-validez").textContent = fValidez;

              new bootstrap.Modal(document.getElementById('quoteModal')).show();
          } else {
              Swal.fire({ icon: 'warning', title: 'Atención', text: data.message });
          }
      }).catch(err => {
          console.error("Error del servidor:", err);
          Swal.fire({ icon: 'error', title: 'Error', text: 'Error interno al procesar.' });
      });
  });
  toggleCheckoutForm();
});
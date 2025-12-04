const cartBox = document.querySelector(".cart-box");
const carrito = JSON.parse(localStorage.getItem("carrito")) || [];

if (carrito.length === 0) {
  cartBox.innerHTML = `<p class="muted">Tu carrito está vacío.</p>
  <div style="display:flex;justify-content:space-between;font-weight:700;margin-top:20px">
    <span>Total</span>
    <span>$0.00</span>
  </div>`;
} else {

  let total = 0;
  let html = "";

  carrito.forEach((p, index) => {
    const subtotal = p.precio * p.cantidad;
    total += subtotal;

    html += `
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
        <div>
          <strong>${p.nombre}</strong><br>
          <span class="muted">$${p.precio} x ${p.cantidad}</span>
        </div>
        <button onclick="eliminar(${index})" class="btn">X</button>
      </div>
    `;
  });

  html += `
    <hr style="border-color:rgba(255,255,255,0.1)">
    <div style="display:flex;justify-content:space-between;font-weight:700;margin-top:20px">
      <span>Total</span>
      <span>$${total}</span>
    </div>
  `;

  cartBox.innerHTML = html;
}

function eliminar(index) {
  const carrito = JSON.parse(localStorage.getItem("carrito")) || [];
  carrito.splice(index, 1);
  localStorage.setItem("carrito", JSON.stringify(carrito));
  location.reload();
}

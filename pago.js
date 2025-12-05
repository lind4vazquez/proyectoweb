const carrito = JSON.parse(localStorage.getItem("carrito")) || [];
const totalConfig = Number(localStorage.getItem("totalConfig")) || 0;

let total = 0;
if (totalConfig > 0) {
  total = totalConfig;
} else {
  carrito.forEach(p => {
    total += p.precio * p.cantidad;
  });
}

const totalPagoSpan = document.getElementById("totalPago");
const totalPagoInput = document.getElementById("totalPagoInput");

if (totalPagoSpan) {
  totalPagoSpan.textContent = "$" + total.toFixed(2);
}
if (totalPagoInput) {
  // poner el valor sin el signo para que PHP lo reciba bien (ej: 120.50)
  totalPagoInput.value = total.toFixed(2);
}

// (Opcional) asegurar que justo antes de enviar se actualice el input
const formPago = document.getElementById("formPago");
if (formPago) {
  formPago.addEventListener("submit", () => {
    totalPagoInput.value = total.toFixed(2);
  });
}

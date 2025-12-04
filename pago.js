const carrito = JSON.parse(localStorage.getItem("carrito")) || [];

let total = 0;

carrito.forEach(p => {
  total += p.precio * p.cantidad;
});

const totalPago = document.getElementById("totalPago");

if (totalPago) {
  totalPago.textContent = "$" + total;
}

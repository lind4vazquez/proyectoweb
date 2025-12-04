const carrito = JSON.parse(localStorage.getItem("carrito")) || [];
const totalConfig = Number(localStorage.getItem("totalConfig")) || 0;

let total = 0;

// Si viene del configurador
if (totalConfig > 0) {
  total = totalConfig;
} 
// Si viene del carrito normal
else {
  carrito.forEach(p => {
    total += p.precio * p.cantidad;
  });
}

const totalPago = document.getElementById("totalPago");

if (totalPago) {
  totalPago.textContent = "$" + total;
}

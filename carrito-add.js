document.addEventListener("click", function(e) {
  if (e.target && e.target.id === "addToCartBtn") {

    const producto = window.productoActual;

    if (!producto) {
      alert("Error: producto no detectado");
      return;
    }

    const carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    const productoCarrito = {
      id: producto.id,
      nombre: producto.nombre,
      precio: producto.precio,
      imagen: producto.imagenes[0],
      categoria: producto.categoria,
      cantidad: 1
    };

    const existente = carrito.find(p => p.id === productoCarrito.id);

    if (existente) {
      existente.cantidad += 1;
    } else {
      carrito.push(productoCarrito);
    }

    localStorage.setItem("carrito", JSON.stringify(carrito));

    alert("Producto agregado al carrito ✅");
  }
});

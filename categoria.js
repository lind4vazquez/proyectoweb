
document.addEventListener("DOMContentLoaded", function() {
  // Datos de ejemplo — puedes cambiar rutas/imágenes/precios
  const productsData = {
      cpu: [
          {img:"img/1.jpg", name:"Intel Core i5 12400F", meta:"6 núcleos / 12 hilos", price:"$2,890"},
          {img:"img/1.jpg", name:"Ryzen 7 5700X", meta:"8 núcleos / 16 hilos", price:"$3,999"},
          {img:"imagenes/cpu.png", name:"Intel Core i3 12100F", meta:"4 núcleos", price:"$1,850"},
          {img:"imagenes/cpu.png", name:"Ryzen 5 5600G", meta:"APU con Vega", price:"$2,390"}
      ],
      gpu: [
          {img:"img/1.jpg", name:"NVIDIA RTX 4060", meta:"8GB GDDR6", price:"$6,999"},
          {img:"img/1.jpg", name:"RTX 4070 Super", meta:"12GB GDDR6X", price:"$12,900"},
          {img:"img/1.jpg", name:"RX 6700 XT", meta:"12GB GDDR6", price:"$7,200"},
          {img:"img/1.jpg", name:"RTX 3050", meta:"8GB", price:"$3,800"}
      ],
      ram: [
          {img:"imagenes/cpu.png", name:"DDR4 16GB 3200MHz", meta:"CL16", price:"$890"},
          {img:"imagenes/cpu.png", name:"DDR4 32GB 3600MHz", meta:"Dual Channel", price:"$1,799"},
          {img:"imagenes/cpu.png", name:"DDR5 16GB 6000MHz", meta:"RGB", price:"$1,690"},
          {img:"imagenes/cpu.png", name:"DDR4 8GB 2666MHz", meta:"Básica", price:"$390"}
      ],
      mb: [
          {img:"imagenes/cpu.png", name:"B450M Pro-M2", meta:"AM4", price:"$1,250"},
          {img:"imagenes/cpu.png", name:"B660M DS3H", meta:"Intel 12/13 gen", price:"$2,150"},
          {img:"imagenes/cpu.png", name:"X570 Aorus Elite", meta:"Gaming AM4", price:"$3,990"}
      ],
      storage: [
          {img:"imagenes/cpu.png", name:"SSD NVMe 1TB", meta:"PCIe 3.0", price:"$1,299"},
          {img:"imagenes/cpu.png", name:"SSD 480GB", meta:"SATA 3", price:"$450"},
          {img:"imagenes/cpu.png", name:"SSD NVMe 2TB", meta:"PCIe 4.0", price:"$2,490"}
      ],
      psu: [
          {img:"imagenes/cpu.png", name:"Fuente 650W Bronze", meta:"Semi Modular", price:"$1,499"},
          {img:"imagenes/cpu.png", name:"450W Certificada", meta:"Económica", price:"$590"},
          {img:"imagenes/cpu.png", name:"750W Gold", meta:"Full Modular", price:"$2,199"}
      ],
      case: [
          {img:"imagenes/cpu.png", name:"Gabinete ATX RGB", meta:"Vidrio templado", price:"$1,299"},
          {img:"imagenes/cpu.png", name:"Gabinete MicroATX", meta:"Negro minimalista", price:"$890"},
          {img:"imagenes/cpu.png", name:"Gabinete Full Tower", meta:"Alto flujo de aire", price:"$1,999"}
      ]
  };

  // Elementos
  const container = document.getElementById("catProducts");
  const catButtons = Array.from(document.querySelectorAll(".cat-btn"));

  if (!container) {
    console.error("No se encontró el contenedor #catProducts. Asegúrate de haber pegado el HTML correcto.");
    return;
  }
  if (catButtons.length === 0) {
    console.error("No se encontraron botones con la clase .cat-btn.");
    return;
  }

  // Render inicial (si hay un botón activo)
  const activeBtn = catButtons.find(b => b.classList.contains("active"));
  const initialCat = activeBtn ? activeBtn.dataset.cat : catButtons[0].dataset.cat;
  renderProducts(initialCat);

  // Función de render
  function renderProducts(category) {
    container.innerHTML = ""; // limpiar
    const list = productsData[category] || [];
    if (list.length === 0) {
      container.innerHTML = "<p style='color:var(--muted)'>No hay productos en esta categoría.</p>";
      return;
    }

    list.forEach(p => {
      // Fallback imagen si la ruta no existe visualmente (no puede comprobarse por JS sin fetch),
      // así que dejamos la ruta dada; asegúrate de que existan esas rutas en tu proyecto.
      const article = document.createElement("article");
      article.className = "pro";
      article.innerHTML = `
        <div class="thumb"><img src="${p.img}" alt="${escapeHtml(p.name)}"></div>
        <strong>${escapeHtml(p.name)}</strong>
        <div class="meta">${escapeHtml(p.meta)}</div>
        <div class="price">${escapeHtml(p.price)}</div>
        <button class="add-btn">Agregar al carrito</button>
      `;
      container.appendChild(article);
    });
  }

  // Manejo click botones
  catButtons.forEach(btn => {
    btn.addEventListener("click", () => {
      catButtons.forEach(b => b.classList.remove("active"));
      btn.classList.add("active");
      const cat = btn.dataset.cat;
      renderProducts(cat);
    });
  });

  // Util: evita inyección simple
  function escapeHtml(text) {
    return text
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;");
  }
});


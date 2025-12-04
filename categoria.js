document.addEventListener("DOMContentLoaded", function() {

  // Mapeo entre botones del index → categorías del JSON
  const categoryMap = {
    cpu: "cpu",
    gpu: "gpus",
    ram: "ram",
    mb: "motherboards",
    storage: "almacenamiento",
    psu: "psu",
    case: "gabinetes"
  };

  const container = document.getElementById("catProducts");
  const catButtons = Array.from(document.querySelectorAll(".cat-btn"));

  // =======================
  //  CARGAR JSON REAL
  // =======================
  let jsonData = {};

  fetch("productos.json")
    .then(res => res.json())
    .then(data => {
      jsonData = data;
      // Render inicial
      const initialCat = catButtons[0].dataset.cat;
      renderProducts(initialCat);
    })
    .catch(err => console.error("Error cargando productos.json", err));

  // =======================
  //  RENDERIZAR
  // =======================
  function renderProducts(categoryButton) {

    const realCategory = categoryMap[categoryButton];
    const list = jsonData[realCategory] || [];

    container.innerHTML = "";

    if (list.length === 0) {
      container.innerHTML = "<p style='color:gray'>No hay productos en esta categoría.</p>";
      return;
    }

    list.forEach(item => {
      const article = document.createElement("article");
      article.className = "pro";
      article.style.cursor = "pointer";

      article.addEventListener("click", () => {
        location.href = `componentes.php?id=${item.id}`;
      });

      article.innerHTML = `
        <div class="thumb">
          <img src="${item.imagenes ? item.imagenes[0] : 'img/producto.png'}" alt="${escapeHtml(item.nombre)}">
        </div>

        <strong>${escapeHtml(item.nombre)}</strong>

        <div class="meta">
          ${item.nucleos || item.vram || item.velocidad || item.socket || item.watts || item.capacidad || item.tipo || item.formato || item.ventiladores || ""}
        </div>

        <div class="price">$${item.precio}</div>
      `;

      container.appendChild(article);
    });
  }

  // Manejo click botones
  catButtons.forEach(btn => {
    btn.addEventListener("click", () => {
      catButtons.forEach(b => b.classList.remove("active"));
      btn.classList.add("active");
      renderProducts(btn.dataset.cat);
    });
  });

  function escapeHtml(text) {
    return text.toString()
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;");
  }

});

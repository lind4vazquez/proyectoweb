<?php
session_start();
echo "<pre>";
var_dump($_SESSION);
echo "</pre>";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalle de Componente</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="componentes.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <div class="container py-5">

    <a href="index.php" class="btn btn-secondary mb-4">← Volver</a>

    <div id="product-container" class="row g-4">
      <!-- Aquí se cargará dinámicamente el componente -->
    </div>
  </div>

  <script>
    // Obtener parámetros de la URL
    const params = new URLSearchParams(window.location.search);
    const productIdParam = params.get("id");     // preferido
    const productNameParam = params.get("name"); // alternativa

    // helper: normaliza texto para comparar (slug)
    function slugify(text) {
      if (!text) return "";
      return String(text)
        .toLowerCase()
        .normalize("NFKD").replace(/[\u0300-\u036f]/g, "") // remove accents
        .replace(/[^a-z0-9]+/g, "-")
        .replace(/(^-|-$)/g, "");
    }

    // helper: extraer imagen (soporta distintos esquemas)
    function getMainImage(product) {
      if (!product) return null;
      if (Array.isArray(product.imagenes) && product.imagenes.length > 0) return product.imagenes[0];
      if (Array.isArray(product.images) && product.images.length > 0) return product.images[0];
      if (product.img) return product.img;
      if (product.imagen) return product.imagen;
      if (product.imagenes && typeof product.imagenes === "string") return product.imagenes;
      return null;
    }

    // helper: get price field (number or string)
    function getPrice(product) {
      if (!product) return null;
      if (product.precio !== undefined && product.precio !== null) return product.precio;
      if (product.price !== undefined && product.price !== null) return product.price;
      return null;
    }

    // format currency
    function formatCurrency(value) {
      if (value === null || value === undefined || value === "") return "$ --";
      // if already string with $ leave it
      if (typeof value === "string") {
        // try parse number from string
        const num = Number(String(value).replace(/[^0-9.-]+/g,""));
        if (!isNaN(num)) return "$" + num.toLocaleString();
        return "$" + value;
      }
      if (typeof value === "number") return "$" + value.toLocaleString();
      return String(value);
    }

    // muestra mensaje de error en el contenedor
    function showMessage(html) {
      document.getElementById("product-container").innerHTML = html;
    }

    // Validación inicial: si no hay parámetros, avisa
    if (!productIdParam && !productNameParam) {
      showMessage("<h2 class='text-danger'>No se detectó un ID o nombre de producto en la URL.</h2><p>Pasa ?id=<em>producto-id</em> o ?name=<em>Nombre+Del+Producto</em></p>");
    }

    // Cargar JSON y buscar producto
    fetch("productos.json")
      .then(res => {
        if (!res.ok) throw new Error("No se pudo cargar productos.json (status " + res.status + ")");
        return res.json();
      })
      .then(data => {
        // Unir todas las listas del JSON (no asumimos nombres de clave)
        let allProducts = [];
        Object.keys(data).forEach(key => {
          const val = data[key];
          if (Array.isArray(val)) {
            allProducts = allProducts.concat(val);
          } else if (typeof val === "object") {
            Object.values(val).forEach(v => {
              if (Array.isArray(v)) allProducts = allProducts.concat(v);
            });
          }
        });

        // Asegurarnos que cada producto tenga un id y un slug para buscar
        allProducts = allProducts.map(p => {
          const copy = Object.assign({}, p);
          if (!copy.id) {
            const name = copy.nombre || copy.name || "";
            if (name) copy.id = slugify(name);
            else copy.id = "prod-" + Math.random().toString(36).slice(2, 9);
          }
          copy._slug = slugify(copy.id || copy.nombre || copy.name || "");
          const nameForSlug = copy.nombre || copy.name || "";
          copy._nameSlug = slugify(nameForSlug);
          return copy;
        });

        // función de búsqueda robusta (igual que antes)
        function findProduct() {
          if (productIdParam) {
            const pid = productIdParam.trim().toLowerCase();
            let found = allProducts.find(p => (String(p.id || "").toLowerCase() === pid));
            if (found) return found;
            const pidSlug = slugify(productIdParam);
            found = allProducts.find(p => p._slug === pidSlug || p._nameSlug === pidSlug);
            if (found) return found;
          }
          if (productNameParam) {
            const pnameSlug = slugify(productNameParam);
            let found = allProducts.find(p => p._nameSlug === pnameSlug || p._slug === pnameSlug);
            if (found) return found;
            const pname = productNameParam.trim().toLowerCase();
            found = allProducts.find(p => {
              const nm = (p.nombre || p.name || "").toLowerCase();
              return nm.includes(pname);
            });
            if (found) return found;
          }
          if (productIdParam) {
            const cleaned = productIdParam.replace(/[^a-z0-9]/gi, "").toLowerCase();
            const found = allProducts.find(p => ((p.id || "").replace(/[^a-z0-9]/gi, "").toLowerCase() === cleaned));
            if (found) return found;
          }
          return null;
        }


        const producto = findProduct();
        window.productoActual = producto;

        if (!producto) {
          // sugerencias
          const suggestions = [];
          const query = (productIdParam || productNameParam || "").toLowerCase().replace(/\+/g, " ").trim();
          if (query) {
            allProducts.forEach(p => {
              const name = (p.nombre || p.name || "").toLowerCase();
              if (name.includes(query) && suggestions.length < 6) suggestions.push({id: p.id, nombre: (p.nombre || p.name)});
            });
          }

          let html = "<h2 class='text-danger'>Producto no encontrado.</h2>";
          if (query) html += `<p class="text-muted">No se encontró "${escapeHtml(query)}" en el catálogo.</p>`;
          if (suggestions.length > 0) {
            html += "<h5>Quizá buscabas:</h5><ul>";
            suggestions.forEach(s => {
              html += `<li><a href="componentes.php?id=${encodeURIComponent(s.id)}">${escapeHtml(s.nombre)}</a></li>`;
            });
            html += "</ul>";
          } else {
            html += "<p class='text-muted'>Verifica que la URL incluya el parámetro <code>?id=producto-id</code> o <code>?name=Nombre+Del+Producto</code>.</p>";
          }
          showMessage(html);
          return;
        }

        // Ahora: construir lista de detalles completos usando todos los campos relevantes
        const imagen = getMainImage(producto);
        const precioRaw = getPrice(producto);
        const precioFormatted = formatCurrency(precioRaw);
        const nombre = producto.nombre || producto.name || producto.id || "Producto";
        const categoria = producto.categoria || producto.category || producto.tipo || "";
        // Campos comunes
        const mapaCampos = {
          socket: "Socket",
          nucleos: "Núcleos",
          vram: "VRAM",
          velocidad: "Velocidad",
          tipo: "Tipo",
          tipoRam: "Tipo de RAM",
          ram: "RAM",
          watts: "Potencia (W)",
          potencia: "Potencia (W)",
          capacidad: "Capacidad",        // ✅ NUEVO (almacenamiento)
          formato: "Formato",            // ✅ NUEVO (gabinetes)
          ventiladores: "Ventiladores",  // ✅ NUEVO (gabinetes)
          precio: "Precio",
          precio_formato: "Precio"
        };

        // recopilar detalles en orden preferido
        const detallesOrden = ["socket","nucleos","vram","velocidad","tipo","tipoRam","ram","watts","potencia","velocidad","categoria"];
        const detallesList = [];

        // añadir precio y categoria primero visibles ya
        // recorrer keys del producto y mapear
        Object.keys(producto).forEach(key => {
          const val = producto[key];
          // ignorar imagenes y nombre que ya mostramos
          if (["imagenes","images","img","imagen","nombre","name","id"].includes(key)) return;
          // precio lo manejamos aparte
          if (key === "precio" || key === "price") {
            // skip here, we'll show precioFormatted
            return;
          }
          // if known field map
          if (mapaCampos[key]) {
            detallesList.push({label: mapaCampos[key], value: val});
          }
        });

        // preparar 'otros' con campos no ya añadidos
        const usados = new Set(["imagenes","images","img","imagen","nombre","name","id","precio","price"]);
        Object.keys(producto).forEach(key => {
          if (usados.has(key)) return;
          // if already mapped above, skip
          if (mapaCampos[key]) { usados.add(key); return; }
        });

        // FEATURES / CARACTERISTICAS
        const caracteristicas = producto.caracteristicas || producto.features || producto.detalles || producto.detail || null;

        // Construcción de HTML dinámico (sin cambiar estilo)
        let detallesHtml = "";
        // siempre mostramos algunos campos principales de forma clara
        detallesHtml += `<p class="text-muted">Categoría: ${escapeHtml(categoria || "Componente")}</p>`;
        detallesHtml += `<p><strong>Precio:</strong> ${escapeHtml(precioFormatted)}</p>`;

        // mostrar detalles mapeados (en orden lógico)
        if (detallesList.length > 0) {
          detallesHtml += `<h5 class="mt-3">Detalles</h5><ul>`;
          detallesList.forEach(d => {
            // si es array mostrar como lista, sino como texto
            if (Array.isArray(d.value)) {
              detallesHtml += `<li><strong>${escapeHtml(d.label)}:</strong> ${d.value.map(v => escapeHtml(String(v))).join(", ")}</li>`;
            } else {
              detallesHtml += `<li><strong>${escapeHtml(d.label)}:</strong> ${escapeHtml(String(d.value))}</li>`;
            }
          });
          detallesHtml += `</ul>`;
        }

        // características (si hay)
        if (caracteristicas && Array.isArray(caracteristicas) && caracteristicas.length > 0) {
          detallesHtml += `<h5 class="mt-3">Características</h5><ul>`;
          caracteristicas.forEach(it => detallesHtml += `<li>${escapeHtml(String(it))}</li>`);
          detallesHtml += `</ul>`;
        } else if (caracteristicas && typeof caracteristicas === "string") {
          detallesHtml += `<p class="mt-3"><strong>Características:</strong> ${escapeHtml(caracteristicas)}</p>`;
        }

        // Otros campos que no estén ya mostrados (extra)
        const mostrados = new Set(["imagenes","images","img","imagen","nombre","name","id","precio","price"]);
        Object.keys(producto).forEach(key => mostrados.add(key));
        // Actually we want to show any leftover simple fields (numbers/strings) that weren't already added via detallesList
        const leftoverItems = [];
        Object.keys(producto).forEach(key => {
          // skip ones already displayed in detallesList by checking labels
          if (["imagenes","images","img","imagen","nombre","name","id","precio","price"].includes(key)) return;
          if (mapaCampos[key]) return; // already shown
          // skip caracteristicas keys already handled
          if (["caracteristicas","features","detalles","detail"].includes(key)) return;
          const value = producto[key];
          // only show primitive types (string/number/boolean)
          if (typeof value === "string" || typeof value === "number" || typeof value === "boolean") {
            leftoverItems.push({k:key,v:value});
          }
        });

        if (leftoverItems.length > 0) {
          detallesHtml += `<h5 class="mt-3">Otros detalles</h5><ul>`;
          leftoverItems.forEach(it => detallesHtml += `<li><strong>${escapeHtml(it.k)}:</strong> ${escapeHtml(String(it.v))}</li>`);
          detallesHtml += `</ul>`;
        }

        const html = `
          <div class="col-md-5 position-relative">

            

    ${imagen
      ? `<img src="${imagen}" class="product-img" alt="${escapeHtml(nombre)}">`
      : `<div class="bg-dark text-white p-5 rounded text-center">Sin imagen</div>`
    }
  </div>

  <div class="col-md-7">
    <h2>${escapeHtml(nombre)}</h2>
    <h4 class="text-success">${escapeHtml(precioFormatted)}</h4>

    ${detallesHtml}

    <button class="btn btn-success mt-3 w-100" id="addToCartBtn">Agregar al carrito</button>
  </div>
`;
        showMessage(html);
      })
      .catch(err => {
        console.error(err);
        showMessage("<h2 class='text-danger'>Error al cargar productos.json</h2><p class='text-muted'>Revisa la consola para más detalles.</p>");
      });

    // escape simple
    function escapeHtml(text) {
      if (text === undefined || text === null) return "";
      return String(text)
        .replaceAll("&", "&amp;")
        .replaceAll("<", "&lt;")
        .replaceAll(">", "&gt;");
    }
  </script>

<script src="carrito-add.js"></script>


</body>
</html>

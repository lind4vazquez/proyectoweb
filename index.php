<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Tienda PC - Demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="estilo.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body>
<div class="wrap">

  <!-- HEADER -->
  <header>
    <div class="logo">
      <div class="mark">
        <img src="imagenes/logo.png" alt="Logo">
      </div>
      <div>
        <strong>TiendaPC</strong>
        <div style="font-size:12px;color:var(--muted)">Componentes y ensamblaje</div>
      </div>
    </div>

    <div class="search-box">
      <input type="text" placeholder="Buscar productos...">
    </div>

    <nav>
      <a href="#">Inicio</a>
      <a href="registro.html">Registro</a>
      <a href="config.html">Configura tu PC</a>
    </nav>

    <a href="carrito.php">
      <button class="btn">Carrito</button>
    </a>
  </header>

  <!-- ------------------------- CARRUSEL ------------------------- -->
  <div id="carouselMain" class="carousel slide custom-carousel" data-bs-ride="carousel">
    
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="img/ti.png" class="d-block w-100" alt="Imagen 1">
      </div>
      <div class="carousel-item">
        <img src="img/re.png" class="d-block w-100" alt="Imagen 2">
      </div>
      <div class="carousel-item">
        <img src="img/pr.png" class="d-block w-100" alt="Imagen 3">
      </div>
      <div class="carousel-item">
        <img src="img/ti.png" class="d-block w-100" alt="Imagen 4">
      </div>
      <div class="carousel-item">
        <img src="img/re.png" class="d-block w-100" alt="Imagen 5">
      </div>
    </div>

    <!-- Flechas -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselMain" data-bs-slide="prev">
      <span class="carousel-control-prev-icon custom-arrow"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#carouselMain" data-bs-slide="next">
      <span class="carousel-control-next-icon custom-arrow"></span>
    </button>

  </div>

  <h1>Productos destacados</h1>

<!-- PRODUCTOS -->
<div class="products">

  <article class="pro" onclick="location.href='componentes.php?id=r5-5600x'">
    <div class="thumb"><img src="img/procesadores/4.jpg" alt="CPU"></div>
    <strong>Procesador Ryzen 5 5600X</strong>
    <div class="meta">6 núcleos / 12 hilos</div>
    <div class="price">$3,490</div>
  </article>

  <article class="pro" onclick="location.href='componentes.php?id=rtx4060'">
    <div class="thumb"><img src="img/grafica/1.jpg" alt="CPU"></div>
    <strong>NVIDIA RTX 4060 Ti</strong>
    <div class="meta">8GB GDDR6</div>
    <div class="price">$6,999</div>
  </article>

  <article class="pro" onclick="location.href='componentes.php?id=ddr4-16-3200'">
    <div class="thumb"><img src="img/almacenamiento/1.jpg" alt="CPU"></div>
    <strong>Memoria DDR4 16GB</strong>
    <div class="meta">3200MHz</div>
    <div class="price">$890</div>
  </article>

  <article class="pro" onclick="location.href='componentes.php?id=650w-bronze'">
    <div class="thumb"><img src="img/fuente/1.jpg" alt="CPU"></div>
    <strong>Fuente 650W Bronze</strong>
    <div class="meta">Modular parcial</div>
    <div class="price">$1,499</div>
  </article>

</div>

<!-- =======================
     CATEGORÍAS EXTRA
======================== -->

<h2 class="mt-5 mb-3">Para ti</h2>

<div class="category-buttons d-flex gap-3 flex-wrap mb-4">
    <button class="cat-btn" data-cat="cpu">Procesadores</button>
    <button class="cat-btn" data-cat="gpu">Tarjetas Gráficas</button>
    <button class="cat-btn" data-cat="ram">Memorias RAM</button>
    <button class="cat-btn" data-cat="mb">Placas Base</button>
    <button class="cat-btn" data-cat="storage">Almacenamiento</button>
    <button class="cat-btn" data-cat="psu">Fuentes de Poder</button>
    <button class="cat-btn" data-cat="case">Gabinetes</button>
</div>

<!-- PRODUCTOS DINÁMICOS -->
<div class="products" id="catProducts"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="categoria.js" defer></script>

</body>
</html>

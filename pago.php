<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pago con Tarjeta</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="estilo.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body{
      color:white;
    }
  </style>

</head>

<body>

<div class="wrap">

<header>
  <div class="logo">
    <div class="mark"><img src="img/logoPagina.jpg" alt=""></div>
    <h2>Pago</h2>
  </div>
</header>

<div class="container mt-4">

  <div class="case-box p-4">
    <h3 class="text-center mb-3">Pago con Tarjeta</h3>

    <form id=formPago action="seguimiento.php" method="post">
      <input type="hidden" id="totalPagoInput" name="totalPago">


      <!-- DATOS DE TARJETA -->
      <div class="mb-3">
        <label class="form-label">Número de Tarjeta</label>
        <input type="text" class="form-control custom-select" placeholder="0000 0000 0000 0000" maxlength="19" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Nombre del Titular</label>
        <input type="text" class="form-control custom-select" placeholder="Como aparece en la tarjeta" required>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Fecha de Expiración</label>
          <input type="month" class="form-control custom-select" required>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">CVV</label>
          <input type="text" class="form-control custom-select" maxlength="4" placeholder="123" required>
        </div>
      </div>

      <!-- DIRECCIÓN DE ENVÍO -->
      <hr class="my-4">
      <h5 class="text-center mb-3">Dirección de Envío</h5>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Estado</label>
          <input type="text" class="form-control custom-select" placeholder="Estado" name="estado" required>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Ciudad</label>
          <input type="text" class="form-control custom-select" placeholder="Ciudad" estado="ciudad" required>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Código Postal</label>
          <input type="text" class="form-control custom-select" placeholder="00000" name="cp" required>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Colonia</label>
          <input type="text" class="form-control custom-select" placeholder="Colonia" name="colonia" required>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Calle</label>
        <input type="text" class="form-control custom-select" placeholder="Nombre de la calle" name="calle" required>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Número Exterior</label>
          <input type="text" class="form-control custom-select" placeholder="123" name="num_ex" required>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Número Interior (Opcional)</label>
          <input type="text" class="form-control custom-select" placeholder="A-2" name="num_in">
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Referencia</label>
        <textarea class="form-control custom-select" rows="2" placeholder="Casa color azul, portón negro, etc." name="referencia"></textarea>
      </div>

      <hr class="my-4">

      <div class="text-center mb-3">
        <h5>Total a Pagar</h5>
        <h3 id="totalPago">$0.00</h3>
      </div>


      <button class="btn w-100 mt-3" type="submit">Pagar Ahora</button>

    </form>

  </div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="pago.js"></script>
<script>
  const formulario = document.querySelector("form");

  formulario.addEventListener("submit", function () {
    localStorage.removeItem("carrito");
    localStorage.removeItem("totalPago");
  });
</script>
</body>
</html>

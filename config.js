let data = {};
let seleccion = {
  cpu: null,
  motherboard: null,
  ram: null,
  gpu: null,
  psu: null,
  case: null,
  almacenamiento: null
};

/* ==================================
   MODAL GENERAL
================================== */
function crearModalBase() {
  if (document.getElementById("modalConfig")) return;

  document.body.insertAdjacentHTML("beforeend", `
    <div class="modal fade" id="modalConfig" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Selector</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body text-dark" id="modalContenido"></div>
          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  `);
}

function mostrarModal(titulo, contenido, tipo = "primary") {
  crearModalBase();
  const modal = document.getElementById("modalConfig");
  modal.querySelector(".modal-title").innerText = titulo;
  modal.querySelector(".modal-header").className = `modal-header bg-${tipo} text-white`;
  document.getElementById("modalContenido").innerHTML = contenido;

  const modalBootstrap = new bootstrap.Modal(modal);
  modalBootstrap.show();
}

/* ===========================
      CARGAR JSON
=========================== */
fetch("productos.json")
  .then(res => res.json())
  .then(json => {
    data = json;
    activarBotones();
    actualizarTotal();
  });

/* ===========================
      BOTONES
=========================== */
function activarBotones() {
  const botones = document.querySelectorAll(".select-btn");
  botones.forEach((btn, index) => {
    btn.addEventListener("click", () => abrirSelector(index));
  });
}

/* ===========================
   MAPEO DE COMPONENTES
=========================== */
function abrirSelector(index) {
  const mapa = [
    "cpu",
    "motherboards",
    "ram",
    null,
    "gpus",
    "almacenamiento",
    "psu",
    "gabinetes"
  ];

  const categoria = mapa[index];

  if (!categoria) {
    mostrarModal("No disponible", "Este componente aún no está disponible.", "secondary");
    return;
  }

  const lista = aplicarFiltros(categoria);
  mostrarOpcionesEnModal(lista, categoria, index);
}

/* ===========================
   FILTROS DE COMPATIBILIDAD
=========================== */
function aplicarFiltros(cat) {
  let lista = [...data[cat]];

  if (cat === "motherboards" && seleccion.cpu) {
    lista = lista.filter(mb => mb.socket === seleccion.cpu.socket);
  }

  if (cat === "ram" && seleccion.motherboard) {
    lista = lista.filter(ram => ram.tipo === seleccion.motherboard.ram);
  }

  if (cat === "gabinetes" && seleccion.motherboard) {
    lista = lista.filter(g => g.formato === seleccion.motherboard.formato);
  }

  if (cat === "psu") {
    let consumo = 0;
    if (seleccion.cpu) consumo += parseInt(seleccion.cpu.tdp);
    if (seleccion.gpu) consumo += parseInt(seleccion.gpu.tdp);

    lista = lista.filter(psu => psu.watts >= consumo + 100);
  }

  return lista;
}

/* ===========================
   MOSTRAR OPCIONES
=========================== */
function mostrarOpcionesEnModal(lista, categoria, index) {
  if (lista.length === 0) {
    mostrarModal("Sin compatibilidad", "No hay componentes compatibles.", "danger");
    return;
  }

  let html = `<div class="list-group">`;

  lista.forEach((item, i) => {
    html += `
      <button class="list-group-item list-group-item-action"
        onclick="guardarSeleccionDesdeModal(${i}, '${categoria}', ${index})">
        <strong>${item.nombre}</strong> — $${item.precio}
      </button>
    `;
  });

  html += `</div>`;

  mostrarModal("Selecciona tu componente", html, "primary");
}

/* ===========================
   GUARDAR SELECCIÓN
=========================== */
function guardarSeleccionDesdeModal(pos, categoria, index) {
  const item = aplicarFiltros(categoria)[pos];

  const tarjetas = document.querySelectorAll(".comp-card");
  const tarjeta = tarjetas[index];

  tarjeta.querySelector("button").innerText = item.nombre;
  tarjeta.querySelector("button").classList.add("btn-success");

  const mapeoFinal = {
    cpu: "cpu",
    motherboards: "motherboard",
    ram: "ram",
    gpus: "gpu",
    psu: "psu",
    gabinetes: "case",
    almacenamiento: "almacenamiento"
  };

  seleccion[mapeoFinal[categoria]] = item;

  bootstrap.Modal.getInstance(document.getElementById("modalConfig")).hide();
  validarSistema();
  actualizarTotal();
}

/* ===========================
     TOTAL AUTOMÁTICO ✅
=========================== */
function actualizarTotal() {
  let total = 0;

  Object.values(seleccion).forEach(comp => {
    if (comp && comp.precio) {
      total += parseFloat(comp.precio);
    }
  });

  document.getElementById("totalPrecio").innerText =
    "$" + total.toLocaleString("es-MX");
}

/* ===========================
     VALIDACIÓN
=========================== */
function validarSistema() {
  if (seleccion.cpu && seleccion.motherboard) {
    if (seleccion.cpu.socket !== seleccion.motherboard.socket) {
      mostrarModal(
        "CPU incompatible",
        `El procesador <strong>${seleccion.cpu.nombre}</strong> no es compatible con la placa base <strong>${seleccion.motherboard.nombre}</strong>.`,
        "danger"
      );
    }
  }

  if (seleccion.motherboard && seleccion.ram) {
    if (seleccion.motherboard.ram !== seleccion.ram.tipo) {
      mostrarModal(
        "RAM incompatible",
        "La memoria no es compatible con la placa base.",
        "warning"
      );
    }
  }

  if (seleccion.motherboard && seleccion.case) {
    if (seleccion.case.formato !== seleccion.motherboard.formato) {
      mostrarModal(
        "Gabinete incompatible",
        "El gabinete no soporta el formato de la placa.",
        "warning"
      );
    }
  }

  if (seleccion.cpu && seleccion.gpu && seleccion.psu) {
    const consumo = parseInt(seleccion.cpu.tdp) + parseInt(seleccion.gpu.tdp);
    if (seleccion.psu.watts < consumo + 100) {
      mostrarModal(
        "Fuente insuficiente",
        "La fuente no cubre el consumo del sistema.",
        "danger"
      );
    }
  }
}

/* ===========================
   ENVIAR TOTAL A PAGO ✅
=========================== */
const btnPagar = document.getElementById("btnPagarConfig");

btnPagar.addEventListener("click", () => {
  let total = 0;

  Object.values(seleccion).forEach(comp => {
    if (comp && comp.precio) {
      total += parseFloat(comp.precio);
    }
  });

  localStorage.setItem("totalConfig", total);
  window.location.href = "pago.html";
});

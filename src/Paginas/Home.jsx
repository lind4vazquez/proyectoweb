import img1 from "../img/1.jpg";
import img2 from "../img/2.jpg";
import pr from "../img/pr.png";
import re from "../img/re.png";
import ti from "../img/ti.png";


export default function Home() {
  return (
    <div className="wrap">

      {/* HEADER */}
      <header>
        <div className="logo">
          <div className="mark">
            <img src="/imagenes/logo.png" alt="Logo" />
          </div>
          <div>
            <strong>TiendaPC</strong>
            <div style={{ fontSize: "12px", color: "var(--muted)" }}>
              Componentes y ensamblaje
            </div>
          </div>
        </div>

        <div className="search-box">
          <input type="text" placeholder="Buscar productos..." />
        </div>

        <nav>
          <a href="#">Inicio</a>
          <a href="#">Registro</a>
        </nav>

        <a href="/carrito">
          <button className="btn">Carrito</button>
        </a>
      </header>

      {/* CARRUSEL */}
      <div id="carouselMain" className="carousel slide custom-carousel" data-bs-ride="carousel">

        <div className="carousel-inner">
          <div className="carousel-item active">
            <img src={ti} className="d-block w-100" alt="Imagen 1" />
          </div>
          <div className="carousel-item">
            <img src={re} className="d-block w-100" alt="Imagen 2" />
          </div>
          <div className="carousel-item">
            <img src={pr} className="d-block w-100" alt="Imagen 3" />
          </div>
          <div className="carousel-item">
            <img src={ti} className="d-block w-100" alt="Imagen 4" />
          </div>
          <div className="carousel-item">
            <img src={re} className="d-block w-100" alt="Imagen 5" />
          </div>
        </div>

        <button className="carousel-control-prev" type="button" data-bs-target="#carouselMain" data-bs-slide="prev">
          <span className="carousel-control-prev-icon custom-arrow"></span>
        </button>

        <button className="carousel-control-next" type="button" data-bs-target="#carouselMain" data-bs-slide="next">
          <span className="carousel-control-next-icon custom-arrow"></span>
        </button>
      </div>

      <h1>Productos destacados</h1>

      {/* PRODUCTOS */}
      <div className="products">

        <article className="pro">
          <div className="thumb"><img src={img1} alt="CPU" /></div>
          <strong>Procesador Ryzen 5 5600X</strong>
          <div className="meta">6 núcleos / 12 hilos</div>
          <div className="price">$3,490</div>
          <button className="add-btn">Agregar al carrito</button>
        </article>

        <article className="pro">
          <div className="thumb"><img src={img2} alt="CPU" /></div>
          <strong>NVIDIA RTX 4060 Ti</strong>
          <div className="meta">8GB GDDR6</div>
          <div className="price">$12,999</div>
          <button className="add-btn">Agregar al carrito</button>
        </article>

        <article className="pro">
          <div className="thumb"><img src="/imagenes/cpu.png" alt="CPU" /></div>
          <strong>Memoria DDR4 16GB</strong>
          <div className="meta">3200MHz</div>
          <div className="price">$1,299</div>
          <button className="add-btn">Agregar al carrito</button>
        </article>

        <article className="pro">
          <div className="thumb"><img src="/imagenes/cpu.png" alt="CPU" /></div>
          <strong>Fuente 650W Bronze</strong>
          <div className="meta">Modular parcial</div>
          <div className="price">$1,499</div>
          <button className="add-btn">Agregar al carrito</button>
        </article>

      </div>
    </div>
  );
}

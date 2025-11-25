export default function Carrito() {
  return (
    <div style={{
      margin: 0,
      padding: "32px",
      fontFamily: "'Inter', sans-serif",
      background: "linear-gradient(180deg,#071024,#06121c)",
      color: "#e6eef6",
      minHeight: "100vh",
      display: "flex",
      justifyContent: "center"
    }}>
      
      <div className="wrap" style={{ width: "100%", maxWidth: "700px" }}>

        <a href="/" className="back" style={{ 
          display: "inline-block",
          marginBottom: "20px",
          color: "#6ee7b7",
          textDecoration: "none"
        }}>
          ← Regresar a productos
        </a>

        <h1 style={{ textAlign: "center" }}>Carrito</h1>

        <div className="cart-box" style={{
          background: "linear-gradient(180deg,#061226,#07182a)",
          padding: "20px",
          borderRadius: "12px",
          border: "1px solid rgba(255,255,255,0.03)"
        }}>
          
          <p style={{ color: "#9aa4b2" }}>Tu carrito está vacío.</p>

          <div style={{
            display: "flex",
            justifyContent: "space-between",
            fontWeight: "700",
            marginTop: "20px"
          }}>
            <span>Total</span>
            <span>$0.00</span>
          </div>
        </div>

      </div>
    </div>
  );
}

import { Routes, Route } from "react-router-dom";
import Home from "./Paginas/Home";
import Carrito from "./Paginas/Carrito";

function App() {
  return (
    <Routes>
      <Route path="/" element={<Home />} />
      <Route path="/Carrito" element={<Carrito />} />
    </Routes>
  );
}

export default App;

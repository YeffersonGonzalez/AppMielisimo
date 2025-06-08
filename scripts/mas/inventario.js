function validarProductoNuevo(nombre, precioCompra, precioVenta) {
    if (!nombre || precioCompra <= 0 || precioVenta <= 0) {
      alert("Todos los campos deben estar completos y válidos.");
      return false;
    }
    return true;
  }
  
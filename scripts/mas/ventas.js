const ivaPorcentaje = 0.16; // IVA del 16%

function agregarProducto() {
  const contenedor = document.getElementById("productos-container");

  const fila = document.createElement("div");
  fila.classList.add("row", "producto-fila", "mb-2");

  fila.innerHTML = `
    <div class="col-md-4">
      <input type="text" class="form-control nombre-producto" placeholder="Nombre del producto">
    </div>
    <div class="col-md-3">
      <input type="number" class="form-control precio" placeholder="Precio unitario">
    </div>
    <div class="col-md-3">
      <input type="number" class="form-control cantidad" placeholder="Cantidad">
    </div>
    <div class="col-md-2">
      <button type="button" class="btn btn-danger" onclick="eliminarFila(this)">X</button>
    </div>
  `;

  contenedor.appendChild(fila);
}

function eliminarFila(boton) {
  const fila = boton.closest(".producto-fila");
  fila.remove();
  calcularTotalVenta();
}

function calcularTotalVenta() {
  let subtotal = 0;

  document.querySelectorAll('.producto-fila').forEach(fila => {
    const precio = parseFloat(fila.querySelector('.precio').value) || 0;
    const cantidad = parseInt(fila.querySelector('.cantidad').value) || 0;
    subtotal += precio * cantidad;
  });

  const iva = subtotal * ivaPorcentaje;
  const total = subtotal + iva;

  document.getElementById('subtotal').innerText = subtotal.toFixed(2);
  document.getElementById('iva').innerText = iva.toFixed(2);
  document.getElementById('total').innerText = total.toFixed(2);
}

document.addEventListener('input', function (e) {
  if (e.target.classList.contains('precio') || e.target.classList.contains('cantidad')) {
    calcularTotalVenta();
  }
});

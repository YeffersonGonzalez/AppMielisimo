function generarFacturaPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
  
    doc.setFontSize(16);
    doc.text("Factura de Venta", 14, 20);
  
    const filas = [];
    document.querySelectorAll('.producto-fila').forEach(fila => {
      const nombre = fila.querySelector('.nombre-producto').value;
      const precio = parseFloat(fila.querySelector('.precio').value).toFixed(2);
      const cantidad = parseInt(fila.querySelector('.cantidad').value);
      const total = (precio * cantidad).toFixed(2);
      filas.push([nombre, cantidad, `$${precio}`, `$${total}`]);
    });
  
    doc.autoTable({
      head: [["Producto", "Cantidad", "Precio Unitario", "Total"]],
      body: filas,
      startY: 30,
    });
  
    const subtotal = document.getElementById('subtotal').innerText;
    const iva = document.getElementById('iva').innerText;
    const total = document.getElementById('total').innerText;
  
    doc.text(`Subtotal: $${subtotal}`, 14, doc.lastAutoTable.finalY + 10);
    doc.text(`IVA (16%): $${iva}`, 14, doc.lastAutoTable.finalY + 20);
    doc.text(`Total: $${total}`, 14, doc.lastAutoTable.finalY + 30);
  
    doc.save("factura_venta.pdf");
  }
  
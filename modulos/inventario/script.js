"use strict";

$(document).ready(() => {
  cargarInventario();
  cargarEstadisticas();
});

const cargarInventario = () => {
  $.post(
    "modulos/inventario/ajax.php",
    { fnc: "obtenerProductosConMovimientos" },
    (respuesta) => {
      const productos = JSON.parse(respuesta);
      let html = "";

      productos.forEach((producto) => {
        const entradas = producto.movimientos
          .filter((m) => m.tipo_movimiento === "Entrada")
          .reduce((acc, movimiento) => acc + Number(movimiento.cantidad), 0);
        const salidas = producto.movimientos
          .filter((m) => m.tipo_movimiento === "Salida")
          .reduce((acc, movimiento) => acc + Number(movimiento.cantidad), 0);

        html += `
              <tr>
                  <td>${producto.nombre}</td>
                  <td>${producto.stock_inicial}</td>
                  <td>${entradas}</td>
                  <td>${salidas}</td>
                  <td>${producto.stock_actual}</td>  <!-- Usar directamente el stock_actual del backend -->
              </tr>`;
      });

      $("#tablaInventario").html(html);
    }
  );
};

const cargarEstadisticas = () => {
  $.post(
    "modulos/inventario/ajax.php",
    { fnc: "obtenerEstadisticas" },
    (respuesta) => {
      const stats = JSON.parse(respuesta);
      $("#totalProductos").text(stats.totalProductos);
      $("#movimientosRecientes").text(stats.movimientosRecientes);
      $("#productosBajoStock").text(stats.productosBajoStock);
      $("#ultimoMovimiento").text(stats.ultimoMovimiento);
    }
  );
};

$(document).ready(function () {
  // Búsqueda para Entrada
  $("#buscarProductoEntrada").on("keyup", function () {
    let query = $(this).val();
    if (query.length >= 3) {
      $.post(
        "modulos/inventario/ajax.php",
        { fnc: "buscarProducto", producto: query },
        function (respuesta) {
          console.log(respuesta);
          let productos = JSON.parse(respuesta);
          let opciones = "";
          productos.forEach((producto) => {
            opciones += `<option value="${producto.id_producto}">${producto.nombre_producto}</option>`;
          });
          $("#productoEntrada").html(opciones);
        }
      );
    }
  });

  // Búsqueda para Salida
  $("#buscarProductoSalida").on("keyup", function () {
    let query = $(this).val();
    if (query.length >= 3) {
      $.post(
        "modulos/inventario/ajax.php",
        { fnc: "buscarProducto", producto: query },
        function (respuesta) {
          console.log(respuesta);
          let productos = JSON.parse(respuesta);
          let opciones = "";
          productos.forEach((producto) => {
            opciones += `<option value="${producto.id_producto}">${producto.nombre_producto}</option>`;
          });
          $("#productoSalida").html(opciones);
        }
      );
    }
  });
});

const guardarMovimiento = (tipo) => {
  console.log("Tipo de movimiento:", tipo);

  let id_producto = $(`#producto${tipo}`).val();
  let cantidad = $(`#cantidad${tipo}`).val();
  let motivo = $(`#motivo${tipo}`).val();
  console.log("Elemento seleccionado:", $(`#producto${tipo}`));
  console.log("ID del producto seleccionado:", id_producto); // Agregar esto

  // Validaciones básicas antes de enviar los datos
  if (!id_producto || isNaN(id_producto) || id_producto <= 0) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "ID de producto inválido.",
    });
    return;
  }

  if (!cantidad || isNaN(cantidad) || cantidad <= 0) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Cantidad inválida.",
    });
    return;
  }

  if (!motivo) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Motivo no puede estar vacío.",
    });
    return;
  }

  if (!["Entrada", "Salida"].includes(tipo)) {
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "Tipo de movimiento inválido.",
    });
    return;
  }

  $.ajax({
    url: "modulos/inventario/ajax.php",
    method: "POST",
    data: {
      fnc: "agregarMovimiento",
      id_producto: id_producto,
      cantidad: cantidad,
      motivo: motivo,
      tipo_movimiento: tipo,
    },
    success: function (respuesta) {
      console.log("Respuesta del servidor al guardar movimiento:", respuesta);

      let result = respuesta.split("|");
      if (result[0] === "1") {
        Swal.fire({
          icon: "success",
          title: "Hecho",
          text: result[1],
        }).then(() => {
          // Limpiar los campos del modal
          $(`#producto${tipo}`).val("");
          $(`#cantidad${tipo}`).val("");
          $(`#motivo${tipo}`).val("");

          // Cerrar el modal correspondiente
          if (tipo === "Entrada") {
            $("#agregarEntradaModal").modal("hide");
          } else if (tipo === "Salida") {
            $("#agregarSalidaModal").modal("hide");
          }
        });
        cargarInventario();
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: result[1],
        });
      }
    },
    error: function (xhr, status, error) {
      console.log("XHR:", xhr);
      console.log("Estado:", status);
      console.error("Error en la solicitud AJAX: ", error);
    },
  });
};

$(document).ready(function () {
  // Al hacer clic en el botón "Manipular Inv."
  $("button[data-target='#manipularInventarioModal']").on("click", function () {
    Swal.fire({
      title: "¿Qué deseas manipular?",
      showDenyButton: true,
      confirmButtonText: `Entradas`,
      denyButtonText: `Salidas`,
    }).then((result) => {
      if (result.isConfirmed) {
        cargarMovimientos("Entrada");
      } else if (result.isDenied) {
        cargarMovimientos("Salida");
      }
    });
  });

  // Búsqueda AJAX
  $("#buscarMovimiento").on("keyup", function () {
    let query = $(this).val();
    cargarMovimientos(null, query);
  });
});

function cargarMovimientos(tipo, query = "") {
  $.post(
    "modulos/inventario/ajax.php",
    { fnc: "obtenerMovimientos", tipo: tipo, query: query },
    function (respuesta) {
      let movimientos = JSON.parse(respuesta);
      let html = "";
      movimientos.forEach((movimiento) => {
        html += `
                  <tr>
                      <td>${movimiento.nombre_producto}</td>
                      <td>${movimiento.cantidad}</td>
                      <td>${movimiento.tipo_movimiento}</td>
                      <td><button class="btn btn-danger btn-sm" onclick="eliminarMovimiento(${movimiento.id_inventario})">Eliminar</button></td>
                  </tr>`;
      });
      $("#tablaMovimientos").html(html);
    }
  );
}

function eliminarMovimiento(idMovimiento) {
  $.post(
    "modulos/inventario/ajax.php",
    { fnc: "eliminarMovimiento", idMovimiento: idMovimiento },
    function (respuesta) {
      let result = respuesta.split("|");
      if (result[0] === "1") {
        Swal.fire({
          icon: "success",
          title: "Hecho",
          text: result[1],
        });
        cargarMovimientos();
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: result[1],
        });
      }
    }
  );
}

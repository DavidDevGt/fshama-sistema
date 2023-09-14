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
          .reduce((acc, movimiento) => acc + movimiento.cantidad, 0);
        const salidas = producto.movimientos
          .filter((m) => m.tipo_movimiento === "Salida")
          .reduce((acc, movimiento) => acc + movimiento.cantidad, 0);

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
  // Función para buscar un producto.
  function buscarProducto(query) {
    if (query.length > 2) {
      $("#searchFeedback").removeClass("d-none").text("Buscando...");
      $.ajax({
        type: "POST",
        url: "modulos/inventario/ajax.php",
        data: {
          fnc: "buscarProducto",
          producto: query,
        },
        dataType: "json",
        success: function (response) {
          $("#resultadosBusqueda").empty(); // Limpiar resultados anteriores
          if (response && response.length > 0) {
            $("#resultadosBusqueda").removeClass("d-none");
            response.forEach((producto) => {
              let option = $("<option>")
                .text(producto.nombre_producto)
                .val(JSON.stringify(producto)); // Guardamos todo el objeto del producto como string
              $("#resultadosBusqueda").append(option);
            });
          } else {
            $("#resultadosBusqueda").addClass("d-none");
            $("#nombreProducto").text("No encontrado");
            $(
              "#descripcionProducto, #existenciaProducto, #precioProducto, #categoriaProducto"
            ).text("");
          }
          $("#searchFeedback").addClass("d-none");
        },
        error: function () {
          $("#searchFeedback")
            .removeClass("d-none")
            .text("Error en la búsqueda. Intente de nuevo.");
        },
      });
    } else {
      $("#searchFeedback").addClass("d-none");
    }
  }

  // Escuchar el evento keyup del input de búsqueda.
  $("#busquedaProducto").on("keyup", function () {
    let query = $(this).val();
    buscarProducto(query);
  });
});

$("#resultadosBusqueda").on("change", function () {
  let productoSeleccionado = JSON.parse($(this).val()); // Convertimos el string a objeto

  $("#nombreProducto").text(
    productoSeleccionado.nombre_producto || "Desconocido"
  );
  $("#descripcionProducto").text(
    productoSeleccionado.descripcion || "Desconocido"
  );
  $("#existenciaProducto").text(
    productoSeleccionado.stock_actual || "Desconocido"
  );
  $("#precioProducto").text(productoSeleccionado.precio_venta || "Desconocido");
  $("#categoriaProducto").text(productoSeleccionado.id_categoria || "Desconocida");
});

$("#busquedaProductoModal").on('hidden.bs.modal', function () {
  $("#busquedaProducto").val('');  // Limpiamos el campo de búsqueda
  $("#nombreProducto, #descripcionProducto, #existenciaProducto, #precioProducto, #categoriaProducto").text(''); // Limpiamos los detalles del producto
  $("#resultadosBusqueda").empty().addClass('d-none');  // Limpiamos las opciones y ocultamos el select
  $("#searchFeedback").addClass("d-none");
});

"use strict";

const cargarMovimientosInventario = () => {
  $.post(
    "modulos/inventario/ajax.php",
    { fnc: "mostrar_entradas_salidas" },
    (data) => {
      const respuesta = data.split("|");
      let html = "";

      if (respuesta[0] === "1") {
        const movimientos = JSON.parse(respuesta[1]);

        movimientos.forEach((movimiento) => {
          html += `
                <tr>
                    <td>${movimiento.id_inventario}</td>
                    <td>${movimiento.id_producto}</td>
                    <td>${movimiento.fecha}</td>
                    <td>${movimiento.tipo_movimiento}</td>
                    <td>${movimiento.cantidad}</td>
                    <td>${movimiento.motivo}</td>
                    <td>
                        <!-- Aquí puedes agregar botones para editar o eliminar el movimiento si lo consideras necesario -->
                    </td>
                </tr>`;
        });
      } else {
        html =
          '<tr><td colspan="7">No hay movimientos registrados en el inventario.</td></tr>';
      }

      $("#listaMovimientos").html(html);
    }
  );
};

("use strict");

$(document).ready(function () {
  // Delegación del evento click para las filas de la tabla
  $("#tablaResultadosBusqueda").on("click", "tr", function () {
    const idProducto = $(this).data("id");
    mostrarDetalleProducto(idProducto);
  });
});

const buscarProducto = (nombre) => {
  if (nombre.length >= 3) {
    $("#tablaResultadosBusqueda").show();
    $.post(
      "modulos/inventario/ajax.php",
      { fnc: "buscar_producto_por_nombre", nombre_producto: nombre },
      (data) => {
        const respuesta = data.split("|");
        let html = "";

        if (respuesta[0] === "1") {
          const productos = JSON.parse(respuesta[1]);

          productos.forEach((producto) => {
            html += `<tr data-id="${producto.id_producto}">`;
            html += `<td>${producto.nombre_producto}</td>`;
            html += `</tr>`;
          });

          $("#tablaResultadosBusqueda").html(html);
        } else {
          $("#tablaResultadosBusqueda").html(
            "<tr><td>Producto no encontrado</td></tr>"
          );
        }
      }
    );
  } else {
    $("#tablaResultadosBusqueda").hide();
    $("#tablaResultadosBusqueda").html("");
  }
};

const mostrarDetalleProducto = (idProducto) => {
  $.post(
    "modulos/inventario/ajax.php",
    { fnc: "consultar_producto", id_producto: idProducto },
    (data) => {
      const respuesta = data.split("|");
      let html = "";

      if (respuesta[0] === "1") {
        const producto = JSON.parse(respuesta[1]);

        html += `<div class="card">
                        <div class="card-body">
                            <h5 class="card-title">${producto.nombre_producto}</h5>
                            <p class="card-text">${producto.descripcion}</p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Stock Actual:</strong> ${producto.stock_actual}</li>
                            </ul>
                        </div>
                    </div>`;

        $("#detalleProducto").html(html);
      } else {
        $("#detalleProducto").html(
          '<div class="alert alert-danger" role="alert">Producto no encontrado.</div>'
        );
      }
    }
  );
};

const limpiarCampos = () => {
  $("#busquedaProducto").val("");
  $("#tablaResultadosBusqueda").hide();
  $("#tablaResultadosBusqueda").html("");
  $("#detalleProducto").html("");
};

const seleccionarProducto = (idProducto, tipo) => {
  if (tipo === "consulta") {
    $.post(
      "modulos/inventario/ajax.php",
      { fnc: "consultar_producto", id_producto: idProducto },
      (data) => {
        const respuesta = data.split("|");
        if (respuesta[0] === "1") {
          const producto = JSON.parse(respuesta[1]);
          $("#nombreProductoConsulta").text(producto.nombre_producto);
          $("#descripcionProductoConsulta").text(producto.descripcion);
          $("#stockProductoConsulta").text(producto.stock_actual);
          $("#consultaProductoModal").modal("show");
        }
      }
    );
  } else if (tipo === "entrada" || tipo === "salida") {
    // Guardar el id del producto en un campo oculto o en un atributo 'data' para usarlo después al agregar la entrada/salida
    $("#idProductoSeleccionado").val(idProducto);
  }
};

const agregarEntrada = () => {
  const idProducto = $("#idProductoSeleccionado").val();
  const cantidad = $("#cantidadEntrada").val();
  const motivo = $("#motivoEntrada").val();

  $.post(
    "modulos/inventario/ajax.php",
    {
      fnc: "agregar_entrada_inventario",
      id_producto: idProducto,
      cantidad: cantidad,
      motivo: motivo,
    },
    (data) => {
      const respuesta = data.split("|");

      if (respuesta[0] === "1") {
        alert("Entrada agregada correctamente");
        $("#agregarEntradaModal").modal("hide");
        cargarMovimientosInventario();
      } else {
        alert("Error al agregar la entrada");
      }
    }
  );
};

const agregarSalida = () => {
  const idProducto = $("#idProductoSeleccionado").val();
  const cantidad = $("#cantidadSalida").val();
  const motivo = $("#motivoSalida").val();

  $.post(
    "modulos/inventario/ajax.php",
    {
      fnc: "agregar_salida_inventario",
      id_producto: idProducto,
      cantidad: cantidad,
      motivo: motivo,
    },
    (data) => {
      const respuesta = data.split("|");

      if (respuesta[0] === "1") {
        alert("Salida agregada correctamente");
        $("#agregarSalidaModal").modal("hide");
        cargarMovimientosInventario();
      } else {
        alert("Error al agregar la salida");
      }
    }
  );
};

$(document).ready(() => {
  cargarMovimientosInventario();

  // Inicializar los selects con un prompt
  $("#buscarYSeleccionarProductoEntrada").html(
    '<option value="">Escriba para buscar...</option>'
  );
  $("#buscarYSeleccionarProductoSalida").html(
    '<option value="">Escriba para buscar...</option>'
  );

  $("#buscarYSeleccionarProductoEntrada").on("input", function () {
    buscarProducto($(this).val(), "entrada");
  });

  $("#buscarYSeleccionarProductoSalida").on("input", function () {
    buscarProducto($(this).val(), "salida");
  });
});

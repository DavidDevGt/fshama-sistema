const listaProductos = $("#listaProductos");
const formularioProducto = $("#formularioProducto");
const btnGuardarProducto = $("#btnGuardarProducto");
const agregarProductoModal = $("#agregarProductoModal");
const productoId = $("#productoId"); // Añadido para editar
const busquedaProducto = $("#busquedaProducto");

busquedaProducto.on(
  "keyup",
  debounce(function () {
    const consulta = $(this).val();
    cargarProductos(consulta);
  }, 400)
);

const cargarProductos = (consulta = "") => {
  let data = { fnc: "mostrar_productos" };

  if (consulta) {
    data.fnc = "buscar_producto";
    data.consulta = consulta;
  }

  $.post("modulos/productos/ajax.php", data, (data) => {
    console.log(data);
    const respuesta = data.split("|");
    let html = "";

    if (respuesta[0] === "1") {
      const productos = JSON.parse(respuesta[1]);

      productos.forEach((producto) => {
        const descripcionResumida =
          producto.descripcion && producto.descripcion.length > 10
            ? producto.descripcion.substring(0, 8) + "..."
            : producto.descripcion;

        const categoriaResumida =
          producto.nombre_categoria && producto.nombre_categoria.length > 10
            ? producto.nombre_categoria.substring(0, 8) + "..."
            : producto.nombre_categoria;

        html += `
                <tr>
                    <td>${producto.id_producto}</td>
                    <td class="nombre-producto">${producto.nombre_producto}</td>
                    <td>${descripcionResumida}</td>
                    <td>${categoriaResumida}</td>
                    <td>${formatoMonedaGTQ(producto.precio_compra)}</td>
                    <td>${formatoMonedaGTQ(producto.precio_venta)}</td>
                    <td>${producto.stock_actual}</td>
                    <td>${producto.unidad_medida}</td>
                    <td>${producto.active === "1" ? "Activo" : "Inactivo"}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-success btn-sm" onclick="cargarEditarProducto(${
                              producto.id_producto
                            })">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="eliminarProducto(${
                              producto.id_producto
                            })">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </div>
                    </td>
                </tr>`;
      });
    } else {
      html =
        '<tr><td colspan="10">No hay productos que coincidan con la consulta.</td></tr>';
    }

    listaProductos.html(html);
  });
};

const guardarProducto = () => {
  const data = {
    fnc: productoId.val() ? "editar_producto" : "agregar_producto",
    id_producto: productoId.val(),
    nombre_producto: $("#nombreProducto").val(),
    descripcion: $("#descripcionProducto").val(),
    id_categoria: $("#categoriaProducto").val(),
    precio_compra: $("#precioCompra").val(),
    precio_venta: $("#precioVenta").val(),
    stock_actual: $("#stockProducto").val(),
    unidad_medida: $("#unidadProducto").val(),
    active: $("#estadoProducto").is(":checked") ? 1 : 0,
  };

  $.post("modulos/productos/ajax.php", data, (response) => {
    const respuesta = response.split("|");

    if (respuesta[0] === "1") {
      Swal.fire({
        title: "¡Éxito!",
        text: respuesta[1],
        icon: "success",
      });
      cargarProductos();
      agregarProductoModal.modal("hide");
    } else {
      Swal.fire({
        title: "Error",
        text: respuesta[1],
        icon: "error",
      });
    }
  });
};

const cargarEditarProducto = (idProducto) => {
  $.post(
    "modulos/productos/ajax.php",
    { fnc: "mostrar_producto", id_producto: idProducto },
    (data) => {
      const respuesta = data.split("|");
      if (respuesta[0] === "1") {
        const producto = JSON.parse(respuesta[1]);
        productoId.val(producto.id_producto);
        $("#nombreProducto").val(producto.nombre_producto);
        $("#descripcionProducto").val(producto.descripcion);
        $("#categoriaProducto").val(producto.id_categoria);
        $("#precioCompra").val(producto.precio_compra);
        $("#precioVenta").val(producto.precio_venta);
        $("#stockProducto").val(producto.stock_actual);
        $("#unidadProducto").val(producto.unidad_medida);
        $("#estadoProducto").prop("checked", producto.active === "1");

        agregarProductoModal.modal("show");
      } else {
        Swal.fire({
          title: "Error",
          text: respuesta[1],
          icon: "error",
        });
      }
    }
  );
};

const eliminarProducto = (idProducto) => {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "Esta acción no se puede revertir.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.post(
        "modulos/productos/ajax.php",
        {
          fnc: "eliminar_producto",
          id_producto: idProducto,
        },
        (response) => {
          const respuesta = response.split("|");
          if (respuesta[0] === "1") {
            Swal.fire("Eliminado", respuesta[1], "success");
            cargarProductos();
          } else {
            Swal.fire("Error", respuesta[1], "error");
          }
        }
      );
    }
  });
};

const cargarCategorias = () => {
  $.post(
    "modulos/productos/ajax.php",
    { fnc: "mostrar_categorias" },
    (data) => {
      const respuesta = data.split("|");
      let html = "";

      if (respuesta[0] === "1") {
        const categorias = JSON.parse(respuesta[1]);

        categorias.forEach((categoria) => {
          html += `<option value="${categoria.id_categoria}">${categoria.nombre_categoria}</option>`;
        });
      } else {
        html = '<option value="">No hay categorías disponibles</option>';
      }

      $("#categoriaProducto").html(html);
    }
  );
};

const cargarUnidadesMedida = () => {
  $.post(
    "modulos/productos/ajax.php",
    { fnc: "mostrar_unidades_medida" },
    (data) => {
      const respuesta = data.split("|");
      let html = '<option value="">Selecciona una unidad</option>'; // Opción por defecto

      if (respuesta[0] === "1") {
        const unidades = JSON.parse(respuesta[1]);

        unidades.forEach((unidad) => {
          html += `<option value="${unidad}">${unidad}</option>`;
        });
      } else {
        html += '<option value="">No hay unidades disponibles</option>';
      }

      $("#unidadProducto").html(html);
    }
  );
};

function debounce(func, wait, immediate) {
  let timeout;
  return function () {
    const context = this,
      args = arguments;
    const later = function () {
      timeout = null;
      if (!immediate) func.apply(context, args);
    };
    const callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
    if (callNow) func.apply(context, args);
  };
}

// Eventos
btnGuardarProducto.click(guardarProducto);

$(document).ready(function () {
  cargarProductos();
  cargarCategorias();
  cargarUnidadesMedida();
});

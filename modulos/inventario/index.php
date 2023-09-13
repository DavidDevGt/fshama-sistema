<div class="container mt-5">
    <h1 class="mb-4">Gestión de Inventario</h1>

    <!-- Barra de búsqueda y filtrado -->
    <div class="row mb-4">
        <div class="col-md-9"> <!-- Ocupará 3/4 del espacio disponible -->
            <div class="input-group mb-3">
                <input type="text" id="busquedaProducto" placeholder="Buscar producto para consulta..." class="form-control" onkeyup="buscarProducto(this.value)">
                <div class="input-group-append">
                    <button class="btn btn-info" onclick="limpiarCampos()">Limpiar campos</button>
                </div>
            </div>

            <!-- Tabla de resultados de búsqueda -->
            <div class="table-responsive shadow mb-3"> <!-- Agregamos sombra y hacemos la tabla responsive -->
                <table class="table table-striped" id="tablaResultadosBusqueda" style="display: none;">
                    <!-- Las filas se cargarán dinámicamente aquí -->
                </table>
            </div>
        </div>
        <div class="col-md-3" id="detalleProducto">
            <!-- Aquí se mostrarán los detalles del producto de manera dinámica -->
        </div>
    </div>





    <!-- Botones para agregar entradas/salidas -->
    <div class="mb-4">
        <button class="btn btn-success" data-toggle="modal" data-target="#agregarEntradaModal">Agregar Entrada</button>
        <button class="btn btn-danger" data-toggle="modal" data-target="#agregarSalidaModal">Agregar Salida</button>
    </div>

    <!-- Tabla de movimientos de inventario -->
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Fecha</th>
                <th>Tipo de Movimiento</th>
                <th>Cantidad</th>
                <th>Motivo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="listaMovimientos">
            <!-- Los movimientos de inventario se cargarán dinámicamente desde JS -->
        </tbody>
    </table>
</div>

<!-- Modal para agregar entrada -->
<div class="modal fade" id="agregarEntradaModal" tabindex="-1" aria-labelledby="agregarEntradaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarEntradaModalLabel">Agregar Entrada de Inventario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="buscarProductoEntrada" placeholder="Buscar producto..." class="form-control mb-3" onkeyup="buscarProducto(this.value, 'entrada')">
                <select id="seleccionProductoEntrada" class="form-control mb-3" size="5"></select>
                <input type="number" id="cantidadEntrada" placeholder="Cantidad" class="form-control mb-3">
                <textarea id="motivoEntrada" placeholder="Motivo" class="form-control mb-3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="agregarEntrada()">Guardar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal para agregar salida -->
<div class="modal fade" id="agregarSalidaModal" tabindex="-1" aria-labelledby="agregarSalidaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarSalidaModalLabel">Agregar Salida de Inventario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select class="form-control mb-3" id="buscarYSeleccionarProductoSalida"></select>
                <input type="number" id="cantidadSalida" placeholder="Cantidad" class="form-control mb-3">
                <textarea id="motivoSalida" placeholder="Motivo" class="form-control mb-3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-warning" onclick="agregarSalida()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script src="modulos/inventario/script.js"></script>
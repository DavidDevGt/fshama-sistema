<style type="text/css">
    .nombre-producto {
        width: 200px; /* O el ancho que prefieras */
    }

</style>

<!-- Vista general de productos -->
<div class="container mt-5">
    <h1 class="mb-4">Listado de Productos</h1>

    <!-- Barra de búsqueda y filtrado -->
    <div class="mb-4">
        <input type="text" id="busquedaProducto" placeholder="Buscar producto..." class="form-control">
    </div>

    <!-- Botón para agregar producto -->
    <button class="btn btn-success mb-5" data-toggle="modal" data-target="#agregarProductoModal">
        <i class="fa fa-plus"></i> Agregar Producto
    </button>

    <!-- Tabla de productos -->
    <table class="table table-warning table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Categoría</th>
                <th>Precio Compra</th>
                <th>Precio Venta</th>
                <th>Stock</th>
                <th>Unidad</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="listaProductos">
            <!-- Los productos se cargarán dinámicamente desde JS -->
        </tbody>
    </table>
</div>

<!-- Modal para agregar/editar producto -->
<div class="modal fade" id="agregarProductoModal" tabindex="-1" role="dialog" aria-labelledby="agregarProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarProductoModalLabel">Agregar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formularioProducto">
                    <input type="hidden" id="productoId">
                    <div class="form-group">
                        <label for="nombreProducto">Nombre del Producto</label>
                        <input type="text" class="form-control" id="nombreProducto" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcionProducto">Descripción</label>
                        <textarea class="form-control" id="descripcionProducto" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="categoriaProducto">Categoría</label>
                        <select class="form-control" id="categoriaProducto">
                            <!-- Las categorías se cargarán dinámicamente desde JS -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="precioCompra">Precio de Compra</label>
                        <input type="number" step="0.01" class="form-control" id="precioCompra" required>
                    </div>
                    <div class="form-group">
                        <label for="precioVenta">Precio de Venta</label>
                        <input type="number" step="0.01" class="form-control" id="precioVenta" required>
                    </div>
                    <div class="form-group">
                        <label for="stockProducto">Stock Inicial</label>
                        <input type="number" class="form-control" id="stockProducto">
                    </div>
                    <div class="form-group">
                        <label for="unidadProducto">Unidad de Medida</label>
                        <select class="form-control" id="unidadProducto">
                            <option value="Unidad">Unidad</option>
                            <option value="Metro">Metro</option>
                            <!-- ... otros valores ... -->
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="estadoProducto" checked>
                            <label class="custom-control-label" for="estadoProducto">Activo</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarProducto">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script src="modulos/productos/script.js"></script>
<script src="funciones.js"></script>

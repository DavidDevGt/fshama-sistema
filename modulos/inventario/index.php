<link rel="stylesheet" href="modulos/inventario/style.css">

<div class="container mt-5">
    <!-- Título -->
    <h1 class="mb-4">Gestión de Inventario</h1>

    <!-- Botón para abrir el modal de búsqueda -->
    <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#busquedaProductoModal">Buscar Producto</button>

    <!-- Estadísticas Rápidas -->
    <div class="mb-4 p-4 bg-light rounded">
        <div class="row" id="estadisticasInventario">
            <div class="col-3">
                <div class="card border-0 shadow-sm stat-card">
                    <div class="card-body text-center bg-success">
                        <h2 class="display-4" id="totalProductos"></h2>
                        <p class="lead">Total de Productos en Sistema</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card border-0 shadow-sm stat-card">
                    <div class="card-body text-center bg-success">
                        <h2 class="display-4" id="productosBajoStock"></h2>
                        <p class="lead">Productos con Bajo Stock</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card border-0 shadow-sm stat-card">
                    <div class="card-body text-center bg-success">
                        <h2 class="display-4" id="ultimoMovimiento"></h2>
                        <p class="lead">Último Movimiento Registrado</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card border-0 shadow-sm stat-card">
                    <div class="card-body text-center bg-success">
                        <h2 class="display-4" id="movimientosRecientes"></h2>
                        <p class="lead">Movimientos en los últimos 7 días</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Botones de acción rápida -->
    <div class="mb-4">
        <button class="btn btn-success" data-toggle="modal" data-target="#agregarEntradaModal">Agregar Entrada</button>
        <button class="btn btn-danger" data-toggle="modal" data-target="#agregarSalidaModal">Agregar Salida</button>
        <button class="btn btn-warning" data-toggle="modal" data-target="#exportarInventarioModal">Exportar Inventario</button>
    </div>

    <!-- Tabla de Productos en Inventario -->
    <table class="table table-warning table-hover table-bordered">
        <thead>
            <tr>
                <th>Nombre del Producto</th>
                <th>Stock Inicial</th>
                <th>Entradas</th>
                <th>Salidas</th>
                <th>Stock Actual</th>
            </tr>
        </thead>
        <tbody id="tablaInventario">
            <!-- Los datos se cargarán aquí desde el script.js -->
        </tbody>
    </table>

    <!-- Modal para la Búsqueda y Resultado de Búsqueda -->
    <div class="modal fade" id="busquedaProductoModal" tabindex="-1" role="dialog" aria-labelledby="busquedaProductoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="busquedaProductoModalLabel">Buscar Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input type="text" id="busquedaProducto" aria-label="Buscar producto" placeholder="Buscar producto..." class="form-control">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                    <select id="resultadosBusqueda" class="form-control custom-select mb-2 d-none" size="5"></select>

                    <small id="searchFeedback" class="form-text text-muted d-none mt-2">Buscando...</small>

                    <div id="infoProducto" class="mt-4">
                        <h4 class="mb-3"><span id="nombreProducto"></span></h4>
                        <p><strong>Descripción:</strong> <span id="descripcionProducto"></span></p>
                        <p><strong>Existencia:</strong> <span id="existenciaProducto"></span></p>
                        <p><strong>Precio:</strong>Q <span id="precioProducto"></span></p>
                        <p><strong>Categoría:</strong> <span id="categoriaProducto"></span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal para "Agregar Entrada" -->
    <div class="modal fade" id="agregarEntradaModal" tabindex="-1" role="dialog" aria-labelledby="agregarEntradaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarEntradaModalLabel">Agregar Entrada</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formAgregarEntrada">
                        <div class="form-group">
                            <label for="productoEntrada">Producto</label>
                            <select class="form-control" id="productoEntrada" required>
                                <!-- Opciones dinámicas cargadas desde la base de datos -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cantidadEntrada">Cantidad</label>
                            <input type="number" class="form-control" id="cantidadEntrada" required>
                        </div>
                        <div class="form-group">
                            <label for="motivoEntrada">Motivo</label>
                            <textarea class="form-control" id="motivoEntrada" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onclick="guardarEntrada()">Guardar Entrada</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para "Agregar Salida" -->
    <div class="modal fade" id="agregarSalidaModal" tabindex="-1" role="dialog" aria-labelledby="agregarSalidaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarSalidaModalLabel">Agregar Salida</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formAgregarSalida">
                        <div class="form-group">
                            <label for="productoSalida">Producto</label>
                            <select class="form-control" id="productoSalida" required>
                                <!-- Opciones dinámicas cargadas desde la base de datos -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cantidadSalida">Cantidad</label>
                            <input type="number" class="form-control" id="cantidadSalida" required>
                        </div>
                        <div class="form-group">
                            <label for="motivoSalida">Motivo</label>
                            <textarea class="form-control" id="motivoSalida" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" onclick="guardarSalida()">Guardar Salida</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="modulos/inventario/script.js"></script>
</div>
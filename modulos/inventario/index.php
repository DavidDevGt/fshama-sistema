<link rel="stylesheet" href="modulos/inventario/style.css">

<div class="container mt-5">
    <!-- Título -->
    <h1 class="mb-4">Gestión de Inventario</h1>

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
        <button class="btn btn-primary" data-toggle="modal" data-target="#manipularInventarioModal">Manipular Inv.</button>
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

    <!-- Modal para "Manipular Inventario" -->
    <div class="modal fade" id="manipularInventarioModal" tabindex="-1" role="dialog" aria-labelledby="manipularInventarioModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manipularInventarioModalLabel">Manipular Inventario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-3" id="buscarMovimiento" placeholder="Buscar producto...">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Tipo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaMovimientos">
                            <!-- Los datos se cargarán aquí desde el script.js -->
                        </tbody>
                    </table>
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
                            <input type="text" class="form-control mb-2" id="buscarProductoEntrada" placeholder="Buscar producto...">
                            <select class="form-control" id="productoEntrada" required>
                                <option value="">Seleccione un producto</option>

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
                    <button type="button" class="btn btn-success" onclick="guardarMovimiento('Entrada')">Guardar Entrada</button>

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
                            <input type="text" class="form-control mb-2" id="buscarProductoSalida" placeholder="Buscar producto...">
                            <select class="form-control" id="productoSalida" required>
                                <option value="">Seleccione un producto</option>

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
                    <button type="button" class="btn btn-danger" onclick="guardarMovimiento('Salida')">Guardar Salida</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="modulos/inventario/script.js"></script>
</div>
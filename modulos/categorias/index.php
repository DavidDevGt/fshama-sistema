

<div class="container mt-5">
        <h1>Administrar Categorías</h1>
        <!-- Botón para abrir el modal de agregar categoría -->
        <button class="btn btn-success mt-3" data-toggle="modal" data-target="#agregarModal">
            <i class="fas fa-plus"></i> Agregar Categoría
        </button>

        <!-- Tabla para mostrar las categorías -->
        <table class="table table-warning table-hover mt-5 table-rounded" id="tablaCategorias">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se mostrarán las filas de categorías desde Javascript -->
            </tbody>
        </table>
    </div>

    <!-- Modal para agregar categoría -->
<div class="modal fade" id="agregarModal" tabindex="-1" role="dialog" aria-labelledby="agregarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarModalLabel">Agregar Categoría</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario para agregar una categoría -->
                <form>
                    <div class="form-group">
                        <label for="nombreCategoria">Nombre de la Categoría</label>
                        <input type="text" class="form-control" id="nombreCategoria" placeholder="Ingrese el nombre de la categoría" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcionCategoria">Descripción</label>
                        <textarea class="form-control" id="descripcionCategoria" rows="3" placeholder="Ingrese una descripción de la categoría"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar categoría -->
<div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Editar Categoría</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario para editar una categoría -->
                <form>
                    <div class="form-group">
                        <label for="nombreCategoriaEditar">Nombre de la Categoría</label>
                        <input type="text" class="form-control" id="nombreCategoriaEditar" placeholder="Ingrese el nuevo nombre de la categoría" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcionCategoriaEditar">Descripción</label>
                        <textarea class="form-control" id="descripcionCategoriaEditar" rows="3" placeholder="Ingrese una nueva descripción de la categoría"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<script src="modulos/categorias/script.js"></script>

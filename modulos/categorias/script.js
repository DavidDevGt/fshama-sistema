console.log("Script de categorías cargado.");


// Declaración de las constantes para elementos del DOM
const tablaCategorias = $('#tablaCategorias tbody');

const btnAgregar = $('#agregarModal .btn-primary');
const modalEditar = $('#editarModal');
const btnEditar = $('#editarModal .btn-primary');

// Función para cargar las categorías en la tabla
const cargarCategorias = () => {
    console.log("Cargando categorías...");

    $.post('modulos/categorias/ajax.php', { fnc: 'mostrar_categorias' }, (data) => {
        
        const respuesta = data.split("|");
        let html = '';

        if (respuesta[0] == '1') {
            const categorias = JSON.parse(respuesta[1]);
            console.log("Categorías:", categorias);
            
            categorias.forEach((categoria) => {
                html += `
                <tr>
                    <td width="5%">${categoria.id_categoria}</td>
                    <td width="auto">${categoria.nombre_categoria}</td>
                    <td width="20%">
                        <div class="btn-group">
                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#editarModal" data-id="${categoria.id_categoria}" data-nombre="${categoria.nombre_categoria}" data-descripcion="${categoria.descripcion}">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarCategoria(${categoria.id_categoria})">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                        </div>
                    </td>
                </tr>`;
            });
        } else {
            console.error("Error al cargar categorías:", respuesta[1]);
            html = `
                <tr>
                    <td colspan="3">No hay categorías registradas.</td>
                </tr>
            `;
        }

        tablaCategorias.html(html);
    });
}


// Función para agregar una categoría
const agregarCategoria = () => {
    const nombreCategoria = $('#nombreCategoria').val();
    const descripcion = $('#descripcionCategoria').val();

    $.post('modulos/categorias/ajax.php', {
        fnc: 'agregar_categoria',
        nombreCategoria,
        descripcion
    }, (data) => {
        const respuesta = data.split("|");
        if (respuesta[0] == '1') {
            $('#agregarModal').modal('hide');
            cargarCategorias();
            Swal.fire({
            title: '¡Éxito!',
            text: 'Categoría agregada correctamente',
            icon: 'success',
            timer: 1000, // Configura el tiempo en milisegundos (1 segundo en este caso)
            timerProgressBar: true,
            showConfirmButton: false
        });

            // Aquí reseteamos el formulario
            $('#nombreCategoria').val('');
            $('#descripcionCategoria').val('');
        } else {
             Swal.fire('Error', respuesta[1], 'error');
        }
    });
}

// Función para editar una categoría
const editarCategoria = () => {
    const idCategoria = btnEditar.data('id');
    const nombreCategoria = $('#nombreCategoriaEditar').val();
    const descripcion = $('#descripcionCategoriaEditar').val();

    $.post('modulos/categorias/ajax.php', {
        fnc: 'editar_categoria',
        idCategoria,
        nombreCategoria,
        descripcion
    }, (data) => {
        const respuesta = data.split("|");
        if (respuesta[0] == '1') {
            modalEditar.modal('hide');
            cargarCategorias();
            Swal.fire({
            title: '¡Éxito!',
            text: 'Categoría actualizada correctamente',
            icon: 'success',
            timer: 1000, // Configura el tiempo en milisegundos (1 segundo en este caso)
            timerProgressBar: true,
            showConfirmButton: false
        });
        } else {
            Swal.fire('Error', respuesta[1], 'error');
        }
    });
}

// Función para eliminar una categoría
const eliminarCategoria = (idCategoria) => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¿Deseas eliminar esta categoría?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Aquí va el código para eliminar la categoría
            $.post('modulos/categorias/ajax.php', {
                fnc: 'eliminar_categoria',
                idCategoria
            }, (data) => {
                const respuesta = data.split("|");
                if (respuesta[0] == '1') {
                    cargarCategorias();
                    
                    Swal.fire({
                    title: '¡Eliminado!',
                    text: 'La categoría ha sido eliminada.',
                    icon: 'success',
                    timer: 1000, // Configura el tiempo en milisegundos (1 segundo en este caso)
                    timerProgressBar: true,
                    showConfirmButton: false
                });

                } else {
                    Swal.fire('Error', respuesta[1], 'error');
                }
            });
        }
    })
}

// Eventos
btnAgregar.click(agregarCategoria);

modalEditar.on('show.bs.modal', function(event) {
    const button = $(event.relatedTarget);
    const id = button.data('id');
    const nombre = button.data('nombre');
    const descripcion = button.data('descripcion');

    $(this).find('#nombreCategoriaEditar').val(nombre);
    $(this).find('#descripcionCategoriaEditar').val(descripcion);
    btnEditar.attr('data-id', id);
});

btnEditar.click(editarCategoria);

// Carga inicial
$(document).ready(function () {
    cargarCategorias();
});

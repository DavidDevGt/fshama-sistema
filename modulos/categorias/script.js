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
        console.log("Respuesta recibida:", data);
        
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
                        <button class="btn btn-primary" data-toggle="modal" data-target="#editarModal" data-id="${categoria.id_categoria}" data-nombre="${categoria.nombre_categoria}" data-descripcion="${categoria.descripcion}">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button class="btn btn-danger" onclick="eliminarCategoria(${categoria.id_categoria})">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
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
            bootbox.alert('Categoría agregada correctamente');

            // Aquí reseteamos el formulario
            $('#nombreCategoria').val('');
            $('#descripcionCategoria').val('');
        } else {
            bootbox.alert(respuesta[1]);
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
            bootbox.alert('Categoría actualizada correctamente');
        } else {
            bootbox.alert(respuesta[1]);
        }
    });
}

// Función para eliminar una categoría
const eliminarCategoria = (idCategoria) => {
    if (confirm('¿Está seguro de que desea eliminar esta categoría?')) {
        $.post('modulos/categorias/ajax.php', {
            fnc: 'eliminar_categoria',
            idCategoria
        }, (data) => {
            const respuesta = data.split("|");
            if (respuesta[0] == '1') {
                cargarCategorias();
                    bootbox.alert('Categoría eliminada correctamente');
            } else {
                    bootbox.alert(respuesta[1]);
            }
        });
    }
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

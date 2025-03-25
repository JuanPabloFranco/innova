$(document).ready(function() {

    $(document).on('click', '.btnComentar', (e) => {
        const elemento = $(this)[0].activeElement.parentElement;
        const id = $(elemento).attr('idHistoria');
        $('#txtIdHistoria').val(id);
    });

    $('#form_crear_comentario').submit(e => {
        e.preventDefault();
        let comentario = $('#txtComentario').val();
        let id_historia = $('#txtIdHistoria').val();
        funcion = 'comentar';
        $.post('../Controlador/historiaController.php', { funcion, id_historia, comentario, id_usuario }, (response) => {
            if (response.includes('creado')) {
                location.reload();
            } else {
                Swal.fire({
                    title: 'Error al registrar el comentario',
                    showDenyButton: false,
                    showCancelButton: false
                });
            }
        });
    });

    $(document).on('click', '.btn_nominado', (e) => {
        const elemento = $(this)[0].activeElement;
        Swal.fire({
            title: 'Realmente desea votar por este nominado?',
            showCancelButton: true,
            confirmButtonText: `Si`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id_nominado = $(elemento).attr('id');
                const id_encuesta = $(elemento).attr('encuesta');
                let id_autor_respuesta = $('#id_usuario').val();
                funcion = 'votar_nominado';
                $.post('../Controlador/encuestaController.php', { id_nominado, id_autor_respuesta, id_encuesta, funcion }, (response) => {
                    if (response == 'creado') {
                        location.reload();
                    } else {
                        Swal.fire({
                            title: response,
                            showCloseButton: true,
                        })
                    }
                });
            }
        })
    });

    $(document).on('click', '.delHistory', (e) => {
        const elemento = $(this)[0].activeElement.parentElement;
        Swal.fire({
            title: 'Realmente desea eliminar la historia?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Eliminar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('idHistoria');
                funcion = 'eliminarHistoria';
                $.post('../Controlador/historiaController.php', { id, funcion }, (response) => {
                    if (response.includes('delete')) {
                        Swal.fire('Eliminado!', '', 'success');
                        setTimeout("location.href='./adm_panel.php'", 1000);
                    } else {
                        Swal.fire(response, '', 'info')
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('No se ha eliminado la historia', '', 'info')
            }
        })
    });

    $(document).on('click', '.delComentario', (e) => {
        const elemento = $(this)[0].activeElement.parentElement;
        Swal.fire({
            title: 'Realmente desea eliminar el comentario?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Eliminar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('idComentario');
                funcion = 'eliminarComentario';
                $.post('../Controlador/historiaController.php', { id, funcion }, (response) => {
                    if (response.includes('delete')) {
                        Swal.fire('Eliminado!', '', 'success');
                        setTimeout("location.href='./adm_panel.php'", 1000);
                    } else {
                        Swal.fire(response, '', 'info')
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('No se ha eliminado la historia', '', 'info')
            }
        })
    });
});
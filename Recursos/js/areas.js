$(document).ready(function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    var funcion = "";
    var tipoUsuario = $('#txtTipoUsuario').val();
    var page = $('#txtPage').val();
    var editar = $('#txtEditar').val();
    var crear = $('#txtCrear').val();
    var eliminar = $('#txtEliminar').val();
    var ver = $('#txtVer').val();

    if (page == "general") {
        buscar();
        $(document).on('keyup', '#TxtBuscar', function () {
            let consulta = $(this).val();
            if (consulta.length > 3 || consulta.length == 0) {
                buscar(consulta);
            }
        });
    }

    function buscar(consulta) {
        let template = ``;
        if (ver == 1 || tipoUsuario <= 2) {
            var funcion = "buscar";
            $.post('../Controlador/areaController.php', { consulta, funcion }, (response) => {
                const objetos = JSON.parse(response);
                let template = `            <table class="table table-bordered text-center">
                                                <thead>                  
                                                    <tr class='notiHeader'>
                                                        <th >#</th>
                                                        <th>Estado</th>       
                                                        <th>Nombre</th>                                                    
                                                        <th>Descripción</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;
                var num = 0;
                objetos.forEach(objeto => {
                    num += 1;
                    estado = "";
                    if (objeto.estado == 1) {
                        estado = "<h1 class='badge badge-success'>Activa</h1>";
                    } else if (objeto.estado == 0) {
                        estado = "<h1 class='badge badge-danger'>Inactivo</h1>";
                    } else if (objeto.estado == 3) {
                        estado = "";
                    }
                    template += `                   <tr id=${objeto.id}>
                                                        <td>${num}</td>
                                                        <td>${estado}</td>
                                                        <td>${objeto.nombre}</td>
                                                        <td>${objeto.descripcion != null ? objeto.descripcion : ""}</td>
                                                        <td>`;
                    if (editar == 1) {
                        if (objeto.estado == 1) {
                            template += `                   <button class='state btn btn-sm btn-danger mr-1' type='button' title='Inactivar'>
                                                                <i class="fas fa-lock"></i>
                                                            </button>`;
                        } else {
                            template += `                   <button class='state btn btn-sm btn-success mr-1' type='button' title='Activar'>
                                                                <i class="fas fa-lock-open"></i>
                                                            </button>`;
                        }
                        template += `                       <button class='edit btn btn-sm btn-primary mr-1' data-bs-toggle="modal" data-bs-target="#editar_area" type='button' title='Editar'>
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>`;
                    }
                    template += `                       </td>
                                                    </tr>`;
                });
                template += `                   </tbody>
                                            </table>`;
                $('#busqueda').html(template);
            });
        } else {
            template += `Tu cargo no tiene permiso para ver este módulo`;
            $('#busqueda').html(template);
        }
    }

    $(document).on('click', '.edit', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        $('#txtIdEd').val(id);
        funcion = 'cargar';
        $.post('../Controlador/areaController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#txtNombre2').val(obj.nombre);
            $('#txtDesc2').val(obj.descripcion);
        })
        e.preventDefault();
    });

    $(document).on('click', '.state', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea cambiar de estado esta área?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Aceptar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'cambiar_estado';
                $.post('../Controlador/areaController.php', { id, funcion }, (response) => {
                    Swal.fire('Estado cambiado!', '', 'success');
                    buscar();
                });
            } else if (result.isDenied) {
                Swal.fire('No se cambió el estado', '', 'info')
            }
        })
        e.preventDefault();
    });

    $('#form_editar_area').submit(e => {
        let id = $('#txtIdEd').val();
        let nombre = $('#txtNombre2').val();
        let descripcion = $('#txtDesc2').val();
        funcion = 'editar';
        $.post('../Controlador/areaController.php', { funcion, id, nombre, descripcion }, (response) => {
            if (response == 'update') {
                Toast.fire({
                    icon: 'success',
                    title: 'Área Actualizada'
                })
                $("#editar_area").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_editar_area').trigger('reset');
                buscar();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
        e.preventDefault();
    });


    $('#form_crear_area').submit(e => {
        let nombre = $('#txtNombre').val();
        let descripcion = $('#txtDesc').val();
        funcion = 'crear';
        $.post('../Controlador/areaController.php', { funcion, nombre, descripcion }, (response) => {
            if (response == 'create') {
                Toast.fire({
                    icon: 'success',
                    title: 'Área registrado'
                })
                $("#crearArea").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_crear_area').trigger('reset');
                buscar();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
        e.preventDefault();
    });

});
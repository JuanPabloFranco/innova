$(document).ready(function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    editar = $('#txtEditar').val();
    tipoUsuario = $('#txtTipoUsuario').val();
    var funcion = "";
    buscar();

    $(document).on('keyup', '#TxtBuscarCargo', function () {
        let consulta = $('#TxtBuscarCargo').val();
        if (consulta.length > 3 || consulta.length ==0) { // También corregido aquí
            buscar(consulta);
        } 
    });

    function buscar(consulta) {
        var funcion = "buscar";
        $.post('../Controlador/moduloController.php', { consulta, funcion }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            let template = `            <table class="table table-bordered text-center">
                                            <thead>                  
                                                <tr class='notiHeader'>
                                                    <th >#</th>
                                                    <th>Estado</th>                                                    
                                                    <th>Nombre</th>                                                    
                                                    <th>Icono</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;

            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr idmodulo=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${objeto.estado == 1 ? 'Activo' : 'Inactivo'}</td>
                                                    <td>${objeto.nombre}</td>
                                                    <td>${objeto.icono == null ? "No aplica" : `<img src='../Recursos/img/empresa/${objeto.icono}' width='25px'>`}</td>
                                                    <td>`;
                if (objeto.id > 4) {
                    if (objeto.estado == 1) {
                        template += `                       <button class='state btn btn-sm btn-success mr-1' type='button'>
                                                                <i class="fas fa-lock-open"></i>
                                                            </button>`;
                    } else {
                        template += `                       <button class='state btn btn-sm btn-danger mr-1' type='button'>
                                                                <i class="fas fa-lock"></i>
                                                            </button>`;
                    }
                    template += `                           <button class='edit btn btn-sm btn-primary mr-1' type='button' data-bs-toggle="modal" data-bs-target="#editar_modulo">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>`;
                }
                if (editar == 1 || tipoUsuario <= 2) {
                    template += `                           <button class='icono btn btn-sm btn-warning mr-1' type='button' data-bs-toggle="modal" data-bs-target="#cambiar_icono">
                                                                <i class="fas fa-image"></i>
                                                            </button>`;
                }
                template += `                       </td>
                                                </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#busqueda').html(template);
        });
    }

    $(document).on('click', '.icono', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('idmodulo');
        $('#txtIdModuloIcono').val(id);
        funcion = 'cargarModulo';
        $.post('../Controlador/moduloController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            if (obj.icono != null) {
                $('#imgIconoModulo').attr('src', '../Recursos/img/empresa/' + obj.icono);
                $('#btnDelIcono').show();
            } else {
                $('#imgIconoModulo').attr('src', '');
                $('#btnDelIcono').hide();
            }
        });
        e.preventDefault();
    });

    $(document).on('click', '.edit', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('idmodulo');
        $('#txtId_moduloEd').val(id);
        funcion = 'cargarModulo';
        $.post('../Controlador/moduloController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#txtNombreModulo2').val(obj.nombre);
        });
        e.preventDefault();
    });

    $('#form_editar_modulo').submit(e => {
        let id = $('#txtId_moduloEd').val();
        let nombre = $('#txtNombreModulo2').val();
        funcion = 'editar_modulo';
        $.post('../Controlador/moduloController.php', { funcion, id, nombre }, (response) => {
            if (response == 'update') {
                Toast.fire({
                    icon: 'success',
                    title: 'Módulo Actualizado'
                })
                $("#editar_modulo").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
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


    $('#form_crear_modulo').submit(e => {
        let nombre = $('#txtNombreModulo').val();        
        let eliminar = 0;
        if (document.getElementById('customSwitchEliminar').checked) {
            eliminar = 1;
        }
        funcion = 'crear_modulo';
        $.post('../Controlador/moduloController.php', { funcion, nombre, eliminar }, (response) => {
            if (response.includes('create')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Módulo registrado'
                })
                $("#form_crear_modulo").trigger('reset'); //limpiamos el formulario
                $("#crearCargo").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
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

    $(document).on('click', '.state', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: 'Realmente desea cambiar el estado del módulo?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Actualizar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('idmodulo');
                funcion = 'cambiar_estado';
                $.post('../Controlador/moduloController.php', { id, funcion }, (response) => {
                    if (response.includes('update')) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Estado Actualizado'
                        })
                        buscar();
                    }
                });
            }
        })
    });

    $("#form_cambiar_icono").on("submit", function (e) {
        e.preventDefault();
        var f = $(this);
        var formData = new FormData(document.getElementById("form_cambiar_icono"));
        formData.append("dato", "valor");
        var peticion = $('#form_cambiar_icono').attr('action');
        $.ajax({
            url: '../Controlador/moduloController.php',
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false
        }).done(function (response) {
            if (response.includes('update')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Icono actualizado con éxito'
                })
                $("#cambiar_icono").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_cambiar_icono').trigger('reset');
                buscar();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
    });

    $(document).on('click', '.delIcono', (e) => {
        Swal.fire({
            title: 'Desea eliminar el icono del módulo?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Si`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $('#txtIdModuloIcono').val();
                funcion = 'eliminarIcono';
                $.post('../Controlador/moduloController.php', { id, funcion }, (response) => {
                    if (response.includes('update')) {
                        $("#cambiar_icono").modal('hide'); //ocultamos el modal
                        $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                        $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                        buscar();
                    }
                });
            }
        })
        e.preventDefault();
    });
});
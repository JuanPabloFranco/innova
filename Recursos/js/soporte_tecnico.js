$(document).ready(function () {
    var funcion = "";
    var tipo_usuario = $('#txtTipoUsuario').val();
    var id_autor = $('#txtId_usuario').val();
    buscarSolicitudes();

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    })

    $('#form_crear_soporte').submit(e => {
        e.preventDefault();
        let descripcion = $('#txtDescSoporte').val();
        let id_modulo = $('#selModulo').val();
        let tipo = $('#selTipo').val();
        funcion = 'crear_soporte';
        $.post('../Controlador/soporteController.php', { funcion, id_autor, descripcion, id_modulo, tipo }, (response) => {
            if (response == 'creado') {
                Toast.fire({
                    icon: 'success',
                    title: 'Caso de soporte registrado'
                })
                $('#form_crear_soporte').trigger('reset');
                buscarSolicitudes();
                enviar_email(id_autor, descripcion);
                $('#crear_solicitud').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                rqs_soporte();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
    });

    function rqs_soporte() {
        funcion = 'contar_soporte';
        id_usuario = $('#txtIdUsuario').val();
        $.post('../Controlador/soporteController.php', { funcion, id_usuario }, (response) => {
            const obj = JSON.parse(response);
            $('#spanContacto').text(obj[0].cantidad);
        });
    }

    function enviar_email(id_usuario, descripcion) {
        funcion = 'soporteRecibido';
        $.post('../Controlador/controlador_phpmailer.php', { funcion, id_usuario, descripcion }, (response) => { });
    }

    $(document).on('keyup', '#TxtBuscarSolicitud', function () {
        let consulta = $(this).val();
        if (consulta != "") {
            buscarSolicitudes(consulta);
        } else {
            buscarSolicitudes();
        }
    });

    function buscarSolicitudes(consulta) {
        var funcion = "buscar_solicitud";
        $.post('../Controlador/soporteController.php', { consulta, funcion, id_usuario, tipo_usuario }, (response) => {
            const objetos = JSON.parse(response); let template = `
                                        <table class="table table-bordered table-responsive text-center">
                                            <thead class='notiHeader'> 
                                                <tr>
                                                    <th>#</th> 
                                                    <th>Estado</th>
                                                    <th>Tipo</th>
                                                    <th>Fecha</th>
                                                    <th>Módulo</th>
                                                    <th>Autor</th>
                                                    <th>Descripción</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            var num = 0;
            objetos.forEach(objeto => {
                num++;
                estado = "";
                if(objeto.estado=="Nuevo"){
                    estado = `<h1 class='badge badge-primary'>Nuevo</h1>`;
                }else if(objeto.estado=="Finalizado"){
                    estado = `<h1 class='badge badge-success'>Finalizado</h1>`;                    
                }else if(objeto.estado=="En Proceso"){
                    estado = `<h1 class='badge badge-secondary'>En Proceso</h1>`;                
                }else if(objeto.estado=="En Pruebas"){
                    estado = `<h1 class='badge badge-light'>En Pruebas</h1>`;
                }else{
                    estado = `<h1 class='badge badge-warning'>Revisado</h1>`;
                }
                template += `                   <tr idSoporte=${objeto.id}>
                                                    <td style="width: 2px">${num}</td>
                                                    <td >${estado}</td>
                                                    <td >${objeto.tipo}</td>
                                                    <td >${objeto.fecha}</td>
                                                    <td >${objeto.nombre_modulo}</td>
                                                    <td >${objeto.nombre_completo}</td>
                                                    <td >${objeto.descripcion}</td>
                                                    <td >   
                                                        <button class='view btn btn-sm btn-primary mr-1' title='Detalle' type='button' data-bs-toggle="modal" data-bs-target="#ver_caso">
                                                            <i class='fas fa-list-alt'></i>
                                                        </button>`;
                if (tipo_usuario <= 2) {
                    template += `                       <button class='changeEstado btn btn-sm btn-success mr-1' title='Cambiar Estado' type='button' data-bs-toggle="modal" data-bs-target="#cambiar_estado">
                                                           <i class="fas fa-sign-out-alt"></i>
                                                        </button>`;
                }
                template += `                           <button class='upImg btn btn-sm btn-warning mr-1' title='Agregar Imagén' type='button' data-bs-toggle="modal" data-bs-target="#agregarSoporte">
                                                            <i class="fas fa-image"></i>
                                                        </button>`;

                template += `                       </td>
                                                </tr>`;
            });

            template += `                   </tbody>
                                        </table>`;
            $('#busquedaSoporte').html(template);
        });
    }

    $(document).on('click', '.upImg', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('idSoporte');
        $('#txtIdSoporteImg').val(id);
    });

    $(document).on('click', '.view', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('idSoporte');
        funcion = 'cargar';
        $.post('../Controlador/soporteController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#pEstado').html('<b>Estado: </b>' + obj.estado);
            $('#pModulo').html('<b>Módulo: </b>' + obj.nombre_modulo);
            $('#pFecha').html('<b>Fecha: </b>' + obj.fecha);
            $('#pTipo').html('<b>Tipo: </b>' + obj.tipo);
            $('#pAutor').html('<b>Autor: </b>' + obj.nombre_completo);
            if (obj.imagen != "" && obj.imagen != null) {
                $('#imgCaso').attr('src', '../Recursos/img/soporte/' + obj.imagen);
            }
            $('#pDescripcion').html('<b>Descripción</b><br>' + obj.descripcion);
            if (obj.observaciones != "" && obj.observaciones != null) {
                $('#pObservaciones').html('<b>Observaciones de desarrollo</b><br>' + obj.observaciones);
            }
        })
    });

    $(document).on('click', '.changeEstado', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('idSoporte');
        $('#txtIdEstadoSop').val(id);
    });

    $('#form_img_soporte').submit(e => {
        let formData = new FormData($('#form_img_soporte')[0]);
        $.ajax({
            url: '../Controlador/soporteController.php',
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false
        }).done(function (response) {
            if (response.includes('update')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Imagén registrada'
                })
                $('#agregarSoporte').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_img_soporte').trigger('reset');
                buscarSolicitudes();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
        e.preventDefault();
    });

    $('#form_estado_soporte').submit(e => {
        e.preventDefault();
        let id_soporte = $('#txtIdEstadoSop').val();
        let estado = $('#selEstado').val();
        let observaciones = $('#txtObservaciones').val();
        funcion = 'cambiar_estado';
        $.post('../Controlador/soporteController.php', { funcion, id_soporte, estado, observaciones }, (response) => {
            if (response == 'update') {
                Toast.fire({
                    icon: 'success',
                    title: 'Soporte actualizado'
                })
                $('#form_estado_soporte').trigger('reset');
                buscarSolicitudes();
                contarSoporte();
                $('#cambiar_estado').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                if (estado == 'Finalizado') {
                    enviar_email_soporte_terminado(id_soporte);
                }

            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
    });

    function contarSoporte() {
        funcion = 'contar_soporte';
        $.post('../Controlador/soporteController.php', { funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#spanContacto').text(obj[0].cantidad);
        });
    }

    function enviar_email_soporte_terminado(id_soporte) {
        funcion = 'soporteTerminado';
        $.post('../Controlador/controlador_phpmailer.php', { funcion, id_soporte }, (response) => { });
    }
});
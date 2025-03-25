$(document).ready(function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    })

    var tipo_usuario = $('#txtTipoUsuario').val();
    var id_cargo = $('#txtCargoUsuario').val();
    var editar = $('#txtEditar').val();
    var ver = $('#txtVer').val();

    var funcion = "";
    var id_usuario = $('#id_usuario').val();

    buscarGestionUsuarios();

    $(document).on('keyup', '#TxtBuscarUsuario', function () {
        let consulta = $('#TxtBuscarUsuario').val();
        if (consulta.length > 3 || consulta.length == 0) { // También corregido aquí
            buscarGestionUsuarios(consulta);
        }
    });

    function buscarGestionUsuarios(consulta) {
        if (ver == 1 || tipo_usuario <= 2) {
            var hoy = new Date();
            var funcion = "buscar_gestion_usuario_full";

            $.post('../Controlador/usuarioController.php', { consulta, funcion, tipo_usuario, id_cargo }, (response) => {
                const usuarios = JSON.parse(response);
                let template = "";
                usuarios.forEach(usuario => {
                    template += `<div usuarioId="${usuario.id}" estadoU="${usuario.estado}" tipo="${usuario.tipo_usuario}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                    <div class="card bg-light">
                      <div class="card-header text-muted border-bottom-0">`;
                    if (usuario.tipo_usuario == 1) {
                        template += `<h1 class="badge badge-dark">${usuario.nombre_tipo}</h1>`;
                    }
                    if (usuario.tipo_usuario == 2) {
                        template += `<h1 class='badge badge-warning'>${usuario.nombre_tipo}</h1>`;
                    }
                    if (usuario.tipo_usuario == 3) {
                        template += `<h1 class='badge badge-info'>${usuario.nombre_tipo}</h1>`;
                    }
                    if (usuario.tipo_usuario == 4) {
                        template += `<h1 class='badge badge-primary'>${usuario.nombre_tipo}</h1>`;
                    }
                    if (usuario.tipo_usuario == 5) {
                        template += `<h1 class='badge badge-secondary'>${usuario.nombre_tipo}</h1>`;
                    }
                    if (usuario.tipo_usuario == 6) {
                        template += `<h1 class='badge badge-light'>${usuario.nombre_tipo}</h1>`;
                    }

                    if (usuario.estado == 1) {
                        template += `<h1 class="badge badge-success ml-1">Activo</h1>`;
                    } else {
                        template += `<h1 class="badge badge-danger ml-1">Inactivo</h1>`;
                    }

                    template += `</div>
                      <div class="card-body pt-0">
                        <div class="row">
                          <div class="col-8">
                            <h2 class="lead"><b>${usuario.nombre_completo}</b></h2>
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Dirección: ${usuario.direccion != null && usuario.direccion != "" ? usuario.direccion : "N/A"}</li>
                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Teléfono: ${usuario.telefono != null && usuario.telefono != "" ? usuario.telefono : "N/A"}</li>
                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-at"></i></span> Email: ${usuario.email != null && usuario.email != "" ? usuario.email : "N/A"}</li>
                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-at"></i></span> Email Institucional: ${usuario.correo_institucional != null && usuario.correo_institucional != "" ? usuario.correo_institucional : "N/A"}</li>
                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-map-marker-alt"></i></span> Ciudad: ${usuario.municipio} (${usuario.departamento})</li>
                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-sitemap"></i></span> Cargo: ${usuario.nombre_cargo}</li>
                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-city"></i></span> Empresa: ${usuario.nombre_empresa}</li>
                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-check-double"></i></span> Última conexión: ${usuario.fecha != 'N/A' ? usuario.fecha + " a las " + usuario.hora : "N/A"}</li>
                            </ul>`;
                    if (usuario.telefono !== null && usuario.telefono != '' && usuario.telefono != undefined) {
                        template += `<a href="https://api.whatsapp.com/send?phone=+57${usuario.telefono}&amp;text=Hola, quiero contactar contigo" target="_blank">
                                        <img src="../Recursos/img/whatsapp_icon.png" alt="" width="30px">
                                    </a>`;
                    }
                    if (usuario.facebook !== null && usuario.facebook != '' && usuario.facebook != undefined) {
                        template += `<a href="${usuario.facebook}" target="_blank">
                                        <img src="../Recursos/img/facebook_icon.png" alt="" width="30px">
                                    </a>`;
                    }
                    if (usuario.instagram !== null && usuario.instagram != '' && usuario.instagram != undefined) {
                        template += `<a href="${usuario.instagram}" target="_blank">
                                        <img src="../Recursos/img/instagram_icon.png" alt="" width="30px">
                                    </a>`;
                    }
                    if (usuario.tiktok !== null && usuario.tiktok != '' && usuario.tiktok != undefined) {
                        template += `<a href="${usuario.tiktok}" target="_blank">
                                        <img src="../Recursos/img/tiktok_icon.png" alt="" width="30px">
                                    </a>`;
                    }
                    if (usuario.youtube !== null && usuario.youtube != '' && usuario.youtube != undefined) {
                        template += `<a href="${usuario.youtube}" target="_blank">
                                        <img src="../Recursos/img/youtube_icon.png" alt="" width="30px">
                                    </a>`;
                    }

                    template += `     </ul></div>
                                        <div class="col-4 text-center">
                                            <img src="${usuario.avatar}" alt="" class="img-circle img-fluid" style='width: 80%'>`;

                    template += `      </div>
                        </div>
                      </div>
                      <div class="card-footer">
                        <div class="text-right" >`;

                    if (editar == 1) {
                        if (id_usuario != usuario.id) {
                            template += `<button class='login btn btn-sm btn-info ml-1' type='button' data-bs-toggle="modal" data-bs-target="#confirmar_resp" title='Restablecer login'>
                                            <i class="fas fa-key ml-1"></i>
                                        </button>`;
                            if (usuario.estado == 1) {
                                template += `<button class='activacion btn btn-sm btn-danger ml-1' type='button' data-bs-toggle="modal" data-bs-target="#confirmar_resp" title='Inactivar'>
                                                <i class="fas fa-window-close ml-1"></i>
                                            </button>`;
                            } else {
                                template += `<button class='activacion btn btn-sm btn-success ml-1' type='button' data-bs-toggle="modal" data-bs-target="#confirmar_resp" title='Activar'>
                                                <i class="fas fa-check ml-1"></i>
                                            </button>`;
                            }
                            if (tipo_usuario <= 2 || (id_cargo == 3 || id_cargo == 4 || id_cargo == 7)) {
                                template += `<button class='editcc btn btn-sm btn-primary ml-1' type='button' data-bs-toggle="modal" data-bs-target="#editar_cc" title='Editar'>
                                                <i class="fas fa-pencil-alt ml-1"></i>
                                            </button>`;
                            }
                        }
                    }
                    template += `<a href='../Vista/usuario.php?id=${usuario.id}&modulo=usuarios'>
                                    <button class='btn btn-sm btn-warning ml-1' type='button' title='Perfil'>
                                        <i class="fas fa-address-card"></i>
                                    </button>
                                </a>`;
                    template += `</div>
                      </div>
                    </div>
                  </div>`;
                });
                $('#busquedaUsuario').html(template);
            });
        } else {
            $('#busquedaUsuario').html("<h3>Tu cargo no tiene permisos para ver este contenido</h3>");
        }


    }

    $('#form_crear_usuario').submit(e => {
        let nombre_completo = $('#txtNombreUsuario').val();
        let documento = $('#txtDoc').val();
        let telefono = $('#txtTelefono').val();
        let email = $('#txtEmail').val();
        let id_tipo_usuario = $('#selTipoUsuario').val();
        let id_cargo = $('#selCargo').val();
        let id_empresa = $('#selEmpresa').val();
        funcion = 'crear_usuario';
        $.post('../Controlador/usuarioController.php', { funcion, nombre_completo, documento, telefono, email, id_tipo_usuario, id_cargo, id_empresa }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                buscarGestionUsuarios();
                enviarCorreoUsuarioNuevo(documento);
                $('#crearUsuario').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_crear_usuario').trigger('reset');
            }
        });
        e.preventDefault();
    });

    $(document).on('click', '.activacion', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id = $(elemento).attr('usuarioId');
        const estado = $(elemento).attr('estadoU');
        funcion = "activacion";
        $('#txtId_userConfirm').val(id);
        $('#txtFuncionConfirm').val(funcion);
        $('#txtEstadoConfirm').val(estado);
    });

    $(document).on('click', '.login', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id = $(elemento).attr('usuarioId');
        funcion = "restablecer_login";
        $('#txtId_userConfirm').val(id);
        $('#txtFuncionConfirm').val(funcion);
    });

    $(document).on('click', '.editcc', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        const id = $(elemento).attr('usuarioId');
        $('#txtIdCc').val(id);
        funcion = 'cargarCc';
        $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#txtDoc2').val(obj.doc_id);
            $('#selCargo2').val(obj.id_cargo).trigger('change.select2');
            $('#selTipoUsuario2').val(obj.id_tipo_usuario).trigger('change.select2');
            $('#selEmpresa2').val(obj.id_empresa).trigger('change.select2');
        });
    });

    $('#form_confirmar_user').submit(e => {
        let id = $('#txtId_userConfirm').val();
        funcion = $('#txtFuncionConfirm').val();
        let pass = $('#txtPass').val();
        let estado = $('#txtEstadoConfirm').val();
        let id_tipo_usuario = tipo_usuario;
        $.post('../Controlador/usuarioController.php', { id, funcion, pass, estado, id_tipo_usuario }, (response) => {
            if (response.includes('update')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Usuario Actualizado'
                })
                $('#form_confirmar_user').trigger('reset');
                $('#confirmar_resp').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                buscarGestionUsuarios();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
        e.preventDefault();
    });

    $('#form_update_cc').submit(e => {
        let id = $('#txtIdCc').val();
        let doc = $('#txtDoc2').val();
        let id_cargo = $('#selCargo2').val();
        let id_tipo_usuario = $('#selTipoUsuario2').val();
        let id_empresa = $('#selEmpresa2').val();
        funcion = 'update_cc';
        $.post('../Controlador/usuarioController.php', { id, funcion, doc, id_cargo, id_tipo_usuario, id_empresa }, (response) => {
            if (response == 'update') {
                buscarGestionUsuarios();
                Toast.fire({
                    icon: 'success',
                    title: 'Usuario Actualizado'
                })
                $('#editar_cc').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_update_cc').trigger('reset');
                buscarGestionUsuarios();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
        e.preventDefault();
    });


    function enviarCorreoUsuarioNuevo(doc_id) {
        funcion = 'usuarioNuevo';
        $.post('../Controlador/controlador_phpmailer.php', { funcion, doc_id }, (response) => { });
    }

});
$(document).ready(function () {

    var funcion = "";
    var id_usuario = $('#id_usuario').val();
    var pagina = $('#page').val();
    if (pagina == "editarInfPersonal" || pagina == "editar") {
        var edit = false;
        buscar_general(id_usuario);
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    })

    function buscar_general(id) {
        funcion = 'cargarUserFull';
        $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            
            $('#genero').html(obj.genero);
            $('#edad_usuario').html(obj.edad!=null?obj.edad:0 +' años');
            $('#fecha_nac').html(obj.fecha_nacimiento);
            $('#doc_usuario').html(obj.doc_id);
            $('#p_telefono').html(obj.telefono);
            $('#divNombrePass').html('<b>' + obj.nombre_completo + '</b>');
            $('#nombreUsuarioEdAvatar').html('<b>' + obj.nombre_completo + '</b>');
            $('#h3NombreUsuario').html('<b>' + obj.nombre_completo + '</b>');
            $('#p_residencia').html(obj.direccion + ", " + obj.municipio + " (" + obj.depto + ")");
            $('#p_email').html(obj.email);
            $('#p_cargo').html(obj.nombre_cargo);
            $('#p_sede').html(obj.nombre_sede);
            $('#p_tipo').html(obj.nombre_tipo);
            $('#p_info').html(obj.inf_usuario);
            $('#avatar1').attr('src', obj.avatar);
            $('#avatar2').attr('src', obj.avatar);
            $('#avatar3').attr('src', obj.avatar);

            $('#avatarScout').attr('src', obj.avatar);
            $('#imagenGrande').attr('src', obj.avatar);

            // Formulario
            $('#txtNombreUsuario').val(obj.nombre_completo);
            $('#titleUsuario').html(obj.nombre_completo);
            $('#selGenero').val(obj.genero);
            $('#txtDoc').val(obj.doc_id);
            $('#txtFecNac').val(obj.fecha_nacimiento);
            $('#selGenero').val(obj.genero);
            $('#txtTelefono').val(obj.telefono);
            $('#txtEmail').val(obj.email);
            $('#txtDireccion').val(obj.direccion);
            $('#selMunicipio').val(obj.ciudad_residencia).trigger('change.select2');;
            $('#txtInformacion').val(obj.inf_usuario);

            // Formulario pass
            $('#txtUsuarioCh').val(obj.usuario_login);

            // familiar
            $('#txtNombreMadre').val(obj.nombre_madre);
            $('#txtTelMadre').val(obj.telefono_madre);
            $('#txtNombrePadre').val(obj.nombre_padre);
            $('#txtTelPadre').val(obj.telefono_padre);
            listarPersonasACargo();

            //Academico
            $('#selNivelAcademico').val(obj.nivel_academico);
            $('#txtProfesion').val(obj.profesion);
            $('#txtExperiencia').val(obj.experiencia);
            $('#txtPension').val(obj.fondo);
            $('#txtCesantias').val(obj.cesantias);
            $('#txtArl').val(obj.arl);
            $('#selVerificarAsistencia').val(obj.verificar_asistencia);
            $('#selVerificarContrato').val(obj.verificar_contrato);
            $('#txtHoraEntrada').val(obj.hora_entrada);
            $('#txtCorreoInstitucional').val(obj.correo_institucional);
            $('#txtPassInstitucional').val(obj.clave_email_institucional);
            $('#txtTipoCuenta').val(obj.tipo_cuenta);
            $('#txtBanco').val(obj.banco);
            $('#txtNumeroCuenta').val(obj.numero_cuenta);
            $('#txtTelCorporativo').val(obj.telefono_corporativo);
            listarEstudios();
            listarCursos();

            // Salud
            $('#txtConEmerg').val(obj.contacto_emergencia);
            $('#txtParentezco').val(obj.parentezco_contacto);
            $('#txtTelEmerg').val(obj.telefono_contacto);
            $('#txtEps').val(obj.eps);
            $('#tipo_sangre').val(obj.tipo_sangre);
            listarAlergias();            
            listarAntecedentes();
            listarCirugia();
            listarEnfermedades();
            listarLesiones();
            listarMedicamentos();

            //sociodemografico
            $('#selEstrato').val(obj.estrato);
            $('#selEstadoCivil').val(obj.estado_civil);
            $('#selGrupoEtnico').val(obj.grupo_etnico);
            $('#txtPersonas_cargo').val(obj.personas_cargo);
            $('#selCabeza_familia').val(obj.cabeza_familia);
            $('#txtHijos').val(obj.hijos);
            $('#selFuma').val(obj.fuma);
            $('#txtfuma_frecuencia').val(obj.fuma_frecuencia);
            $('#selBebidas').val(obj.bebidas);
            $('#txtbebe_frecuencia').val(obj.bebidas_frecuencia);
            $('#txtDeporte').val(obj.deporte);
            $('#txtTallaCamisa').val(obj.talla_camisa);
            $('#txtTallaPantalon').val(obj.talla_pantalon);
            $('#txtTallaCalzado').val(obj.talla_calzado);
            $('#selTVivienda').val(obj.tipo_vivienda);
            $('#selLicencia').val(obj.licencia_conduccion);
            $('#txtLicencia_descr').val(obj.licencia_descr);
            $('#txtAct_tiempo_libre').val(obj.act_tiempo_libre);

            if (obj.firma_digital != "" && obj.firma_digital != null) {
                $('#divFirma').html(`<span style="border-radius: 3px;" class="info-box-icon bg-success elevation-1 pt-1 pb-1 pl-2 pr-2"><i class="fas fa-check"></i></span>
                <input type="file" id='inputFirma' name="firma_digital" required class='input-group' accept="image/*">
                <button type="submit" class='btn firma btn-outline-success btn-sm' style='width: 50px'><i class="fa fa-save"></button>`);
            } else {
                $('#divFirma').html(`<span style="border-radius: 3px;" class="info-box-icon bg-danger elevation-1 pt-1 pb-1 pl-2 pr-2"><i class="fas fa-ban"></i></span>
                <input type="file" id='inputFirma' name="firma_digital" required class='input-group' accept="image/*">
                <button type="submit" class='btn firma btn-outline-success btn-sm' style='width: 50px'><i class="fa fa-save"></button>`);
            }
        })
    };

    $('#formEditarGeneral').submit(e => {
        let nombre = $('#txtNombreUsuario').val();
        let doc_id = $('#txtDoc').val();
        let fecha_nacimiento = $('#txtFecNac').val();
        let genero = $('#selGenero').val();
        let telefono = $('#txtTelefono').val();
        let email = $('#txtEmail').val();
        let direccion = $('#txtDireccion').val();
        let ciudad_residencia = $('#selMunicipio').val();
        let inf_usuario = $('#txtInformacion').val();
        funcion = 'editar_usuario';
        $.post('../Controlador/usuarioController.php', { id_usuario, funcion, nombre, doc_id, fecha_nacimiento, telefono, direccion, email, inf_usuario, genero, ciudad_residencia }, (response) => {
            if (response.includes('editado')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Actualizado'
                })
                $('#formEditarGeneral').trigger('reset');
                edit = false;
                buscar_general(id_usuario);
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }

        })
        e.preventDefault();
    });

    $('#form_pass').submit(e => {
        let nameUser = $('#txtUsuarioCh').val();
        let oldpass = $('#oldPass').val();
        let newpass = $('#newPass').val();
        let newpass2 = $('#newPass2').val();
        if (newpass == newpass2) {
            funcion = "changePass";
            $.post('../Controlador/usuarioController.php', { id_usuario, funcion, nameUser, oldpass, newpass }, (response) => {
                if (response == 'update') {
                    Toast.fire({
                        icon: 'success',
                        title: 'Login Actualizado'
                    })
                    $('#form_pass').trigger('reset');
                    buscar_general(id_usuario);
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response
                    })
                }
            });
        } else {
            Toast.fire({
                icon: 'info',
                title: 'Las contraseñas no coinciden'
            })
        }

        e.preventDefault();
    });

    $('#form_avatar').submit(e => {
        let formData = new FormData($('#form_avatar')[0]);
        $(`#modalEspera`).modal(`show`);
        $('#imgEspera').html('<h2 class=`text-center`>Espere por favor<br><img src=`../Recursos/img/Update.gif` class=`center-all-contens`></h2>');
        $.ajax({
            url: '../Controlador/usuarioController.php',
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false
        }).done(function (response) {
            const json = JSON.parse(response);
            if (json.alert == 'edit') {
                $('#avatar3').attr('src', json.ruta);
                Toast.fire({
                    icon: 'success',
                    title: 'Avatar Actualizado'
                })
                $('#imgEspera').html('');
                $('#modalEspera').modal('hide');
                $('#changeAvatar').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_avatar').trigger('reset');
                buscar_general(id_usuario);
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
                $('#modalEspera').modal('hide');
                $('#imgEspera').html('');
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
            }
        });
        e.preventDefault();
    });

    $('#form_firma').submit(e => {
        e.preventDefault();
        $(`#modalEspera`).modal(`show`);
        $('#imgEspera').html('<h2 class="text-center">Espere por favor<br><div><img src="../Recursos/img/cargando.gif"></div><p></p></h2>');
        let formData = new FormData($('#form_firma')[0]);
        var ext = $('#inputFirma').val().split('.').pop();
        if (ext == "png") {
            $.ajax({
                url: '../Controlador/usuarioController.php',
                type: 'POST',
                data: formData,
                cache: false,
                processData: false,
                contentType: false
            }).done(function (response) {
                if (response.includes('update')) {
                    buscar_general(id_usuario);
                    $('#modalEspera').modal('hide');
                    $('#imgEspera').html('');
                    $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                    $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                    Toast.fire({
                        icon: 'success',
                        title: 'Firma actualizada'
                    })
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response
                    })
                    $('#modalEspera').modal('hide');
                    $('#imgEspera').html('');
                    $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                    $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                }
            });
        } else {
            Toast.fire({
                icon: 'info',
                title: "La firma debe ser en formato png y con fondo transparente"
            })
        }
    });

    //Personas a cargo
    $('#form_crear_persona_cargo').submit(e => {
        let nombre = $('#txtNombrePersona').val();
        let fecha_nac = $('#txtFechaNacPersona').val();
        let parentezco = $('#selParentezcoPersona').val();
        funcion = 'crear_persona_cargo';
        $.post('../Controlador/usuarioController.php', { id_usuario, funcion, nombre, fecha_nac, parentezco }, (response) => {
            if (response.includes('creado')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Registro Exitoso'
                })
                listarPersonasACargo();
                $('#personaCargo').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        })
        e.preventDefault();
    });

    function listarPersonasACargo() {
        var funcion = "listar_persona_a_cargo";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            template = "";
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${objeto.nombre}</td>
                                                    <td>${objeto.edad}</td>
                                                    <td>${objeto.fecha_nac}</td>
                                                    <td>${objeto.parentezco}</td>
                                                    <td>`;
                template += `                           <button class='eliminarPersona btn btn-sm btn-danger mr-1' type='button' >
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>`;
                template += `                       </td>
                                                </tr>`;
            });
            $('#bodyPersonasCargo').html(template);
        });
    }

    $(document).on('click', '.eliminarPersona', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea eliminar este registro?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Aceptar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'eliminar_persona_a_cargo';
                $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
                    if (response.includes('eliminado')) {
                        Swal.fire('Registro Eliminado!', '', 'success');
                        listarPersonasACargo();
                    } else {
                        Swal.fire('Registro Eliminado!', '', 'error');
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('No se eliminó el registro', '', 'info')
            }
        })
    });

    //Medicamentos
    $('#form_crear_medicamento').submit(e => {
        let nombre = $('#txtNombreMed').val();
        let indicaciones = $('#txtIndicaciones').val();
        funcion = 'crear_medicamento';
        $.post('../Controlador/usuarioController.php', { id_usuario, funcion, nombre, indicaciones }, (response) => {
            if (response.includes('creado')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Registro Exitoso'
                })
                $('#crearMedicamento').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                listarMedicamentos();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        })
        e.preventDefault();
    });

    function listarMedicamentos() {
        var funcion = "listar_medicamentos";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            template = "";
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${objeto.nombre}</td>
                                                    <td>${objeto.indicaciones}</td>
                                                    <td>`;
                template += `                           <button class='eliminarMedicamento btn btn-sm btn-danger mr-1' type='button' >
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>`;
                template += `                       </td>
                                                </tr>`;
            });
            $('#bodyMedicamento').html(template);
        });
    }

    $(document).on('click', '.eliminarMedicamento', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea eliminar este registro?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Aceptar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'eliminar_medicamento';
                $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
                    if (response.includes('eliminado')) {
                        Swal.fire('Registro Eliminado!', '', 'success');
                        listarMedicamentos();
                    } else {
                        Swal.fire('Error al eliminar', '', 'error');
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('No se eliminó el registro', '', 'info')
            }
        })
    });

    //Enfermedades
    $('#form_crear_enfermedad').submit(e => {
        let nombre = $('#txtNombreEnf').val();
        funcion = 'crear_enfermedad';
        $.post('../Controlador/usuarioController.php', { id_usuario, funcion, nombre }, (response) => {
            if (response.includes('creado')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Registro Exitoso'
                })
                listarEnfermedades();
                $('#crearEnfermedad').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        })
        e.preventDefault();
    });

    function listarEnfermedades() {
        var funcion = "listar_enfermedad";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            template = "";
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${objeto.nombre}</td>
                                                    <td>`;
                template += `                           <button class='eliminarEnfermedad btn btn-sm btn-danger mr-1' type='button' >
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>`;
                template += `                       </td>
                                                </tr>`;
            });
            $('#bodyEnfermedad').html(template);
        });
    }

    $(document).on('click', '.eliminarEnfermedad', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea eliminar este registro?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Aceptar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'eliminar_enfermedad';
                $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
                    if (response.includes('eliminado')) {
                        Swal.fire('Registro Eliminado!', '', 'success');
                        listarEnfermedades();
                    } else {
                        Swal.fire('Error al eliminar', '', 'error');
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('No se eliminó el registro', '', 'info')
            }
        })
    });

    //Alergias
    $('#form_crear_alergia').submit(e => {
        let tipo = $('#selTipoAlergia').val();
        let nombre = $('#txtNombreAlergia').val();
        funcion = 'crear_alergia';
        $.post('../Controlador/usuarioController.php', { id_usuario, funcion, nombre, tipo }, (response) => {
            if (response.includes('creado')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Registro Exitoso'
                })
                listarAlergias();
                $('#crearAlergia').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        })
        e.preventDefault();
    });

    function listarAlergias() {
        var funcion = "listar_alergia";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            template = "";
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${objeto.tipo}</td>
                                                    <td>${objeto.nombre}</td>
                                                    <td>`;
                template += `                           <button class='eliminarAlergia btn btn-sm btn-danger mr-1' type='button' >
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>`;
                template += `                       </td>
                                                </tr>`;
            });
            $('#bodyAlergia').html(template);
        });
    }

    $(document).on('click', '.eliminarAlergia', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea eliminar este registro?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Aceptar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'eliminar_alergia';
                $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
                    if (response.includes('eliminado')) {
                        Swal.fire('Registro Eliminado!', '', 'success');
                        listarAlergias();
                    } else {
                        Swal.fire('Error al eliminar', '', 'error');
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('No se eliminó el registro', '', 'info')
            }
        })
        e.preventDefault();
    });

    //Cirugias
    $('#form_crear_cirugia').submit(e => {
        let nombre = $('#txtNombreCirugia').val();
        funcion = 'crear_cirugia';
        $.post('../Controlador/usuarioController.php', { id_usuario, funcion, nombre }, (response) => {
            if (response.includes('creado')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Registro Exitoso'
                })
                listarCirugia();
                $('#crearCirugia').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        })
        e.preventDefault();
    });

    function listarCirugia() {
        var funcion = "listar_cirugia";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            template = "";
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${objeto.nombre}</td>
                                                    <td>`;
                template += `                           <button class='eliminarCirugia btn btn-sm btn-danger mr-1' type='button' >
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>`;
                template += `                       </td>
                                                </tr>`;
            });
            $('#bodyCirugia').html(template);
        });
    }

    $(document).on('click', '.eliminarCirugia', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea eliminar este registro?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Aceptar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'eliminar_cirugia';
                $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
                    if (response.includes('eliminado')) {
                        Swal.fire('Registro Eliminado!', '', 'success');
                        listarCirugia();
                    } else {
                        Swal.fire('Error al eliminar', '', 'error');
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('No se eliminó el registro', '', 'info')
            }
        })
    });

    //Lesiones
    $('#form_crear_lesion').submit(e => {
        let tipo = $('#selTipoLesion').val();
        let nombre = $('#txtNombreLesion').val();
        funcion = 'crear_lesion';
        $.post('../Controlador/usuarioController.php', { id_usuario, funcion, nombre, tipo }, (response) => {
            if (response.includes('creado')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Registro Exitoso'
                })
                listarLesiones();
                $('#crearLesion').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        })
        e.preventDefault();
    });

    function listarLesiones() {
        var funcion = "listar_lesion";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            template = "";
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${objeto.tipo}</td>
                                                    <td>${objeto.nombre}</td>
                                                    <td>`;
                template += `                           <button class='eliminarLesion btn btn-sm btn-danger mr-1' type='button' >
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>`;
                template += `                       </td>
                                                </tr>`;
            });
            $('#bodyLesion').html(template);
        });
    }

    $(document).on('click', '.eliminarLesion', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea eliminar este registro?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Aceptar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'eliminar_lesion';
                $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
                    if (response.includes('eliminado')) {
                        Swal.fire('Registro Eliminado!', '', 'success');
                        listarLesiones();
                    } else {
                        Swal.fire('Error al eliminar', '', 'error');
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('No se eliminó el registro', '', 'info')
            }
        })
    });

    //Antecedentes
    $('#form_crear_antecedente').submit(e => {
        let nombre = $('#selAntecedente').val();
        funcion = 'crear_antecedente';
        $.post('../Controlador/usuarioController.php', { id_usuario, funcion, nombre }, (response) => {
            if (response.includes('creado')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Registro Exitoso'
                })
                listarAntecedentes();
                $('#crearAntecedente').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        })
        e.preventDefault();
    });

    function listarAntecedentes() {
        var funcion = "listar_antecedente";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            template = "";
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${objeto.nombre}</td>
                                                    <td>`;
                template += `                           <button class='eliminarAntecedente btn btn-sm btn-danger mr-1' type='button' >
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>`;
                template += `                       </td>
                                                </tr>`;
            });
            $('#bodyAntecedente').html(template);
        });
    }

    $(document).on('click', '.eliminarAntecedente', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea eliminar este registro?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Aceptar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'eliminar_antecedente';
                $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
                    if (response.includes('eliminado')) {
                        Swal.fire('Registro Eliminado!', '', 'success');
                        listarAntecedentes();
                    } else {
                        Swal.fire('Error al eliminar', '', 'error');
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('No se eliminó el registro', '', 'info')
            }
        })
    });

    //Estudios
    $('#form_crear_estudio').submit(e => {
        let nivel = $('#selNivel').val();
        let tipo_nivel = $('#selTipoEstudio').val();
        let titulo = $('#txtTitulo').val();
        let institucion = $('#txtInstitucion').val();
        let año = $('#txtAñoEstudio').val();
        let ciudad = $('#txtCiudad').val();
        funcion = 'crear_estudio';
        $.post('../Controlador/usuarioController.php', { id_usuario, funcion, nivel, tipo_nivel, titulo, institucion, año, ciudad }, (response) => {
            if (response.includes('creado')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Registro Exitoso'
                })
                listarEstudios();
                $('#crearEstudio').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        })
        e.preventDefault();
    });

    function listarEstudios() {
        var funcion = "listar_estudio";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            template = "";
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${objeto.nivel}</td>
                                                    <td>${objeto.tipo_nivel}</td>
                                                    <td>${objeto.titulo}</td>
                                                    <td>${objeto.institucion}</td>
                                                    <td>${objeto.ano}</td>
                                                    <td>${objeto.ciudad}</td>
                                                    <td>`;
                template += `                           <button class='eliminarEstudios btn btn-sm btn-danger mr-1' type='button' >
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>`;
                template += `                       </td>
                                                </tr>`;
            });
            $('#bodyEstudios').html(template);
        });
    }

    $(document).on('click', '.eliminarEstudios', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea eliminar este registro?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Aceptar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'eliminar_estudio';
                $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
                    if (response.includes('eliminado')) {
                        Swal.fire('Registro Eliminado!', '', 'success');
                        listarEstudios();
                    } else {
                        Swal.fire('Error al eliminar', '', 'error');
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('No se eliminó el registro', '', 'info')
            }
        })
    });

    //Cursos
    $('#form_crear_curso').submit(e => {
        let fecha = $('#txtFechaCurso').val();
        let institucion = $('#txtInstitucionCurso').val();
        let descripcion = $('#txtNombreCurso').val();
        let horas = $('#txtHorasCursos').val();
        funcion = 'crear_curso';
        $.post('../Controlador/usuarioController.php', { id_usuario, funcion,fecha, institucion, descripcion, horas }, (response) => {
            if (response.includes('creado')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Registro Exitoso'
                })
                listarCursos();
                $('#crearOtroEst').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        })
        e.preventDefault();
    });

    function listarCursos() {
        var funcion = "listar_curso";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            template = "";
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${objeto.descripcion}</td>
                                                    <td>${objeto.fecha}</td>
                                                    <td>${objeto.institucion}</td>
                                                    <td>${objeto.horas}</td>
                                                    <td>`;
                template += `                           <button class='eliminarCurso btn btn-sm btn-danger mr-1' type='button' >
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>`;
                template += `                       </td>
                                                </tr>`;
            });
            $('#bodyCursos').html(template);
        });
    }

    $(document).on('click', '.eliminarCurso', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea eliminar este registro?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Aceptar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'eliminar_curso';
                $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
                    if (response.includes('eliminado')) {
                        Swal.fire('Registro Eliminado!', '', 'success');
                        listarCursos();
                    } else {
                        Swal.fire('Error al eliminar', '', 'error');
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('No se eliminó el registro', '', 'info')
            }
        })
    });

});

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
})

function salud() {
    let id_usuario = $('#id_usuario').val();
    let tipo_sangre = $('#selTipoSangre').val();
    let contacto_emergencia = $('#txtConEmerg').val();
    let parentezco_contacto = $('#txtParentezco').val();
    let telefono_contacto = $('#txtTelEmerg').val();
    let eps = $('#txtEps').val();
    funcion = 'editar_salud';
    $.post('../Controlador/usuarioController.php', { funcion, id_usuario, eps, tipo_sangre, contacto_emergencia, parentezco_contacto, telefono_contacto }, (response) => {
        if (response.includes('editado')) {
            Toast.fire({
                icon: 'success',
                title: 'Actualizado'
            })
        } else {
            Toast.fire({
                icon: 'error',
                title: response
            })
        }

    })
}

function academica() {
    let id_usuario = $('#id_usuario').val();
    let nivel_academico = $('#selNivelAcademico').val();
    let profesion = $('#txtProfesion').val();
    let experiencia = $('#txtExperiencia').val();
    let fondo = $('#txtPension').val();
    let cesantias = $('#txtCesantias').val();
    let arl = $('#txtArl').val();
    let correo_institucional = $('#txtCorreoInstitucional').val();
    let clave_email_institucional = $('#txtPassInstitucional').val();
    let tipo_cuenta = $('#txtTipoCuenta').val();
    let numero_cuenta = $('#txtNumeroCuenta').val();
    let banco = $('#txtBanco').val();
    let hora_entrada = $('#txtHoraEntrada').val();
    let verificar_asistencia = $('#selVerificarAsistencia').val();
    let verificar_contrato = $('#selVerificarContrato').val();
    let telefono_corporativo = $('#txtTelCorporativo').val();
    funcion = 'editar_academica_laboral';
    $.post('../Controlador/usuarioController.php', { funcion, hora_entrada, verificar_asistencia, id_usuario, nivel_academico, profesion, experiencia, fondo, cesantias, arl, correo_institucional, clave_email_institucional, tipo_cuenta, numero_cuenta, banco, telefono_corporativo, verificar_contrato }, (response) => {
        if (response.includes('editado')) {
            Toast.fire({
                icon: 'success',
                title: 'Actualizado'
            })
        } else {
            Toast.fire({
                icon: 'error',
                title: response
            })
        }

    })
}

function familiar() {
    let nombre_madre = $('#txtNombreMadre').val();
    let telefono_madre = $('#txtTelMadre').val();
    let nombre_padre = $('#txtNombrePadre').val();
    let telefono_padre = $('#txtTelPadre').val();
    let id_usuario = $('#id_usuario').val();
    funcion = 'editar_familiar';
    $.post('../Controlador/usuarioController.php', { funcion, id_usuario, nombre_madre, telefono_madre, nombre_padre, telefono_padre }, (response) => {
        if (response.includes('editado')) {
            Toast.fire({
                icon: 'success',
                title: 'Actualizado'
            })
        } else {
            Toast.fire({
                icon: 'error',
                title: response
            })
        }

    })
}
function sociodemografica() {
    let id_usuario = $('#id_usuario').val();
    let estrato = $('#selEstrato').val();
    let estado_civil = $('#selEstadoCivil').val();
    let grupo_etnico = $('#selGrupoEtnico').val();
    let personas_cargo = $('#txtPersonas_cargo').val();
    let cabeza_familia = $('#selCabeza_familia').val();
    let hijos = $('#txtHijos').val();
    let fuma = $('#selFuma').val();
    let fuma_frecuencia = $('#txtfuma_frecuencia').val();
    let bebidas = $('#selBebidas').val();
    let bebidas_frecuencia = $('#txtbebe_frecuencia').val();
    let deporte = $('#txtDeporte').val();
    let talla_camisa = $('#txtTallaCamisa').val();
    let talla_pantalon = $('#txtTallaPantalon').val();
    let talla_calzado = $('#txtTallaCalzado').val();
    let tipo_vivienda = $('#selTVivienda').val();
    let licencia_conduccion = $('#selLicencia').val();
    let licencia_descr = $('#txtLicencia_descr').val();
    let act_tiempo_libre = $('#txtAct_tiempo_libre').val();
    funcion = 'editar_sociodemografica';
    $.post('../Controlador/usuarioController.php', {
        funcion, id_usuario, estrato, estado_civil, grupo_etnico, personas_cargo, cabeza_familia, hijos,
        fuma, fuma_frecuencia, bebidas, bebidas_frecuencia, deporte, talla_calzado, talla_camisa, talla_pantalon, tipo_vivienda, licencia_conduccion, licencia_descr, act_tiempo_libre
    }, (response) => {
        if (response.includes('editado')) {
            Toast.fire({
                icon: 'success',
                title: 'Actualizado'
            })
        } else {
            Toast.fire({
                icon: 'error',
                title: response
            })
        }

    })
}
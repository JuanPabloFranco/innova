$(document).ready(function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    var funcion = "";
    var id_usuario = $('#txtId').val();
    var page = $('#page').val();

    if (page == 'autogestion') {
        solicitudes(id_usuario);
        incapacidades(id_usuario);
        compensaciones(id_usuario);
        reporteVacaciones(id_usuario);
        compensacionHoras(id_usuario);
        tiempoParaTi(id_usuario);
    }

    function reporteVacaciones(id_usuario) {
        funcion = 'vacacionesAutogestion';
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const obj = JSON.parse(response);
            if (obj.disfrutados != null) {
                $('#h2Disfrutados').html(obj.disfrutados);
            }
            if (obj.compensados != null) {
                $('#h2Compensados').html(obj.compensados);
            }
            if (obj.ultimas_vacaciones != null) {
                $('#pUltimasVacaciones').html(obj.ultimas_vacaciones + " (" + obj.ultimos_disfrutados + " días tomados)");
            }
            if (obj.dias_contratado != null) {
                $('#divLaborados').html(obj.dias_contratado);
                $('#divCartaLaboral').show();
            } else {
                $('#divCartaLaboral').hide();
            }
            if (obj.periodos != null) {
                $('#divPeriodos').html(obj.periodos);
            }
            if (obj.dias_acumulados != null && obj.dias_contratado >= 364) {
                $('#divDiasDisponibles').html(obj.dias_acumulados - obj.disfrutados);
            }
            if (obj.dias_nuevo_periodo != null) {
                $('#divDiasNuevoPeriodo').html(obj.dias_nuevo_periodo);
            }
            if (obj.disfrutados != null || obj.compensados != null) {
                if (obj.disfrutados != null && obj.compensados == null) {
                    $('#h2Total').html(obj.disfrutados);
                }
                if (obj.disfrutados == null && obj.compensados != null) {
                    $('#h2Total').html(obj.compensados);
                }
                if (obj.disfrutados != null && obj.compensados != null) {
                    $('#h2Total').html(parseInt(obj.disfrutados) + parseInt(obj.compensados));
                }
            }
        })
    }

    function incapacidades(id_usuario) {
        var funcion = "listarIncapacidadesUsuario";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            let template = `            <table class="table table-bordered text-center">
                                            <thead>                  
                                                <tr class='notiHeader'>
                                                    <th >#</th>
                                                    <th>Estado</th>                                                    
                                                    <th>Fecha Inicio</th>                                                    
                                                    <th>Fecha Fin</th>                                                    
                                                    <th>Duración</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            var num = 0;
            var estado = "";
            objetos.forEach(objeto => {
                num += 1;
                if (objeto.estado == 1) {
                    estado = "<h1 class='badge badge-success'>Activa</h1>";
                } else {
                    estado = "<h1 class='badge badge-dark'>Inactiva</h1>";
                }
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${estado}</td>
                                                    <td>${objeto.inicio}</td>
                                                    <td>${objeto.fin}</td>
                                                    <td>${objeto.duracion} días</td>
                                                    <td>`;
                template += `                           <button class='detalleIncapacidad btn btn-sm btn-secondary mr-1' type='button' data-bs-toggle="modal" data-bs-target="#detalle_incapacidad" title='Detalle'>
                                                            <i class="fas fa-eye"></i>
                                                        </button>`;

                template += `                       </td>
                                                </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#divIncapacidades').html(template);
        });
    }

    $(document).on('click', '.detalleIncapacidad', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        funcion = 'cargarIncapacidad';
        $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            if (obj.estado == 1) {
                estado = "<h1 class='badge badge-success'>Activa</h1>";
            } else {
                estado = "<h1 class='badge badge-dark'>Inactiva</h1>";
            }
            $('#pColaboradorIncapacidad').html("<b>Colaborador: </b>" + obj.nombre_completo);
            $('#pDocIdIncapacidad').html("<b>Documento: </b>" + obj.doc_id);
            $('#pSedeIncapacidad').html("<b>Sede: </b>" + obj.nombre_sede);
            $('#pCargoIncapacidad').html("<b>Cargo: </b>" + obj.nombre_cargo);
            $('#pTipoIncapacidad').html("<b>Tipo de solicitud: </b>" + obj.tipo);
            $('#pInicio').html("<b>Fecha Inicio: </b>" + obj.inicio);
            $('#pEstadoIncapacidad').html(estado);
            $('#pFin').html("<b>Fecha Final: </b>" + obj.fin);
            $('#pDuracion').html("<b>Duración: </b>" + obj.duracion);
            if (obj.descripcion != null && obj.descripcion != undefined) {
                $('#pDescripcion').html("<b>Descripción: </b>" + obj.descripcion);
                $('#pDescripcion').show();
            }
            if (obj.diagnostico != null && obj.diagnostico != undefined) {
                $('#pDiagnostico').html("<b>Diagnóstico: </b><br>" + obj.diagnostico);
                $('#pDiagnostico').show();
            }
        })
    });

    function compensaciones(id_usuario) {
        var funcion = "listarCompensacionesUsuario";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            let template = `            <table class="table table-bordered text-center">
                                                <thead>                  
                                                    <tr class='notiHeader'>
                                                        <th >#</th>
                                                        <th>Estado</th>                                       
                                                        <th>Disponibles</th> 
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;
            var num = 0;
            var estado = "";
            objetos.forEach(objeto => {
                num += 1;
                if (objeto.estado == 1) {
                    estado = "<h1 class='badge badge-success'>Activo</h1>";
                } else {
                    estado = "<h1 class='badge badge-dark'>Inactivo</h1>";
                }
                template += `                   <tr id=${objeto.id} >
                                                        <td>${num}</td>
                                                        <td>${estado}</td>
                                                        <td>${objeto.dias} días</td>
                                                        <td>`;
                template += `                           <button class='detalleCompensacion btn btn-sm btn-info mr-1' type='button' data-bs-toggle="modal" data-bs-target="#detalle_compensacion" title='Detalle'>
                                                                <i class="fas fa-eye"></i>
                                                            </button>`;
                template += `                       </td>
                                                    </tr>`;
            });
            template += `                   </tbody>
                                            </table>`;
            $('#divCompensaciones').html(template);
        });
    }

    $(document).on('click', '.detalleCompensacion', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        funcion = 'cargarCompensacion';
        $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            if (obj.estado == 1) {
                estado = "<h1 class='badge badge-success'>Activo</h1>";
            } else {
                estado = "<h1 class='badge badge-dark'>Inactivo</h1>";
            }
            $('#divEstadoVer').html("<b>Estado: </b>" + estado);
            $('#divDiasVer').html("<b>Días disponibles: </b>" + obj.dias);
            $('#divColaborador').html("<b>Colaborador: </b>" + obj.nombre_colaborador + "<br><b>Documento: </b>" + obj.doc_id + "<br><b>Cargo: </b>" + obj.nombre_cargo + "<br><b>Sede: </b>" + obj.nombre_sede);
            $('#divAutor').html("<b>Creado Por: </b>" + obj.nombre_autor);
            compensacionDetalle(id);
        })
    });

    function compensacionDetalle(id_compensacion) {
        var funcion = "listarCompensacionesDetalle";
        $.post('../Controlador/usuarioController.php', { funcion, id_compensacion }, (response) => {
            const objetos = JSON.parse(response);
            let template = `            <table class="table table-bordered text-center">
                                            <thead>                  
                                                <tr class='notiHeader'>
                                                    <th >#</th>
                                                    <th>Fecha</th>                                                    
                                                    <th>Autor</th>                                                    
                                                    <th>Descripción</th>   
                                                </tr>
                                            </thead>
                                            <tbody>`;
            var num = 0;
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id} >
                                                    <td>${num}</td>
                                                    <td>${objeto.fecha_creacion}</td>
                                                    <td>${objeto.autor_detalle}</td>
                                                    <td>${objeto.descripcion}</td>`;

                template += `                   </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#divDetalleCompensaciones').html(template);
        });
    }

    function solicitudes(id_usuario) {
        var funcion = "listarSolicitudesUsuario";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            let template = `            <table class="table table-bordered text-center">
                                            <thead>                  
                                                <tr class='notiHeader'>
                                                    <th >#</th>
                                                    <th>Estado</th>                                                    
                                                    <th>Tipo</th>                                                    
                                                    <th>Cantidad</th>
                                                    <th>Fecha Inicio</th>                                                    
                                                    <th>Fecha Final</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            var num = 0;
            var estado = "";
            objetos.forEach(objeto => {
                num += 1;
                if (objeto.estado == 1) {
                    estado = "<h1 class='badge badge-warning'>Pendiente</h1>";
                } else if (objeto.estado == 2) {
                    estado = "<h1 class='badge badge-success'>Aprobado</h1>";
                } else if (objeto.estado == 3) {
                    estado = "<h1 class='badge badge-dark'>Rechazado</h1>";
                } else if (objeto.estado == 4) {
                    estado = "<h1 class='badge badge-primary'>Anulado</h1>";
                }
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${estado}</td>
                                                    <td>${objeto.tipo}</td>
                                                    <td>${objeto.tipo == 'Permiso' ? objeto.cantidad_horas + ' horas' : objeto.cantidad + ' días'}</td>
                                                    <td>${objeto.fecha_inicial}</td>
                                                    <td>${objeto.fecha_final != null ? objeto.fecha_final : "N/A"}</td>
                                                    <td>`;
                template += `                           <button class='detalle btn btn-sm btn-secondary' type='button' data-bs-toggle="modal" data-bs-target="#detalle_solicitud" title='Detalle'>
                                                            <i class="fas fa-eye"></i>
                                                        </button>`;
                if (objeto.estado == 1) {
                    template += `                       <button class='anular btn btn-sm btn-dark' type='button' title='Anular'>
                                                            <i class="fas fa-ban"></i>
                                                        </button>`;
                }
                if (objeto.estado == 4) {
                    template += `                       <button class='eliminarSolicitud btn btn-sm btn-danger' type='button' title='Eliminar'>
                                                            <i class="fas fa-trash"></i>
                                                        </button>`;
                }
                template += `                       <button class='adjunto btn btn-sm btn-warning' type='button' data-bs-toggle="modal" data-bs-target="#crearAdjuntoSolicitud" title='Agregar Adjunto'>
                                                        <i class="fas fa-paperclip"></i>
                                                    </button>`;
                template += `                       </td>
                                                </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#divSolicitudes').html(template);
        });
    }

    $(document).on('click', '.adjunto', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        $('#txtIdSolicitudAdjunto').val(id);
    });

    $("#form_crear_adjunto_solicitud").on("submit", function (e) {
        e.preventDefault();
        var ext = $('#txtAdjunto').val().split('.').pop();
        if (ext == 'xls' || ext == 'xlsx' || ext == 'doc' || ext == 'docx' || ext == 'pdf' || ext == 'jpg' || ext == 'png' || ext == 'jpeg') {
            var f = $(this);
            var formData = new FormData(document.getElementById("form_crear_adjunto_solicitud"));
            formData.append("dato", "valor");
            var peticion = $('#form_crear_adjunto_solicitud').attr('action');
            $.ajax({
                url: '../Controlador/usuarioController.php',
                type: 'POST',
                data: formData,
                cache: false,
                processData: false,
                contentType: false
            }).done(function (response) {
                const respuesta = JSON.parse(response);
                Toast.fire({
                    icon: respuesta[0].type,
                    title: respuesta[0].mensaje
                })
                if (!respuesta[0].error) {
                    solicitudes();
                    $('#form_crear_adjunto_solicitud').trigger('reset');
                    $('#crearAdjuntoSolicitud').modal('hide'); //ocultamos el modal
                    $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                    $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                }
            });
        } else {
            Toast.fire({
                icon: 'info',
                title: "Los formatos permitidos son: pdf, xlsx, xls, doc, docx, jpg, jpeg, png"
            })
        }
    });

    function adjuntosSolicitud(id_solicitud) {
        var funcion = "listar_adjuntos_solicitud";
        $.post('../Controlador/usuarioController.php', { funcion, id_solicitud }, (response) => {
            const objetos = JSON.parse(response);
            let template = `            <table class="table table-bordered text-center">
                                            <thead>                  
                                                <tr class='notiHeader'>
                                                    <th >#</th>
                                                    <th>Adjunto</th>     
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            var num = 0;
            var estado = "";
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td><a href="../Recursos/adjuntos/solicitudes/${objeto.adjunto}" target="_blank">${objeto.adjunto}</a></td>                                                   
                                                    <td>`;
                template += `                           <button class='eliminarAdjunto btn btn-sm btn-danger' type='button' title='Eliminar Adjunto'>
                                                            <i class="fas fa-trash"></i>
                                                        </button>`;
                template += `                       </td>
                                                </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#divAdjuntosSolicitud').html(template);
        });
    }

    $(document).on('click', '.eliminarAdjunto', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea eliminar este adjunto de la solicitud??',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Aceptar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'eliminar_adjunto_solicitud';
                $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
                    Swal.fire('Adjunto Eliminado!', '', 'success');
                    $('#detalle_solicitud').modal('hide'); //ocultamos el modal
                    $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                    $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                });
            }
        })
    });

    $('#form_crear_compensacion_horas').submit(e => {
        e.preventDefault();
        let horas_solicitadas = $('#txtHorasSolicitadas').val();
        let fecha_laboradas = $('#txtFechaLaboradas').val();
        funcion = 'crear_compensacion_horas';
        $.post('../Controlador/usuarioController.php', { funcion, horas_solicitadas, fecha_laboradas }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                $("#crear_compensacion_horas").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_crear_compensacion_horas').trigger('reset');
                compensacionHoras(id_usuario);
                enviar_email_compensacion_horas($respuesta[0].id)
            }
        });
    });

    function compensacionHoras(id_usuario) {
        var funcion = "listarCompensacionesHorasUsuario";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            let template = `            <table class="table table-bordered text-center">
                                            <thead>                  
                                                <tr class='notiHeader'>
                                                    <th >#</th>
                                                    <th>Estado</th>                                                    
                                                    <th>Fecha Solicitud</th>                                                    
                                                    <th>Horas Solicitadas</th>
                                                    <th>Horas Aprobadas</th>                                                    
                                                    <th>Fecha Compensación</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            var num = 0;
            var estado = "";
            objetos.forEach(objeto => {
                num += 1;
                if (objeto.estado == 1) {
                    etiqueta = "primary";
                    estado = "Pendiente";
                } else if (objeto.estado == 2) {
                    etiqueta = "success";
                    estado = "Aprobado";
                } else {
                    etiqueta = "danger";
                    estado = "Rechazado";
                }
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td><h1 class='badge badge-${etiqueta}'>${estado}</h1></td>
                                                    <td>${objeto.fecha_solicitud}</td>
                                                    <td>${objeto.horas_solicitadas}</td>
                                                    <td>${objeto.horas_aprobadas != null ? objeto.fecha_compensacion : "N/A"}</td>
                                                    <td>${objeto.fecha_compensacion != null ? objeto.fecha_compensacion : "N/A"}</td>
                                                    <td>`;
                template += `                           <button class='detalleHoras btn btn-sm btn-secondary' type='button' data-bs-toggle="modal" data-bs-target="#detalle_compensacion_horas" title='Detalle'>
                                                            <i class="fas fa-eye"></i>
                                                        </button>`;
                if (objeto.estado == 1) {
                    template += `                       <button class='anularHoras btn btn-sm btn-danger' type='button' title='Eliminar'>
                                                            <i class="fas fa-trash"></i>
                                                        </button>`;
                }
                template += `                       </td>
                                                </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#divCompensacionesHoras').html(template);
        });
    }

    $(document).on('click', '.detalleHoras', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        funcion = 'cargarCompensacionHoras';
        $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            var etiqueta = "";
            var estado = "";
            if (obj.estado == 1) {
                etiqueta = "primary";
                estado = "Pendiente";
            } else if (obj.estado == 2) {
                etiqueta = "success";
                estado = "Aprobado";
            } else {
                etiqueta = "danger";
                estado = "Rechazado";
            }

            $('#divEstadoHoras').html(`<h1 class='badge badge-${etiqueta}'>${estado}</h1>`);
            $('#FechaSolicitudHoras').html('<p><b>Fecha Solicitud: </b>' + obj.fecha_solicitud + "</p>");
            $('#pColaboradorHoras').html('<b>Nombre: </b>' + obj.nombre_colaborador);
            $('#pCargoHoras').html('<b>Cargo: </b>' + obj.nombre_cargo);
            $('#pSedeHoras').html('<b>Sede: </b>' + obj.nombre_sede);
            $('#pAreaHoras').html('<b>Área: </b>' + obj.nombre_area);
            $('#pFechaLaboradosHoras').html('<b>Fecha horas laboradas: </b>' + obj.fecha_laboradas);
            $('#pHorasSolicitadas').html('<b>Horas Solicitadas: </b>' + obj.horas_solicitadas);
            if (obj.estado == 2) {
                $('#pFechaAprobacionHoras').html('<b>Fecha Aprobación: </b>' + obj.fecha_aprobacion);
                $('#pHorasAprobados').html('<b>Horas Aprobadas: </b>' + obj.horas_aprobadas);
                $('#pFechaCompensacionHoras').html('<b>Fecha Compensación: </b>' + obj.fecha_compensacion);
                $('#pAprobadorHoras').html('<b>Aprobado por: </b>' + obj.nombre_aprobador);
                $('#pNota').html('<b>Nota: </b><br>' + obj.nota);
            } else {
                $('#pFechaAprobacionHoras').html('');
                $('#pHorasAprobados').html('');
                $('#pFechaCompensacionHoras').html('');
                $('#pAprobadorHoras').html('');
                $('#pNota').html('');
            }
        })
    });

    $(document).on('click', '.eliminarSolicitud', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea eliminar esta solicitud?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Si`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                let estado = 4;
                funcion = 'eliminar_solicitud';
                $.post('../Controlador/usuarioController.php', { id, funcion, estado }, (response) => {
                    if (response.includes('delete')) {
                        Swal.fire('Solicitud Eliminada!', '', 'success');
                        enviar_email_cambio_estado_solicitud(id);
                        solicitudes(id_usuario);
                    } else {
                        Swal.fire('Error al eliminar!', '', 'error');
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('No se eliminó la solicitud', '', 'info')
            }
        })
    });

    $(document).on('click', '.anular', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea anular esta solicitud?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Si`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                let estado = 4;
                funcion = 'cambiar_estado_solicitud';
                $.post('../Controlador/usuarioController.php', { id, funcion, estado }, (response) => {
                    if (response.includes('update')) {
                        Swal.fire('Solicitud Anulada!', '', 'success');
                        enviar_email_cambio_estado_solicitud(id);
                        solicitudes(id_usuario);
                    } else {
                        Swal.fire('Error al anular!', '', 'error');
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('No se anuló la solicitud', '', 'info')
            }
        })
    });

    $(document).on('click', '.anularHoras', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea eliminar esta solicitud de compensación de horas laborales?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Si`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'eliminar_compensacion_horas';
                $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
                    const obj = JSON.parse(response);
                    Swal.fire(respuesta[0].mensaje, '', respuesta[0].type);
                    if (!respuesta[0].error) {
                        $("#crear_compensacion_horas").modal('hide'); //ocultamos el modal
                        $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                        $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                        $('#form_crear_compensacion_horas').trigger('reset');
                        compensacionHoras(id_usuario);
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('No se anuló la solicitud', '', 'info')
            }
        })
    });

    $('#form_carta_laboral').submit(function (e) {
        e.preventDefault(); // Evita que se envíe el formulario de la manera tradicional
        let tipo = $('#selTipoCartaLaboral').val();
        let dirigido = $('#txtDirigidoA').val();
        // Construye la URL con los parámetros GET
        let url = `../Vista/cartaLaboralPdf.php?page=autogestion&tipo=${tipo}&dirigido=${encodeURIComponent(dirigido)}`;
        window.open(url, '_blank'); // Abre el PDF en una nueva pestaña
    });


    $(document).on('click', '.detalle', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        funcion = 'cargarSolicitud';
        $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            if (obj.estado == 1) {
                estado = "<h1 class='badge badge-warning'>Pendiente</h1>";
            } else if (obj.estado == 2) {
                estado = "<h1 class='badge badge-success'>Aprobado</h1>";
            } else if (obj.estado == 3) {
                estado = "<h1 class='badge badge-dark'>Rechazado</h1>";
            } else if (obj.estado == 4) {
                estado = "<h1 class='badge badge-primary'>Anulado</h1>";
            }
            $('#pColaborador').html("<b>Colaborador: </b>" + obj.nombre_completo);
            $('#pDocId').html("<b>Documento: </b>" + obj.doc_id);
            $('#pSede').html("<b>Sede: </b>" + obj.nombre_sede);
            $('#pArea').html("<b>Área: </b>" + obj.nombre_area);
            $('#pCargo').html("<b>Cargo: </b>" + obj.nombre_cargo);
            $('#pTipo').html("<b>Tipo de solicitud: </b>" + obj.tipo);
            $('#pFechaSolicitud').html("<b>Fecha Solicitud: </b>" + obj.fecha_solicitud);
            $('#pEstado').html(estado);
            $('#pFechaInicial').html("<b>Fecha Inicial: </b>" + obj.fecha_inicial);
            $('#pFechaFinal').html("<b>Fecha Final: </b>" + obj.fecha_final);
            $('#pDiasSolicitados').html(obj.tipo == 'Permiso' ? "<b>Cantidad: </b>" + obj.cantidad_horas + ' horas' : "<b>Cantidad: </b>" + obj.cantidad + ' días');
            // if (obj.compensados != null) {
            //     $('#pDiasCompensados').html("<b>Días Compensados: </b>" + obj.compensados);
            //     $('#pDiasCompensados').show();
            // }
            if (obj.observaciones != null) {
                $('#pObservaciones').html("<b>Observaciones: </b><br>" + obj.observaciones);
            } else {
                $('#pObservaciones').html("");
            }
            if (obj.nombre_aprobador != null) {
                $('#pNombreAprobador').html("<b>Aprobado Por: </b>" + obj.nombre_aprobador);
            } else {
                $('#pNombreAprobador').html("");
            }
            if (obj.observaciones_aprobador != null) {
                $('#pObsAprobador').html("<b>Observaciones Aprobador: </b><br>" + obj.observaciones_aprobador);
            } else {
                $('#pObsAprobador').html("");
            }
            adjuntosSolicitud(id);
        })
    });

    $('#form_crear_solicitud').submit(e => {
        let tipo = $('#selTipoSolicitud').val();
        let fecha_inicial = $('#txtFechaInicial').val();
        let observaciones = $('#txtObservaciones').val();
        let cantidad = $('#txtCantidad').val();
        let cantidad_horas = $('#txtCantidadHoras').val();
        let id_usuario_solicitud = "";
        if (page == 'autogestion') {
            id_usuario_solicitud = id_usuario;
        }
        if (page == 'adm') {
            id_usuario_solicitud = $('#selUsuario').val();
        }
        funcion = 'crear_solicitud';
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario_solicitud, tipo, fecha_inicial, cantidad, observaciones, cantidad_horas }, (response) => {
            if (response.includes('create')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Solicitud registrada'
                })
                $('#crear_solicitud').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_crear_solicitud').trigger('reset');
                enviar_email_solicitud(id_usuario_solicitud, tipo, fecha_inicial, cantidad, observaciones, cantidad_horas);
                if (page == 'autogestion') {
                    solicitudes(id_usuario);
                }
                if (page == 'adm') {                    
                    setInterval(() => {
                        location.reload();
                    }, 6000);
                }
            } else {
                Toast.fire({
                    icon: 'error',
                    title: "Error al registrar la solicitud"
                })
            }
        });
        e.preventDefault();
    });

    $('#form_crear_tiempo').submit(e => {
        let horario = $('#selHorario').val();
        let fecha_aprobacion = $('#txtFechaAprobacion').val();

        const date = new Date();

        // Ajustar la fecha a la zona horaria de Bogotá
        const options = {
            timeZone: 'America/Bogota',
            year: 'numeric',
            month: '2-digit', // Usar dos dígitos para el mes
            day: '2-digit' // Usar dos dígitos para el día
        };

        const formatter = new Intl.DateTimeFormat('es-ES', options);
        const parts = formatter.formatToParts(date);

        // Extraer las partes necesarias y construir la fecha en el formato YYYY-MM-DD
        const year = parts.find(part => part.type === 'year').value;
        const month = parts.find(part => part.type === 'month').value;
        const day = parts.find(part => part.type === 'day').value;

        var fecha_solicitud = `${year}-${month}-${day}`;
        var dias = diasEntreDosFechas(fecha_solicitud, fecha_aprobacion);

        if (dias <= 13) {
            funcion = 'crear';
            $.post('../Controlador/tiempoParaTiController.php', { funcion, id_usuario, horario, fecha_solicitud, fecha_aprobacion }, (response) => {
                const respuesta = JSON.parse(response);
                Toast.fire({
                    icon: respuesta[0].type,
                    title: respuesta[0].mensaje
                })
                if (!respuesta[0].error) {
                    tiempoParaTi(id_usuario);
                    $('#crear_tiempo').modal('hide'); //ocultamos el modal
                    $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                    $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                    enviar_email_solicitud_tiempo_para_ti(id_usuario, horario, fecha_solicitud, fecha_aprobacion);
                }
            });
        } else {
            Toast.fire({
                icon: 'info',
                title: 'Debes solicitar tiempo para la ' + obtenerSemanaSiguiente(fecha_solicitud)
            })
        }
        e.preventDefault();
    });

    function diasEntreDosFechas(fechaInicial, fechaFinal) {
        // Parsear las fechas en el formato "YYYY-MM-DD"
        const date1 = new Date(fechaInicial);
        const date2 = new Date(fechaFinal);

        // Obtener la diferencia en milisegundos
        const differenceInMillis = Math.abs(date2 - date1);

        // Convertir la diferencia de milisegundos a días
        const millisecondsPerDay = 1000 * 60 * 60 * 24;
        const differenceInDays = Math.ceil(differenceInMillis / millisecondsPerDay);

        return differenceInDays;
    }

    function formatearFecha(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    function tiempoParaTi(id_usuario) {
        var habilitado = false;
        const hoy = new Date();
        var dias = 0;
        var fechaHoy = formatearFecha(hoy);
        var funcion = "listar_por_usuario";
        $.post('../Controlador/tiempoParaTiController.php', { funcion, id_usuario }, (response) => {

            const objetos = JSON.parse(response);
            let template = `            <table class="table table-bordered text-center">
                                            <thead>                  
                                                <tr class='notiHeader'>
                                                    <th >#</th>
                                                    <th>Estado</th>                                                 
                                                    <th>Fecha Solicitud</th>  
                                                    <th>Fecha a disfrutar</th>  
                                                    <th>Horario</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            var num = 0;
            var estado = "";
            objetos.forEach(objeto => {
                num += 1;
                const fecha_aprobacion = new Date(objeto.fecha_aprobacion);
                if (num == 1) {
                    if (fecha_aprobacion < hoy) {
                        habilitado = true;
                    }
                }
                if (objeto.estado == 0) {
                    estado = "<h1 class='badge badge-warning'>Pendiente</h1>";
                } else if (objeto.estado == 1) {
                    estado = "<h1 class='badge badge-success'>Aprobado</h1>";
                } else if (objeto.estado == 2) {
                    estado = "<h1 class='badge badge-dark'>Rechazado</h1>";
                } else if (objeto.estado == 3) {
                    estado = "<h1 class='badge badge-primary'>Anulado</h1>";
                }

                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${estado}</td>
                                                    <td>${objeto.fecha_solicitud}</td>
                                                    <td>${objeto.fecha_aprobacion != null ? objeto.fecha_aprobacion : "N/A"}</td>
                                                    <td>${objeto.horario}</td>
                                                    <td>`;
                template += `                           <button class='detalleTiempoParaTi btn btn-sm btn-info mr-1' type='button' title='Editar Solicitud' data-bs-toggle="modal" data-bs-target="#detalle_solicitud_tiempo">
                                                            <i class="fas fa-info-circle"></i>
                                                        </button>`;
                if (objeto.estado == 0) {
                    template += `                       <button class='anularTiempo btn btn-sm btn-dark' type='button' title='Anular'>
                                                            <i class="fas fa-ban"></i>
                                                        </button>`;
                }
                template += `                       </td>
                                                </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#divTiempoParaTi').html(template);
            if (habilitado || num == 0) {
                $('#btnSolicitarTiempo').attr('style', '');
            }
        });
    }

    $(document).on('click', '.detalleTiempoParaTi', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        funcion = 'cargar';
        $.post('../Controlador/tiempoParaTiController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            if (obj.estado == 0) {
                estado = "<h1 class='badge badge-warning'>Pendiente</h1>";
            } else if (obj.estado == 1) {
                estado = "<h1 class='badge badge-success'>Aprobado</h1>";
            } else if (obj.estado == 2) {
                estado = "<h1 class='badge badge-dark'>Rechazado</h1>";
            } else if (obj.estado == 3) {
                estado = "<h1 class='badge badge-primary'>Anulado</h1>";
            }
            $('#pColaborador').html("<b>Colaborador: </b>" + obj.nombre_completo);
            $('#pDocId').html("<b>Documento: </b>" + obj.doc_id);
            $('#pSede').html("<b>Sede: </b>" + obj.nombre_sede);
            $('#pCargo').html("<b>Cargo: </b>" + obj.nombre_cargo);
            $('#pTipo').html("<b>Tipo de solicitud: </b>" + obj.tipo);
            $('#pFechaSolicitud').html("<b>Fecha Solicitud: </b>" + obj.fecha_solicitud);
            $('#pEstado').html(estado);
            $('#pFechaAprobacion').html(obj.fecha_aprobacion != null ? "<b>Fecha a Disfrutar: </b>" + obj.fecha_aprobacion : "<b>Fecha Aprobación: </b> N/A");
            $('#pSemana').html(obtenerSemanaSiguiente(obj.fecha_solicitud));
            $('#pHorario').html("<b>Horario: </b>" + obj.horario);
            adjuntosSolicitud(id);
        })
    });

    function obtenerSemanaSiguiente(startDateStr) {
        // Parsear la fecha de entrada "YYYY-MM-DD"
        const [year, month, day] = startDateStr.split('-').map(Number);
        const startDate = new Date(year, month - 1, day); // Crear la fecha inicial

        const result = [];
        const date = new Date(startDate);

        // Obtener el día de la semana (0 = domingo, 1 = lunes, ..., 6 = sábado)
        const dayOfWeek = date.getDay();

        // Calcular los días hasta el próximo lunes
        const daysUntilNextMonday = (8 - dayOfWeek) % 7;

        // Ajustar la fecha al próximo lunes
        date.setDate(date.getDate() + daysUntilNextMonday);

        // Formatear fechas
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        const monday = new Date(date);
        const mondayStr = monday.toLocaleDateString('es-ES', options);

        // Obtener las fechas de lunes a viernes de la semana siguiente
        for (let i = 0; i < 5; i++) {
            result.push(new Date(date));
            date.setDate(date.getDate() + 1);
        }

        const friday = result[result.length - 1];
        const fridayStr = friday.toLocaleDateString('es-ES', options);

        return `Semana del ${mondayStr} al ${fridayStr}`;
    }

    $(document).on('click', '.anularTiempo', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: '¿Desea anular esta solicitud?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Aceptar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                var estado = 3;
                funcion = 'cambiar_estado';
                $.post('../Controlador/tiempoParaTiController.php', { id, funcion, estado }, (response) => {
                    const respuesta = JSON.parse(response);
                    Toast.fire({
                        icon: respuesta[0].type,
                        title: respuesta[0].mensaje
                    })
                    if (!respuesta[0].error) {
                        Swal.fire('Estado cambiado!', '', 'success');
                        tiempoParaTi(id_usuario);
                    }
                });
            }
        })
    });

    function enviar_email_solicitud(id_usuario, tipo, fecha_inicial, cantidad, observaciones, cantidad_horas) {
        funcion = 'enviar_email_solicitud';
        $.post('../Controlador/controlador_phpmailer.php', { funcion, id_usuario, tipo, fecha_inicial, cantidad, observaciones, cantidad_horas }, (response) => {
        });
    }

    function enviar_email_cambio_estado_solicitud(id) {
        funcion = 'cambio_estado_solicitud';
        $.post('../Controlador/controlador_phpmailer.php', { funcion, id }, (response) => {
        });
    }

    function enviar_email_compensacion_horas(id) {
        funcion = 'solicitud_compensacion_horas';
        $.post('../Controlador/controlador_phpmailer.php', { funcion, id }, (response) => {
        });
    }

    function enviar_email_solicitud_tiempo_para_ti(id_usuario, horario, fecha_solicitud, fecha_aprobacion) {
        funcion = 'enviar_email_solicitud_tiempo_para_ti';
        $.post('../Controlador/controlador_phpmailer.php', { funcion, id_usuario, horario, fecha_solicitud, fecha_aprobacion }, (response) => {
        });
    }
});

function tipoSolicitud(valor) {
    if (valor == "Vacaciones") {
        $('#divCantidad').show();
        $('#divCantidadHoras').hide();
    } else if (valor == "Permiso") {
        $('#divCantidad').hide();
        $('#divCantidadHoras').show();
    } else {
        $('#divCantidad').hide();
        $('#divCantidadHoras').hide();
    }
}

function calcularFechaFinal() {
    let tipo = $('#selTipoSolicitud').val();
    const fecha_inicial = new Date($('#txtFechaInicial').val());
    const fechaInicialFormateada = `${fecha_inicial.getDate() + 1}/${fecha_inicial.getMonth() + 1}/${fecha_inicial.getFullYear()}`;

    if (tipo == "Vacaciones") {
        let cantidad = $('#txtCantidad').val();
        funcion = 'calcularFechaFinal';
        inicial = $('#txtFechaInicial').val();
        $.post('../Controlador/usuarioController.php', { funcion, inicial, cantidad }, (response) => {
            const fecha = new Date(response);
            const fechaFinalFormateada = `${fecha.getDate()}/${fecha.getMonth() + 1}/${fecha.getFullYear()}`;
            $('#txtTiempoSolicitud').val(fechaInicialFormateada + " - " + fechaFinalFormateada);

            // Actualizar el daterangepicker con el nuevo rango de fechas
            $('#txtTiempoSolicitud').data('daterangepicker').setStartDate(fechaInicialFormateada);
            $('#txtTiempoSolicitud').data('daterangepicker').setEndDate(fechaFinalFormateada);

        });
    } else {
        $('#txtTiempoSolicitud').val(fechaInicialFormateada + " - " + fechaInicialFormateada);

        // Actualizar el daterangepicker con el nuevo rango de fechas
        $('#txtTiempoSolicitud').data('daterangepicker').setStartDate(fechaInicialFormateada);
        $('#txtTiempoSolicitud').data('daterangepicker').setEndDate(fechaInicialFormateada);
    }
}

function calcularFechaFinal2() {
    let tipo = $('#selTipoSolicitud2').val();
    const fecha_inicial = new Date($('#txtFechaInicial2').val());
    const fechaInicialFormateada = `${fecha_inicial.getDate() + 1}/${fecha_inicial.getMonth() + 1}/${fecha_inicial.getFullYear()}`;

    if (tipo == "Vacaciones") {
        let cantidad = $('#txtCantidad2').val();
        funcion = 'calcularFechaFinal';
        inicial = $('#txtFechaInicial2').val();
        $.post('../Controlador/usuarioController.php', { funcion, inicial, cantidad }, (response) => {
            const fecha = new Date(response);
            const fechaFinalFormateada = `${fecha.getDate()}/${fecha.getMonth() + 1}/${fecha.getFullYear()}`;
            $('#txtTiempoSolicitud2').val(fechaInicialFormateada + " - " + fechaFinalFormateada);

            // Actualizar el daterangepicker con el nuevo rango de fechas
            $('#txtTiempoSolicitud2').data('daterangepicker').setStartDate(fechaInicialFormateada);
            $('#txtTiempoSolicitud2').data('daterangepicker').setEndDate(fechaFinalFormateada);

        });
    } else {
        $('#txtTiempoSolicitud2').val(fechaInicialFormateada + " - " + fechaInicialFormateada);

        // Actualizar el daterangepicker con el nuevo rango de fechas
        $('#txtTiempoSolicitud2').data('daterangepicker').setStartDate(fechaInicialFormateada);
        $('#txtTiempoSolicitud2').data('daterangepicker').setEndDate(fechaInicialFormateada);
    }
}

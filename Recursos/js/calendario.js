$(document).ready(function () {
    var funcion = "";
    var tipo_usuario = $('#txtTipoUsuario').val();
    var editarTarea = $('#txtEditar').val();
    var verTarea = $('#txtVer').val();
    var eliminarTarea = $('#txtEliminar').val();
    var page = $('#txtPage').val();
    var calendarUsuario = "";
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    var popoverTriggerList = Array.prototype.slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    })
    if (page == "calendario") {
        tipoCalendario();
        setTimeout(function () {
            cargarCalendario();
        }, 1000);
    } else {
        buscarMiAgenda();
        $(document).on('keyup', '#TxtBuscar', function () {
            let consulta = $('#TxtBuscar').val();
            if (consulta.length > 3 || consulta.length == 0) { // También corregido aquí
                buscarMiAgenda(consulta);
            }
        });
    }

    $('#form_crear_tarea').submit(e => {
        e.preventDefault();
        let habilitar = 0;
        let nombre = $('#txtNombre').val();
        let fecha_inicio = $('#txtFechaInicial').val();
        let fecha_fin = $('#txtFechaFin').val();
        let descripcion = $('#txtDescripcion').val();
        let tipo_tarea = $('#selTipo').val();
        let observaciones = $('#txtObservaciones').val();
        // Cita
        let ubicacion = $('#selUbicacion').val();
        let descripcion_ubicacion = $('#txtDescripcionUbicacion').val();
        // Gestion redes

        // Responsables
        var responsablesImg = [];
        if ($('#divResponsables').html() != "") {
            var contenedor = document.getElementById('divResponsables');
            var imagenes = contenedor.querySelectorAll('img');
            imagenes.forEach(function (imagen) {
                responsablesImg.push(imagen.id);
            })
            var responsables = JSON.stringify(responsablesImg);
        }
        var mensaje = "No se ha habilitado el registro, es posible que falte agregar un responsable";
        if (fecha_fin > fecha_inicio) {
            if (tipo_tarea == "Tarea" || tipo_tarea == "Laboral Festivo") {
                if (nombre != "" && fecha_inicio != "" && fecha_fin != "" && descripcion != "") {
                    if (responsablesImg.length === 0) {
                        mensaje = "Es necesario agregar al menos 1 responsable";
                    } else {
                        habilitar = 1;
                    }
                } else {
                    mensaje = "Complete los datos requeridos";
                }
            }
            if (tipo_tarea == "Cita / Reunión" || tipo_tarea == "Evento") {
                if (nombre != "" && fecha_inicio != "" && fecha_fin != "" && descripcion != "" && ubicacion != "" && descripcion_ubicacion != "") {
                    if (responsablesImg.length === 0) {
                        mensaje = "Es necesario agregar al menos 1 responsable";
                    } else {
                        habilitar = 1;
                    }
                } else {
                    mensaje = "Complete los datos requeridos";
                }
            }

            if (habilitar == 1) {
                $('#btnGuardarTarea').attr('disabled', '');
                $(`#modalEspera`).modal(`show`);
                $('#imgEspera').html('<h2 class=`text-center`>Espere por favor<br><div><img src=`../Recursos/img/cargando.gif`></div><p></p></h2>');
                funcion = 'crear_tarea';
                $.post('../Controlador/tareaController.php', { funcion, nombre, descripcion, fecha_inicio, fecha_fin, tipo_tarea, ubicacion, descripcion_ubicacion, responsables, observaciones }, (response) => {
                    if (response.includes('creado')) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Tarea registrada'
                        })
                        $('#btnGuardarTarea').attr('disabled', 'false');
                        $(`#modalEspera`).modal(`hide`);
                        $('#imgEspera').html('');

                        $("#crearTarea").modal('hide'); //ocultamos el modal
                        $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                        $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                        $('#form_crear_tarea').trigger('reset');
                        $('#divResponsables').html("");
                        cargarCalendario();
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response
                        })
                        $('#btnGuardarTarea').attr('disabled', 'false');
                        $(`#modalEspera`).modal(`hide`);
                        $('#imgEspera').html('');
                    }
                });
            } else {
                Toast.fire({
                    icon: 'info',
                    title: mensaje
                })
            }
        } else {
            Toast.fire({
                icon: 'info',
                title: 'La fecha final debe ser mayor a la inicial'
            })
        }
    });

    $('#form_editar_tarea').submit(e => {
        e.preventDefault();
        let habilitar = 0;
        let id = $('#txtIdTareaEdit').val();
        let nombre = $('#txtNombre2').val();
        let fecha_inicio = $('#txtFechaInicial2').val();
        let fecha_fin = $('#txtFechaFin2').val();
        let descripcion = $('#txtDescripcion2').val();
        let tipo_tarea = $('#selTipo2').val();
        // Cita
        let ubicacion = $('#selUbicación2').val();
        let descripcion_ubicacion = $('#txtDescripcionUbicacion2').val();
        let observaciones = $('#txtObservaciones2').val();

        var responsablesImg = [];
        if ($('#divResponsables2').html() != "") {
            var contenedor = document.getElementById('divResponsables2');
            var imagenes = contenedor.querySelectorAll('img');
            imagenes.forEach(function (imagen) {
                responsablesImg.push(imagen.id);
            })
            var responsables = JSON.stringify(responsablesImg);
        }
        var mensaje = "No se ha habilitado el registro, es posible que falte agregar un responsable";
        if (fecha_fin > fecha_inicio) {
            if (tipo_tarea == "Tarea" || tipo_tarea == "Laboral Festivo") {
                if (nombre != "" && fecha_inicio != "" && fecha_fin != "" && descripcion != "") {
                    if (responsablesImg.length === 0) {
                        mensaje = "Es necesario agregar al menos 1 responsable";
                    } else {
                        habilitar = 1;
                    }
                } else {
                    mensaje = "Complete los datos requeridos";
                }
            }
            if (tipo_tarea == "Cita / Reunión" || tipo_tarea == "Evento") {
                if (nombre != "" && fecha_inicio != "" && fecha_fin != "" && descripcion != "" && ubicacion != "" && descripcion_ubicacion != "") {
                    if (responsablesImg.length === 0) {
                        mensaje = "Es necesario agregar al menos 1 responsable";
                    } else {
                        habilitar = 1;
                    }
                } else {
                    mensaje = "Complete los datos requeridos (Ubicación, descripción Ubicación)";
                }
            }

            if (habilitar == 1) {
                funcion = 'editar_tarea';
                var pagina = "calendario";
                $('#btnGuardarProducto').attr('disabled', '');
                $(`#modalEspera`).modal(`show`);
                $('#imgEspera').html('<h2 class=`text-center`>Espere por favor<br><div><img src=`../Recursos/img/cargando.gif`></div><p></p></h2>');
                $.post('../Controlador/tareaController.php', { funcion, id, nombre, descripcion, fecha_inicio, fecha_fin, tipo_tarea, ubicacion, descripcion_ubicacion, responsables, observaciones, pagina }, (response) => {
                    if (response.includes('update')) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Tarea actualizada'
                        })
                        $("#editarTarea").modal('hide'); //ocultamos el modal
                        $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                        $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                        $('#form_editar_tarea').trigger('reset');
                        $('#btnGuardarProducto').attr('disabled', 'false');
                        $(`#modalEspera`).modal(`hide`);
                        $('#imgEspera').html('');
                        if (page == "calendario") {
                            cargarCalendario();
                        } else {
                            buscarMiAgenda();
                        }
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
                    title: mensaje
                })
            }
        } else {
            Toast.fire({
                icon: 'info',
                title: 'La fecha final debe ser mayor a la inicial'
            })
        }
    });

    $(document).on('click', '.editTarea', (e) => {
        e.preventDefault();
        $('#modalVer').modal('hide'); //ocultamos el modal
        $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
        $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
        $('#editarTarea').modal('show'); //ocultamos el modal
        const elemento = $(this)[0].activeElement;
        const id = $(elemento).attr('id');
        $('#txtIdTareaEdit').val(id);
        funcion = 'cargarTarea';
        $.post('../Controlador/tareaController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#selTipo2').val(obj.tipoTarea);
            $('#txtNombre2').val(obj.nombreTarea);
            $('#txtDescripcion2').val(obj.descripcion);
            $('#txtFechaInicial2').val(obj.fechaInicio);
            $('#txtFechaFin2').val(obj.fechaFin);
            $('#txtObservaciones2').val(obj.observaciones);
            if (obj.tipoTarea == "Cita / Reunión" || obj.tipoTarea == "Evento") {
                $('#divUbicacion2').show();
                $('#selUbicación2').val(obj.ubicacion);
                $('#divUbicacionDesc2').show();
                $('#txtDescripcionUbicacion2').val(obj.descripcion_ubicacion);
            }
            $('#divResponsables2').html(obj.responsables);
            setTimeout(function () {
                $('#selProducto2').val(obj.idProducto).trigger('change.select2');
            }, 2000);
        });
    });

    $(document).on('click', '.imgResponsable', (e) => {
        const img = $(e.target);
        img.remove();
    });

    function tipoCalendario() {
        funcion = 'buscar_calendar';
        $.post('../Controlador/usuarioController.php', { funcion }, (response) => {
            const obj = JSON.parse(response);
            calendarUsuario = obj.calendar;
            // Verificar si calendarUsuario es null y asignar un valor predeterminado si es necesario
            calendarUsuario = calendarUsuario ? calendarUsuario : 'dayGridMonth'; // Valor predeterminado
        })
    }

    function buscarMiAgenda(consulta) {
        if (verTarea == 1) {
            var funcion = "miAgenda";
            $.post('../Controlador/tareaController.php', { consulta, funcion }, (response) => {
                const objetos = JSON.parse(response);
                num = 0;
                let template = `<div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered table-responsive center-all">
                                                <thead class='notiHeader'>                  
                                                    <tr>
                                                        <th>#</th>                                                    
                                                        <th>Estado</th>
                                                        <th>Tipo</th>
                                                        <th>Nombre</th>
                                                        <th>Fecha Inicial</th>
                                                        <th>Fecha Final</th>
                                                        <th>Responsables</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;

                objetos.forEach(objeto => {
                    num += 1;
                    var estado = "";
                    if (objeto.estado == 1) {
                        estado = '<h1 class="badge badge-lg badge-secondary">Pendiente</h1><br>';
                    }
                    if (objeto.estado == 2) {
                        estado = '<h1 class="badge badge-lg badge-success">Finalizada</h1><br>';
                    }
                    if (objeto.estado == 3) {
                        estado = '<h1 class="badge badge-lg badge-dark">Cancelada</h1><br>';
                    }
                    template += `                   <tr id=${objeto.id}>
                                                        <td>${num}</td>
                                                        <td>${estado}</td>
                                                        <td>${objeto.tipo_tarea}</td>
                                                        <td>${objeto.nombre}</td>
                                                        <td>${objeto.fecha_inicio}</td>
                                                        <td>${objeto.fecha_fin}</td>
                                                        <td>${objeto.responsables}</td>
                                                        <td>`;
                    if (editarTarea == 1 || tipo_usuario <= 2) {
                        template += `                       <button id='${objeto.id}' class='editTarea btn btn-sm btn-primary ml-2' type='button' title='Editar'>
                                                                <i class='fas fa-pencil-alt'></i>
                                                            </button>`;
                        if (objeto.estado == 3) {
                            template += `                   <button id='${objeto.id}' class='activate btn btn-sm btn-info mr-1' type='button' title='Activar'>
                                                                <i class="fas fa-check"></i>
                                                            </button>`;
                        }
                        if (objeto.estado != 2) {
                            template += `                   <button id='${objeto.id}' class='check btn btn-sm btn-success mr-1' type='button' title='Finalizar'>
                                                                <i class="fas fa-check-double"></i>
                                                            </button>`;
                        }
                        if (objeto.estado != 2 && objeto.estado != 3) {
                            template += `                   <button id='${objeto.id}' class='cancel btn btn-sm btn-dark mr-1' type='button' title='Cancelar'>
                                                                <i class="fas fa-ban"></i>
                                                            </button>`;
                        }
                    }
                    if (eliminarTarea == 1 || tipo_usuario <= 2) {
                        template += `                       <button id='${objeto.id}' class='del btn btn-sm btn-danger mr-1' type='button' title='Eliminar'>
                                                                <i class="fas fa-trash"></i>
                                                            </button>`;
                    }
                    template += `                       </td>
                                                    </tr>`;
                });
                template += `                       </tbody>
                                            </table>
                                        </div> 
                                    </div>`;
                $('#busqueda').html(template);
            });
        } else {
            $('#busqueda').html("Tu cargo no tiene permisos para ver esta información");
        }
    }

    function cargarCalendario() {
        var id_responsable = $('#selIdUsuario').val();
        $.getJSON("../Controlador/calendarioController.php", { id: id_responsable })
            .done(function (data) {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    timeZone: 'America/Bogota',
                    initialView: calendarUsuario,
                    locales: 'es',
                    headerToolbar: {
                        left: 'title',
                        center: 'prev,next',
                        right: 'dayGridMonth, timeGridWeek, timeGridDay'
                    },
                    editable: false,
                    firstDay: 1,
                    selectable: true,
                    displayEventTime: false,
                    googleCalendarApiKey: 'AIzaSyDcnW6WejpTOCffshGDDb4neIrXVUA1EAE',
                    eventSources: [
                        {
                            events: data
                        },
                        {
                            googleCalendarId: 'es-419.co#holiday@group.v.calendar.google.com',
                            className: 'gcal-event' // an option!
                        }
                    ],
                    eventClick: function (info) {
                        info.jsEvent.preventDefault();
                        if (info.event.url) {
                            return;
                        }
                        info.el.style.borderColor = 'blue';
                        if (info.event.extendedProps.tipoEvento == 'Tarea') {
                            if (info.event.extendedProps.estado == 1) {
                                $("#badges").html('<h1 class="badge badge-lg badge-secondary">Pendiente</h1><br>');
                            }
                            if (info.event.extendedProps.estado == 2) {
                                $("#badges").html('<h1 class="badge badge-lg badge-success">Finalizada</h1><br>');
                            }
                            if (info.event.extendedProps.estado == 3) {
                                $("#badges").html('<h1 class="badge badge-lg badge-dark">Cancelada</h1><br>');
                            }
                            $("#LTipoTarea").html('<b>Tipo: </b>' + info.event.extendedProps.tipo_tarea);
                            $("#verTitle").html(info.event.title);
                            $("#fInicio").val(info.event.startStr);
                            $("#fFin").val(info.event.endStr);
                            // -------------------------------
                            if (info.event.extendedProps.tipo_tarea == "Cita / Reunión") {
                                $("#ubicacion").html('<b>Ubicación : </b><br>' + info.event.extendedProps.ubicacion + ' - ' + info.event.extendedProps.descripcion_ubicacion);
                            }

                            $("#descripcion").html('<b>Descripción : </b><br>' + (info.event.extendedProps.descripcion != "" ? info.event.extendedProps.descripcion : ""));
                            if (info.event.extendedProps.observaciones != "" && info.event.extendedProps.observaciones != null) {
                                $("#observaciones").html('<b>Observaciones : </b><br>' + (info.event.extendedProps.observaciones != "" ? info.event.extendedProps.observaciones : ""));
                            }
                            // ------
                            var botones = "";

                            $("#divResponsablesVer").html(info.event.extendedProps.responsables);
                            $("#listaResponsables").html(info.event.extendedProps.listResponsables);


                            if (editarTarea == 1 || tipo_usuario <= 2) {
                                botones += `<button id='${info.event.id}' class='editTarea btn btn-sm btn-primary ml-2' type='button' title='Editar'>
                                                <i class='fas fa-pencil-alt'></i>
                                            </button>`;
                                if (info.event.extendedProps.estado == 3) {
                                    botones += `<button id='${info.event.id}' class='activate btn btn-sm btn-info mr-1' type='button' title='Activar'>
                                                    <i class="fas fa-check"></i>
                                                </button>`;
                                }
                                if (info.event.extendedProps.estado != 2) {
                                    botones += `<button id='${info.event.id}' class='check btn btn-sm btn-success mr-1' type='button' title='Finalizar'>
                                                    <i class="fas fa-check-double"></i>
                                                </button>`;
                                }
                                if (info.event.extendedProps.estado != 2 && info.event.extendedProps.estado != 3) {
                                    botones += `<button id='${info.event.id}' class='cancel btn btn-sm btn-dark mr-1' type='button' title='Cancelar'>
                                                    <i class="fas fa-ban"></i>
                                                </button>`;
                                }
                            }
                            if (eliminarTarea == 1 || tipo_usuario <= 2) {
                                botones += `<button id='${info.event.id}' class='del btn btn-sm btn-danger mr-1' type='button' title='Eliminar'>
                                                <i class="fas fa-trash"></i>
                                            </button>`;
                            }
                            botones += ' <button type="button" class="btn btn-default " class="close" data-bs-dismiss="modal" aria-label="Close">Cerrar</button>';
                            $("#verBotones").html(botones);

                            $("#modalVer").modal("show");
                        }
                        // if (info.event.extendedProps.tipoEvento == '') {

                        //     $("#verTitleReunion").html(info.event.title);
                        //     $("#fInicioReunion").val(info.event.startStr);
                        //     $("#fFinReunion").val(info.event.endStr);

                        //     $("#tipoReunion").html('<b>Tipo reunión: </b>' + info.event.extendedProps.tipo);
                        //     $("#direccionReunion").html('<b>Dirección : </b>' + info.event.extendedProps.direccion);
                        //     $("#verReunion").html('<a href="../Vista/reunion.php?modulo=reuniones&id=' + info.event.id + '"class="btn btn-sm btn-success mr-1" type="button" target="blanck"> Ver detalle reunión</a>');

                        //     $("#modalVerReunion").modal("show");
                        // }
                    },
                    dateClick: function (date, jsEvent, view) {
                        var vistaActual = calendar.view;
                        var fechaSeleccionada = new Date(date.dateStr);
                        if (vistaActual.type == 'dayGridMonth') {
                            fechaSeleccionada.setHours(8, 0, 0, 0);
                        }
                        var fechaInicioFormateada = formatDateLocalInicio(fechaSeleccionada);
                        var fechaFinFormateada = formatDateLocalFin(fechaSeleccionada);
                        $('#txtFechaInicial').val(fechaInicioFormateada);
                        $('#txtFechaFin').val(fechaFinFormateada);
                        $('#crearTarea').modal('show');
                    }
                });
                calendar.render();
            }).fail(function (jqxhr, textStatus, error) {
                var err = textStatus + ", " + error;
                $('#calendar').html('<h3>Error ' + err + '</h3>')
            }
            );
    }

    $(document).on('click', '.fc-dayGridMonth-button', (e) => {
        tipo = 'dayGridMonth';
        funcion = 'actualizarCalendario';
        $.post('../Controlador/usuarioController.php', { tipo, funcion }, () => { })
    });

    $(document).on('click', '.fc-timeGridWeek-button', (e) => {
        tipo = 'timeGridWeek';
        funcion = 'actualizarCalendario';
        $.post('../Controlador/usuarioController.php', { tipo, funcion }, () => { })
    });

    $(document).on('click', '.fc-timeGridDay-button', (e) => {
        tipo = 'timeGridDay';
        funcion = 'actualizarCalendario';
        $.post('../Controlador/usuarioController.php', { tipo, funcion }, () => { })
    });

    $(document).on('click', '.check', (e) => {
        const elemento = $(this)[0].activeElement;
        Swal.fire({
            title: 'Para finalizar la tarea hacer clic en confirmar',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Confirmar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'finalizarTarea';
                $.post('../Controlador/tareaController.php', { id, funcion }, (response) => {
                    if (response.includes('update')) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Tarea Finalizada'
                        })
                        $('#modalVer').modal('hide'); //ocultamos el modal
                        $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                        $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                        if (page == "calendario") {
                            cargarCalendario();
                        } else {
                            buscarMiAgenda();
                        }
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response
                        })
                    }
                });
            }
        })
    });

    $(document).on('click', '.cancel', (e) => {
        const elemento = $(this)[0].activeElement;
        Swal.fire({
            title: 'Para cancelar la tarea hacer clic en confirmar',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Confirmar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'cancelarTarea';
                $.post('../Controlador/tareaController.php', { id, funcion }, (response) => {
                    if (response.includes('update')) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Tarea Cancelada'
                        })
                        $('#modalVer').modal('hide'); //ocultamos el modal
                        $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                        $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                        if (page == "calendario") {
                            cargarCalendario();
                        } else {
                            buscarMiAgenda();
                        }
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response
                        })
                    }
                });
            }
        })
    });

    $(document).on('click', '.activate', (e) => {
        const elemento = $(this)[0].activeElement;
        Swal.fire({
            title: 'Para activar la tarea hacer clic en confirmar',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Confirmar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'activarTarea';
                $.post('../Controlador/tareaController.php', { id, funcion }, (response) => {
                    if (response.includes('update')) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Tarea Activada'
                        })
                        $('#modalVer').modal('hide'); //ocultamos el modal
                        $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                        $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                        if (page == "calendario") {
                            cargarCalendario();
                        } else {
                            buscarMiAgenda();
                        }
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response
                        })
                    }
                });
            }
        })
    });

    $(document).on('click', '.del', (e) => {
        const elemento = $(this)[0].activeElement;
        Swal.fire({
            title: 'Para eliminar la tarea hacer clic en confirmar',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Confirmar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'eliminarTarea';
                $.post('../Controlador/tareaController.php', { id, funcion }, (response) => {
                    if (response.includes('delete')) {
                        if (page == "calendario") {
                            cargarCalendario();
                        } else {
                            buscarMiAgenda();
                        }
                        Toast.fire({
                            icon: 'success',
                            title: 'Tarea Eliminada'
                        })
                        $('#modalVer').modal('hide'); //ocultamos el modal
                        $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                        $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response
                        })
                    }
                });
            }
        })
    });

    $("#selIdUsuario").change(function () {
        cargarCalendario();
    });

    function formatDateLocalInicio(date) {
        var dia = date.getDate() + 1;
        var mes = date.getMonth() + 1; // Los meses en JavaScript son de 0 a 11
        var año = date.getFullYear();
        var horas = date.getHours();
        var minutos = date.getMinutes();
        var segundos = date.getSeconds();

        // Agrega un cero delante si es necesario
        dia = dia < 10 ? '0' + dia : dia;
        mes = mes < 10 ? '0' + mes : mes;
        horas = horas < 10 ? '0' + horas : horas;
        minutos = minutos < 10 ? '0' + minutos : minutos;
        segundos = segundos < 10 ? '0' + segundos : segundos;

        // Devuelve la fecha formateada
        return año + '-' + mes + '-' + dia + 'T' + horas + ':' + minutos + ':' + segundos;
    }

    function formatDateLocalFin(date) {
        var dia = date.getDate() + 1;
        var mes = date.getMonth() + 1; // Los meses en JavaScript son de 0 a 11
        var año = date.getFullYear();
        var horas = date.getHours() + 1;
        var minutos = date.getMinutes();
        var segundos = date.getSeconds();
        // Agrega un cero delante si es necesario
        dia = dia < 10 ? '0' + dia : dia;
        mes = mes < 10 ? '0' + mes : mes;
        horas = horas < 10 ? '0' + horas : horas;
        minutos = minutos < 10 ? '0' + minutos : minutos;
        segundos = segundos < 10 ? '0' + segundos : segundos;

        // Devuelve la fecha formateada
        return año + '-' + mes + '-' + dia + 'T' + horas + ':' + minutos + ':' + segundos;
    }

    function formatDate(date) {
        var dia = date.getDate();
        var mes = date.getMonth() + 1; // Los meses en JavaScript son de 0 a 11
        var año = date.getFullYear();
        var horas = date.getHours();
        var minutos = date.getMinutes();
        var segundos = date.getSeconds();

        // Agrega un cero delante si es necesario
        dia = dia < 10 ? '0' + dia : dia;
        mes = mes < 10 ? '0' + mes : mes;
        horas = horas < 10 ? '0' + horas : horas;
        minutos = minutos < 10 ? '0' + minutos : minutos;
        segundos = segundos < 10 ? '0' + segundos : segundos;

        // Devuelve la fecha formateada
        return dia + '/' + mes + '/' + año + ' ' + horas + ':' + minutos + ':' + segundos;
    }

});


function tipoTarea(valor, accion) {
    if (valor == "Tarea") {
        if (accion == 'crear') {
            $('#divUbicacion').hide();
            $('#divUbicacionDesc').hide();
        } else {
            $('#divUbicacion2').hide();
            $('#divUbicacionDesc2').hide();
        }
    }
    if (valor == "Laboral Festivo") {
        if (accion == 'crear') {
            $('#divUbicacion').hide();
            $('#divUbicacionDesc').hide();
            $('#txtObservaciones').hide();
        } else {
            $('#divUbicacion2').hide();
            $('#divUbicacionDesc2').hide();
            $('#txtObservaciones2').hide();
        }
    }
    if (valor == "Cita / Reunión" || valor == "Evento") {
        if (accion == 'crear') {
            $('#divUbicacion').show();
            $('#divUbicacionDesc').show();
        } else {
            $('#divUbicacion2').show();
            $('#divUbicacionDesc2').show();
        }
    }
}

function agregarResponsable(div) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    })
    if (div == "divResponsables") {
        var id = $('#selResponsable').val();
    } else {
        var id = $('#selResponsable2').val();
    }
    if (id != "") {
        funcion = 'cargarUserFull';
        $.post('../Controlador/usuarioController.php', { funcion, id }, (response) => {
            const obj = JSON.parse(response);
            var responsables = $('#' + div).html();
            var nuevoResponsable = `<img id='${id}' class='img-circle elevation-2 imgResponsable' title='${obj.nombre_completo}' src='${obj.avatar}' style='width: 45px; height: 35px'>`;
            responsables = responsables + ' ' + nuevoResponsable;
            $('#' + div).html(responsables);
        });
    } else {
        Toast.fire({
            icon: 'info',
            title: 'Seleccione un responsable de la lista'
        })
    }
}

function agregarTodos(div) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    })
    if (div == "divResponsables") {
        var id = $('#selResponsable').val();
    } else {
        var id = $('#selResponsable2').val();
    }
    funcion = 'listarActivos';
    $.post('../Controlador/usuarioController.php', { funcion }, (response) => {
        const objetos = JSON.parse(response);
        var responsables = $('#' + div).html();
        objetos.forEach(obj => {
            var nuevoResponsable = `<img id='${obj.id}' class='img-circle elevation-2 imgResponsable' title='${obj.nombre_completo}' src='${obj.avatar}' style='width: 45px; height: 35px'>`;
            responsables = responsables + ' ' + nuevoResponsable;
        });
        $('#' + div).html(responsables);
    });
}


$('#modalEspera').on('show.bs.modal', function (e) {
    var zIndex = 1051 + ($('#modalEspera').data('bs.modal') || {}).zIndex || 1051;
    $(this).css('z-index', zIndex);
    setTimeout(function () {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
});
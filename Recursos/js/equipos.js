$(document).ready(function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    var funcion = "";
    var page = $('#txtPage').val();
    var id_empresa = $('#txtIdEmpresa').val();

    var esp = {
        "processing": "Procesando...",
        "lengthMenu": "Mostrar _MENU_ registros",
        "zeroRecords": "No se encontraron resultados",
        "emptyTable": "Ningún dato disponible en esta tabla",
        "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "infoFiltered": "(filtrado de un total de _MAX_ registros)",
        "search": "Buscar:",
        "infoThousands": ",",
        "loadingRecords": "Cargando...",
        "paginate": {
            "first": "Primero",
            "last": "Último",
            "next": "Siguiente",
            "previous": "Anterior"
        },
        "aria": {
            "sortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sortDescending": ": Activar para ordenar la columna de manera descendente"
        },
        "buttons": {
            "copy": "Copiar",
            "colvis": "Visibilidad",
            "collection": "Colección",
            "colvisRestore": "Restaurar visibilidad",
            "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
            "copySuccess": {
                "1": "Copiada 1 fila al portapapeles",
                "_": "Copiadas %d fila al portapapeles"
            },
            "copyTitle": "Copiar al portapapeles",
            "csv": "CSV",
            "excel": "Excel",
            "pageLength": {
                "-1": "Mostrar todas las filas",
                "1": "Mostrar 1 fila",
                "_": "Mostrar %d filas"
            },
            "pdf": "PDF",
            "print": "Imprimir"
        },
        "autoFill": {
            "cancel": "Cancelar",
            "fill": "Rellene todas las celdas con <i>%d<\/i>",
            "fillHorizontal": "Rellenar celdas horizontalmente",
            "fillVertical": "Rellenar celdas verticalmentemente"
        },
        "decimal": ",",
        "searchBuilder": {
            "add": "Añadir condición",
            "button": {
                "0": "Constructor de búsqueda",
                "_": "Constructor de búsqueda (%d)"
            },
            "clearAll": "Borrar todo",
            "condition": "Condición",
            "conditions": {
                "date": {
                    "after": "Despues",
                    "before": "Antes",
                    "between": "Entre",
                    "empty": "Vacío",
                    "equals": "Igual a",
                    "notBetween": "No entre",
                    "notEmpty": "No Vacio",
                    "not": "Diferente de"
                },
                "number": {
                    "between": "Entre",
                    "empty": "Vacio",
                    "equals": "Igual a",
                    "gt": "Mayor a",
                    "gte": "Mayor o igual a",
                    "lt": "Menor que",
                    "lte": "Menor o igual que",
                    "notBetween": "No entre",
                    "notEmpty": "No vacío",
                    "not": "Diferente de"
                },
                "string": {
                    "contains": "Contiene",
                    "empty": "Vacío",
                    "endsWith": "Termina en",
                    "equals": "Igual a",
                    "notEmpty": "No Vacio",
                    "startsWith": "Empieza con",
                    "not": "Diferente de"
                },
                "array": {
                    "not": "Diferente de",
                    "equals": "Igual",
                    "empty": "Vacío",
                    "contains": "Contiene",
                    "notEmpty": "No Vacío",
                    "without": "Sin"
                }
            },
            "data": "Data",
            "deleteTitle": "Eliminar regla de filtrado",
            "leftTitle": "Criterios anulados",
            "logicAnd": "Y",
            "logicOr": "O",
            "rightTitle": "Criterios de sangría",
            "title": {
                "0": "Constructor de búsqueda",
                "_": "Constructor de búsqueda (%d)"
            },
            "value": "Valor"
        },
        "searchPanes": {
            "clearMessage": "Borrar todo",
            "collapse": {
                "0": "Paneles de búsqueda",
                "_": "Paneles de búsqueda (%d)"
            },
            "count": "{total}",
            "countFiltered": "{shown} ({total})",
            "emptyPanes": "Sin paneles de búsqueda",
            "loadMessage": "Cargando paneles de búsqueda",
            "title": "Filtros Activos - %d"
        },
        "select": {
            "1": "%d fila seleccionada",
            "_": "%d filas seleccionadas",
            "cells": {
                "1": "1 celda seleccionada",
                "_": "$d celdas seleccionadas"
            },
            "columns": {
                "1": "1 columna seleccionada",
                "_": "%d columnas seleccionadas"
            }
        },
        "thousands": ".",
        "datetime": {
            "previous": "Anterior",
            "next": "Proximo",
            "hours": "Horas",
            "minutes": "Minutos",
            "seconds": "Segundos",
            "unknown": "-",
            "amPm": [
                "am",
                "pm"
            ]
        },
        "editor": {
            "close": "Cerrar",
            "create": {
                "button": "Nuevo",
                "title": "Crear Nuevo Registro",
                "submit": "Crear"
            },
            "edit": {
                "button": "Editar",
                "title": "Editar Registro",
                "submit": "Actualizar"
            },
            "remove": {
                "button": "Eliminar",
                "title": "Eliminar Registro",
                "submit": "Eliminar",
                "confirm": {
                    "_": "¿Está seguro que desea eliminar %d filas?",
                    "1": "¿Está seguro que desea eliminar 1 fila?"
                }
            },
            "error": {
                "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\\/a&gt;).<\/a>"
            },
            "multi": {
                "title": "Múltiples Valores",
                "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
                "restore": "Deshacer Cambios",
                "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
            }
        }
    };
    var dataTable;
    if (page == 'adm_empresas') {
        listarEquiposEmpresa(id_empresa);
    }

    if (page == 'adm') {
        buscar();
    }
    if (page == 'editar') {
        const urlParams = new URLSearchParams(window.location.search);
        var id_empresa = urlParams.get('id');
        var dataTableMantenimiento;
        cargarEquipo();
        listarMantenimientos();
    }

    function listarEquiposEmpresa(id_empresa) {
        let funcion = 'listar';
        dataTable = $('#dataTable').DataTable({
            "ajax": {
                "url": "../Controlador/equiposController.php",
                "method": "POST",
                "data": { funcion: funcion, id_empresa: id_empresa }
            },
            "columns": [
                { "data": "estado", "visible": false },
                { "data": "id" },
                { "data": "estado_badge" },
                { "data": "tipo_equipo" },
                { "data": "ubicacion" },
                { "data": "ubicacion_completa" },
                { "data": "referencia" },
                { "data": "estado_gral" },
                { "data": "persona_a_cargo" },
                { "data": "boton_editar" },
                { "data": "boton_pdf" },
            ],
            "language": esp
        });
    }


    $('#form_crear_equipo').submit(e => {
        e.preventDefault();
        let tipo_equipo = $('#selTipoEquipo').val();
        let ubicacion = $('#txtUbicacion').val();
        let id_sede = $('#selSede').val();
        funcion = 'crear';
        $.post('../Controlador/equiposController.php', { funcion, tipo_equipo, ubicacion, id_sede }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                location.href = '../Vista/equipo.php?modulo=equipo&id=' + respuesta[0].id;
            }
        });
    });

    $(document).on('blur', '.formulario', (e) => {
        e.preventDefault();
        const urlParams = new URLSearchParams(window.location.search);
        var id_equipo = urlParams.get('id');
        editar_equipo(id_equipo);
    });

    function editar_equipo(id_equipo) {
        let tipo_equipo = $('#selTipoEquipo').val();
        let ubicacion = $('#txtUbicacion').val();
        let id_sede = $('#selSede').val();
        let serial = $('#txtSerial').val();
        let referencia = $('#txtReferencia').val();
        let procesador = $('#txtProcesador').val();
        let ram = $('#txtRam').val();
        let disco_duro = $('#txtDiscoDuro').val();
        let sistema_operativo = $('#txtSO').val();
        let teclado = $('#txtTeclado').val();
        let mouse = $('#txtMouse').val();
        let monitor = $('#txtMonitor').val();
        let office = $('#txtOffice').val();
        let pad_mouse = $('#selPadMouse').val();
        let tipo_impresora = $('#selTipoImpresora').val();
        let codigo_maquina = $('#txtCodigoMaquina').val();
        let persona_a_cargo = $('#txtPersonaCargo').val();
        let estado_general = $('#rangeEstado').val();
        let observaciones = $('#txtObservaciones').val();
        funcion = 'editar';
        $.post('../Controlador/equiposController.php', {
            funcion, tipo_equipo, ubicacion, id_sede, serial, referencia, procesador, ram, disco_duro,
            sistema_operativo, teclado, mouse, monitor, office, pad_mouse, codigo_maquina, tipo_impresora, persona_a_cargo, estado_general, observaciones, id_equipo
        }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                cargarEquipo();
            }
        });
    }

    $('#form_crear_mantenimiento').submit(e => {
        e.preventDefault();
        const urlParams = new URLSearchParams(window.location.search);
        var id_equipo = urlParams.get('id')
        let fecha = $('#txtFecha').val();
        let tipo = $('#selTipoMantenimiento').val();
        let descripcion = $('#txtDescripcion').val();
        let realizado_por = $('#txtRealizado').val();
        let observaciones = $('#txtObsMant').val();
        funcion = 'crear_mantenimiento';
        $.post('../Controlador/equiposController.php', { funcion, id_equipo, fecha, tipo, descripcion, realizado_por, observaciones }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                dataTableMantenimiento.ajax.reload();
                $('#crear_mantenimiento').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_crear_mantenimiento').trigger('reset');
                dataTableMantenimiento.ajax.reload();
            }
        });
    });


    function cargarEquipo() {
        const urlParams = new URLSearchParams(window.location.search);
        var id = urlParams.get('id');
        funcion = 'cargar';
        $.post('../Controlador/equiposController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#selTipoEquipo').val(obj.tipo_equipo);
            $('#txtUbicacion').val(obj.ubicacion);
            $('#selSede').val(obj.id_sede);
            $('#txtSerial').val(obj.serial);
            $('#txtReferencia').val(obj.referencia);
            $('#txtProcesador').val(obj.procesador);
            $('#txtRam').val(obj.ram);
            $('#txtDiscoDuro').val(obj.disco_duro);
            $('#txtSO').val(obj.sistema_operativo);
            $('#txtTeclado').val(obj.teclado);
            $('#txtMouse').val(obj.mouse);
            $('#txtMonitor').val(obj.monitor);
            $('#txtOffice').val(obj.office);
            $('#selPadMouse').val(obj.pad_mouse);
            $('#selTipoImpresora').val(obj.tipo_impresora);
            $('#txtCodigoMaquina').val(obj.codigo_maquina);
            $('#txtPersonaCargo').val(obj.persona_a_cargo);
            // $('#txtDireccion').val(obj.estado_general);
            $('#txtObservaciones').val(obj.observaciones);

            $('#h3Name').html(obj.referencia);
            $('#liNameProd').html(obj.referencia);
            $('#titleProd').html(obj.referencia);
            $('#codigoInterno').html(obj.codigo_maquina);
            $('#rangeEstado').val(obj.estado_general).trigger('input');

            cargarValorRange(obj.estado_general);

            if (obj.estado == 1) {
                $('#divEstado').html('<span class="badge badge-success">Activo</span>');
            }
            if (obj.estado == 2) {
                $('#divEstado').html('<span class="badge badge-success">Inactivo</span>');
            }
            if (obj.estado == 3) {
                $('#divEstado').html('<span class="badge badge-success">Dado de Baja</span>');
            }

            if (obj.tipo_equipo == 'Impresora') {
                $('#imgProd').attr('src', '../Recursos/img/copy-machine-1.png');
                $('#divTipoImpresora').show();
                $('#divPadMouse').hide();
                $('#divOffice').hide();
                $('#divMonitor').hide();
                $('#divMouse').hide();
                $('#divTeclado').hide();
                $('#divSO').hide();
                $('#divDD').hide();
                $('#divRam').hide();
                $('#divProcesador').hide();
            } else {
                if (obj.tipo_equipo == 'Portátil') {
                    $('#imgProd').attr('src', '../Recursos/img/macbook.png');
                }
                if (obj.tipo_equipo == 'PC Escritorio') {
                    $('#imgProd').attr('src', '../Recursos/img/computador.png');
                }
                if (obj.tipo_equipo == 'PC Todo En Uno') {
                    $('#imgProd').attr('src', '../Recursos/img/imac.png');
                }
                $('#divTipoImpresora').hide();
                $('#divPadMouse').show();
                $('#divOffice').show();
                $('#divMonitor').show();
                $('#divMouse').show();
                $('#divTeclado').show();
                $('#divSO').show();
                $('#divDD').show();
                $('#divRam').show();
                $('#divProcesador').show();
            }
        });
    }

    $(document).on('click', '.edit', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement;
        const id = $(elemento).attr('id');
        $('#txtIdSede').val(id);
        funcion = 'cargar_sede';
        $.post('../Controlador/equiposController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#txtNombreSede2').val(obj.nombre_sede);
            $('#selMunicipioSede2').val(obj.id_municipio).trigger('change.select2');
            $('#txtDireccionSede2').val(obj.direccion);
        });
    });

    function listarMantenimientos() {
        let funcion = 'listar_mantenimientos';
        const urlParams = new URLSearchParams(window.location.search);
        var id_equipo = urlParams.get('id');
        dataTableMantenimiento = $('#dataTable').DataTable({
            "ajax": {
                "url": "../Controlador/equiposController.php",
                "method": "POST",
                "data": { funcion: funcion, id_equipo: id_equipo }
            },
            "columns": [
                { "data": "fecha", "visible": false, order: true },
                { "data": "fecha" },
                { "data": "nombre_tipo" },
                { "data": "realizado_por" },
                { "data": "boton_detalle" },
            ],
            "language": esp
        });
    }

    $(document).on('click', '.detalle_mantenimiento', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement;
        const id = $(elemento).attr('id');
        funcion = 'cargar_mantenimiento';
        $.post('../Controlador/equiposController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#pTipoMantenimiento').html(obj.nombre_tipo);
            $('#pFechaMantenimiento').html(obj.fecha);
            $('#pDescripcionMantenimiento').html(obj.descripcion);
            $('#pRealizadoPor').html(obj.realizado_por);
            $('#pObservacionesMantenimiento').html(obj.observaciones);
        })
    });

    $(document).on('change', '#rangeEstado', (e) => {
        e.preventDefault();
        cargarValorRange($('#rangeEstado').val());
    });

    function cargarValorRange(valor){
        $('#pEstadoGeneralLabel').html(' '+valor);
    }


});
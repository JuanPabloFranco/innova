$(document).ready(function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    var funcion = "";
    let page = $('#txtPage').val();
    let id_usuario = $('#id_usuario').val();
    let tipo_usuario = $('#txtTipoUsuario').val();
    let cargo_usuario = $('#txtCargoUsuario').val();
    let editar = $('#txtEditar').val();
    let ver = $('#txtVer').val();

    if (ver == 1) {
        var tablaReportes;
        cargarReportes();
        cargarEstadisticas();
        cargarSalidas();
    }

    function cargarReportes() {
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
        let funcion = 'listar_reportes_estibas';
        let edit = editar;
        tablaReportes = $('#tablaReportes').DataTable({
            "ajax": {
                "url": "../Controlador/transporteController.php",
                "method": "POST",
                "data": { funcion: funcion, editar: edit }
            },
            "columns": [
                { "data": "fecha", "visible": false },
                { "data": "num_remision" },
                { "data": "fecha" },
                { "data": "estibas_recibidas" },
                { "data": "estibas_vendidas" },
                { "data": "valor_ind" },
                { "data": "valor_venta" },
                { "data": "nombre_completo" },
                { "data": "observaciones" },
                { "data": "recibir" },
                { "data": "recibido_por" },
                { "data": "editar" },
                { "data": "eliminar" },
            ],
            "order": [[0, 'desc']],
            "language": esp
        });
    }

    $(document).on('click', '.eliminar', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement;
        Swal.fire({
            title: '¿Desea eliminar este registro?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Si`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'eliminar_reporte_estiba';
                $.post('../Controlador/transporteController.php', { id, funcion }, (response) => {
                    const respuesta = JSON.parse(response);
                    Toast.fire({
                        icon: respuesta[0].type,
                        title: respuesta[0].mensaje
                    })
                    if (!respuesta[0].error) {
                        tablaReportes.ajax.reload();
                        cargarEstadisticas();
                    }
                });
            }
        })
    });

    $(document).on('click', '.editar', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement;
        const id = $(elemento).attr('id');
        funcion = 'cargar_estiba';
        $('#txtIdReporte').val(id);
        $.post('../Controlador/transporteController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#txtNumRemision2').val(obj.num_remision);
            $('#txtEstibasRecibidas2').val(obj.estibas_recibidas);
            $('#txtEstibasVendidas2').val(obj.estibas_vendidas);
            $('#txtObservaciones2').val(obj.observaciones);
            $('#txtValorInd2').val(obj.valor_ind);
        });
    });

    $(document).on('click', '.recibir', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement;
        Swal.fire({
            title: '¿Desea recibir este dinero de estibas?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Si`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'recibir_reporte_estiba';
                $.post('../Controlador/transporteController.php', { id, funcion }, (response) => {
                    const respuesta = JSON.parse(response);
                    Toast.fire({
                        icon: respuesta[0].type,
                        title: respuesta[0].mensaje
                    })
                    if (!respuesta[0].error) {
                        tablaReportes.ajax.reload();
                        cargarEstadisticas();
                    }
                });
            }
        })
    });

    function cargarEstadisticas() {
        funcion = 'estadisticas_estibas';
        $.post('../Controlador/transporteController.php', { funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#h3PVentas').html('$' + new Intl.NumberFormat('es-CO').format(obj.ventas));
            $('#h3PSalidas').html('$' + new Intl.NumberFormat('es-CO').format(obj.salidas));
            $('#h3Total').html('$' + new Intl.NumberFormat('es-CO').format(obj.total));
        });
    }

    $('#form_crear_reporte_estiba').submit(e => {
        let num_remision = $('#txtNumRemision').val();
        let observaciones = $('#txtObservaciones').val();
        let estibas_vendidas = $('#txtEstibasVendidas').val();
        let estibas_recibidas = $('#txtEstibasRecibidas').val();
        let valor_ind = $('#txtValorInd').val();
        funcion = 'crear_reporte_estiba';
        $.post('../Controlador/transporteController.php', { funcion, num_remision, observaciones, estibas_vendidas, estibas_recibidas, valor_ind }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                tablaReportes.ajax.reload();
                cargarEstadisticas();
                $('#form_crear_reporte_estiba').trigger('reset');
                $('#crearReporteEstiba').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
            }
        });
        e.preventDefault();
    });

    $('#form_editar_reporte_estiba').submit(e => {
        let id = $('#txtIdReporte').val();
        let num_remision = $('#txtNumRemision2').val();
        let observaciones = $('#txtObservaciones2').val();
        let estibas_vendidas = $('#txtEstibasVendidas2').val();
        let estibas_recibidas = $('#txtEstibasRecibidas2').val();
        let valor_ind = $('#txtValorInd2').val();
        funcion = 'editar_reporte_estiba';
        $.post('../Controlador/transporteController.php', { funcion, id, num_remision, observaciones, estibas_vendidas, estibas_recibidas, valor_ind }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                tablaReportes.ajax.reload();
                cargarEstadisticas();
                $('#form_editar_reporte_estiba').trigger('reset');
                $('#editarReporteEstiba').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
            }
        });
        e.preventDefault();
    });

    $('#form_crear_salida').submit(e => {
        let valor = $('#txtValorSalida').val();
        let concepto = $('#txtCpncepto').val();
        funcion = 'crear_salida_estiba';
        $.post('../Controlador/transporteController.php', { funcion, valor, concepto }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                cargarEstadisticas();
                cargarSalidas();
                $('#form_crear_salida').trigger('reset');
                $('#crearSalida').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
            }
        });
        e.preventDefault();
    });

    function cargarSalidas() {
        var funcion = "listar_salidas";
        $.post('../Controlador/transporteController.php', { funcion }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            let template = `            <table class="table table-bordered table-responsive text-center">
                                            <thead class='notiHeader'>                  
                                                <tr>
                                                    <th>#</th>  
                                                    <th>Fecha</th>
                                                    <th>Valor</th>
                                                    <th>Concepto</th>
                                                    <th>Creado Por</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;

            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${objeto.fecha}</td>
                                                    <td>$${new Intl.NumberFormat('es-CO').format(objeto.valor)}</td>
                                                    <td>${objeto.concepto}</td>
                                                    <td>${objeto.nombre_completo}</td>
                                                </tr>`;
            });
            template += `                   </tbody>`;
            $('#divSalidas').html(template);
        });
    }


});
$(document).ready(function () {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    var funcion = "";
    var editar = $('#txtEditar').val();
    var ver = $('#txtVer').val();
    var page = $('#txtPage').val();

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
    if (page == 'adm') {
        buscar();
    }
    if (page == 'editar') {
        const urlParams = new URLSearchParams(window.location.search);
        var id_empresa = urlParams.get('id');
        cargarEmpresa();
        listarSedes();
    }

    if (page == 'editar_ind') {
        const urlParams = new URLSearchParams(window.location.search);
        var id_empresa = urlParams.get('id');
        cargarEmpresa();
        listarSedes();
    }


    $('#form_crear_empresa').submit(e => {
        e.preventDefault();
        let nombre = $('#txtNombre').val();
        let telefono = $('#txtTelefono').val();
        let email = $('#txtEmail').val();
        let direccion = $('#txtDireccion').val();
        let id_municipio = $('#selMunicipio').val();
        funcion = 'crear';
        $.post('../Controlador/empresasController.php', { funcion, nombre, telefono, email, direccion, id_municipio }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                location.href = '../Vista/editar_empresa.php?modulo=empresas&id=' + respuesta[0].id;
            }
        });

    });

    $('#form_crear_sede').submit(e => {
        e.preventDefault();
        const urlParams = new URLSearchParams(window.location.search);
        var id_empresa = urlParams.get('id')
        let nombre_sede = $('#txtNombreSede').val();
        let direccion = $('#txtDireccionSede').val();
        let id_municipio = $('#selMunicipioSede').val();
        funcion = 'crear_sede';
        $.post('../Controlador/empresasController.php', { funcion, nombre_sede, direccion, id_municipio, id_empresa }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                dataTable.ajax.reload();
                $('#crear_sede').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_crear_sede').trigger('reset');
            }
        });

    });


    function listarSedes() {
        let funcion = 'listar_sedes';
        dataTable = $('#dataTable').DataTable({
            "ajax": {
                "url": "../Controlador/empresasController.php",
                "method": "POST",
                "data": { funcion: funcion, id_empresa: id_empresa }
            },
            "columns": [
                { "data": "id" },
                { "data": "nombre_sede" },
                { "data": "direccion" },
                { "data": "boton" },
            ],
            "language": esp
        });
    }

    function buscar() {
        let funcion = 'listar';
        dataTable = $('#dataTable').DataTable({
            "ajax": {
                "url": "../Controlador/empresasController.php",
                "method": "POST",
                "data": { funcion: funcion }
            },
            "columns": [
                { "data": "estado_valor", "visible": false },
                { "data": "id" },
                { "data": "logo" },
                { "data": "estado" },
                { "data": "nombre" },
                { "data": "telefono" },
                { "data": "email" },
                { "data": "direccion" },
                { "data": "boton" },
            ],
            "language": esp
        });
    }


    $(document).on('click', '.edit', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement;
        const id = $(elemento).attr('id');
        $('#txtIdSede').val(id);
        funcion = 'cargar_sede';
        $.post('../Controlador/empresasController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#txtNombreSede2').val(obj.nombre_sede);
            $('#selMunicipioSede2').val(obj.id_municipio).trigger('change.select2');
            $('#txtDireccionSede2').val(obj.direccion);
        });
    });


    $('#form_editar_empresa').submit(e => {
        var id = id_empresa;
        let nombre = $('#txtNombre').val();
        let telefono = $('#txtTelefono').val();
        let email = $('#txtEmail').val();
        let direccion = $('#txtDireccion').val();
        let id_municipio = $('#selMunicipio').val();
        let estado = $('#selEstado').val();
        funcion = 'editar';
        $.post('../Controlador/empresasController.php', { funcion, id, nombre, telefono, email, direccion, id_municipio, estado }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
        });
        e.preventDefault();
    });

    $('#form_editar_sede').submit(e => {
        var id = $('#txtIdSede').val();
        let nombre_sede = $('#txtNombreSede2').val();
        let direccion = $('#txtDireccionSede2').val();
        let id_municipio = $('#selMunicipioSede2').val();
        funcion = 'editar_sede';
        $.post('../Controlador/empresasController.php', { funcion, id, nombre_sede, direccion, id_municipio }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            if (!respuesta[0].error) {
                $('#form_editar_sede').trigger('reset');
                $('#editar_sede').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                dataTable.ajax.reload();
            }
        });
        e.preventDefault();
    });

    function cargarEmpresa() {
        var id = id_empresa;
        funcion = 'cargar';
        $.post('../Controlador/empresasController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#txtNombre').val(obj.nombre);
            $('#txtTelefono').val(obj.telefono);
            $('#txtDireccion').val(obj.direccion);
            $('#selMunicipio').val(obj.id_municipio).trigger('change.select2');
            $('#txtEmail').val(obj.email);
            $('#selEstado').val(obj.estado);
            $('#logoEmpresa').attr('src', '../Recursos/img/empresas/' + obj.logo);
            $('#logoEmpresa2').attr('src', '../Recursos/img/empresas/' + obj.logo);
        });
    }

    $('#form_logo').submit(e => {
        let formData = new FormData($('#form_logo')[0]);
        $(`#modalEspera`).modal(`show`);
        $('#imgEspera').html('<h2 class=`text-center`>Espere por favor<br><img src=`../Recursos/img/Update.gif` class=`center-all-contens`></h2>');
        $.ajax({
            url: '../Controlador/empresasController.php',
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false
        }).done(function (response) {
            const json = JSON.parse(response);
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
            $('#modalEspera').modal('hide');
            $('#changeLogo').modal('hide'); //ocultamos el modal
            $('#imgEspera').html('');
            if (!respuesta[0].error) {
                $('#logoEmpresa2').attr('src', json.logo);
                $('#logoEmpresa').attr('src', json.logo);
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#form_logo').trigger('reset');
                cargarEmpresa();
            }
        });
        e.preventDefault();
    });

});
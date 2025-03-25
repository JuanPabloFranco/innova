$(document).ready(function () {
    let funcion = 'reporteGeneral';
    let page = $('#txtPage').val();

    if (page == 'dashboard') {
        cargarMorosos();
        graficoTh('sedes','thPorSedes', '#graficoThSedes');
        graficoTh('estratos','thPorEstrato', '#graficoThEstrato');
        graficoTh('áreas','thPorArea', '#graficoThAreas');
        graficoTh('cargos','thPorCargo', '#graficoThCargo');
        
        graficoTh('nivel académico','thPorNivelAcademico', '#graficoThNivelAcademico');
        graficoTh('tipo de sangre','thTipoSangre', '#graficoThTipoSangre');
        graficoTh('grupo étnico','thPorGrupoEtnico', '#graficoThGrupoEtnico');
        graficoTh('estado civil','thPorEstadoCivil', '#graficoThEstadoCivil');

        graficoTh('bebidas alcoholicas','thPorBebidas', '#graficoThBebidas');

        graficoTh('fuma','thPorFuma', '#graficoThFuma');
        
        graficoTh('Licencia Conducción','thPorLicencia', '#graficoThLicencia');
        graficoTh('Cabeza de Familia','thPorCabezaF', '#graficoThCabezaFamilia');
        graficoTh('Tipo de Vivienda','thPorTipoVivienda', '#graficoThTipoVivienda');
        
        // biblioteca
        graficoBiblioteca('Estado','porEstado', '#graficoArchivosEstado');
        graficoBiblioteca('Sedes','porSedes', '#graficoArchivosSede');
        graficoBiblioteca('Areas','porAreas', '#graficoArchivosAreas');
        graficoBiblioteca('Tipo','porTipo', '#graficoArchivosTipo');
        graficoBiblioteca('Categoria','porCategoria', '#graficoArchivosCategoria');
        graficoBiblioteca('Cargo','porCargo', '#graficoArchivosCargo');
        graficoBiblioteca('Privacidad','porPrivacidad', '#graficoArchivosPrivacidad');
        graficoBiblioteca('Usuario','porUsuario', '#graficoArchivosUsuarios');
        
        
        //agenda
        graficoAgenda('Estado','agendaPorEstado', '#graficoAgendaEstado');
        graficoAgenda('Tipo','agendaPorTipo', '#graficoAgendaTipo');
        graficoAgenda('Proxima','agendaPorTipoProxima', '#graficoAgendaProxima');
    }

    function graficoTh(tipo, grafico, div) {
        const $grafica = document.querySelector(div);
        funcion = 'graficos';
        $.post('../Controlador/usuarioController.php', { funcion, grafico }, (response) => {
            const obj = JSON.parse(response);
            let backGrCo = 'rgba(255, 172, 19, 0.2)';
            let border = 'rgba(255, 0, 0, 1)';
            const etiquetas = obj[0].valor;
            const usuarios = [{
                label: 'Usuarios por '+tipo,
                data: obj[0].cantidad, // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas               
                backgroundColor: backGrCo, // Color de fondo
                borderColor: border, // Color del borde
                borderWidth: 1,// Ancho del borde
            }];
            new Chart($grafica, {
                type: 'bar',// Tipo de gráfica
                data: {
                    labels: etiquetas,
                    datasets: usuarios
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }],
                    },
                }
            });
        });
    }

    function graficoBiblioteca(tipo, grafico, div) {
        const $grafica = document.querySelector(div);
        funcion = 'graficos';
        $.post('../Controlador/archivoController.php', { funcion, grafico }, (response) => {
            const obj = JSON.parse(response);
            let backGrCo = 'rgba(255, 172, 19, 0.2)';
            let border = 'rgba(255, 0, 0, 1)';
            const etiquetas = obj[0].valor;
            const usuarios = [{
                label: 'Archivos por '+tipo,
                data: obj[0].cantidad, // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas               
                backgroundColor: backGrCo, // Color de fondo
                borderColor: border, // Color del borde
                borderWidth: 1,// Ancho del borde
            }];
            new Chart($grafica, {
                type: 'bar',// Tipo de gráfica
                data: {
                    labels: etiquetas,
                    datasets: usuarios
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }],
                    },
                }
            });
        });
    }
    function graficoAgenda(tipo, grafico, div) {
        const $grafica = document.querySelector(div);
        funcion = 'graficos';
        $.post('../Controlador/tareaController.php', { funcion, grafico }, (response) => {
            const obj = JSON.parse(response);
            let backGrCo = 'rgba(255, 172, 19, 0.2)';
            let border = 'rgba(255, 0, 0, 1)';
            const etiquetas = obj[0].valor;
            const usuarios = [{
                label: 'Agenda por '+tipo,
                data: obj[0].cantidad, // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas               
                backgroundColor: backGrCo, // Color de fondo
                borderColor: border, // Color del borde
                borderWidth: 1,// Ancho del borde
            }];
            new Chart($grafica, {
                type: 'bar',// Tipo de gráfica
                data: {
                    labels: etiquetas,
                    datasets: usuarios
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }],
                    },
                }
            });
        });
    }

    function cargarMorosos() {
        let funcion = 'morosos';
        let esp = {
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

        $('#tablaUsuarios').DataTable({
            "ajax": {
                "url": "../Controlador/usuarioController.php",
                "method": "POST",
                "data": { funcion: funcion }
            },
            "columns": [
                { "data": "nombre_sede" },
                { "data": "nombre_cargo" },
                { "data": "nombre_completo" },
                { "data": "doc_id" },
                { "data": "personal" },
                { "data": "familiar" },
                { "data": "salud" },
                { "data": "academica" },
                { "data": "estudios" },
                { "data": "sociodemografica" },
                { "data": "boton" }
            ],
            "language": esp
        });
    }

});
$(document).ready(function () {
    var funcion = "";
    var id_usuario = $('#txtId_usuario').val();
    var tipo_usuario = $('#txtTipoUsuario').val();
    var eliminar = $('#txtEliminar').val();
    var ver = $('#txtVer').val();
    var editar = $('#txtEditar').val();
    var page = $('#txtPage').val();

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    if (page == "adm") {
        buscar();
        buscarCategoria();

        $(document).on('keyup', '#TxtBuscarArchivo', function () {
            let consulta = $('#TxtBuscarArchivo').val();
            if (consulta.length > 3 || consulta.length == 0) {
                buscar(consulta);
            }
        });

        $(document).on('keyup', '#TxtBuscarCategoria', function () {
            let consulta = $('#TxtBuscarCategoria').val();
            if (consulta.length > 3 || consulta.length == 0) {
                buscarCategoria(consulta);
            }
        });
    } else {
        $(document).on('keyup', '#TxtBuscarArchivo', function () {
            let consulta = $('#TxtBuscarArchivo').val();
            if (consulta.length > 3 || consulta.length == 0) {
                buscar(consulta);
            }
        });
        buscarBiblioteca();
    }

    $("#form_crear_archivo").on("submit", function (e) {
        e.preventDefault();
        var ext = $('#txtArchivo').val().split('.').pop();
        if (ext == 'xls' || ext == 'xlsx' || ext == 'doc' || ext == 'docx' || ext == 'pdf' || ext == 'jpg' || ext == 'png' || ext == 'jpeg') {
            var f = $(this);
            var formData = new FormData(document.getElementById("form_crear_archivo"));
            formData.append("dato", "valor");
            var peticion = $('#form_crear_archivo').attr('action');
            $.ajax({
                url: '../Controlador/archivoController.php',
                type: 'POST',
                data: formData,
                cache: false,
                processData: false,
                contentType: false
            }).done(function (response) {
                if (response == 'subido') {
                    Toast.fire({
                        icon: 'success',
                        title: 'Archivo subido exitosamente'
                    })
                    $('#form_crear_archivo').trigger('reset');
                    buscar();
                    $('#crearArchivo').modal('hide'); //ocultamos el modal
                    $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                    $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
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
                title: "Los formatos permitidos son: pdf, xlsx, xls, doc, docx, jpg, jpeg, png"
            })
        }
    });

    function buscar(consulta) {
        var funcion = "buscar";
        $.post('../Controlador/archivoController.php', { consulta, funcion }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            let template = `<table class="table table-bordered center-all">
                                            <thead class='notiHeader'>                  
                                                <tr>
                                                    <th>#</th>                                                    
                                                    <th>Estado</th>
                                                    <th>Privacidad</th>
                                                    <th>Tipo</th>
                                                    <th>Categoria</th>
                                                    <th>Nombre Archivo</th>
                                                    <th>Archivo</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;

            objetos.forEach(objeto => {
                num += 1;
                var privacidad = "";
                if (objeto.privacidad == "Todos") {
                    privacidad = `Todos`;
                } else if (objeto.privacidad == "Cargo") {
                    privacidad = `Cargo (${objeto.nombre_cargo})`;
                } else if (objeto.privacidad == "Sede") {
                    privacidad = `Sede (${objeto.nombre_sede})`;
                } else if (objeto.privacidad == "Usuario") {
                    privacidad = `Usuario (${objeto.nombre_usuario})`;
                }else if (objeto.privacidad == "Area") {
                    privacidad = `Área (${objeto.nombre_area})`;
                }
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>`;
                if (objeto.estado == 1) {
                    template += `                   <td><h1 class="badge badge-success ml-1">Disponible</h1></td>`;
                } else {
                    template += `                   <td><h1 class="badge badge-warning ml-1">No Disponible</h1></td>`;
                }
                template += `                       <td>${privacidad}</td>
                                                    <td>${objeto.tipo}</td>
                                                    <td>${objeto.nombre_categoria}</td>
                                                    <td>${objeto.nombre}</td>`;
                if (objeto.tipo == 'Documento PDF') {
                    template += `                   <td><a target='_blanck' href='../Recursos/biblioteca/${objeto.archivo}'><img width='40px' src='../Recursos/img/pdf.png'></a></td>`;
                }
                if (objeto.tipo == 'Imagén') {
                    template += `                   <td><a target='_blanck' href='../Recursos/biblioteca/${objeto.archivo}'><img width='40px' src='../Recursos/img/png.png'></a></td>`;
                }
                if (objeto.tipo == 'Documento') {
                    template += `                   <td><a target='_blanck' href='../Recursos/biblioteca/${objeto.archivo}'><img width='40px' src='../Recursos/img/doc.png'></a></td>`;
                }
                if (objeto.tipo == 'Hoja de calculo') {
                    template += `                   <td><a target='_blanck' href='../Recursos/biblioteca/${objeto.archivo}'><img width='40px' src='../Recursos/img/xls.png'></a></td>`;
                }
                template += `                       <td>`;
                template += `                           <button class='ver btn btn-sm btn-info mr-1' data-bs-toggle="modal" data-bs-target="#detalle_archivo" type='button' title='Detalle archivo'>
                                                            <i class="fas fa-clipboard"></i>
                                                        </button>`;
                if (editar == 1) {
                    if (objeto.estado == 1) {
                        template += `                   <button class='state btn btn-sm btn-warning mr-1' type='button' title='Inactivar'>
                                                            <i class="fas fa-lock"></i>
                                                        </button>`;
                    } else {
                        template += `                   <button class='state btn btn-sm btn-success mr-1' type='button' title='Activar'>
                                                            <i class="fas fa-lock-open"></i>
                                                        </button>`;
                    }
                    template += `                       <button class='edit btn btn-sm btn-primary mr-1' type='button' data-bs-toggle="modal" data-bs-target="#editarArchivo">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>`;
                }
                if (eliminar == 1) {
                    template += `                   <button class='delete btn btn-sm btn-danger mr-1' type='button' title='Eliminar archivo'>
                                                        <i class="fas fa-trash"></i>
                                                    </button>`;
                }
                template += `                       </td>
                                                </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#busquedaArchivos').html(template);
        });
    }

    function buscarBiblioteca(consulta) {
        var funcion = "buscar_biblioteca";
        $.post('../Controlador/archivoController.php', { consulta, funcion }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            let template = `<table class="table table-bordered center-all">
                                            <thead class='notiHeader'>                  
                                                <tr>
                                                    <th>#</th>        
                                                    <th>Tipo</th>
                                                    <th>Categoria</th>
                                                    <th>Nombre Archivo</th>
                                                    <th>Archivo</th>
                                                    <th style='width: 138px'>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;

            objetos.forEach(objeto => {
                num += 1;

                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>`;
                template += `                   <td>${objeto.tipo}</td>
                                                <td>${objeto.nombre_categoria}</td>
                                                <td>${objeto.nombre}</td>`;
                if (objeto.tipo == 'Documento PDF') {
                    template += `                   <td><a target='_blanck' href='../Recursos/biblioteca/${objeto.archivo}'><img width='40px' src='../Recursos/img/pdf.png'></a></td>`;
                }
                if (objeto.tipo == 'Imagén') {
                    template += `                   <td><a target='_blanck' href='../Recursos/biblioteca/${objeto.archivo}'><img width='40px' src='../Recursos/img/png.png'></a></td>`;
                }
                if (objeto.tipo == 'Documento') {
                    template += `                   <td><a target='_blanck' href='../Recursos/biblioteca/${objeto.archivo}'><img width='40px' src='../Recursos/img/doc.png'></a></td>`;
                }
                if (objeto.tipo == 'Hoja de calculo') {
                    template += `                   <td><a target='_blanck' href='../Recursos/biblioteca/${objeto.archivo}'><img width='40px' src='../Recursos/img/xls.png'></a></td>`;
                }
                template += `                       <td style="width: 10px">`;
                template += `                           <button class='ver btn btn-sm btn-info mr-1' data-bs-toggle="modal" data-bs-target="#detalle_archivo" type='button' title='Detalle archivo'>
                                                            <i class="fas fa-clipboard"></i>
                                                        </button>`;
                template += `                       </td>
                                                </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#busquedaArchivos').html(template);
        });
    }

    $(document).on('click', '.ver', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        funcion = 'cargarArchivo';
        $.post('../Controlador/archivoController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#divFechaCreacion').html('<p><b>Fecha Creación:</b>' + obj.fecha_creacion + '</p>');
            $('#pNombre').html('<p><b>Nombre: </b>' + obj.nombre + '</p>');
            $('#pTipo').html('<p><b>Tipo: </b>' + obj.tipo + '</p>');
            $('#pCategoria').html('<p><b>Categoría: </b>' + obj.nombre_categoria + '</p>');
            if(obj.descripcion!=null){
                $('#divDescripcion').html('<p><b>Descripción: </b><br>' + obj.descripcion + '</p>');
            }else{
                $('#divDescripcion').html('');
            }
            var privacidad;
            if (obj.privacidad == "Todos") {
                privacidad = `Todos`;
            } else if (obj.privacidad == "Cargo") {
                privacidad = `Cargo (${obj.nombre_cargo})`;
            } else if (obj.privacidad == "Sede") {
                privacidad = `Sede (${obj.nombre_sede})`;
            } else if (obj.privacidad == "Usuario") {
                privacidad = `Usuario (${obj.nombre_usuario})`;
            }else if (objeto.privacidad == "Area") {
                privacidad = `Área (${objeto.nombre_area})`;
            }
            $('#pPrivacidad').html('<p><b>Privacidad: </b>' + privacidad + '</p>');
            $('#divAutor').html('<p><b>Autor: </b>' + obj.nombre_completo + '</p>');
            var estado = "";
            if (obj.estado == 1) {
                estado += `<h1 class="badge badge-success ml-1">Disponible</h1>`;
            } else {
                estado += `<h1 class="badge badge-warning ml-1">No Disponible</h1>`;
            }
            $('#divEstado').html('<p>' + estado + '</p>');
        });
        e.preventDefault();
    });

    $(document).on('click', '.edit', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        $('#txtId_archivo_ed').val(id);
        funcion = 'cargarArchivo';
        $.post('../Controlador/archivoController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#txtNombre2').val(obj.nombre);
            $('#txtDesc2').val(obj.descripcion);
            $('#selCategoria2').val(obj.id_categoria);
            $('#selTipo2').val(obj.tipo);
            $('#selPrivacidad2').val(obj.privacidad);
            $('#selCargo2').val(obj.id_cargo).trigger('change.select2');
            $('#selSede2').val(obj.id_sede).trigger('change.select2');
            $('#selArea2').val(obj.id_area).trigger('change.select2');
            $('#selUsuario2').val(obj.id_usuario).trigger('change.select2');
            if (obj.privacidad == "Cargo") {
                $('#divCargo2').show();
                $('#divSede2').hide();
                $('#divArea2').hide();
                $('#divUsuario2').hide();
            } else if (obj.privacidad == "Sede") {
                $('#divSede2').show();
                $('#divCargo2').hide();
                $('#divUsuario2').hide();
                $('#divArea2').hide();
            } else if( obj.privacidad == "Usuario"){
                $('#divUsuario2').show();
                $('#divCargo2').hide();
                $('#divSede2').hide();
                $('#divArea2').hide();
            }else if( obj.privacidad == "Area"){
                $('#divUsuario2').hide();
                $('#divCargo2').hide();
                $('#divSede2').hide();
                $('#divArea2').show();
            }else{
                $('#divCargo2').hide();
                $('#divSede2').hide();
                $('#divUsuario2').hide();
                $('#divArea2').hide();
            }
        });
        e.preventDefault();
    });

    $(document).on('click', '.state', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: 'Realmente desea cambiar el estado del archivo?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Aceptar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                $('#txtId_archivo_ed').val(id);
                funcion = 'cambiarEstado';
                $.post('../Controlador/archivoController.php', { id, funcion }, (response) => {
                    Swal.fire('Estado cambiado!', '', 'success');
                    buscar();
                });
            } else if (result.isDenied) {
                Swal.fire('No se cambió el estado', '', 'info')
            }
        })
        e.preventDefault();
    });

    $(document).on('click', '.delete', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: 'Realmente desea eliminar el archivo?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Eliminar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                $('#txtId_archivo_ed').val(id);
                funcion = 'eliminarArchivo';
                $.post('../Controlador/archivoController.php', { id, funcion }, (response) => {
                    Swal.fire('Eliminado!', '', 'success');
                    buscar();
                });
            } else if (result.isDenied) {
                Swal.fire('No se ha eliminado el archivo', '', 'info')
            }
        })
        e.preventDefault();
    });

    $('#form_editar_archivo').submit(e => {
        let id = $('#txtId_archivo_ed').val();
        let nombre = $('#txtNombre2').val();
        let descripcion = $('#txtDesc2').val();
        let categoria = $('#selCategoria2').val();
        let privacidad = $('#selPrivacidad2').val();
        let id_cargo = $('#selCargo2').val();
        let id_sede = $('#selSede2').val();
        let id_usuario = $('#selUsuario2').val();
        let id_area = $('#selArea2').val();
        funcion = 'editar_archivo';
        $.post('../Controlador/archivoController.php', { funcion, id, nombre, id_area, descripcion, categoria, privacidad, id_cargo, id_sede, id_usuario }, (response) => {
            if (response == 'update') {
                Toast.fire({
                    icon: 'success',
                    title: 'Información de archivo actualizada'
                })
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

    $('#form_crear_categoria').submit(e => {
        e.preventDefault();
        let nombre_categoria = $('#txtNombreCategoria').val();
        funcion = 'crear_categoria';
        $.post('../Controlador/archivoController.php', { funcion, nombre_categoria }, (response) => {
            if (response == 'creado') {
                Toast.fire({
                    icon: 'success',
                    title: 'Categoria Registrada'
                })
                setTimeout('document.location.reload()', 3000);
                buscarCategoria();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Error al registrar'
                })
            }
        });
    });

    $('#form_editar_categoria').submit(e => {
        e.preventDefault();
        let id = $('#txtIdCategoriaEd').val();
        let nombre_categoria = $('#txtNombreCategoria2').val();
        funcion = 'editar_categoria';
        $.post('../Controlador/archivoController.php', { funcion, nombre_categoria, id }, (response) => {
            if (response == 'update') {
                Toast.fire({
                    icon: 'success',
                    title: 'Categoria Actualizada'
                })
                setTimeout('document.location.reload()', 3000);
                buscarCategoria();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Error al editar'
                })
            }
        });
    });

    function buscarCategoria(consulta) {
        var funcion = "listarCategoria";
        $.post('../Controlador/archivoController.php', { consulta, funcion }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            let template = `<table class="table table-bordered center-all">
                                            <thead class='notiHeader'>                  
                                                <tr>
                                                    <th>#</th>                                                    
                                                    <th>Estado</th>
                                                    <th>Nombre</th>
                                                    <th >Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;

            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>`;
                if (objeto.estado == 1) {
                    template += `<td><h1 class="badge badge-success ml-1">Activa</h1></td>`;
                } else {
                    template += `<td><h1 class="badge badge-warning ml-1">Inactiva</h1></td>`;
                }
                template += `                       <td>${objeto.nombre}</td>
                                                    <td >`;
                if (editar == 1) {
                    template += `                           <button class='editCategory btn btn-sm btn-primary mr-1' type='button' data-bs-toggle="modal" data-bs-target="#editar_categoria">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>`;
                    if (objeto.estado == 1) {
                        template += `                       <button class='stateCategory btn btn-sm btn-warning mr-1' type='button' title='Inactivar'>
                                                                <i class="fas fa-lock"></i>
                                                            </button>`;
                    } else {
                        template += `                       <button class='stateCategory btn btn-sm btn-success mr-1' type='button' title='Activar'>
                                                                <i class="fas fa-lock-open"></i>
                                                            </button>`;
                    }
                }
                template += `                       </td>
                                                </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#busquedaCategoria').html(template);
        });
    }

    $(document).on('click', '.editCategory', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('id');
        $('#txtIdCategoriaEd').val(id);
        funcion = 'cargarCategoria';
        $.post('../Controlador/archivoController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#txtNombreCategoria2').val(obj.nombre);
        });
    });

    $(document).on('click', '.stateCategory', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: 'Realmente desea cambiar el estado de la categoria?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Aceptar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('id');
                funcion = 'cambiarEstadoCategoria';
                $.post('../Controlador/archivoController.php', { id, funcion }, (response) => {
                    Swal.fire('Estado cambiado!', '', 'success');
                    buscarCategoria();
                });
            } else if (result.isDenied) {
                Swal.fire('No se cambió el estado', '', 'info')
            }
        })
    });

    $('#selPrivacidad').change(e => {
        valor = $('#selPrivacidad').val();
        if (valor == 'Todos') {
            document.getElementById('divSede').style.display = 'none';
            document.getElementById('divCargo').style.display = 'none';
            document.getElementById('divUsuario').style.display = 'none';
            document.getElementById('divArea').style.display = 'none';
        }
        if (valor == 'Sede') {
            document.getElementById('divSede').style.display = '';
            document.getElementById('divCargo').style.display = 'none';
            document.getElementById('divArea').style.display = 'none';
            document.getElementById('divUsuario').style.display = 'none';
        }
        if (valor == 'Cargo') {
            document.getElementById('divSede').style.display = 'none';
            document.getElementById('divArea').style.display = 'none';
            document.getElementById('divCargo').style.display = '';
            document.getElementById('divUsuario').style.display = 'none';
        }
        if (valor == 'Usuario') {
            document.getElementById('divSede').style.display = 'none';
            document.getElementById('divCargo').style.display = 'none';
            document.getElementById('divArea').style.display = 'none';
            document.getElementById('divUsuario').style.display = '';
        }
        if (valor == 'Area') {
            document.getElementById('divSede').style.display = 'none';
            document.getElementById('divCargo').style.display = 'none';
            document.getElementById('divUsuario').style.display = 'none';
            document.getElementById('divArea').style.display = '';
        }
    });

    $('#selPrivacidad2').change(e => {
        valor = $('#selPrivacidad2').val();
        if (valor == 'Todos') {
            document.getElementById('divSede2').style.display = 'none';
            document.getElementById('divCargo2').style.display = 'none';
            document.getElementById('divUsuario2').style.display = 'none';
            document.getElementById('divArea2').style.display = 'none';
        }
        if (valor == 'Rama') {
            document.getElementById('divSede2').style.display = '';
            document.getElementById('divCargo2').style.display = 'none';
            document.getElementById('divUsuario2').style.display = 'none';
            document.getElementById('divArea2').style.display = 'none';
        }
        if (valor == 'Cargo') {
            document.getElementById('divSede2').style.display = 'none';
            document.getElementById('divCargo2').style.display = '';
            document.getElementById('divUsuario2').style.display = 'none';
            document.getElementById('divArea2').style.display = 'none';
        }
        if (valor == 'Usuario') {
            document.getElementById('divSede2').style.display = 'none';
            document.getElementById('divCargo2').style.display = 'none';
            document.getElementById('divArea2').style.display = 'none';
            document.getElementById('divUsuario2').style.display = '';
        }
        if (valor == 'Area') {
            document.getElementById('divSede2').style.display = 'none';
            document.getElementById('divCargo2').style.display = 'none';
            document.getElementById('divArea2').style.display = '';
            document.getElementById('divUsuario2').style.display = 'none';
        }
    });
});
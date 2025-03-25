$(document).ready(function () {
    var funcion = "";
    var tipo_usuario = $('#txtTipoUsuario').val();
    var cargo = $('#id_cargo').val();
    var editar = $('#txtEditar').val();
    var ver = $('#txtVer').val();
    buscarNotas();

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    })

    $('#form_crear_nota').submit(e => {
        e.preventDefault();
        let tipo = $('#selTipoNota').val();
        let dirigido = $('#selDirigido').val();
        let id_cargo = 0;
        let id_sede = 0;
        var id_area = 0;
        let id_usuario = 0;
        if (dirigido == 'Todos') {
            id_cargo = 0;
            id_sede = 0;
            id_area = 0;
            id_usuario = 0;
        }
        if (dirigido == 'Area') {
            id_cargo = 0;
            id_sede = 0;
            id_usuario = 0;
            id_area = $('#selAreaNota').val();
        }
        if (dirigido == 'Sede') {
            id_cargo = 0;
            id_area = 0;
            id_sede = $('#selSedeNota').val();
            id_usuario = 0;
        }
        if (dirigido == 'Cargo') {
            id_cargo = $('#selCargoNota').val();
            id_sede = 0;
            id_area = 0;
            id_usuario = 0;
        }
        if (dirigido == 'Usuario') {
            id_cargo = 0;
            id_sede = 0;
            id_area = 0;
            id_usuario = $('#selUsuario').val();;
        }
        let fechaini = $('#txtFechaIni').val();
        let fechafin = $('#txtFechaFinal').val();
        let descripcion = $('#txtDescNota').val();
        funcion = 'crear_nota';
        $.post('../Controlador/notaController.php', { funcion, tipo, dirigido, id_cargo, id_sede, id_usuario, fechaini, fechafin, descripcion, id_area }, (response) => {
            if (response.includes('creado')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Nota Registrada'
                })
                $('#form_crear_nota').trigger('reset');
                $('#crearNota').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                buscarNotas();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Error al registrar'
                })
            }
        });
    });

    function buscarNotas(consulta) {
        if (ver == 1) {
            var id = $('#id_usuario').val();
            var funcion = "buscar_nota";
            $.post('../Controlador/notaController.php', { consulta, funcion, id }, (response) => {
                const objetos = JSON.parse(response);
                num = 0;
                let template = `<div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered table-responsive center-all">
                                                <thead class='notiHeader'>                  
                                                    <tr>
                                                        <th>#</th>                                                    
                                                        <th>Tipo</th>
                                                        <th>Dirigido a</th>
                                                        <th>Descripción</th>
                                                        <th>Fecha Inicial</th>
                                                        <th>Fecha Final</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>`;

                objetos.forEach(objeto => {
                    num += 1;
                    let dirigido;
                    if(objeto.dirigido == "Sede"){
                        dirigido = "Sede ("+objeto.nombre_sede+")";
                    } else if(objeto.dirigido == "Area"){
                        dirigido = "Área ("+objeto.nombre_area+")";
                    }else if(objeto.dirigido == "Usuario"){
                        dirigido = "Usuario ("+objeto.nombre_completo+")";
                    }else if(objeto.dirigido == "Cargo"){
                        dirigido = "Cargo ("+objeto.nombre_cargo+")";
                    }else{
                        dirigido = "Todos";
                    }
                    template += `                   <tr idNota=${objeto.id}>
                                                        <td>${num}</td>
                                                        <td>${objeto.tipo_nota}</td>
                                                        <td>${dirigido}</td>
                                                        <td>${objeto.descripcion_nota}</td>
                                                        <td>${objeto.fecha_ini}</td>
                                                        <td>${objeto.fecha_fin}</td>
                                                        <td>
                                                            <button class='editNota btn btn-sm btn-primary mr-1' type='button' data-bs-toggle="modal" data-bs-target="#editar_nota">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </button>
                                                            <button class='imgNota btn btn-sm btn-warning mr-1' type='button' data-bs-toggle="modal" data-bs-target="#agregar_imagen">
                                                                <i class="fas fa-image"></i>
                                                            </button>
                                                            <button class='delNota btn btn-sm btn-danger mr-1' type='button'>
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                         </td>
                                                    </tr>`;
                });
                template += `                   </tbody>
                                            </table>
                                        </div> 
                                    </div>
                `
                $('#busquedaNota').html(template);
            });
        } else {
            $('#busquedaNota').html("Tu cargo no tiene permisos para ver esta información");
        }
    }

    $(document).on('click', '.editNota', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('idNota');
        $('#txtId_NotaEd').val(id);
        funcion = 'cargarNotaEdit';
        $.post('../Controlador/notaController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#selTipoNota2').val(obj.tipo_nota);
            $('#selDirigido2').val(obj.dirigido);
            $('#selSedeNota2').val(obj.id_sede).trigger('change.select2');
            $('#selCargoNota2').val(obj.id_cargo).trigger('change.select2');
            $('#selAreaNota2').val(obj.id_area).trigger('change.select2');
            $('#selUsuario2').val(obj.id_usuario).trigger('change.select2');
            $('#txtFechaIni2').val(obj.fecha_ini);
            $('#txtFechaFinal2').val(obj.fecha_fin);
            $('#txtDescNota2').val(obj.descripcion_nota);
            if (obj.dirigido == 'Sede') {
                document.getElementById('divSede2').style.display = '';
                document.getElementById('divCargo2').style.display = 'none';
                document.getElementById('divUsuario2').style.display = 'none';
                document.getElementById('divArea2').style.display = 'none';
            }
            if (obj.dirigido == 'Cargo') {
                document.getElementById('divCargo2').style.display = '';
                document.getElementById('divSede2').style.display = 'none';
                document.getElementById('divUsuario2').style.display = 'none';
                document.getElementById('divArea2').style.display = 'none';
            }
            if (obj.dirigido == 'Area') {
                document.getElementById('divCargo2').style.display = 'none';
                document.getElementById('divSede2').style.display = 'none';
                document.getElementById('divUsuario2').style.display = 'none';
                document.getElementById('divArea2').style.display = '';
            }
            if (obj.dirigido == 'Usuario') {
                document.getElementById('divUsuario2').style.display = '';
                document.getElementById('divSede2').style.display = 'none';
                document.getElementById('divCargo2').style.display = 'none';
                document.getElementById('divArea2').style.display = 'none';
            }
            if (obj.dirigido == 'Usuario') {
                document.getElementById('divUsuario2').style.display = '';
                document.getElementById('divSede2').style.display = 'none';
                document.getElementById('divCargo2').style.display = 'none';
                document.getElementById('divArea2').style.display = 'none';
            }
            if (obj.dirigido == 'Todos') {
                document.getElementById('divCargo2').style.display = 'none';
                document.getElementById('divSede2').style.display = 'none';
                document.getElementById('divUsuario2').style.display = 'none';
                document.getElementById('divArea2').style.display = 'none';
            }

        });
    });

    $(document).on('click', '.imgNota', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('idNota');
        $('#txtIdNotaImg').val(id);
        funcion = 'cargarNotaImg';
        $.post('../Controlador/notaController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            if (obj.imagen != null) {
                $('#notaImg').show();
                $('#notaImg').attr('src', '../Recursos/img/notas/' + obj.imagen);
                $('#txtNotaImg').html(obj.tipo_nota + " dirigido a " + obj.dirigido);
            } else {
                $('#notaImg').hide();
            }
        });
    });

    $(document).on('click', '.delNota', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        Swal.fire({
            title: 'Realmente desea eliminar la nota?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Eliminar`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $(elemento).attr('idNota');
                funcion = 'eliminarNota';
                $.post('../Controlador/notaController.php', { id, funcion }, (response) => {
                    Swal.fire('Eliminado!', '', 'success');
                    buscarNotas();
                });
            } else if (result.isDenied) {
                Swal.fire('No se ha eliminado la nota', '', 'info')
            }
        })
    });

    $(document).on('click', '#deleteImg', (e) => {
        Swal.fire({
            title: '¿Desea eliminar esta imagén?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Si`,
        }).then((result) => {
            if (result.isConfirmed) {
                const id = $('#txtIdNotaImg').val();
                funcion = 'eliminarImagen';
                $.post('../Controlador/notaController.php', { id, funcion }, (response) => {
                    Swal.fire('Eliminada!', '', 'success');
                    $('#agregar_imagen').modal('hide'); //ocultamos el modal
                    $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                    $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                });
            } else if (result.isDenied) {
                Swal.fire('Error al eliminar', '', 'info')
            }
        })
    });

    $('#form_editar_nota').submit(e => {
        e.preventDefault();
        let tipo = $('#selTipoNota2').val();
        let dirigido = $('#selDirigido2').val();
        let id_cargo = 0;
        let id_sede = 0;
        let id_area = 0;
        let id_usuario = 0;
        if (dirigido == 'Todos') {
            id_cargo = 0;
            id_sede = 0;
            id_usuario = 0;
            id_area = 0;
        }
        if (dirigido == 'Sede') {
            id_cargo = 0;
            id_area = 0;
            id_sede = $('#selSedeNota2').val();
            id_usuario = 0;
        }
        if (dirigido == 'Cargo') {
            id_cargo = $('#selCargoNota2').val();
            id_sede = 0;
            id_area = 0;
            id_usuario = 0;
        }
        if (dirigido == 'Usuario') {
            id_cargo = 0;
            id_sede = 0;
            id_area = 0;
            id_usuario = $('#selUsuario2').val();;
        }
        if (dirigido == 'Area') {
            id_cargo = 0;
            id_sede = 0;
            id_usuario = 0;
            id_usuario = $('#selArea2').val();
        }
        let fechaini = $('#txtFechaIni2').val();
        let fechafin = $('#txtFechaFinal2').val();
        let descripcion = $('#txtDescNota2').val();
        let id = $('#txtId_NotaEd').val();
        funcion = 'editar_nota';
        $.post('../Controlador/notaController.php', { funcion, id, tipo, dirigido, id_cargo, id_sede, id_usuario, fechaini, fechafin, descripcion, id_area }, (response) => {
            if (response.includes('update')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Actualizada'
                })
                $('#editar_nota').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                buscarNotas();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: 'Error al actualizar'
                })
            }
        });
    });

    $('#form_img_nota').submit(e => {
        let formData = new FormData($('#form_img_nota')[0]);
        $.ajax({
            url: '../Controlador/notaController.php',
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false
        }).done(function (response) {
            const json = JSON.parse(response);
            if (json.alert == 'edit') {
                Toast.fire({
                    icon: 'success',
                    title: 'Actualizado'
                })
                $('#form_img_nota').trigger('reset');
                buscarNotas();
                $('#agregar_imagen').modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
            } else {
                Toast.fire({
                    icon: 'error',
                    title: json.alert
                })
            }
        });
        e.preventDefault();
    });

    $('#selDirigido').change(e => {
        valor = $('#selDirigido').val();
        if (valor == 'Todos') {
            document.getElementById('divSede').style.display = 'none';
            document.getElementById('divCargo').style.display = 'none';
            document.getElementById('divUsuario').style.display = 'none';
            document.getElementById('divArea').style.display = 'none';
        }
        if (valor == 'Sede') {
            document.getElementById('divSede').style.display = '';
            document.getElementById('divCargo').style.display = 'none';
            document.getElementById('divUsuario').style.display = 'none';
            document.getElementById('divArea').style.display = 'none';
        }
        if (valor == 'Cargo') {
            document.getElementById('divSede').style.display = 'none';
            document.getElementById('divCargo').style.display = '';
            document.getElementById('divUsuario').style.display = 'none';
            document.getElementById('divArea').style.display = 'none';
        }
        if (valor == 'Usuario') {
            document.getElementById('divSede').style.display = 'none';
            document.getElementById('divCargo').style.display = 'none';
            document.getElementById('divUsuario').style.display = '';
            document.getElementById('divArea').style.display = 'none';
        }
        if (valor == 'Area') {
            document.getElementById('divSede').style.display = 'none';
            document.getElementById('divCargo').style.display = 'none';
            document.getElementById('divUsuario').style.display = 'none';
            document.getElementById('divArea').style.display = '';
        }
    });

    $('#selDirigido2').change(e => {
        valor = $('#selDirigido2').val();
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
            document.getElementById('divUsuario2').style.display = '';
            document.getElementById('divArea2').style.display = 'none';
        }
        if (valor == 'Area') {
            document.getElementById('divSede2').style.display = 'none';
            document.getElementById('divCargo2').style.display = 'none';
            document.getElementById('divUsuario2').style.display = 'none';
            document.getElementById('divArea2').style.display = '';
        }
    });
});
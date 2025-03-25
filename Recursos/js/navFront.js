$(document).ready(function() {
    $('#selmunicipio').select2();
    starsValidate(5);

    if (document.getElementById('idPageReserva')) {
        funcion = 'cargarReserva';
        let id = $('#idPageReserva').val();
        $.post('Controlador/reserva_controler.php', { funcion, id }, (response) => {
            const items = JSON.parse(response);
            $("#pfecha").html(items.fecha);
            $("#pestado").html(items.estado);
            $("#pinfo").html(items.informacion);
            $("#pinfo_ad").html(items.inf_ad);
        });
    }

    $('#form_contactenos').submit(e => {
        let nombre = $('#nombre_contacto').val();
        let email = $('#email').val();
        let asunto = $('#asunto').val();
        let msj = $('#descripcion').val();
        let id_sede = "1";
        funcion = 'crear_mensaje';
        $.post('Controlador/msjContacto_controler.php', { funcion, nombre, email, asunto, msj, id_sede }, (response) => {
            if (response == 'creado') {
                $('#msjEnviado').hide('slow');
                $('#msjEnviado').show(1000);
                $('#msjEnviado').hide(2000);
                $('#form_contactenos').trigger('reset');
                enviarEmailMsjContacto(nombre, email, asunto, msj);
            }
        });
        e.preventDefault();
    });

    $('#form_opiniones').submit(e => {
        let opinion = $('#txtOpinion').val();
        let estrellas = $('#txtEstrellas').val();
        let id_usuario = $('#id_visitante_front').val();
        funcion = 'crear_opinion';
        $.post('Controlador/opinion_controler.php', { funcion, opinion, estrellas, id_usuario }, (response) => {
            if (response == 'creado') {
                $('#updateOpinion').hide('slow');
                $('#updateOpinion').show(1000);
                $('#updateOpinion').hide(2000);
                $('#form_opiniones').trigger('reset');
            } else {
                $('#msjNoSave').html(response);
                $('#noUpdateOpinion').hide('slow');
                $('#noUpdateOpinion').show(1000);
                $('#noUpdateOpinion').hide(2000);
            }
        });
        e.preventDefault();
    });

    $('#form_crear_reserva').submit(e => {
        let fecha = $('#txtFechaReserva').val();
        let id_usuario = $('#id_visitante_front').val();
        if (fecha != "" && id_usuario != "0") {
            let inf_ad = $('#txtInfReserva').val();
            funcion = 'crear';
            $.post('Controlador/reserva_controler.php', { funcion, fecha, id_usuario, inf_ad }, (response) => {
                cargarItemsTemporales(id_usuario);
                $('#crearItemReserva').hide('slow');
                $('#crearItemReserva').show(1000);
                $('#crearItemReserva').hide(2000);

                $('#form_front_reserva').trigger('reset');
                $('#id_visitante_front').val("");
                $('#txtFechaReserva').val("");
                $('#txtInfReserva').val("");

                $('#txtFechaReserva').prop('readonly', true);
                $('#txtInfReserva').prop('readonly', true);
                $('#selItemServicio').prop('disabled', true);
                document.getElementById("btn_agregar_item_reserva").style.display = "";
                document.getElementById("btn_crear_reserva").style.display = "";
                enviarEmailReservaRecibida(id_usuario);
            });
        } else {
            alert("La fecha es obligatoria")
        }
        e.preventDefault();
    });

    $(document).on('click', '#btn_agregar_item_reserva', (e) => {
        let id_cliente = $('#id_visitante_front').val();
        let id_servicio = $('#selItemServicio').val();
        let cant_adultos = $('#txtCantAdultos').val();
        let cant_kids = $('#txtCantKids').val();
        let noches = $('#txtNoches').val();
        let valor_adulto = $('#txtItemValorAdulto').val();
        let valor_nino = $('#txtItemValorNino').val();

        funcion = 'agregar_item_temporal';
        $.post('Controlador/reserva_controler.php', { funcion, id_cliente, id_servicio, cant_adultos, cant_kids, noches, valor_adulto, valor_nino }, (response) => {
            if (response == 'creado') {
                cargarItemsTemporales(id_cliente);
            } else {
                $('#nocrearItemReserva').hide('slow');
                $('#nocrearItemReserva').show(1000);
                $('#nocrearItemReserva').hide(2000);
                $('#nocrearItemReserva').html(response);
            }
        });
        e.preventDefault();
    });

    $(document).on('click', '#btn_sig', (e) => {
        let id_visitante = $('#id_visitante_front').val();
        if (id_visitante != "" && id_visitante != "0") { // Si el visitante ya existe
            $('#txtFechaReserva').prop('readonly', false);
            $('#txtInfReserva').prop('readonly', false);
            $('#selItemServicio').prop('disabled', false);
            document.getElementById("btn_agregar_item_reserva").style.display = "";
            cargarItemsTemporales(id_visitante);
        } else { // Si el visitante no existe se procede a crearlo
            let nombre = $('#txtNameVisitante').val();
            let cel_usuario = $('#txtTelVisitante').val();
            let documento = $('#txtDocVisitante').val();
            let email_usuario = $('#txtEmailVisitante').val();
            let id_cargo = 1;
            let id_tipo_usuario = 4;
            let id_nacionalidad = $('#selNacionalidad').val();
            let id_municipio = "";
            if (id_nacionalidad == 43) {
                id_municipio = $('#selmunicipio').val();
            } else {
                id_municipio = 1127;
            }
            funcion = 'crear_usuario';
            $.post('Controlador/usuario_controler.php', { funcion, nombre, documento, cel_usuario, email_usuario, id_nacionalidad, id_municipio, id_cargo, id_tipo_usuario }, (response) => {
                if (response == 'agregado') {
                    validarDocVisitante(documento);
                    $('#txtFechaReserva').prop('readonly', false);
                    $('#txtInfReserva').prop('readonly', false);
                    document.getElementById("btn_agregar_item_reserva").style.display = "";
                } else {
                    Swal.fire('Contácte con nosotros para informar del error', '', 'error');
                }
            });
        }
        e.preventDefault();
    });

    function cargarItemsTemporales(id) {
        funcion = 'buscar_items_temporales';
        $.post('Controlador/reserva_controler.php', { id, funcion }, (response) => {
            const items = JSON.parse(response);
            let num = 0;
            let template = ``;
            let totalAdultos = 0;
            let totalKids = 0;
            let total = 0;
            items.forEach(item => {
                num += 1;
                template += `<div class="col-sm-3"><div class="card" style='text-align: center;'>
                                <div class="card-body text-center" style='font-size: 12px;'>`;
                if (item.tipo == "Pasadia") {
                    template += `<img src="Recursos/img/trekking.png" class="card-img-top" style='width: 30%; text-align: center;' alt="...">`;
                }
                if (item.tipo == "Alojamiento") {
                    template += `<img src="Recursos/img/camping2.png" class="card-img-top" style='width: 30%; text-align: center;' alt="...">`;
                }
                if (item.tipo == "Alquiler") {
                    template += `<img src="Recursos/img/tienda.png" class="card-img-top" style='width: 30%; text-align: center;' alt="...">`;
                }
                if (item.tipo == "Alimentación") {
                    template += `<img src="Recursos/img/hoguera (1).png" class="card-img-top" style='width: 30%; text-align: center;' alt="...">`;
                }
                template += `<p class="card-text" style='font-weight: 900; font-size: 12px;'>${item.servicio}</p>
                <p class="card-text" style='font-weight: 200; font-size: 12px;'>${item.cant_adultos} adultos</p>
                <p class="card-text" style='font-weight: 200; font-size: 12px;'>${item.cant_kids} niños</p>
                <p class="card-text" style='font-weight: 200; font-size: 12px;'><b>Total: $${(item.cant_adultos * item.valor_adulto) + (item.cant_kids * item.valor_nino)}</b></p>                      
                </div>
              </div></div>`;
                totalAdultos = totalAdultos + (item.cant_adultos * item.valor_adulto);
                totalKids = totalKids + (item.cant_kids * item.valor_nino);
                total = total + ((item.cant_adultos * item.valor_adulto) + (item.cant_kids * item.valor_nino));
            });
            $('#TotalReserva').html("<b>Total reserva: $" + total + "</b>");
            $('#itemsTurista').html(template);
            if (num != 0) {
                document.getElementById('btn_crear_reserva').style.display = "";
            } else {
                document.getElementById('btn_crear_reserva').style.display = "none";
            }
        });
    }

    $(document).on('click', '#btn_update_turista', (e) => {
        let id_visitante = $('#id_visitante_front').val();
        let nombre = $('#txtNameVisitante').val();
        let cel_usuario = $('#txtTelVisitante').val();
        let documento = $('#txtDocVisitante').val();
        let email_usuario = $('#txtEmailVisitante').val();
        let id_nacionalidad = $('#selNacionalidad').val();
        let id_municipio = "";
        if (id_nacionalidad == 43) {
            id_municipio = $('#selmunicipio').val();
        } else {
            id_municipio = 1127;
        }
        funcion = 'editar_turista';
        $.post('Controlador/usuario_controler.php', { funcion, id_visitante, nombre, documento, cel_usuario, email_usuario, id_nacionalidad, id_municipio }, (response) => {
            if (response == 'editado') {
                $('#updateTurista').hide('slow');
                $('#updateTurista').show(1000);
                $('#updateTurista').hide(2000);
            } else {
                $('#noUpdateTurista').hide('slow');
                $('#noUpdateTurista').show(1000);
                $('#noUpdateTurista').hide(2000);
                $('#noUpdateTurista').html(response);
            }
        });
        e.preventDefault();
    });

    $(document).on('click', '#form_login_turista', (e) => {
        let id_usuario = $('#id_visitante_front').val();
        let nameUser = $('#txtUsuario').val();
        let oldpass = $('#txtPassOld').val();
        let newpass = $('#txtPassNew').val();
        let newpass2 = $('#txtPassNew2').val();
        if (nameUser != "" && oldpass != "" && newpass != "" && newpass2 != "") {
            if (newpass === newpass2) {
                funcion = 'changePass';
                $.post('Controlador/usuario_controler.php', { funcion, id_usuario, nameUser, oldpass, newpass }, (response) => {
                    if (response == 'update') {
                        $('#updateLogin').hide('slow');
                        $('#updateLogin').show(1000);
                        $('#updateLogin').hide(2000);
                        setTimeout("location.reload()", 4000);
                    } else {
                        $('#noUpdateLogin').hide('slow');
                        $('#noUpdateLogin').show(1000);
                        $('#noUpdateLogin').hide(2000);
                        $('#msjNoLogin').html(response);
                    }
                });
            } else {
                $('#noUpdateLogin').hide('slow');
                $('#noUpdateLogin').show(1000);
                $('#noUpdateLogin').hide(2000);
                $('#msjNoLogin').html("Las contraseñas nuevas no son iguales");
            }
        } else {
            $('#noUpdateLogin').hide('slow');
            $('#noUpdateLogin').show(1000);
            $('#noUpdateLogin').hide(2000);
            $('#msjNoLogin').html("Diligencie todos los campos");
        }
        e.preventDefault();
    });

    $(document).on('click', '#cerrarSesion', (e) => {
        $.post('Controlador/logout.php', {}, (response) => {});
    });

    cargarRedesFooter();
});

function starsValidate(valor) {
    plantilla = ``;
    for (let index = 1; index <= valor; index++) {
        plantilla += `<img src="Recursos/img/star.png" width="25px" alt="">`;
    }
    $('#divEstrellas').html(plantilla);
}

$("#form_avatar_turista").on("submit", function(e) {
    e.preventDefault();
    var f = $(this);
    var formData = new FormData(document.getElementById("form_avatar_turista"));
    formData.append("dato", "valor");
    var peticion = $('#form_avatar_turista').attr('action');
    $.ajax({
        url: 'Controlador/usuario_controler.php',
        type: 'POST',
        data: formData,
        cache: false,
        processData: false,
        contentType: false
    }).done(function(response) {
        $('#updateAvatar').hide('slow');
        $('#updateAvatar').show(1000);
        $('#updateAvatar').hide(2000);
        setTimeout("location.reload()", 2000);
    });
});

function validarItemServicio(valor) {
    var tipoServicio = "";
    funcion = 'buscarTipoServicio';
    $.post('Controlador/servicio_controler.php', { valor, funcion }, (response) => {
        const tipo = JSON.parse(response);
        tipoServicio = tipo.tipo;
        document.getElementById('txtItemValorAdulto').value = tipo.valor_adulto;
        document.getElementById('txtItemValorNino').value = tipo.valor_nino;
        if (tipoServicio == "Alojamiento") {
            document.getElementById('labelCantidad').innerHTML = "Cantidad Adultos";
            document.getElementById('labelNoches').innerHTML = "Cantidad Noches";
            document.getElementById('divCantAdultos').style.display = "";
            document.getElementById('divCantKids').style.display = "";
            document.getElementById('divNoches').style.display = "";
        }

        if (tipoServicio == "Pasadia") {
            document.getElementById('labelCantidad').innerHTML = "Cantidad Adultos";
            document.getElementById('labelNoches').innerHTML = "";
            document.getElementById('divCantAdultos').style.display = "";
            document.getElementById('divCantKids').style.display = "";
            document.getElementById('divNoches').style.display = "none";
            document.getElementById('txtNoches').value = "1";
        }

        if (tipoServicio == "Alimentación") {
            document.getElementById('labelCantidad').innerHTML = "Cantidad Platos";
            document.getElementById('labelNoches').innerHTML = "";
            document.getElementById('divCantAdultos').style.display = "";
            document.getElementById('divCantKids').style.display = "none";
            document.getElementById('divNoches').style.display = "";
            document.getElementById('txtCantKids').value = "0";
            document.getElementById('txtNoches').value = "1";
        }

        if (tipoServicio == "Alquiler") {
            document.getElementById('divCantAdultos').style.display = "";
            document.getElementById('divCantKids').style.display = "";
            document.getElementById('divNoches').style.display = "";
            document.getElementById('labelCantidad').innerHTML = "Cantidad Elementos";
            document.getElementById('labelNoches').innerHTML = "";
            document.getElementById('txtCantKids').value = "0";
            document.getElementById('txtNoches').value = "1";
        }
    });
}

function validarDocVisitante(documento) {
    funcion = 'buscar_visitante';
    $.post('Controlador/usuario_controler.php', { funcion, documento }, (response) => {
        if (response != "vacio") {
            const visitante = JSON.parse(response);
            $('#id_visitante_front').val(visitante.id);
            $('#txtNameVisitante').val(visitante.nombre_completo);
            $('#txtTelVisitante').val(visitante.cel_usuario);
            $('#txtEmailVisitante').val(visitante.email_usuario);
            $('#selNacionalidad').val(visitante.id_nacionalidad);
            $('#selmunicipio').val(visitante.id_municipio);
        }
    });
}


function validarNacionalidad(valor) {
    if (valor == 43) {
        document.getElementById('divMunicipio').style.display = '';
    } else {
        document.getElementById('divMunicipio').style.display = 'none';
    }
}

function enviarEmailReservaRecibida(id_usuario) {
    funcion = 'reservaConfirmada';
    $.post('Controlador/controlador_phpmailer.php', { funcion, id_usuario }, (response) => {

    });
}

function enviarEmailMsjContacto(asunto, nombre, email, mensaje) {
    funcion = 'emailMsjContacto';
    $.post('Controlador/controlador_phpmailer.php', { funcion, asunto, nombre, email, mensaje }, (response) => {

    });
}

function cargarRedesFooter() {
    funcion = 'listarRedes';
    let id_sede = "1";
    $.post('Controlador/sede_controler.php', { funcion, id_sede }, (response) => {
        const redes = JSON.parse(response);
        let template = `
        <a href="${redes.facebook}" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="${redes.instagram}" class="instagram"><i class="bx bxl-instagram"></i></a>`;
        $('#iconsSocialFooter').html(template);
    });
}
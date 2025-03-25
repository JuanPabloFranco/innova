-$(document).ready(function () {
    var funcion = "";
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    cargarInformacion();

    function cargarInformacion() {
        funcion = 'cargarInformacion';
        $.post('../Controlador/configuracionController.php', { funcion }, (response) => {
            const obj = JSON.parse(response);
            $('#txtNombre').val(obj.nombre);
            $('#txtNit').val(obj.nit);
            $('#txtHosting').val(obj.hosting);
            $('#txtBackend').val(obj.url_back);
            $('#txtFrontend').val(obj.url_front);
            $('#txtEmailCarta').val(obj.email_carta);
            $('#txtDireccion').val(obj.direccion);
            $('#txtTelefono').val(obj.tel_contacto);
            //Email
            $('#txtDriver').val(obj.driver);
            $('#txtCifrado').val(obj.cifrado);
            $('#txtHost').val(obj.host);
            $('#txtPuerto').val(obj.port);
            $('#txtUsuarioEmail').val(obj.email);
            $('#txtPassword').val(obj.pass_email);
            // Transporte
            $('#txtPuntoInicioEntrega').val(obj.punto_inicio_entrega);
            $('#txtApiKey').val(obj.api_key_maps);
            $('#txtValorMinimoTransporte').val(obj.valor_minimo_transporte_municipios);
            $('#txtValorMinimoTransporteMoto').val(obj.valor_minimo_transporte_municipios_moto);

            // Estibas
            $('#txtValorVentaEstiba').val(obj.valor_venta_estiba);

            // Productos
            $('#txtCantBodegas').val(obj.cant_bodegas);
            $('#txtCantSectores').val(obj.cant_sectores);
            $('#txtCantArrumes').val(obj.cant_arrumes);

            // imagenes
            if (obj.logo) {
                $('#imgLogo').attr('src', '../Recursos/img/empresa/' + obj.logo);
            }
            if (obj.faticon) {
                $('#imgFavicon').attr('src', '../Recursos/img/empresa/' + obj.faticon);
            }
            if (obj.img_login) {
                $('#imgLogin').attr('src', '../Recursos/img/empresa/' + obj.img_login);
            }
            if (obj.logo_blanco) {
                $('#imgLogoBlanco').attr('src', '../Recursos/img/empresa/' + obj.logo_blanco);
            }
        });
    }

    $('#form_datos_basicos').submit(e => {
        let nombre = $('#txtNombre').val();
        let nit = $('#txtNit').val();
        let url_back = $('#txtBackend').val();
        let url_front = $('#txtFrontend').val();
        let hosting = $('#txtHosting').val();
        let email_carta = $('#txtEmailCarta').val();
        let direccion = $('#txtDireccion').val();
        let tel_contacto = $('#txtTelefono').val();
        funcion = 'guardarDatosBasicos';
        $.post('../Controlador/configuracionController.php', { funcion, nombre, url_back, url_front, hosting, nit, email_carta, direccion, tel_contacto }, (response) => {
            if (response.includes('update')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Información Básica Actualizada'
                })
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
        e.preventDefault();
    });

    $('#form_datos_email').submit(e => {
        let driver = $('#txtDriver').val();
        let cifrado = $('#txtCifrado').val();
        let host = $('#txtHost').val();
        let port = $('#txtPuerto').val();
        let email = $('#txtUsuarioEmail').val();
        let pass_email = $('#txtPassword').val();
        funcion = 'guardarDatosEmail';
        $.post('../Controlador/configuracionController.php', { funcion, driver, cifrado, host, port, email, pass_email }, (response) => {
            if (response.includes('1')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Configuración SMTP actualizada'
                })
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
        e.preventDefault();
    });

    $("#form_crear_logo").on("submit", function (e) {
        e.preventDefault();
        var f = $(this);
        var formData = new FormData(document.getElementById("form_crear_logo"));
        formData.append("dato", "valor");
        var peticion = $('#form_crear_logo').attr('action');
        $.ajax({
            url: '../Controlador/configuracionController.php',
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false
        }).done(function (response) {
            if (!response.includes('updateE') && response.includes('update')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Logo actualizado con éxito'
                })
                $('#form_crear_logo').trigger('reset');
                cargarInformacion();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
    });

    $("#btnDeleteLogo").click(function () {
        Swal.fire({
            title: 'Realmente desea eliminar el logo?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Eliminar`,
        }).then((result) => {
            if (result.isConfirmed) {
                funcion = 'eliminarLogo';
                $.post('../Controlador/configuracionController.php', { funcion }, (response) => {
                    if (response == 'update') {
                        Swal.fire('Eliminado!', '', 'success');
                        cargarInformacion();
                        $('#imgLogo').attr('src', '');
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('Error al eliminar el logo', '', 'info')
            }
        })
    });

    $("#form_crear_logo_blanco").on("submit", function (e) {
        e.preventDefault();
        var f = $(this);
        var formData = new FormData(document.getElementById("form_crear_logo_blanco"));
        formData.append("dato", "valor");
        var peticion = $('#form_crear_logo_blanco').attr('action');
        $.ajax({
            url: '../Controlador/configuracionController.php',
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false
        }).done(function (response) {
            if (!response.includes('updateE') && response.includes('update')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Logo actualizado con éxito'
                })
                $('#form_crear_logo_blanco').trigger('reset');
                cargarInformacion();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
    });

    $("#btnDeleteLogoBlanco").click(function () {
        Swal.fire({
            title: 'Realmente desea eliminar el logo?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Eliminar`,
        }).then((result) => {
            if (result.isConfirmed) {
                funcion = 'eliminarLogoBlanco';
                $.post('../Controlador/configuracionController.php', { funcion }, (response) => {
                    if (response == 'update') {
                        Swal.fire('Eliminado!', '', 'success');
                        cargarInformacion();
                        $('#imgLogoBlanco').attr('src', '');
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('Error al eliminar el logo', '', 'info')
            }
        })
    });

    $("#form_crear_favicon").on("submit", function (e) {
        e.preventDefault();
        var f = $(this);
        var formData = new FormData(document.getElementById("form_crear_favicon"));
        formData.append("dato", "valor");
        var peticion = $('#form_crear_favicon').attr('action');
        $.ajax({
            url: '../Controlador/configuracionController.php',
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false
        }).done(function (response) {
            if (response.includes('update')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Icono agregado con éxito'
                })
                $('#form_crear_favicon').trigger('reset');
                cargarInformacion();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
    });

    $("#form_crear_login").on("submit", function (e) {
        e.preventDefault();
        var f = $(this);
        var formData = new FormData(document.getElementById("form_crear_login"));
        formData.append("dato", "valor");
        var peticion = $('#form_crear_login').attr('action');
        $.ajax({
            url: '../Controlador/configuracionController.php',
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false
        }).done(function (response) {
            if (response.includes('update')) {
                Toast.fire({
                    icon: 'success',
                    title: 'Fondo de login agregado con éxito'
                })
                $('#form_crear_login').trigger('reset');
                cargarInformacion();
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response
                })
            }
        });
    });

    $("#btnDeleteFavicon").click(function () {
        Swal.fire({
            title: 'Realmente desea eliminar el icono?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Eliminar`,
        }).then((result) => {
            if (result.isConfirmed) {
                funcion = 'eliminarIcono';
                $.post('../Controlador/configuracionController.php', { funcion }, (response) => {
                    if (response == 'update') {
                        Swal.fire('Eliminado!', '', 'success');
                        cargarInformacion();
                        $('#imgFavicon').attr('src', '');
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('Error al eliminar el icono', '', 'info')
            }
        })
    });

    $("#btnDeleteLogin").click(function () {
        Swal.fire({
            title: 'Realmente desea eliminar la imagén del login?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Eliminar`,
        }).then((result) => {
            if (result.isConfirmed) {
                funcion = 'eliminarImgLogin';
                $.post('../Controlador/configuracionController.php', { funcion }, (response) => {
                    if (response == 'update') {
                        Swal.fire('Eliminado!', '', 'success');
                        cargarInformacion();
                        $('#imgLogin').attr('src', '');
                    }
                });
            } else if (result.isDenied) {
                Swal.fire('Error al eliminar la imagén del login', '', 'info')
            }
        })
    });

    $('#form_valor_estiba').submit(e => {
        let valor_venta_estiba = $('#txtValorVentaEstiba').val();
        funcion = 'guardarDatosVentaEstiba';
        $.post('../Controlador/configuracionController.php', { funcion, valor_venta_estiba }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
        });
        e.preventDefault();
    });

    $('#form_valor_transporte').submit(e => {
        let punto_inicio_entrega = $('#txtPuntoInicioEntrega').val();
        let api_key_maps = $('#txtApiKey').val();
        let valor_minimo_transporte_municipios = $('#txtValorMinimoTransporte').val();
        let valor_minimo_transporte_municipios_moto = $('#txtValorMinimoTransporteMoto').val();
        funcion = 'guardarDatosPagoTransporte';
        $.post('../Controlador/configuracionController.php', { funcion, punto_inicio_entrega, api_key_maps, valor_minimo_transporte_municipios, valor_minimo_transporte_municipios_moto }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
        });
        e.preventDefault();
    });


    $('#form_valor_productos').submit(e => {
        let cant_bodegas = $('#txtCantBodegas').val();
        let cant_sectores = $('#txtCantSectores').val();
        let cant_arrumes = $('#txtCantArrumes').val();
        funcion = 'guardarDatosProductos';
        $.post('../Controlador/configuracionController.php', { funcion, cant_bodegas, cant_sectores, cant_arrumes }, (response) => {
            const respuesta = JSON.parse(response);
            Toast.fire({
                icon: respuesta[0].type,
                title: respuesta[0].mensaje
            })
        });
        e.preventDefault();
    });

});
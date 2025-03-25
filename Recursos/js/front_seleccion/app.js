$(document).ready(function () {

    // responsive nav
    var responsiveNav = $('#toggle-nav');
    var navBar = $('.nav-bar');

    responsiveNav.on('click', function (e) {
        e.preventDefault();
        console.log(navBar);
        navBar.toggleClass('active')
    });

    // pseudo active
    if ($('#docs').length) {
        var sidenav = $('ul.side-nav').find('a');
        var url = window.location.pathname.split('/');
        var url = url[url.length - 1];

        sidenav.each(function (i, e) {
            var active = $(e).attr('href');

            if (active === url) {
                $(e).parent('li').addClass('active');
                return false;
            }
        });
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    })

    $("#form_agregar_postulado").on("submit", function (e) {
        e.preventDefault();
        alert("gola")
        var ext = $('#txtArchivo').val().split('.').pop();
        if (ext == 'pdf') {
            var f = $(this);
            var formData = new FormData(document.getElementById("form_agregar_postulado"));
            formData.append("dato", "valor");
            var peticion = $('#form_agregar_postulado').attr('action');
            $.ajax({
                url: 'Controlador/postuladoController.php',
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
                    setTimeout(() => {
                        location.href = 'https://quindipisos.com/';
                    }, 8000);
                    enviarEmailPostulacion(respuesta[0].id)
                }
            });
        } else {
            Toast.fire({
                icon: 'info',
                title: 'El archivo debe ser formato PDF'
            })
        }
    });

    function enviarEmailPostulacion(id_postulacion) {
        funcion = 'postulacionNueva';
        $.post('../Controlador/controlador_phpmailer.php', { funcion, id_postulacion }, (response) => {});
    }

});

hljs.configure({ tabReplace: '  ' });
hljs.initHighlightingOnLoad();
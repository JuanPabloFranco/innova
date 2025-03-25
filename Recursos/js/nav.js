$(document).ready(function () {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    })

    buscar_avatar();
    rqs_soporte();
    buscar_menu();
    cargar_logo();

    function rqs_soporte() {
        funcion = 'contar_soporte';
        id_usuario = $('#txtIdUsuario').val();
        $.post('../Controlador/soporteController.php', { funcion, id_usuario }, (response) => {
            const obj = JSON.parse(response);
            $('#spanContacto').text(obj[0].cantidad);
        });
    }

    function buscar_avatar() {
        funcion = 'buscarAvatar';
        $.post('../Controlador/usuarioController.php', { funcion }, (response) => {
            const usuario = JSON.parse(response);
            $('#avatar4').attr('src', usuario.avatar);
        });

    }

    function buscar_menu() {
        funcion = 'buscar_menu';
        $.post('../Controlador/usuarioController.php', { funcion }, (response) => {
            const usuario = JSON.parse(response);
            if (usuario.menu == 1) {
                $('#bodyNav').attr('class', 'sidebar-mini sidebar-collapse');
            } else {
                $('#bodyNav').attr('class', 'sidebar-mini');
            }
            setInterval(() => {
                check_aside();                
            }, 1000);
            $('#avatar4').attr('src', usuario.avatar);
        });
    }

    $("#form_crear_historia").on("submit", function (e) {
        e.preventDefault();
        var f = $(this);
        var formData = new FormData(document.getElementById("form_crear_historia"));
        formData.append("dato", "valor");
        var peticion = $('#form_crear_historia').attr('action');
        $.ajax({
            url: '../Controlador/historiaController.php',
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false
        }).done(function (response) {
            if (response == 'creado') {
                Toast.fire({
                  icon: 'success',
                  title: 'Registrada'
                })
                $('#form_crear_historia').trigger('reset');
                setTimeout("location.href='./adm_panel.php'", 3000);
            } else {
                Toast.fire({
                  icon: 'error',
                  title: response
                })
            }
        });
    });

    $(document).on('click', '#btnMenu', (e) => {
        funcion = 'actualizarMenu';
        $.post('../Controlador/usuarioController.php', { funcion }, () => {
            check_aside()
        })
    });

    function check_aside() {
        var boxProfile = document.querySelector('.main-sidebar');
        var boxProfileWidth = boxProfile.offsetWidth;
        if (boxProfileWidth < 75) {
            // Si el ancho es menor que 60px, oculta el div .info
            $('.info').hide();
            $('#avatar4').attr('style','width: 80%');
            // document.querySelector('.info').classList.add('info-hidden');
        } else{
            $('.info').show();
            $('#avatar4').attr('style','width: 25%');
        }
    }

    function cargar_logo() {
        funcion = 'cargarInformacion';
        $.post('../Controlador/configuracionController.php', { funcion }, (response) => {
            const inf = JSON.parse(response);
            $('#faviconHeader').attr('href', '../Recursos/img/empresa/' + inf.faticon);
            $('#divLogoPanel').html('<img src="../Recursos/img/empresa/'+inf.logo+'" class="brand-image " style="opacity: .8"><h4><b>'+inf.nombre+'</b></h4>');
            
        });
    }
});
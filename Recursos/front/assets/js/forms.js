$(document).ready(function() {
    var funcion = "";

    $('#form_reservar_mesa').submit(e => {
        e.preventDefault();
        let name = $('#name').val();
        let email = $('#email').val();
        let phone = $('#phone').val();
        let date = $('#date').val();
        let time = $('#time').val();
        let people = $('#people').val();
        let message = $('#message').val();
        let funcion = "crear";
        $.post('Controlador/reservaController.php', { funcion, name, email, phone, date, time, people, message }, (response) => {
            if(response.includes("creado")){
                enviarEmailReserva(name, email, phone, date, time, people, message);
                $('#formulario_comentario').trigger('reset');
                $('#sent-message').show(2000);
                $('#sent-message').hide(10000);
            }else{
                $('#error-message').show(2000);
                $('#error-message').hide(1000);
                $('#error-message').html(response);

            }
        });

    });

    function enviarEmailReserva(name, email, phone, date, time, people, message ){
        let funcion = "reserva";
        $.post('../Controlador/controlador_phpmailer.php', { funcion, name, email, phone, date, time, people, message }, () => {});
    }

    $(document).on('keyup', '#TxtBuscarContacto', function() {
        let consulta = $(this).val();
        if (consulta != "") {
            buscarContactos(consulta);
        } else {
            buscarContactos();
        }
    });



});
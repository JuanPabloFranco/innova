$(document).ready(function() {
    var funcion = "";
    $('#contact').submit(e => {
        e.preventDefault();
        let nombre = $('#name').val();
        let email = $('#email').val();
        let asunto = $('#asunto').val();
        let mensaje = $('#message').val();
        funcion = 'crear_mensaje';
        $.post('Controlador/msjContacto_controler.php', { funcion, nombre, email, asunto, mensaje }, (response) => {
            if (response == 'creado') {
                $('#divCreate').hide('slow');
                $('#divCreate').show(1000);
                $('#divCreate').hide(2000);
                $('#contact').trigger('reset');
                enviar_email(nombre, email, asunto, mensaje);
            } else {
                $('#divNoCreate').hide('slow');
                $('#divNoCreate').show(1000);
                $('#divNoCreate').hide(2000);
                $('#divNoCreate').html(response);
            }
        });

    });

    $('#inscripcionEvento').submit(e => {
        e.preventDefault();        
        let id_evento = $('#txtidEvento').val();
        let nombre_participante = $('#txtNombre').val();
        let documento = $('#txtDocumento').val();
        let tipo_doc = $('#selTipoDoc').val();
        let fec_nac_part = $('#txtFechaNac').val();
        let telefono = $('#txtTelefono').val();
        let email = $('#txtEmail').val();
        let tipo_sangre = $('#selTipoSangre').val();
        let eps = $('#txtEps').val();
        funcion = 'inscribir_participante';
        $.post('Controlador/participante_evento_controler.php', {
            funcion,
            id_evento,
            nombre_participante,
            documento,
            tipo_doc,
            fec_nac_part,
            telefono,
            email,
            tipo_sangre,
            eps
        }, (response) => {
            if (response == 'registrado') {                
                $("#modalInscripcion").modal('hide'); //ocultamos el modal
                $('body').removeClass('modal-open'); //eliminamos la clase del body para poder hacer scroll
                $('.modal-backdrop').remove(); //eliminamos el backdrop del modal
                $('#inscripcionEvento').trigger('reset');
                $('#divCreate').hide('slow');
                $('#divCreate').show(2000);
                $('#divCreate').hide(5000);
            } else {
                $('#divNoCreate').hide('slow');
                $('#divNoCreate').show(2000);
                $('#divNoCreate').hide(3000);
                $('#divNoCreate').html(response);
            }
        });        
    });

    function enviar_email(nombre, email, asunto, mensaje) {
        funcion = 'enviar_email_contacto';
        $.post('Controlador/controlador_phpmailer.php', { funcion, nombre, email, asunto, mensaje }, (response) => {});
    }

});
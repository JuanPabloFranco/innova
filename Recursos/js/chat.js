$(document).ready(function () {

    var chatActivo = 0;
    var contactoActivo = 0;
    listarConversaciones();

    $(document).on('keyup', '#TxtBuscar', function () {
        let consulta = $('#TxtBuscar').val();
        if (consulta.length > 3) {
            buscar(consulta);
        } else {
            $('#divContactos').html('');
        }
    });

    function buscar(consulta) {
        var funcion = "buscar_usuarios_chat";
        $.post('../Controlador/usuarioController.php', { consulta, funcion }, (response) => {
            const objetos = JSON.parse(response);
            $('#divContactos').html("hola");
            let template = `<ul class="contacts-list">`;            
            objetos.forEach(obj => {
                template += `<li>
                                <a href='#' onclick="seleccionarContactoBusqueda('${obj.chat != null ? obj.chat : 0}','${obj.id}')">
                                    <div class="callout callout-info">
                                        <img class="contacts-list-img" src="../Recursos/img/avatars/${obj.avatar}">
                                        <div class="contacts-list-info">
                                            <span class="contacts-list-name" style="color: #000;">
                                                ${obj.nombre_completo}
                                            </span>
                                            <span class="contacts-list-msg">${obj.nombre_cargo}</span>
                                        </div>
                                    </div>
                                </a>
                            </li>`;
            });
            template += `</ul>`;
            $('#divContactos').html(template);
        });
    }

    function listarConversaciones() {
        var funcion = "listar_conversaciones_usuario";
        $.post('../Controlador/chatController.php', { funcion }, (response) => {
            const objetos = JSON.parse(response);
            let template = `<ul class="contacts-list">`;
            objetos.forEach(obj => {
                template += `<li>
                                <a href='#' onclick="cargarChat('${obj.id != null ? obj.id : 0}')">
                                    <div class="callout callout-info">
                                        <img class="contacts-list-img" src="../Recursos/img/avatars/${obj.avatar}">
                                        <div class="contacts-list-info">
                                            <span class="contacts-list-name" style="color: #000;">
                                                ${obj.nombre_completo}
                                                <span class='contacts-list-date ml-12 float-right'>
                                                    ${obj.ultimo_mensaje}
                                                </span>
                                            </span>
                                            <span class="contacts-list-msg">${obj.nombre_cargo}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </li>`;
            });
            template += `</ul>`;
            $('#divChats').html(template);
        });
    }

});

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
})
function seleccionarContactoBusqueda(chat, id_usuario_2) {
    if (chat == 0) {
        crearConversacion(id_usuario_2);
    } else {
        cargarChat(chat);
    }
}

function crearConversacion(id_usuario_2) {
    funcion = "crearConversacion"
    $.post('../Controlador/chatController.php', { funcion, id_usuario_2 }, (response) => {
        const respuesta = JSON.parse(response);
        Toast.fire({
            icon: respuesta[0].type,
            title: respuesta[0].mensaje
        })
        if (!respuesta[0].error) {
            cargarChat(respuesta[0].id);
        }
    });
}

function cargarChat(id_conversacion) {
    $('#divChat').show();
    cargarConversacion(id_conversacion);
    cargarMensajes(id_conversacion);
}

function cargarConversacion(id_conversacion){
    var funcion = "cargar_conversacion";
    $.post('../Controlador/chatController.php', { funcion, id_conversacion }, (response) => {
        const objetos = JSON.parse(response);
        chatActivo = objetos.id;
        contactoActivo = objetos.id;        
        var title = `<img class="contacts-list-img" src="../Recursos/img/avatars/${objetos.id_usuario_1 == objetos.login ? objetos.avatar_usuario_1 : objetos.avatar_usuario_2}"><label class='mt-1'>${objetos.id_usuario_1 == objetos.login ? objetos.nombre_usuario_1 : objetos.nombre_usuario_2}</label>`;
        $('#chatTitle').html(title);
        $('#btnEnviar').attr('onclick',`enviarMensaje(${id_conversacion},${objetos.id_contacto})`);        
    });
}

function cargarMensajes (id_conversacion){
    var funcion = "cargar_chat";
    $.post('../Controlador/chatController.php', { funcion, id_conversacion }, (response) => {
        const objetos = JSON.parse(response);
        let template = ``;
        //Foreach
        objetos.forEach(msj => {
            if (msj.login == msj.id_enviado_por) {
                template += `       <div class="direct-chat-msg right">
                                        <div class="direct-chat-infos clearfix">
                                            <span class="direct-chat-name float-right">${msj.envia}</span>
                                            <span class="direct-chat-timestamp float-left">${msj.fecha_hora}</span>
                                        </div>
                                        <img class="direct-chat-img" src="../Recursos/img/avatars/${msj.avatar_e}" alt="message user image">
                                        <div class="direct-chat-text">
                                            ${msj.mensaje}
                                        </div>
                                    </div>`;
            }
            if (msj.login == msj.id_recibido_por) {
                template += `       <div class="direct-chat-msg">
                                        <div class="direct-chat-infos clearfix">
                                            <span class="direct-chat-name float-left">${msj.recibe}</span>
                                            <span class="direct-chat-timestamp float-right">${msj.fecha_hora}</span>
                                        </div>
                                        <img class="direct-chat-img" src="../Recursos/img/avatars/${msj.avatar_r}" alt="message user image">
                                        <div class="direct-chat-text">
                                            ${msj.mensaje}
                                        </div>
                                    </div>`;
            }
        });
        $('#direct-chat-messages').html(template);
    });
}


function enviarMensaje(id_conversacion, id_recibido_por){
    funcion = "crear_chat_mensaje"
    var mensaje = $('#mensaje').val();
    $.post('../Controlador/chatController.php', { funcion, id_conversacion, id_recibido_por, mensaje }, (response) => {
        const respuesta = JSON.parse(response);        
        if (!respuesta[0].error) {
            $('#mensaje').html('');
            cargarMensajes(id_conversacion);
        }
    });
}
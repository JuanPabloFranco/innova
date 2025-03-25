const inputs = document.querySelectorAll(".input");

function addcl() {
    let parent = this.parentNode.parentNode;
    parent.classList.add("focus");
}

function remcl() {
    let parent = this.parentNode.parentNode;
    if (this.value == "") {
        parent.classList.remove("focus");
    }
}

inputs.forEach(input => {
    input.addEventListener("focus", addcl);
    input.addEventListener("blur", remcl);
});

$(document).ready(function () {
    cargar_inf();

    function cargar_inf() {
        funcion = 'cargarInformacion';
        $.post('Controlador/configuracionController.php', { funcion }, (response) => {
            const inf = JSON.parse(response);
            if (inf.nombre != null) {
                $('#titleLogin').html('Login ' + inf.nombre);
            }
            if (inf.faticon != null) {
                $('#fatIcon').attr('href', 'Recursos/img/empresa/' + inf.faticon);
            }
            if (inf.logo != null) {
                $('#imgLogo2').attr('src', 'Recursos/img/empresa/' + inf.logo);
            }else{
                $('#imgLogo2').attr('src','');
            }
            if (inf.img_login != null) {
                document.body.style.backgroundImage = `url('Recursos/img/empresa/${inf.img_login}')`;
                document.body.style.backgroundRepeat = `no-repeat`;
                document.body.style.backgroundSize = `cover`;
            }
        });
    }

});
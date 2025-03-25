$(document).ready(function () {
    var funcion = "";
    var id = $('#txtId').val();
    var id_tipo_usuario = $('#txtTipoUsuario').val();
    var editar = $('#txtEditar').val();
    var ver = $('#txtVer').val();
    var cargo = $('#txtCargoUsuario').val();
    var pagina = $('#page').val();

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    if (pagina == "autogestion") {
        datos(id);
    } else if (pagina == "perfil") {
        datos(id);
        conexiones_usuario();
    }else if (pagina == "mi_cargo") {
        datos(id);
    }

    function datos(id) {
        funcion = 'cargarUserFull';
        $.post('../Controlador/usuarioController.php', { id, funcion }, (response) => {
            const obj = JSON.parse(response);
            if (obj.estado == 1) {
                $('#estado').html(`<h2 class="badge badge-success ml-1">Activo</h2>`);
            } else {
                $('#estado').html(`<h2 class="badge badge-danger ml-1">Inactivo</h2>`);
            }
            // $('#conexion').html(obj.conexion);
            $('#creacion').html(obj.fecha_creacion);
            $('#tipo_user').html(obj.nombre_tipo);
            $('#cargo').html('<h5><b>' + obj.nombre_cargo + '</b></h5>');
            $('#h3TitleFunciones').html(obj.nombre_cargo);
            $('#sede').html(obj.nombre_sede);
            $('#area').html(obj.nombre_area);
            $('#avatarScout').attr('src', obj.avatar);
            $('#imagenGrande').attr('src', obj.avatar);
            $('#NombreUser').html('  ' + obj.nombre_completo + '  ');
            $('#titleUsuario').html(obj.nombre_completo);
            $('#liUsuario').html(obj.nombre_completo);
            $('#genero').html(obj.genero!=null?obj.genero:"");
            $('#fecha_nac').html(obj.fecha_nac!=null?obj.fecha_nac:"");
            $('#edad').html(obj.edad != null ? obj.edad + ' años' : 0 + ' años');
            $('#documento').html(obj.doc_id);
            $('#telefono').html(obj.telefono!=null?obj.telefono:"");
            $('#correo_institucional').html(obj.correo_institucional!=null?obj.correo_institucional:"");
            $('#arl').html(obj.arl!=null?obj.arl:"");
            $('#tipo_cuenta').html(obj.tipo_cuenta!=null?obj.tipo_cuenta:"");
            $('#banco').html(obj.banco!=null?obj.banco:"");
            $('#numero_cuenta').html(obj.numero_cuenta!=null?obj.numero_cuenta:"");
            $('#residencia').html(obj.direccion + ', ' + obj.municipio + ' (' + obj.depto + ')');
            $('#email').html(obj.email);
            
            if (pagina == "autogestion") {
                $('#eps').html(obj.eps!=null?obj.eps:"");
                $('#cesantias').html(obj.cesantias!=null?obj.cesantias:"");
            }
            if (pagina == "mi_cargo") {
                $('#PfuncionesCargo').html(obj.funciones!=null?obj.funciones:"");
                adjuntosCargo(obj.id_cargo);
                miHorario(id);
                numerosCargo(id);
                mesesColaboradorMes(id);
            }

            if (pagina == "perfil") {
                if (obj.nombre_cargo) {
                    verificar_asistencia = obj.verificar_asistencia!=0?"Si":"No";
                    verificar_contrato = obj.verificar_contrato!=0?"Si":"No";
                    descripcion_cargo = obj.descripcion!=null?obj.descripcion:""
                    $('#descripcionCargo').html('<h4><b>' + obj.nombre_cargo + '</b></h4><h5><b>Descripción o funciones del cargo</b></h5><p>' + descripcion_cargo + '</p><br><h5><b>Hora de Entrada: </b></h5><h5>' + obj.hora_entrada + '</h5><br><h5><b>Verificar Asistencia: </b></h5><h5>' + verificar_asistencia + '</h5><br><h5><b>Verificar Contrato: </b></h5><h5>' + verificar_contrato + '</h5>');
                }
                $('#inf_adicional').html('<h5>' + obj.inf_usuario + '</h5>');
                let redes = '';
                if (obj.telefono != null) {
                    redes += `<a href="https://api.whatsapp.com/send?phone=+57${obj.telefojo}&amp;text=Hola, quiero contactar contigo" target="_blank"><img src='../Recursos/img/whatsapp_icon.png' style='width: 40px'></a>`;
                }
                if (obj.facebook != null) {
                    redes += `<a href='${obj.facebook}'><img src='../Recursos/img/${obj.facebook}' style='width: 40px'></a>`;
                }
                if (obj.instagram != null) {
                    redes += `<a href='${obj.instagram}'><img src='../Recursos/img/${obj.instagram}' style='width: 40px'></a>`;
                }
                if (obj.youtube != null) {
                    redes += `<a href='${obj.youtube}'><img src='../Recursos/img/' style='width: 40px'></a>`;
                }
                if (obj.tiktok != null) {
                    redes += `<a href='${obj.tiktok}'><img src='../Recursos/img/' style='width: 40px'></a>`;
                }
                $('#inf_adicional').html(redes);

                if (ver == 1) {
                    // Laboral Academico
                    var academica = `<table class="table table-bordered text-center" style="width: 100%">
                                        <tr class='notiHeader'>
                                            <td>Nivel Educativo</td>
                                            <td>Profesión o Labor</td>
                                            <td>Experiencia</td>
                                            <td>Fondo de Pensión</td>
                                            <td>Cesantías</td>
                                        </tr>
                                        <tr >
                                            <td>${obj.nivel_academico != null ? obj.nivel_academico : ""}</td>
                                            <td>${obj.profesion != null ? obj.profesion : ""}</td>
                                            <td>${obj.experiencia != null ? obj.experiencia : "0"} años</td>
                                            <td>${obj.fondo != null ? obj.fondo : ""}</td>
                                            <td>${obj.cesantias != null ? obj.cesantias : ""}</td>
                                        </tr>
                                     </table>`;
                    $('#infGeneralAcademica').html(academica);
                    listarCursos(id);
                    listarEstudios(id);

                    // Laboral Familiar
                    if (obj.nombre_madre != null) {
                        var madre = `<p><h4><b>Información de la madre</b><br></h4><h5><b>Nombre: </b>${obj.nombre_madre}<br><b>Teléfono: </b>${obj.telefono_madre!=null?obj.telefono_madre:"N/A"}</h5></p>`;
                        $('#infMadre').html(madre);
                    }
                    if (obj.nombre_padre != null) {
                        var padre = `<p><h4><b>Información del padre</b><br></h4><h5><b>Nombre: </b>${obj.nombre_padre}<br><b>Teléfono: </b>${obj.telefono_padre!=null?obj.telefono_padre:"N/A"}</h5></p>`;
                        $('#infPadre').html(padre);
                    }
                    listarPersonasACargo(id);

                    // Laboral Salud
                    var salud = `<table class="table table-bordered text-center" style="width: 100%">
                                        <tr class='notiHeader'>
                                            <td>EPS</td>
                                            <td>Tipo Sangre</td>
                                            <td>Contácto Emergencia</td>
                                            <td>Teléfono</td>
                                            <td>Parentezco</td>
                                        </tr>
                                        <tr >
                                            <td>${obj.eps != null ? obj.eps : ""}</td>
                                            <td>${obj.tipo_sangre != null ? obj.tipo_sangre : ""}</td>
                                            <td>${obj.contacto_emergencia != null ? obj.contacto_emergencia : ""} años</td>
                                            <td>${obj.telefono_contacto != null ? obj.telefono_contacto : ""}</td>
                                            <td>${obj.parentezco_contacto != null ? obj.parentezco_contacto : ""}</td>
                                        </tr>
                                     </table>`;
                    $('#saludGeneral').html(salud);
                    listarAlergias(id);
                    listarAntecedentes(id);
                    listarCirugia(id);
                    listarEnfermedades(id);
                    listarLesiones(id);
                    listarMedicamentos(id);

                    // Laboral Sociodemografico
                    var sociodemografica = `<table class="table table-bordered text-center" style="width: 100%">
                                        
                                                <tr >
                                                    <td class='notiHeader'><b>Estrato</b></td><td>${obj.estrato != null ? obj.estrato : ""}</td>
                                                </tr>
                                                <tr >
                                                    <td class='notiHeader'><b>Estado Cívil</b></td><td>${obj.estado_civil != null ? obj.estado_civil : ""}</td>
                                                </tr>
                                                <tr >
                                                    <td class='notiHeader'><b>Grupo Étnico</b></td><td>${obj.grupo_etnico != null ? obj.grupo_etnico : ""}</td>
                                                </tr>
                                                <tr >
                                                    <td class='notiHeader'><b>Personas a cargo</b></td><td>${obj.personas_cargo != null ? obj.personas_cargo : ""}</td>
                                                </tr>
                                                <tr >
                                                    <td class='notiHeader'><b>Cabeza de Familia</b></td><td>${obj.cabeza_familia != null ? obj.cabeza_familia == 0 ? "No" : "Si" : ""}</td>
                                                </tr>
                                                <tr >
                                                    <td class='notiHeader'><b>Número Hijos</b></td><td>${obj.hijos != null ? obj.hijos : ""}</td>
                                                </tr>
                                                <tr >
                                                    <td class='notiHeader'><b>Fuma</b></td><td>${obj.fuma != null ? obj.fuma == 0 ? "No" : "Si" : ""}</td>
                                                </tr>
                                                <tr >
                                                    <td class='notiHeader'><b>Frecuencia Fuma</b></td><td>${obj.fuma_frecuencia != null ? obj.fuma_frecuencia : ""}</td>
                                                </tr>
                                                <tr >
                                                    <td class='notiHeader'><b>Bebidas Alcohólicas</b></td><td>${obj.bebidas != null ? obj.bebidas == 0 ? "No" : "Si" : ""}</td>
                                                </tr>
                                                <tr >
                                                    <td class='notiHeader'><b>Frecuencia Bebidas</b></td><td>${obj.bebidas_frecuencia != null ? obj.bebidas_frecuencia : ""}</td>
                                                </tr>
                                                <tr >
                                                    <td class='notiHeader'><b>Deportes que práctica</b></td><td>${obj.deporte != null ? obj.deporte : ""}</td>
                                                </tr>
                                                <tr >
                                                    <td class='notiHeader'><b>Talla de Camisa</b></td><td>${obj.talla_camisa != null ? obj.talla_camisa : ""}</td>
                                                </tr>
                                                <tr >
                                                    <td class='notiHeader'><b>Talla Pantalón</b></td><td>${obj.talla_pantalon != null ? obj.talla_pantalon : ""}</td>
                                                </tr>
                                                <tr >
                                                    <td class='notiHeader'><b>Talla Calzado</b></td><td>${obj.talla_calzado != null ? obj.talla_calzado : ""}</td>
                                                </tr>
                                                <tr >
                                                    <td class='notiHeader'><b>Tipo Vivienda</b></td><td>${obj.tipo_vivienda != null ? obj.tipo_vivienda : ""}</td>
                                                </tr>
                                                <tr >
                                                    <td class='notiHeader'><b>Licencia de Conducción</b></td><td>${obj.licencia_conduccion != null ? obj.licencia_conduccion == 0 ? "No" : "Si" : ""}</td>
                                                </tr>
                                                <tr >
                                                    <td class='notiHeader'><b>Descripción Licencia</b></td><td>${obj.licencia_descr != null ? obj.licencia_descr : ""}</td>
                                                </tr>
                                                <tr >
                                                    <td class='notiHeader'><b>Actividades de tiempo libre</b></td><td>${obj.act_tiempo_libre != null ? obj.act_tiempo_libre : ""}</td>
                                                </tr>
                                            
                                     </table>`;
                    $('#infSocio').html(sociodemografica);
                }
            }
        });
    }

    function conexiones_usuario() {
        let template = ``;
        var funcion = "conexiones_usuario";
        $.post('../Controlador/usuarioController.php', { funcion, id }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            template += `            <table class="table table-bordered text-center" style="width: 100%">
                                                <thead>                  
                                                    <tr class='notiHeader'>
                                                        <th colspan='3'>Conexiones</th>
                                                    </tr>
                                                    <tr class='notiHeader'>
                                                        <th >#</th>
                                                        <th>Fecha</th>
                                                        <th>Hora</th>  
                                                    </tr>
                                                </thead>
                                                <tbody>`;

            objetos.forEach(objeto => {
                num += 1;
                template += `                       <tr idCargo=${objeto.id}>
                                                        <td>${num}</td>
                                                        <td>${objeto.fecha}</td>
                                                        <td>${objeto.hora}</td>
                                                    </tr>`;
            });
            template += `                       </tbody>
                                            </table>`;
            $('#conexiones').html(template);
        });
    }

    function listarPersonasACargo(id_usuario) {
        var funcion = "listar_persona_a_cargo";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            var template = `            <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr class='notiHeader text-center'><td colspan='5'><b>Personas a Cargo</b></td></tr>
                                                <tr class='notiHeader'>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Nombre</th>
                                                    <th scope="col">Edad</th>
                                                    <th scope="col">Fecha Nacimiento</th>
                                                    <th scope="col">Parentezco</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${objeto.nombre}</td>
                                                    <td>${objeto.edad}</td>
                                                    <td>${objeto.fecha_nac}</td>
                                                    <td>${objeto.parentezco}</td>
                                                </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#personasACargo').html(template);
        });
    }

    function listarMedicamentos(id_usuario) {
        var funcion = "listar_medicamentos";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            var template = `            <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr class='notiHeader text-center'><td colspan='3'><b>Medicamentos</b></td></tr>
                                                <tr class='notiHeader'>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Nombre</th>
                                                    <th scope="col">Indicaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${objeto.nombre}</td>
                                                    <td>${objeto.indicaciones}</td>
                                                </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#medicamentos').html(template);
        });
    }

    function listarEnfermedades(id_usuario) {
        var funcion = "listar_enfermedad";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            var template = `            <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr class='notiHeader text-center'><td colspan='2'><b>Enfermedades</b></td></tr>
                                                <tr class='notiHeader'>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Nombre</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${objeto.nombre}</td>
                                                </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#enfermedades').html(template);
        });
    }

    function listarAlergias(id_usuario) {
        var funcion = "listar_alergia";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            var template = `            <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr class='notiHeader text-center'><td colspan='3'><b>Alergias</b></td></tr>
                                                <tr class='notiHeader'>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Tipo</th>
                                                    <th scope="col">Nombre</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${objeto.tipo}</td>
                                                    <td>${objeto.nombre}</td>
                                                </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#alergias').html(template);
        });
    }

    function listarCirugia(id_usuario) {
        var funcion = "listar_cirugia";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            var template = `            <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr class='notiHeader text-center'><td colspan='2'><b>Cirugías</b></td></tr>
                                                <tr class='notiHeader'>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Nombre</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${objeto.nombre}</td>
                                                </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#cirugias').html(template);
        });
    }

    function listarLesiones(id_usuario) {
        var funcion = "listar_lesion";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            var template = `            <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr class='notiHeader text-center'><td colspan='3'><b>Lesiones</b></td></tr>
                                                <tr class='notiHeader'>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Tipo</th>
                                                    <th scope="col">Nombre</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${objeto.tipo}</td>
                                                    <td>${objeto.nombre}</td>
                                                </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#lesiones').html(template);
        });
    }

    function listarAntecedentes(id_usuario) {
        var funcion = "listar_antecedente";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            var template = `            <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr class='notiHeader text-center'><td colspan='2'><b>Antecedentes</b></td></tr>
                                                <tr class='notiHeader'>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Nombre</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${objeto.nombre}</td>
                                                </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#antedentes').html(template);
        });
    }

    function listarEstudios(id_usuario) {
        var funcion = "listar_estudio";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            var template = `            <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr class='notiHeader text-center'><td colspan='7'><b>Estudios Académicos</b></td></tr>
                                                <tr class='notiHeader'>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Nivel</th>
                                                    <th scope="col">Tipo</th>
                                                    <th scope="col">Título</th>
                                                    <th scope="col">Institución</th>
                                                    <th scope="col">Año</th>
                                                    <th scope="col">Ciudad</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${objeto.nivel}</td>
                                                    <td>${objeto.tipo_nivel}</td>
                                                    <td>${objeto.titulo}</td>
                                                    <td>${objeto.institucion}</td>
                                                    <td>${objeto.ano}</td>
                                                    <td>${objeto.ciudad}</td>
                                                </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#estudios').html(template);
        });
    }

    function listarCursos(id_usuario) {
        var funcion = "listar_curso";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            var template = `            <table class="table table-hover ">
                                            <thead class="table-light">
                                                <tr class='notiHeader text-center'><td colspan='6'><b>Cursos</b></td></tr>
                                                <tr class='notiHeader'>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Nombre Curso</th>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col">Institución</th>
                                                    <th scope="col">Horas</th>
                                                    <th scope="col">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${objeto.descripcion}</td>
                                                    <td>${objeto.fecha}</td>
                                                    <td>${objeto.institucion}</td>
                                                    <td>${objeto.horas}</td>
                                                </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#cursos').html(template);
        });
    }

    function adjuntosCargo(id_cargo) {
        var funcion = "archivosPorCargoEspecifico";
        $.post('../Controlador/archivoController.php', { funcion, id_cargo }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            var template = ``;
            objetos.forEach(objeto => {
                num += 1;
                if(objeto.tipo=='Imagén'){
                    tipo = 'png.png';
                }
                if(objeto.tipo=='Documento'){
                    tipo = 'doc.png';
                }
                if(objeto.tipo=='Hoja de calculo'){
                    tipo = 'xls.png';
                }
                if(objeto.tipo=='Documento PDF'){
                    tipo = 'pdf.png';
                }
                template += `<a href='../Recursos/biblioteca/${objeto.archivo}' target='blanck'><img width='35px' src='../Recursos/img/${tipo}'> ${objeto.nombre}</a>`;
            });
            template += `<br><br>`;
            $('#adjuntos').html(template);
        });
    }

    function miHorario(id_usuario) {
        var funcion = "miHorario";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const obj = JSON.parse(response);
            template = `<h5>${obj.descripcion}</h5><br><h6><b>Hora Entrada: </b>${obj.hora_entrada}</h6>`;
            $('#PHorario').html(template);
        });
    }

    function numerosCargo(id_usuario) {
        var funcion = "numerosCargo";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const obj = JSON.parse(response);
            $('#divTarde').html(obj.llegadas_tarde);
            $('#divColaboradorMes').html(obj.colaboradores_mes);
        });
    }

    function mesesColaboradorMes(id_usuario) {
        var funcion = "mesesColaboradorMes";
        $.post('../Controlador/usuarioController.php', { funcion, id_usuario }, (response) => {
            const objetos = JSON.parse(response);
            num = 0;
            var template = `            <table class="table table-hover ">
                                            <thead class="table-light">
                                                <tr class='notiHeader'>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Tipo</th>
                                                    <th scope="col">Mes</th>
                                                    <th scope="col">Año</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;
            objetos.forEach(objeto => {
                num += 1;
                template += `                   <tr id=${objeto.id}>
                                                    <td>${num}</td>
                                                    <td>${objeto.tipo}</td>
                                                    <td>${objeto.mes}</td>
                                                    <td>${objeto.ano}</td>
                                                </tr>`;
            });
            template += `                   </tbody>
                                        </table>`;
            $('#PColaboradorMes').html(template);
        });
    }

});
<?php
$fecha = date("Y") . "-" . date("m") . "-" . date("d");
include_once '../../Conexion/Conexion.php';
$año = date("Y");
$color = "#f09f09";
$accion = $_POST['accion'];


if ($accion == "completo") {
    //Nombre del archivo
    //        header('Content-Type:text/csv; charset=latin1');
    header('Content-Type: aplication/xls; charset=UTF-8');
    header('Content-Disposition: attachment;filename=TH_completo.xls');
    $sql = "SELECT U.*, S.nombre AS nombre_sede, C.nombre_cargo, T.nombre_tipo, M.nombre AS municipio, D.nombre AS departamentos, TIMESTAMPDIFF(YEAR, U.fecha_nacimiento, CURDATE()) AS edad FROM usuarios U LEFT JOIN cargos C ON U.id_cargo=C.id LEFT JOIN sedes S ON U.id_sede=S.id LEFT JOIN tipo_usuarios T ON U.id_tipo_usuario=T.id LEFT JOIN municipios M ON U.ciudad_residencia=M.id JOIN departamentos D ON M.departamento_id=D.id 
    WHERE U.estado = 1 AND U.id <>1 ORDER BY U.nombre_completo ASC";


    $resultado = ejecutarSQL::consultar($sql);
?>
    <h3 align="center" bgcolor="<?= $color?>"> LISTADO COMPLETO COLABORADORES</h3>
    <table width="100%" border="1" align="center">
        <tr bgcolor="<?= $color?>" align="center">
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA CREACION</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">ESTADO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">TIPO USUARIO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">SEDE</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CARGO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">NOMBRE COMPLETO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">DOCUMENTO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">GENERO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">DIRECCION</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">TELEFONO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CIUDAD RESIDENCIA</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA NACIMIENTO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">EDAD</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">EMAIL</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CONTACTO EMERGENCIA</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">PARENTEZCO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">TELEFONO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">EPS</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">TIPO SANGRE</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FONDO PENSIONES</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CESANTIAS</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">NOMBRE MADRE</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">TELEFONO MADRE</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">NOMBRE PADRE</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">TELEFONO PADRE</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">NIVEL ACADEMICO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">PROFESION U OCUPACION</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">EXPERIENCIA</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">ESTRATO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">ESTADO CIVIL</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">PERSONAS A CARGO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CABEZA DE FAMILIA</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">HIJOS</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FUMA</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FRECUENCIA FUMA</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">BEBIDAS</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FRECUENCIA BEBIDAS</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">DEPORTE</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">TALLA CAMISA</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">TALLA PANTALON</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">TALLA CALZADO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">TIPO VIVIENDA</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">LICENCIA CONDUCCION</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">DESCRIPCION LICENCIA</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">ACC TIEMPO LIBRE</h5>
            </td>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($resultado)) {
        ?>
            <tr align="center">
                <td><?php echo utf8_decode($row['fecha_creacion']) ?></td>
                <td><?php echo utf8_decode($row['estado']==1?'Activo':"Inactivo") ?></td>
                <td><?php echo utf8_decode($row['nombre_tipo']) ?></td>
                <td><?php echo utf8_decode($row['nombre_sede']) ?></td>
                <td><?php echo utf8_decode($row['nombre_cargo']) ?></td>
                <td><?php echo utf8_decode($row['nombre_completo']) ?></td>
                <td><?php echo utf8_decode($row['doc_id']) ?></td>
                <td><?php echo utf8_decode($row['genero']) ?></td>
                <td><?php echo utf8_decode($row['direccion']) ?></td>
                <td><?php echo utf8_decode($row['telefono']) ?></td>
                <td><?php echo utf8_decode($row['municipio']."(".$row['departamentos'].")") ?></td>
                <td><?php echo utf8_decode($row['fecha_nacimiento']) ?></td>
                <td><?php echo utf8_decode($row['edad']) ?></td>
                <td><?php echo utf8_decode($row['email']) ?></td>
                <td><?php echo utf8_decode($row['contacto_emergencia']) ?></td>
                <td><?php echo utf8_decode($row['parentezco_contacto']) ?></td>
                <td><?php echo utf8_decode($row['telefono_contacto']) ?></td>
                <td><?php echo utf8_decode($row['eps']) ?></td>
                <td><?php echo utf8_decode($row['tipo_sangre']) ?></td>
                <td><?php echo utf8_decode($row['fondo']) ?></td>
                <td><?php echo utf8_decode($row['cesantias']) ?></td>

                <td><?php echo utf8_decode($row['nombre_madre']) ?></td>
                <td><?php echo utf8_decode($row['telefono_madre']) ?></td>
                <td><?php echo utf8_decode($row['nombre_padre']) ?></td>
                <td><?php echo utf8_decode($row['telefono_padre']) ?></td>

                <td><?php echo utf8_decode($row['nivel_academico']) ?></td>
                <td><?php echo utf8_decode($row['profesion']) ?></td>
                <td><?php echo utf8_decode($row['experiencia']." años") ?></td>
                <td><?php echo utf8_decode($row['estrato']) ?></td>
                <td><?php echo utf8_decode($row['estado_civil']) ?></td>
                <td><?php echo utf8_decode($row['personas_cargo']) ?></td>
                <td><?php echo utf8_decode($row['cabeza_familia']) ?></td>
                <td><?php echo utf8_decode($row['hijos']) ?></td>
                <td><?php echo utf8_decode($row['fuma']) ?></td>
                <td><?php echo utf8_decode($row['fuma_frecuencia']) ?></td>
                <td><?php echo utf8_decode($row['bebidas']) ?></td>
                <td><?php echo utf8_decode($row['bebidas_frecuencia']) ?></td>
                <td><?php echo utf8_decode($row['deporte']) ?></td>
                <td><?php echo utf8_decode($row['talla_camisa']) ?></td>
                <td><?php echo utf8_decode($row['talla_pantalon']) ?></td>
                <td><?php echo utf8_decode($row['talla_calzado']) ?></td>
                <td><?php echo utf8_decode($row['tipo_vivienda']) ?></td>
                <td><?php echo utf8_decode($row['licencia_conduccion']) ?></td>
                <td><?php echo utf8_decode($row['licencia_descr']) ?></td>
                <td><?php echo utf8_decode($row['act_tiempo_libre']) ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
<?php
    exit;
}

if ($accion == "basico") {
    //Nombre del archivo
    //        header('Content-Type:text/csv; charset=latin1');
    header('Content-Type: aplication/xls; charset=UTF-8');
    header('Content-Disposition: attachment;filename=TH_basico.xls');
    $sql = "SELECT U.*, S.nombre AS nombre_sede, C.nombre_cargo, T.nombre_tipo, M.nombre AS municipio, D.nombre AS departamentos, TIMESTAMPDIFF(YEAR, U.fecha_nacimiento, CURDATE()) AS edad FROM usuarios U LEFT JOIN cargos C ON U.id_cargo=C.id LEFT JOIN sedes S ON U.id_sede=S.id LEFT JOIN tipo_usuarios T ON U.id_tipo_usuario=T.id LEFT JOIN municipios M ON U.ciudad_residencia=M.id JOIN departamentos D ON M.departamento_id=D.id 
    WHERE U.estado = 1 AND U.id <>1 ORDER BY U.nombre_completo ASC";


    $resultado = ejecutarSQL::consultar($sql);
?>
    <h3 align="center" bgcolor="<?= $color?>"> LISTADO BASICO COLABORADORES</h3>
    <table width="100%" border="1" align="center">
        <tr bgcolor="<?= $color?>" align="center">
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA CREACION</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">ESTADO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">TIPO USUARIO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">SEDE</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CARGO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">NOMBRE COMPLETO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">DOCUMENTO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">GENERO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">DIRECCION</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">TELEFONO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CIUDAD RESIDENCIA</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA NACIMIENTO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">EDAD</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">EMAIL</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CONTACTO EMERGENCIA</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">PARENTEZCO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">TELEFONO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">EPS</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">TIPO SANGRE</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FONDO PENSIONES</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CESANTIAS</h5>
            </td>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($resultado)) {
        ?>
            <tr align="center">
                <td><?php echo utf8_decode($row['fecha_creacion']) ?></td>
                <td><?php echo utf8_decode($row['estado']==1?'Activo':"Inactivo") ?></td>
                <td><?php echo utf8_decode($row['nombre_tipo']) ?></td>
                <td><?php echo utf8_decode($row['nombre_sede']) ?></td>
                <td><?php echo utf8_decode($row['nombre_cargo']) ?></td>
                <td><?php echo utf8_decode($row['nombre_completo']) ?></td>
                <td><?php echo utf8_decode($row['doc_id']) ?></td>
                <td><?php echo utf8_decode($row['genero']) ?></td>
                <td><?php echo utf8_decode($row['direccion']) ?></td>
                <td><?php echo utf8_decode($row['telefono']) ?></td>
                <td><?php echo utf8_decode($row['municipio']."(".$row['departamentos'].")") ?></td>
                <td><?php echo utf8_decode($row['fecha_nacimiento']) ?></td>
                <td><?php echo utf8_decode($row['edad']) ?></td>
                <td><?php echo utf8_decode($row['email']) ?></td>
                <td><?php echo utf8_decode($row['contacto_emergencia']) ?></td>
                <td><?php echo utf8_decode($row['parentezco_contacto']) ?></td>
                <td><?php echo utf8_decode($row['telefono_contacto']) ?></td>
                <td><?php echo utf8_decode($row['eps']) ?></td>
                <td><?php echo utf8_decode($row['tipo_sangre']) ?></td>
                <td><?php echo utf8_decode($row['fondo']) ?></td>
                <td><?php echo utf8_decode($row['cesantias']) ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
<?php
    exit;
}

if ($accion == "incapacidades") {
    //Nombre del archivo
    //        header('Content-Type:text/csv; charset=latin1');
    header('Content-Type: aplication/xls; charset=UTF-8');
    header('Content-Disposition: attachment;filename=TH_basico.xls');
    $sql = "SELECT I.inicio, I.fin, I.tipo, I.duracion, I.descripcion, I.diagnostico, I.estado, U.nombre_completo, U.doc_id, C.nombre_cargo, S.nombre AS nombre_sede 
    FROM incapacidades I JOIN usuarios U ON I.id_usuario=U.id JOIN cargos C ON U.id_cargo=C.id JOIN sedes S ON U.id_sede=S.id ORDER BY I.inicio DESC";


    $resultado = ejecutarSQL::consultar($sql);
?>
    <h3 align="center" bgcolor="<?= $color?>"> LISTADO DE INCAPACIDADES</h3>
    <table width="100%" border="1" align="center">
        <tr bgcolor="<?= $color?>" align="center">
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">SEDE</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CARGO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">ESTADO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">NOMBRE COMPLETO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">DOCUMENTO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">INICIO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FIN</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">DURACION</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">DESCRIPCION</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">DIAGNOSTICO</h5>
            </td>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($resultado)) {
        ?>
            <tr align="center">
                <td><?php echo utf8_decode($row['nombre_sede']) ?></td>
                <td><?php echo utf8_decode($row['nombre_cargo']) ?></td>
                <td><?php echo utf8_decode($row['estado']==1?'Activo':"Inactivo") ?></td>
                <td><?php echo utf8_decode($row['nombre_completo']) ?></td>
                <td><?php echo utf8_decode($row['inicio']) ?></td>
                <td><?php echo utf8_decode($row['fin']) ?></td>
                <td><?php echo utf8_decode($row['duracion']) ?></td>
                <td><?php echo utf8_decode($row['descripcion']) ?></td>
                <td><?php echo utf8_decode($row['diagnostico']) ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
<?php
    exit;
}

if ($accion == "solicitudes") {
    //Nombre del archivo
    //        header('Content-Type:text/csv; charset=latin1');
    header('Content-Type: aplication/xls; charset=UTF-8');
    header('Content-Disposition: attachment;filename=TH_basico.xls');
    $sql = "SELECT U.nombre_completo, U.doc_id, SE.nombre AS nombre_sede, C.nombre_cargo, S.tipo, S.fecha_solicitud, S.estado, S.fecha_inicial, S.cantidad, S.compensados, S.observaciones, UA.nombre_completo AS nombre_aprobador, S.fecha_final
    FROM usuario_solicitudes S JOIN usuarios U ON S.id_usuario=U.id JOIN sedes SE ON U.id_sede=SE.id JOIN cargos C ON U.id_cargo=C.id JOIN usuarios UA ON S.id_aprobador=UA.id
    ORDER BY S.fecha_solicitud DESC";


    $resultado = ejecutarSQL::consultar($sql);
?>
    <h3 align="center" bgcolor="<?= $color?>"> LISTADO DE SOLICITUDES</h3>
    <table width="100%" border="1" align="center">
        <tr bgcolor="<?= $color?>" align="center">
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">SEDE</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CARGO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">ESTADO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">NOMBRE COMPLETO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">DOCUMENTO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">TIPO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA SOLICITUD</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA INICIAL</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA FINAL</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CANTIDAD</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">OBSERVACIONES</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">QUIEN APROBO</h5>
            </td>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($resultado)) {
            $estado = "";
            if($row['estado']==1){
                $estado = "Pendiente";
            }else if($row['estado']==2){
                $estado = "Aprobado";
            }else if($row['estado']==3){
                $estado = "Rechazado";
            }else if($row['estado']==4){
                $estado = "Anulado";
            }
        ?>
            <tr align="center">
                <td><?php echo utf8_decode($row['nombre_sede']) ?></td>
                <td><?php echo utf8_decode($row['nombre_cargo']) ?></td>
                <td><?php echo utf8_decode($estado) ?></td>
                <td><?php echo utf8_decode($row['nombre_completo']) ?></td>
                <td><?php echo utf8_decode($row['tipo']) ?></td>
                <td><?php echo utf8_decode($row['fecha_solicitud']) ?></td>
                <td><?php echo utf8_decode($row['fecha_inicial']) ?></td>
                <td><?php echo utf8_decode($row['fecha_final']) ?></td>
                <td><?php echo utf8_decode($row['cantidad']) ?></td>
                <td><?php echo utf8_decode($row['observaciones']) ?></td>
                <td><?php echo utf8_decode($row['nombre_aprobador']) ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
<?php
    exit;
}
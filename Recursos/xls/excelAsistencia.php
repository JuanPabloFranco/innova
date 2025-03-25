<?php
$fecha = date("Y") . "-" . date("m") . "-" . date("d");
include_once '../../Conexion/Conexion.php';
$año = date("Y");
$color = "#f09f09";
$accion = $_POST['accion'];


if ($accion == "full") {
    //Nombre del archivo
    //        header('Content-Type:text/csv; charset=latin1');
    header('Content-Type: aplication/xls; charset=UTF-8');
    header('Content-Disposition: attachment;filename=reporte_asistencia.xls');
    $sql = "SELECT U.nombre_completo, U.doc_id, S.nombre AS nombre_sede, A.nombre AS nombre_area, C.nombre_cargo, UA.tipo, UA.fecha_hora FROM usuario_asistencia UA JOIN usuarios U ON UA.id_usuario=U.id JOIN sedes S ON U.id_sede=S.id JOIN areas A ON U.id_area=A.id JOIN cargos C ON U.id_cargo=C.id ORDER BY UA.fecha_hora DESC";


    $resultado = ejecutarSQL::consultar($sql);
?>
    <h3 align="center" bgcolor="<?= $color?>"> ASISTENCIA</h3>
    <table width="100%" border="1" align="center">
        <tr bgcolor="<?= $color?>" align="center">
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">COLABORADOR</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">DOCUMENTO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">SEDE</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">AREA</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CARGO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">TIPO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA</h5>
            </td>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($resultado)) {
        ?>
            <tr align="center">
                <td><?php echo utf8_decode($row['nombre_completo']) ?></td>
                <td><?php echo utf8_decode($row['doc_id']) ?></td>
                <td><?php echo utf8_decode($row['nombre_sede']) ?></td>
                <td><?php echo utf8_decode($row['nombre_area']) ?></td>
                <td><?php echo utf8_decode($row['nombre_cargo']) ?></td>
                <td><?php echo utf8_decode($row['tipo']) ?></td>
                <td><?php echo utf8_decode($row['fecha_hora']) ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
<?php
    exit;
}

if ($accion == "mes_actual") {
    //Nombre del archivo
    //        header('Content-Type:text/csv; charset=latin1');
    header('Content-Type: aplication/xls; charset=UTF-8');
    header('Content-Disposition: attachment;filename=reporte_asistencia_mes_actual.xls');
    $sql = "SELECT U.nombre_completo, U.doc_id, S.nombre AS nombre_sede, A.nombre AS nombre_area, C.nombre_cargo, UA.tipo, UA.fecha_hora FROM usuario_asistencia UA JOIN usuarios U ON UA.id_usuario=U.id JOIN sedes S ON U.id_sede=S.id JOIN areas A ON U.id_area=A.id JOIN cargos C ON U.id_cargo=C.id WHERE MONTH(UA.fecha_hora)=MONTH(NOW()) ORDER BY UA.fecha_hora DESC";


    $resultado = ejecutarSQL::consultar($sql);
?>
    <h3 align="center" bgcolor="<?= $color?>"> ASISTENCIA MES ACTUAL</h3>
    <table width="100%" border="1" align="center">
        <tr bgcolor="<?= $color?>" align="center">
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">COLABORADOR</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">DOCUMENTO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">SEDE</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">AREA</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CARGO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">TIPO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA</h5>
            </td>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($resultado)) {
        ?>
            <tr align="center">
                <td><?php echo utf8_decode($row['nombre_completo']) ?></td>
                <td><?php echo utf8_decode($row['doc_id']) ?></td>
                <td><?php echo utf8_decode($row['nombre_sede']) ?></td>
                <td><?php echo utf8_decode($row['nombre_area']) ?></td>
                <td><?php echo utf8_decode($row['nombre_cargo']) ?></td>
                <td><?php echo utf8_decode($row['tipo']) ?></td>
                <td><?php echo utf8_decode($row['fecha_hora']) ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
<?php
    exit;
}
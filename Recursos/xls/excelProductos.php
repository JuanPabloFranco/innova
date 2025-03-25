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
    header('Content-Disposition: attachment;filename=productos.xls');
    $sql = "SELECT P.id, P.nombre_producto, P.descripcion, P.codigo_barras, IF(P.estado=1,'Activo','Inactivo') AS estado FROM productos P ORDER BY P.id ASC";


    $resultado = ejecutarSQL::consultar($sql);
?>
    <h3 align="center" bgcolor="<?= $color?>"> PRODUCTOS</h3>
    <table width="100%" border="1" align="center">
        <tr bgcolor="<?= $color?>" align="center">
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CODIGO INTERNO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">NOMBRE PRODUCTO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CODIGO PRODUCTO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">DESCRIPCION</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">ESTADO</h5>
            </td>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($resultado)) {
        ?>
            <tr align="center">
                <td><?php echo utf8_decode($row['id']) ?></td>
                <td><?php echo utf8_decode($row['nombre_producto']) ?></td>
                <td><?php echo utf8_decode($row['codigo_barras']) ?></td>
                <td><?php echo utf8_decode($row['descripcion']) ?></td>
                <td><?php echo utf8_decode($row['estado']) ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
<?php
    exit;
}

if ($accion == "activos") {
    //Nombre del archivo
    //        header('Content-Type:text/csv; charset=latin1');
    header('Content-Type: aplication/xls; charset=UTF-8');
    header('Content-Disposition: attachment;filename=productos_activos.xls');
    $sql = "SELECT P.id, P.nombre_producto, P.descripcion, P.codigo_barras, IF(P.estado=1,'Activo','Inactivo') AS estado FROM productos P WHERE P.estado=1 ORDER BY P.id ASC";


    $resultado = ejecutarSQL::consultar($sql);
?>
    <h3 align="center" bgcolor="<?= $color?>"> PRODUCTOS ACTIVOS</h3>
    <table width="100%" border="1" align="center">
        <tr bgcolor="<?= $color?>" align="center">
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CODIGO INTERNO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">NOMBRE PRODUCTO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CODIGO PRODUCTO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">DESCRIPCION</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">ESTADO</h5>
            </td>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($resultado)) {
        ?>
            <tr align="center">
                <td><?php echo utf8_decode($row['id']) ?></td>
                <td><?php echo utf8_decode($row['nombre_producto']) ?></td>
                <td><?php echo utf8_decode($row['codigo_barras']) ?></td>
                <td><?php echo utf8_decode($row['descripcion']) ?></td>
                <td><?php echo utf8_decode($row['estado']) ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
<?php
    exit;
}


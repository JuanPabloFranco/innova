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
    header('Content-Disposition: attachment;filename=inventario_general.xls');
    $sql = "SELECT SUM(PS.cantidad) AS cantidad, P.nombre_producto, S.nombre AS nombre_sede, P.codigo_barras, P.id  AS codigo
                FROM productos_sala PS JOIN productos P ON PS.id_producto = P.id JOIN sedes S ON PS.id_sede = S.id 
                WHERE PS.estado = 2  AND P.estado=1
                GROUP BY P.nombre_producto, S.nombre";


    $resultado = ejecutarSQL::consultar($sql);
?>
    <h3 align="center" bgcolor="<?= $color?>"> INVENTARIO SALAS</h3>
    <table width="100%" border="1" align="center">
        <tr bgcolor="<?= $color?>" align="center">
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">SEDE</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CODIGO INTERNO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CODIGO PRODUCTO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">NOMBRE PRODUCTO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CANTIDAD</h5>
            </td>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($resultado)) {
        ?>
            <tr align="center">
                <td><?php echo utf8_decode($row['nombre_sede']) ?></td>
                <td><?php echo utf8_decode($row['codigo']) ?></td>
                <td><?php echo utf8_decode($row['codigo_barras']) ?></td>
                <td><?php echo utf8_decode($row['nombre_producto']) ?></td>
                <td><?php echo utf8_decode($row['cantidad']) ?></td>
                
            </tr>
        <?php
        }
        ?>
    </table>
<?php
    exit;
}

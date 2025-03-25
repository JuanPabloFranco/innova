<?php
$fecha = date("Y") . "-" . date("m") . "-" . date("d");
include_once '../../Conexion/Conexion.php';
$año = date("Y");
$mes = date("m");
$color = "#f09f09";
$accion = $_POST['accion'];


if($mes=="01"){
    $mes = "ENERO";
} elseif($mes=="02"){
    $mes = "FEBRERO";
} elseif($mes=="03"){
    $mes = "MARZO";
} elseif($mes=="04"){
    $mes = "ABRIL";
} elseif($mes=="05"){
    $mes = "MAYO";
} elseif($mes=="06"){
    $mes = "JUNIO";
} elseif($mes=="07"){
    $mes = "JULIO";
} elseif($mes=="08"){
    $mes = "AGOSTO";
} elseif($mes=="09"){
    $mes = "SEPTIEMBRE";
} elseif($mes=="10"){
    $mes = "OCTUBRE";
} elseif($mes=="11"){
    $mes = "NOVIEMBRE";
} elseif($mes=="12"){
    $mes = "DICIEMBRE";
}

if ($accion == "full") {
    //Nombre del archivo
    //        header('Content-Type:text/csv; charset=latin1');
    header('Content-Type: aplication/xls; charset=UTF-8');
    header('Content-Disposition: attachment;filename=solicitudes_pago_transporte_full.xls');
    $sql = "SELECT 
                    P.id, 
                    P.fecha, 
                    P.fecha_creado, 
                    P.creado_por, 
                    U.nombre_completo, 
                    U.avatar, 
                    U.doc_id, 
                    S.nombre AS nombre_sede, 
                    C.nombre_cargo,  
                    CONCAT('$', FORMAT(
                        CASE 
                            WHEN D.tipo = 'Porcentaje' THEN P.valor - (P.valor * D.descuento / 100)
                            WHEN D.tipo = 'Valor Fijo' THEN P.valor - D.descuento
                            ELSE P.valor
                        END, 
                    0, 'de_DE')) AS valor, 
                    P.pago, 
                    P.estado, 
                    M.nombre AS ciudad, 
                    P.observacion, 
                    P.tipo_vehiculo, 
                    P.email, 
                    P.metodo_pago, 
                    P.fecha_para_entregar,
                    D.tipo AS tipo_descuento,
                    D.descuento,
                    P.id_descuento,
                    UA.nombre_completo AS aprobado_por,
                    P.fecha_aprobado,
                    UC.nombre_completo AS cargado_por,
                    P.fecha_cargado,
                    UE.nombre_completo AS entregado_por,
                    P.fecha_entregado,
                    UR.nombre_completo AS recibido_por,
                    P.fecha_recibido,
                    UAU.nombre_completo AS auditado_por,
                    P.fecha_auditado,
                    P.observacion_auditoria
                FROM 
                    pago_transporte P 
                    JOIN usuarios U ON P.creado_por = U.id 
                    LEFT JOIN sedes S ON U.id_sede = S.id
                    LEFT JOIN cargos C ON U.id_cargo = C.id 
                    LEFT JOIN municipios M ON P.ciudad = M.id 
                    LEFT JOIN descuentos_pago_transporte D ON P.id_descuento = D.id
                    LEFT JOIN usuarios UA ON P.aprobado_por=UA.id
                    LEFT JOIN usuarios UC ON P.cargado_por=UC.id
                    LEFT JOIN usuarios UE ON P.entregado_por=UE.id
                    LEFT JOIN usuarios UR ON P.recibido_por=UR.id
                    LEFT JOIN usuarios UAU ON P.auditado_por=UAU.id   
                ORDER BY P.fecha DESC";


    $resultado = ejecutarSQL::consultar($sql);
?>
    <h3 align="center" bgcolor="<?= $color?>"> SOLICITUDES PAGO DE TRANSPORTE</h3>
    <table width="100%" border="1" align="center">
        <tr bgcolor="<?= $color?>" align="center">
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">ESTADO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CIUDAD</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">TIPO VEHICULO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">DESCUENTO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">VALOR</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">EMAIL CLIENTE</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">METODO PAGO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FACTURA</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">PAGO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">OBSERVACION</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">APOBADO POR</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA APROBACION</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CREADO POR</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA CREACIÓN</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CARGADO POR</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA CARGADO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">ENTREGADO POR</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA ENTREGADO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">RECIBIDO POR</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA RECIBIDO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">AUDITADO POR</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA AUDITADO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">OBSERVACION AUDITORIA</h5>
            </td>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($resultado)) {
            $descuento = "";
            if($row['id_descuento']<>0){
                $descuento = $row['tipo_descuento']=="Porcentaje"? $row['descuento']."%": "$".$row['descuento'];
            }else{
                $descuento = "Sin Descuento";
            }
            $estado = "";
            if($row['estado']==0){ // Pendiente Aprobación
                $estado = "Pendiente Aprobación";
            } elseif ($row['estado']==1){
                $estado = "Pendiente Cargue";
            }elseif ($row['estado']==2){
                $estado = "Cargado";
            }elseif ($row['estado']==3){
                $estado = "Entregado";
            }elseif ($row['estado']==4){
                $estado = "Recibido";
            }else{
                $estado = "Auditado";
            }
        ?>
            <tr align="center">
                <td><?php echo utf8_decode($estado) ?></td>
                <td><?php echo utf8_decode($row['fecha']) ?></td>
                <td><?php echo utf8_decode($row['ciudad']) ?></td>
                <td><?php echo utf8_decode($row['tipo_vehiculo']) ?></td>
                <td><?php echo utf8_decode($descuento) ?></td>
                <td><?php echo utf8_decode($row['valor']) ?></td>
                <td><?php echo utf8_decode($row['email']) ?></td>
                <td><?php echo utf8_decode($row['metodo_pago']) ?></td>
                <td><?php echo utf8_decode($row['no_factura']) ?></td>
                <td><?php echo utf8_decode($row['pago']) ?></td>
                <td><?php echo utf8_decode($row['observacion']) ?></td>
                <td><?php echo $row['aprobado_por']<>""? utf8_decode($row['aprobado_por']): "" ?></td>
                <td><?php echo $row['aprobado_por']<>""? utf8_decode($row['fecha_aprobado']): "" ?></td>
                <td><?php echo utf8_decode($row['nombre_completo']) ?></td>
                <td><?php echo utf8_decode($row['fecha_creado']) ?></td>
                <td><?php echo utf8_decode($row['cargado_por']) ?></td>
                <td><?php echo utf8_decode($row['fecha_cargado']) ?></td>
                <td><?php echo utf8_decode($row['entregado_por']) ?></td>
                <td><?php echo utf8_decode($row['fecha_entregado']) ?></td>
                <td><?php echo utf8_decode($row['recibido_por']) ?></td>
                <td><?php echo utf8_decode($row['fecha_recibido']) ?></td>
                <td><?php echo utf8_decode($row['auditado_por']) ?></td>
                <td><?php echo utf8_decode($row['fecha_auditado']) ?></td>
                <td><?php echo utf8_decode($row['observacion_auditoria']) ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
<?php
    exit;
}

if ($accion == "mes") {
    //Nombre del archivo
    //        header('Content-Type:text/csv; charset=latin1');
    header('Content-Type: aplication/xls; charset=UTF-8');
    header('Content-Disposition: attachment;filename=solicitudes_pago_transporte_mes.xls');
    $sql = "SELECT 
                    P.id, 
                    P.fecha, 
                    P.fecha_creado, 
                    P.creado_por, 
                    U.nombre_completo, 
                    U.avatar, 
                    U.doc_id, 
                    S.nombre AS nombre_sede, 
                    C.nombre_cargo,  
                    CONCAT('$', FORMAT(
                        CASE 
                            WHEN D.tipo = 'Porcentaje' THEN P.valor - (P.valor * D.descuento / 100)
                            WHEN D.tipo = 'Valor Fijo' THEN P.valor - D.descuento
                            ELSE P.valor
                        END, 
                    0, 'de_DE')) AS valor, 
                    P.pago, 
                    P.estado, 
                    M.nombre AS ciudad, 
                    P.observacion, 
                    P.tipo_vehiculo, 
                    P.email, 
                    P.metodo_pago, 
                    P.fecha_para_entregar,
                    D.tipo AS tipo_descuento,
                    D.descuento,
                    P.id_descuento,
                    UA.nombre_completo AS aprobado_por,
                    P.fecha_aprobado,
                    UC.nombre_completo AS cargado_por,
                    P.fecha_cargado,
                    UE.nombre_completo AS entregado_por,
                    P.fecha_entregado,
                    UR.nombre_completo AS recibido_por,
                    P.fecha_recibido,
                    UAU.nombre_completo AS auditado_por,
                    P.fecha_auditado,
                    P.observacion_auditoria
                FROM 
                    pago_transporte P 
                    JOIN usuarios U ON P.creado_por = U.id 
                    LEFT JOIN sedes S ON U.id_sede = S.id
                    LEFT JOIN cargos C ON U.id_cargo = C.id 
                    LEFT JOIN municipios M ON P.ciudad = M.id 
                    LEFT JOIN descuentos_pago_transporte D ON P.id_descuento = D.id
                    LEFT JOIN usuarios UA ON P.aprobado_por=UA.id
                    LEFT JOIN usuarios UC ON P.cargado_por=UC.id
                    LEFT JOIN usuarios UE ON P.entregado_por=UE.id
                    LEFT JOIN usuarios UR ON P.recibido_por=UR.id
                    LEFT JOIN usuarios UAU ON P.auditado_por=UAU.id    
                WHERE 
                    MONTH(P.fecha) = MONTH(CURRENT_DATE()) AND 
                    YEAR(P.fecha) = YEAR(CURRENT_DATE())
                ORDER BY P.fecha DESC";


    $resultado = ejecutarSQL::consultar($sql);
?>
    <h3 align="center" bgcolor="<?= $color?>"> SOLICITUDES PAGO DE TRANSPORTE MES DE <?= $mes?></h3>
    <table width="100%" border="1" align="center">
        <tr bgcolor="<?= $color?>" align="center">
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">ESTADO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CIUDAD</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">TIPO VEHICULO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">DESCUENTO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">VALOR</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">EMAIL CLIENTE</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">METODO PAGO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FACTURA</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">PAGO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">OBSERVACION</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">APOBADO POR</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA APROBACION</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CREADO POR</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA CREACIÓN</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CARGADO POR</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA CARGADO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">ENTREGADO POR</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA ENTREGADO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">RECIBIDO POR</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA RECIBIDO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">AUDITADO POR</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA AUDITADO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">OBSERVACION AUDITORIA</h5>
            </td>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($resultado)) {
            $descuento = "";
            if($row['id_descuento']<>0){
                $descuento = $row['tipo_descuento']=="Porcentaje"? $row['descuento']."%": "$".$row['descuento'];
            }else{
                $descuento = "Sin Descuento";
            }
            $estado = "";
            if($row['estado']==0){ // Pendiente Aprobación
                $estado = "Pendiente Aprobación";
            } elseif ($row['estado']==1){
                $estado = "Pendiente Cargue";
            }elseif ($row['estado']==2){
                $estado = "Cargado";
            }elseif ($row['estado']==3){
                $estado = "Entregado";
            }elseif ($row['estado']==4){
                $estado = "Recibido";
            }else{
                $estado = "Auditado";
            }
        ?>
            <tr align="center">
                <td><?php echo utf8_decode($estado) ?></td>
                <td><?php echo utf8_decode($row['fecha']) ?></td>
                <td><?php echo utf8_decode($row['ciudad']) ?></td>
                <td><?php echo utf8_decode($row['tipo_vehiculo']) ?></td>
                <td><?php echo utf8_decode($descuento) ?></td>
                <td><?php echo utf8_decode($row['valor']) ?></td>
                <td><?php echo utf8_decode($row['email']) ?></td>
                <td><?php echo utf8_decode($row['metodo_pago']) ?></td>
                <td><?php echo utf8_decode($row['no_factura']) ?></td>
                <td><?php echo utf8_decode($row['pago']) ?></td>
                <td><?php echo utf8_decode($row['observacion']) ?></td>
                <td><?php echo $row['aprobado_por']<>""? utf8_decode($row['aprobado_por']): "" ?></td>
                <td><?php echo $row['aprobado_por']<>""? utf8_decode($row['fecha_aprobado']): "" ?></td>
                <td><?php echo utf8_decode($row['nombre_completo']) ?></td>
                <td><?php echo utf8_decode($row['fecha_creado']) ?></td>
                <td><?php echo utf8_decode($row['cargado_por']) ?></td>
                <td><?php echo utf8_decode($row['fecha_cargado']) ?></td>
                <td><?php echo utf8_decode($row['entregado_por']) ?></td>
                <td><?php echo utf8_decode($row['fecha_entregado']) ?></td>
                <td><?php echo utf8_decode($row['recibido_por']) ?></td>
                <td><?php echo utf8_decode($row['fecha_recibido']) ?></td>
                <td><?php echo utf8_decode($row['auditado_por']) ?></td>
                <td><?php echo utf8_decode($row['fecha_auditado']) ?></td>
                <td><?php echo utf8_decode($row['observacion_auditoria']) ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
<?php
    exit;
}

if ($accion == "salidas") {
    //Nombre del archivo
    //        header('Content-Type:text/csv; charset=latin1');
    header('Content-Type: aplication/xls; charset=UTF-8');
    header('Content-Disposition: attachment;filename=salidas_dinero_transporte.xls');
    $sql = "SELECT S.fecha, S.valor, S.concepto, U.nombre_completo, C.nombre_cargo, SE.nombre FROM salidas_transporte S LEFT JOIN usuarios U ON S.id_usuario=U.id LEFT JOIN cargos C ON U.id_cargo = C.id LEFT JOIN sedes SE ON U.id_sede = S.id ORDER BY S.fecha DESC";


    $resultado = ejecutarSQL::consultar($sql);
?>
    <h3 align="center" bgcolor="<?= $color?>"> SALIDAS DE DINERO DE TRANSPORTE</h3>
    <table width="100%" border="1" align="center">
        <tr bgcolor="<?= $color?>" align="center">
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">FECHA</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">VALOR</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CONCEPTO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">AUTOR</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">CARGO</h5>
            </td>
            <td bgcolor="<?= $color?>">
                <h5 style="color: #F6F6F6">SEDE</h5>
            </td>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($resultado)) {
        ?>
            <tr align="center">
                <td><?php echo utf8_decode($row['fecha']) ?></td>
                <td><?php echo utf8_decode("$".$row['valor']) ?></td>
                <td><?php echo utf8_decode($row['concepto']) ?></td>
                <td><?php echo utf8_decode($row['nombre_completo']) ?></td>
                <td><?php echo utf8_decode($row['nombre_cargo']) ?></td>
                <td><?php echo utf8_decode($row['nombre']) ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
<?php
    exit;
}

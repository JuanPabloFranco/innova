<?php
include_once '../../Conexion/Conexion.php';
if ($_GET['id']) {
    $sqlColaboradores = "SELECT U.id, U.nombre_completo, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id WHERE U.id<>1 AND U.estado=1 AND U.id_sede=".$_GET['id']." AND U.id_cargo IN(3,4,5,6,7,8,10,11,12,13,15)";
    $resColaboradores = ejecutarSQL::consultar($sqlColaboradores);
    if ($resColaboradores->num_rows > 0) { //si la variable tiene al menos 1 fila entonces seguimos con el codigo
        $option = "";
        while ($registro = mysqli_fetch_array($resColaboradores)) {
            $option .= "<option value='" . $registro['id'] . "'>" . $registro['nombre_completo'] . " (" . $registro['nombre_cargo'] . ")</option>";
        }
    } else {
        $option .= "<option value=''>No hay asesores registrados en esta sede</option>";
    }
} else {
    $option = "";
}
?>
<select class="form-control" id="selAsesor">
    <option value="">Elige el asesor que te atendió</option>
    <?= $option ?>
</select>
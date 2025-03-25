<?php
include_once '../../Conexion/Conexion.php';
if ($_GET['id']) {
    $sqlColaboradores = "SELECT S.id, S.nombre, I.cantidad FROM souvenir S JOIN inventario_souvenir_sede I ON I.id_souvenir=S.id JOIN sedes SE ON I.id_sede=SE.id WHERE I.cantidad>0 AND SE.estado=1 AND I.id_sede=".$_GET['id'];
    $resColaboradores = ejecutarSQL::consultar($sqlColaboradores);
    if ($resColaboradores->num_rows > 0) { //si la variable tiene al menos 1 fila entonces seguimos con el codigo
        $option = "";
        while ($registro = mysqli_fetch_array($resColaboradores)) {
            $option .= "<option value='" . $registro['id'] . "'>" . $registro['nombre'] . " (" . $registro['cantidad'] . " UND)</option>";
        }
    } else {
        $option .= "<option value=''>No hay souvenires en inventario de esta sede</option>";
    }
} else {
    $option = "";
}
?>
<label for="selSouvenir">Souvenir *</label>
<select class="form-control" id="selSouvenir">
    <option value="">Elige un Souvenir</option>
    <?= $option ?>
</select>
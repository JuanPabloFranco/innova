<label for="selProductosAgregar">Seleccione un producto</label><br>
<select id="selProductosAgregar" class="form-control" style="width: 100% !important;" required>
    <option value="0">Seleccione una opción</option>
    <?php
    include_once '../../Conexion/Conexion.php';
    if ($_GET['id']) {
        $sql = "SELECT P.id, P.nombre_producto, P.precio, PR.nombre_proveedor FROM listado_producto_basico_compras LP JOIN productos_admin_proveedor P ON LP.id_producto=P.id LEFT JOIN proveedor_productos_administrativos PR ON P.id_proveedor=PR.id WHERE LP.id_listado=" . $_GET['id'];
        $resSql = ejecutarSQL::consultar($sql);
        if ($resSql->num_rows > 0) { //si la variable tiene al menos 1 fila entonces seguimos con el codigo
            $option = "";
            while ($fila = mysqli_fetch_array($resSql)) {
                echo '<option value="' . $fila['id'] . '">' . $fila['nombre_producto'] . " / $" . $fila['precio'] . " (" . $fila['nombre_proveedor'] . ')</option>';
            }
        } else {
            $option .= "<option value=''>No existen productos registrados en la lista seleccionada</option>";
        }
    } else {
        $option = "";
    }
    ?>
    <?= $option ?>
</select>
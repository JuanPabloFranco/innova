<?php
include_once '../DAO/asistenciaDAO.php';

$dao = new asistenciaDAO();

return $dao->asignarPermisoMasivo();

?>
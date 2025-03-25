
<?php
include_once '../DAO/tareaDAO.php';

$dao = new tareaDAO();

$dao->finalizarAntiguas();

?>
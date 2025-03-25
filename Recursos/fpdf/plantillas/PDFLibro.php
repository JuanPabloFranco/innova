<?php

require '../Recursos/fpdf/fpdf.php';
include '../Conexion/consulSQL.php';


class PDFCarta extends FPDF {

    function Header() {
        $this->Image('../Recursos/img/fondo_hoja_antigua.png', 0, 0, 216);
    }

    function Footer() {
        $this->SetY(-20);
        $this->SetFont('Arial', 'I', 8);
    }
}

?>

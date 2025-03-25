<?php

require '../Recursos/fpdf/fpdf.php';
include '../Conexion/consulSQL.php';


class PDFTicket extends FPDF
{

    function Header()
    {
        $datos = mysqli_fetch_row(ejecutarSQL::consultar("SELECT C.nombre, C.logo, C.email, C.direccion, C.tel_contacto, C.nit FROM configuracion C WHERE C.id=1"));
        $this->Image('../Recursos/img/empresa/' . $datos[1], 18, 0, 22);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(0, 8, utf8_decode($datos[0]), 0, 0, 'C');
        $this->SetFont('Arial', 'B', 6);
        $this->Ln(3);
        $this->Cell(0, 8, utf8_decode('Nit '.$datos[5]), 0, 0, 'C');
        $this->Ln(3);
        $this->Cell(0, 8, utf8_decode($datos[3]), 0, 0, 'C');
        $this->Ln(3);
        $this->Cell(0, 8, utf8_decode('Celular: '.$datos[4]), 0, 0, 'C');
    }
}

class PDFTicketCocina extends FPDF
{

    function Header()
    {
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(58, 8, utf8_decode('COCINA'), 0, 0, 'C');
    }
}

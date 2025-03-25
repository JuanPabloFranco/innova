<?php

require '../Recursos/fpdf/fpdf.php';
include '../Conexion/Conexion.php';
session_start();

class PDFCarta extends FPDF {

    function Header() {
        $this->Image('../Recursos/img/banner.png', 27, -1, 190);
    }
    
    function Footer() {
       
    }
}

class PDFCartaLaboral extends FPDF {

    function Header() {
        $datos = mysqli_fetch_row(ejecutarSQL::consultar('SELECT C.logo FROM configuracion C LIMIT 1'));
        // $this->Image('../Recursos/img/membrete_naranja.png', -1, -1, 218);
        // $this->Image('../Recursos/img/empresa/'.$datos[0], 130, 20, 70);
        $this->Image('../Recursos/img/empresa/'.$datos[0], 30, 15, 55);
    }
    
    function Footer() {
        $datos = mysqli_fetch_row(ejecutarSQL::consultar('SELECT C.nombre, C.logo, C.nit, C.direccion, C.tel_contacto, C.email_carta FROM configuracion C LIMIT 1'));
        $this->Ln(50);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(185, 6, utf8_decode("Sede principal Quindipisos Cr 18 # 12 -25  Centro Teléfono 6067107857 Móvil 3153461910"), 0, 0, 'C', 0);
        $this->Ln(5);
        $this->Cell(185, 6, utf8_decode("Sede Cerámicas Quindío Cr 18 # 12 – 30  Armenia  Quindío"), 0, 0, 'C', 0);
        $this->Ln(5);
        $this->Cell(185, 6,  "email: facturacionquindipisos@gmail.com", 0, 0, 'C', 0);
        
    }
}

class PDFCartaVacaciones extends FPDF {

    function Header() {
        $datos = mysqli_fetch_row(ejecutarSQL::consultar('SELECT C.logo FROM configuracion C LIMIT 1'));
        // $this->Image('../Recursos/img/membrete_naranja.png', -1, -1, 218);
        // $this->Image('../Recursos/img/empresa/'.$datos[0], 130, 20, 70);
        $this->Image('../Recursos/img/empresa/'.$datos[0], 30, 15, 55);
    }
    
    function Footer() {
        $datos = mysqli_fetch_row(ejecutarSQL::consultar('SELECT C.nombre, C.logo, C.nit, C.direccion, C.tel_contacto, C.email_carta FROM configuracion C LIMIT 1'));
        $this->Ln(40);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(185, 6, utf8_decode("Sede principal Quindipisos Cr 18 # 12 -25  Centro Teléfono 6067107857 Móvil 3153461910"), 0, 0, 'C', 0);
        $this->Ln(5);
        $this->Cell(185, 6, utf8_decode("Sede Cerámicas Quindío Cr 18 # 12 – 30  Armenia  Quindío"), 0, 0, 'C', 0);
        $this->Ln(5);
        $this->Cell(185, 6,  "email: quindipisos@gmail.com", 0, 0, 'C', 0);
        
    }
}



?>

<?php
include_once '../Conexion/Conexion.php';
include_once '../Modelo/EnvioCorreo.php';
class envioCorreoDAO
{
    var $objetos;
    /**
     * @var PDO
     */
    private $acceso = "";
    public function __CONSTRUCT()
    {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }

    function crear(EnvioCorreo $obj)
    {
        $sql = "INSERT INTO envio_correos(tipo, destinatarios, fecha_hora)                
        values(:tipo, :destinatarios, :fecha_hora)";
        $query2 = $this->acceso->prepare($sql);
        if ($query2->execute(array(':tipo' => $obj->getTipo(), ':destinatarios' => $obj->getDestinatarios(), ':fecha_hora' => $obj->getFechaHora()))) {
            echo 'Correo Enviado a '.$obj->getDestinatarios();
        } else {
            echo 'Error al registrar el envío de correos en base de datos';
        }
    }
    function reporteNotificaciones()
    {
        $sql = "SELECT * FROM envio_correos E ORDER BY E.fecha_hora DESC";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    function estadisticasNotificaciones()
     {

          $sql = "SELECT (SELECT COUNT(C.id) FROM envio_correos C WHERE C.tipo LIKE '%Recordatorio finalizacion contrato%') AS contratos,
          (SELECT COUNT(C.id) FROM envio_correos C WHERE C.tipo LIKE '%Incapacidad Vencidao%') AS incapacidades,
          (SELECT COUNT(C.id) FROM envio_correos C WHERE C.tipo LIKE '%Solicitud aprobada por iniciar%') AS solicitudes
          FROM usuarios GROUP BY contratos, incapacidades, solicitudes";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }
}

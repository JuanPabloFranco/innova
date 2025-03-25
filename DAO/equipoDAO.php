<?php
include_once '../Conexion/Conexion.php';
include_once '../Modelo/Equipo.php';
include_once '../Modelo/EquipoMantenimiento.php';
class equipoDAO
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

    /**
     * La función "buscar" recupera datos de una tabla de base de datos llamada "equipo" en base
     * a una consulta de búsqueda y devuelve los resultados.
     * 
     * @return Equipo serie de objetos.
     */
    function listar($editar, $ver, $id_empresa)
{
    $sql = "SELECT E.*, 
                   S.nombre_sede, 
                   S.direccion, 
                   M.nombre AS municipio, 
                   D.nombre AS departamento,

                   -- Estado en formato HTML Badge
                   CASE 
                       WHEN E.estado = 1 THEN '<h1 class=\"badge badge-primary ml-1\">Activo</h1>'
                       WHEN E.estado = 2 THEN '<h1 class=\"badge badge-dark ml-1\">Inactivo</h1>'
                       WHEN E.estado = 3 THEN '<h1 class=\"badge badge-danger ml-1\">Dado de Baja</h1>'
                       ELSE ''
                   END AS estado_badge,

                   -- Ubicación completa
                   CONCAT(S.nombre_sede, ' (', M.nombre, ' - ', D.nombre, ')') AS ubicacion_completa,

                   -- Botón Editar
                   IF(:editar = 1, 
                      CONCAT('<a href=\"../Vista/equipo.php?modulo=editar_equipo&id=', E.id, '\">
                                <button class=\"btn btn-sm btn-primary mr-1\" type=\"button\" title=\"Editar\">
                                    <i class=\"fas fa-pencil-alt\"></i>
                                </button>
                              </a>'), 
                      '') AS boton_editar,

                   -- Botón PDF
                   IF(:ver = 1, 
                      CONCAT('<a href=\"../Recursos/mpdf/hc_equipo.php?id=', E.id, '\" target=\"blanck\">
                                <button class=\"btn btn-sm btn-primary mr-1\" type=\"button\" title=\"PDF\">
                                    <i><img src=\"../Recursos/img/pdf.png\" style=\"width: 25px\"></i>
                                </button>
                              </a>'), 
                      '') AS boton_pdf,

                   -- Barra de progreso con color dinámico
                   CONCAT(
                      '<div class=\"progress-group\">
                          <span class=\"progress-text\"></span>
                          <span class=\"float-right\"></span>
                          <div class=\"progress progress-sm\">
                              <div class=\"progress-bar bg-',
                              CASE 
                                  WHEN E.estado_general < 5 THEN 'danger'
                                  WHEN E.estado_general BETWEEN 5 AND 7 THEN 'primary'
                                  ELSE 'success'
                              END,
                              '\" style=\"width: ', E.estado_general * 10, '%\" title=\"', E.observaciones, '\"></div>
                          </div>
                      </div>'
                   ) AS estado_gral

            FROM equipos E 
            JOIN sedes_empresa S ON E.id_sede = S.id 
            JOIN empresas EM ON S.id_empresa = EM.id 
            LEFT JOIN municipios M ON S.id_municipio = M.id 
            JOIN departamentos D ON M.departamento_id = D.id

            WHERE S.id_empresa = :id_empresa
            ORDER BY E.tipo_equipo ASC";

    $query = $this->acceso->prepare($sql);
    $query->execute([
        ':id_empresa' => $id_empresa, 
        ':editar' => $editar, 
        ':ver' => $ver
    ]);
    $this->objetos = $query->fetchAll();
    return $this->objetos;
}


    /**
     * La función "cargar" recupera un objeto de carga de la base de datos en función de su ID.
     * 
     * @param Equipo obj El parámetro "obj" es una instancia de la clase "equipo".
     * 
     * @return Equipo serie de objetos de tipo "empresas".
     */
    function cargar(Equipo $obj)
    {
        $sql = "SELECT E.*, S.nombre_sede, S.direccion, M.nombre AS municipio, D.nombre AS departamento FROM equipos E JOIN sedes_empresa S ON E.id_sede=S.id JOIN empresas EM ON S.id_empresa=EM.id LEFT JOIN municipios M ON S.id_municipio=M.id JOIN departamentos D ON M.departamento_id=D.id WHERE E.id=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $obj->getId()));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    /**
     * La función "editar" actualiza un registro en la tabla "equipos" con las propiedades del
     * objeto Cargo proporcionado.
     * 
     * @param Equipo obj El parámetro "obj" es un objeto de la clase "Equipo". Se utiliza para pasar los
     * detalles de la carga que deben actualizarse en la base de datos. El objeto debe tener las
     * siguientes propiedades:
     */
    function editar(Equipo $obj)
    {
        $sql = "UPDATE equipos SET tipo_equipo=:tipo_equipo, ubicacion=:ubicacion, id_sede	=:id_sede, serial=:serial, referencia=:referencia, procesador=:procesador, ram=:ram, disco_duro=:disco_duro, sistema_operativo=:sistema_operativo, teclado=:teclado, mouse=:mouse, monitor=:monitor, office=:office, pad_mouse=:pad_mouse, tipo_impresora=:tipo_impresora, codigo_maquina=:codigo_maquina, persona_a_cargo=:persona_a_cargo, estado_general=:estado_general, observaciones=:observaciones WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId(), ':tipo_equipo' => $obj->getTipoEquipo(), ':ubicacion' => $obj->getUbicacion(), ':id_sede' => $obj->getIdSede(), ':serial' => $obj->getSerial(), ':referencia' => $obj->getreferencia(), ':procesador' => $obj->getProcesador(), ':ram' => $obj->getRam(), ':disco_duro' => $obj->getDiscoDuro(), ':sistema_operativo' => $obj->getSistemaOperativo(), ':teclado' =>$obj->getTeclado(), ':mouse' => $obj->getMouse(), ':monitor' => $obj->getMonitor(), ':office' => $obj->getOffice(), ':pad_mouse' => $obj->getPadMouse(), ':tipo_impresora' => $obj->getTipoImpresora(), ':codigo_maquina' => $obj->getCodigoMaquina(), ':persona_a_cargo' => $obj->getPersonaACargo(), ':estado_general' => $obj->getEstadoGeneral(), ':observaciones' => $obj->getObservaciones()))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * La función "crear" inserta un nuevo registro en la tabla "equipos" con las propiedades del
     * objeto Empresa proporcionado.
     * 
     * @param Equipo obj El parámetro `` es un objeto de la clase `Equipo`. Se utiliza para pasar los
     * valores de las propiedades de la sede) a la función `crear`. Estos valores
     */
    function crear(Equipo $obj)
    {
        $sql = "INSERT INTO equipos(tipo_equipo, ubicacion, id_sede, estado_general, estado) 
        VALUES (:tipo_equipo, :ubicacion, :id_sede, :estado_general, :estado)";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':tipo_equipo' => $obj->getTipoEquipo(), ':ubicacion' => $obj->getUbicacion(), ':estado_general' => $obj->getEstadoGeneral(), ':estado' => $obj->getEstado(), ':id_sede' => $obj->getIdSede()))) {
            return $this->acceso->lastInsertId();
        } else {
            return false;
        }
    }

    /**
     * La función "cambiar_estado" actualiza el estado de un objeto Sede en la base de datos.
     * 
     * @param Sede obj El parámetro "obj" es un objeto de la clase "Equipo".
     */
    function cambiar_estado(Equipo $obj)
    {
        $sql = "UPDATE equipos SET estado=:estado WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId(), ':estado' => $obj->getEstado()))) {
            return true;
        } else {
            return false;
        }
    }

    // Mantenimiento de equipos

    /**
     * La función "crear" inserta un nuevo registro en la tabla "equipo_mantenimiento" con las propiedades del
     * objeto Empresa proporcionado.
     * 
     * @param Sedes obj El parámetro `` es un objeto de la clase `Sedes`. Se utiliza para pasar los
     * valores de las propiedades de la sede) a la función `crear`. Estos valores
     */
    function crear_mantenimiento(EquipoMantenimiento $obj)
    {
        $sql = "INSERT INTO equipo_mantenimiento(fecha, tipo, descripcion, realizado_por, observaciones, id_equipo) 
        VALUES (:fecha, :tipo, :descripcion, :realizado_por, :observaciones, :id_equipo)";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':fecha' => $obj->getFecha(), ':tipo' => $obj->getTipo(), ':realizado_por' => $obj->getRealizadoPor(), ':descripcion' => $obj->getDescripcion(), ':observaciones' => $obj->getObservaciones(), ':id_equipo' => $obj->getIdEquipo()))) { 
            return true;
        } else {
            return false;
        }
    }

    /**
     * La función "editar" actualiza un registro en la tabla "sedes_empresa" con las propiedades del
     * objeto Cargo proporcionado.
     * 
     * @param Sedes obj El parámetro "obj" es un objeto de la clase "Sedes". Se utiliza para pasar los
     * detalles de la carga que deben actualizarse en la base de datos. El objeto debe tener las
     * siguientes propiedades:
     */
    function editar_mantenimiento(EquipoMantenimiento $obj)
    {
        $sql = "UPDATE sedes_empresa SET fecha=:fecha, tipo=:tipo, descripcion=:descripcion, realizado_por=:realizado_por, observaciones=:observaciones WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId(), ':fecha' => $obj->getFecha(), ':tipo' => $obj->getTipo(),  ':descripcion' => $obj->getDescripcion(), ':realizado_por' => $obj->getRealizadoPor(), ':observaciones' => $obj->getObservaciones()))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * La función "buscar" recupera datos de una tabla de base de datos llamada "equipo_mantenimiento" en base
     * a una consulta de búsqueda y devuelve los resultados.
     * 
     * @return EquipoMantenimiento serie de objetos.
     */
    function listar_mantenimientos($editar, $ver, EquipoMantenimiento $obj)
    {
        $sql = "SELECT 
                    M.id, M.fecha, M.tipo, M.descripcion, M.realizado_por, M.observaciones, M.id_equipo, T.nombre_tipo,
                    IF($editar=1,CONCAT('<button class=\'edit btn btn-sm btn-primary mr-1\' id=\'',M.id ,'\' type=\'button\' title\'Editar\' data-bs-target=\'#editar_mantenimiento\' data-bs-toggle=\'modal\'>
                                                                    <i class=\'fas fa-pencil-alt\'></i>
                                                                </button>'
                    ),'N/A') AS boton,
                    CONCAT('<button class=\'detalle_mantenimiento btn btn-sm btn-info mr-1\' id=\'',M.id ,'\' type=\'button\' title\'Detalle\' data-bs-target=\'#ver_mantenimiento\' data-bs-toggle=\'modal\'>
                                                                    <i class=\'fas fa-eye\'></i>
                                                                </button>'
                    ) AS boton_detalle
                FROM 
                    equipo_mantenimiento M JOIN equipos E ON M.id_equipo=E.id JOIN tipo_mantenimiento T ON M.tipo=T.id
                WHERE M.id_equipo=:id_equipo
                ORDER BY 
                    M.fecha DESC;";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_equipo' => $obj->getIdEquipo()));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    /**
     * La función "cargar" recupera un objeto de carga de la base de datos en función de su ID.
     * 
     * @param EquipoMantenimiento obj El parámetro "obj" es una instancia de la clase "equipo_mantenimiento".
     * 
     * @return EquipoMantenimiento serie de objetos de tipo "empresas".
     */
    function cargar_mantenimiento(EquipoMantenimiento $obj)
    {
        $sql = "SELECT M.*, T.nombre_tipo  FROM equipo_mantenimiento M JOIN tipo_mantenimiento T ON M.tipo=T.id WHERE M.id=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $obj->getId()));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }
}

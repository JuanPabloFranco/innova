<?php
include_once '../Conexion/Conexion.php';
include_once '../Modelo/Empresa.php';
include_once '../Modelo/Sedes.php';
class empresaDAO
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
     * La función "buscar" recupera datos de una tabla de base de datos llamada "empresas" en base
     * a una consulta de búsqueda y devuelve los resultados.
     * 
     * @return una serie de objetos.
     */
    function listar($editar, $ver)
    {
        $sql = "SELECT 
                    E.id, E.estado AS estado_valor, E.nombre, CONCAT(E.direccion,' ',M.nombre,' (',D.nombre,')') AS direccion, E.telefono, E.email, E.id_municipio, 
                    IF(E.estado=1, '<h1 class=\'badge badge-primary ml-1\'>Activo</h1>',
                        '<h1 class=\'badge badge-dark ml-1\'>Inactivo</h1>'
                    ) AS estado,
                    IF((1=1),
                        CONCAT('<a href=\'../Vista/editar_empresa.php?modulo=empresas&id=', E.id, '\'><button class=\'btn btn-sm btn-primary mr-1\' type=\'button\' title=\'Editar\'><i class=\'fas fa-pencil-alt\'></i></button></a>'),
                        ''
                    ) AS boton,
                    CONCAT('<img src=\'../Recursos/img/empresas/',E.logo,'\' style=\'width: 35px\'>') AS logo
                FROM 
                    empresas E JOIN municipios M ON E.id_municipio = M.id JOIN departamentos D ON M.departamento_id=D.id
                ORDER BY 
                    E.estado ASC;";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    /**
     * La función "cargar" recupera un objeto de carga de la base de datos en función de su ID.
     * 
     * @param Empresa obj El parámetro "obj" es una instancia de la clase "empresas".
     * 
     * @return una serie de objetos de tipo "empresas".
     */
    function cargar(Empresa $obj)
    {
        $sql = "SELECT S.*, M.nombre AS municipio, D.nombre AS departamento FROM empresas S JOIN municipios M ON S.id_municipio=M.id JOIN departamentos D ON M.departamento_id=D.id WHERE S.id=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $obj->getId()));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    /**
     * La función "editar" actualiza un registro en la tabla "empresas" con las propiedades del
     * objeto Cargo proporcionado.
     * 
     * @param Empresa obj El parámetro "obj" es un objeto de la clase "Empresa". Se utiliza para pasar los
     * detalles de la carga que deben actualizarse en la base de datos. El objeto debe tener las
     * siguientes propiedades:
     */
    function editar(Empresa $obj)
    {
        $sql = "UPDATE empresas SET nombre=:nombre, direccion=:direccion, telefono	=:telefono, id_municipio=:id_municipio, estado=:estado, email=:email WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId(), ':nombre' => $obj->getNombre(), ':direccion' => $obj->getDireccion(), ':telefono' => $obj->getTelefono(), ':id_municipio' => $obj->getIdMunicipio(), ':estado' => $obj->getEstado(), ':email' => $obj->getEmail()))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * La función "crear" inserta un nuevo registro en la tabla "empresas" con las propiedades del
     * objeto Empresa proporcionado.
     * 
     * @param Empresa obj El parámetro `` es un objeto de la clase `Empresa`. Se utiliza para pasar los
     * valores de las propiedades de la sede) a la función `crear`. Estos valores
     */
    function crear(Empresa $obj)
    {
        $sql = "INSERT INTO empresas(nombre, direccion, estado, telefono, id_municipio, email, logo) 
        VALUES (:nombre, :direccion, :estado, :telefono, :id_municipio, :email, :logo)";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':nombre' => $obj->getNombre(), ':direccion' => $obj->getDireccion(), ':telefono' => $obj->getTelefono(), ':id_municipio' => $obj->getIdMunicipio(), ':estado' => $obj->getEstado(), ':email' => $obj->getEmail(),':logo' => $obj->getLogo()))) {
            return $this->acceso->lastInsertId();
        } else {
            return false;
        }
    }

    /**
     * La función "cambiar_estado" actualiza el estado de un objeto Sede en la base de datos.
     * 
     * @param Sede obj El parámetro "obj" es un objeto de la clase "Sede".
     */
    function cambiar_estado(Empresa $obj)
    {
        $sql = "UPDATE empresas SET estado=:estado WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId(), ':estado' => $obj->getEstado()))) {
            return true;
        } else {
            return false;
        }
    }

    // Sedes

    /**
     * La función "crear" inserta un nuevo registro en la tabla "sedes_empresa" con las propiedades del
     * objeto Empresa proporcionado.
     * 
     * @param Sedes obj El parámetro `` es un objeto de la clase `Sedes`. Se utiliza para pasar los
     * valores de las propiedades de la sede) a la función `crear`. Estos valores
     */
    function crear_sede(Sedes $obj)
    {
        $sql = "INSERT INTO sedes_empresa(id_empresa, direccion, nombre_sede, id_municipio) 
        VALUES (:id_empresa, :direccion, :nombre_sede, :id_municipio)";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id_empresa' => $obj->getIdEmpresa(), ':direccion' => $obj->getDireccion(), ':id_municipio' => $obj->getIdMunicipio(), ':nombre_sede' => $obj->getNombre()))) {
            return $this->acceso->lastInsertId();
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
    function editar_sede(Sedes $obj)
    {
        $sql = "UPDATE sedes_empresa SET nombre_sede=:nombre_sede, direccion=:direccion, id_municipio=:id_municipio WHERE id=:id";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':id' => $obj->getId(), ':nombre_sede' => $obj->getNombre(), ':direccion' => $obj->getDireccion(),  ':id_municipio' => $obj->getIdMunicipio()))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * La función "buscar" recupera datos de una tabla de base de datos llamada "empresas" en base
     * a una consulta de búsqueda y devuelve los resultados.
     * 
     * @return una serie de objetos.
     */
    function listar_sedes($editar, $ver, Sedes $obj)
    {
        $sql = "SELECT 
                    E.id, E.nombre_sede, CONCAT(E.direccion,' ',M.nombre,' (',D.nombre,')') AS direccion, E.id_municipio, 
                    CONCAT('<button class=\'edit btn btn-sm btn-primary mr-1\' id=\'',E.id ,'\' type=\'button\' title\'Editar\' data-bs-target=\'#editar_sede\' data-bs-toggle=\'modal\'>
                                                                    <i class=\'fas fa-pencil-alt\'></i>
                                                                </button>'
                    ) AS boton  
                FROM 
                    sedes_empresa E JOIN municipios M ON E.id_municipio = M.id JOIN departamentos D ON M.departamento_id=D.id JOIN empresas S ON E.id_empresa=S.id
                WHERE E.id_empresa=:id_empresa
                ORDER BY 
                    E.nombre_sede ASC;";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_empresa' => $obj->getIdEmpresa()));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    /**
     * La función "cargar" recupera un objeto de carga de la base de datos en función de su ID.
     * 
     * @param Sedes obj El parámetro "obj" es una instancia de la clase "empresas".
     * 
     * @return una serie de objetos de tipo "empresas".
     */
    function cargar_sede(Sedes $obj)
    {
        $sql = "SELECT S.*, M.nombre AS municipio, D.nombre AS departamento FROM sedes_empresa S JOIN municipios M ON S.id_municipio=M.id JOIN departamentos D ON M.departamento_id=D.id WHERE S.id=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $obj->getId()));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }
}

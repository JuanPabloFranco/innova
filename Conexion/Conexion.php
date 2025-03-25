<?php

class Conexion{
    private $servidor = "localhost";
    private $db = "innova";
    private $puerto = "3306";
    private $charset = "utf8";
    private $user = "root";
    private $pass = "";

    private $atributos = [PDO::ATTR_CASE=>PDO::CASE_LOWER,
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_ORACLE_NULLS=>PDO::NULL_EMPTY_STRING,
    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ];
    public $pdo = null;

    function __CONSTRUCT(){
        $this->pdo = new PDO("mysql:dbname={$this->db};host={$this->servidor};port={$this->puerto};charset={$this->charset}",$this->user,$this->pass,$this->atributos);
    }
}

/* Clase para ejecutar las consultas a la Base de Datos */

class ejecutarSQL {

    // Conexion a la BD
    public static function conectar() {
        $host = "localhost";
        $user = "root";
        $bd = "innova";
        $pass = "";

        if (!$con = mysqli_connect($host, $user, $pass, $bd)) {
            die(mysqli_error(ejecutarSQL::conectar()) . "Error en el servidor, verifique sus datos");
        }
        mysqli_set_charset($con, 'utf8');        
        return $con;
        mysqli_close($con);
    }

    public static function consultar($query) { // Funcion para ejecutar una consulta
        if (!$consul = mysqli_query(ejecutarSQL::conectar(), $query)) {
            die(mysqli_error(ejecutarSQL::conectar()) . 'Error en la consulta SQL ejecutada '.$query);
        }        
        return $consul;        
    }
}

/* Clase para hacer las consultas Insertar, Eliminar y Actualizar */

class consultasSQL {

    public static function InsertSQL($tabla, $campos, $valores) {
        if (!$consul = ejecutarSQL::consultar("insert into $tabla ($campos) VALUES($valores)")) {
            die("Ha ocurrido un error al insertar los datos en la tabla $tabla");
        }
        return $consul;
    }

    public static function DeleteSQL($tabla, $condicion) {
        if (!$consul = ejecutarSQL::consultar("DELETE FROM $tabla WHERE $condicion")) {
            die("Ha ocurrido un error al eliminar los registros en la tabla $tabla");
        }
        return $consul;
    }

    public static function UpdateSQL($tabla, $campos, $condicion) {
        if (!$consul = ejecutarSQL::consultar("UPDATE $tabla SET $campos WHERE $condicion")) {
            die("Ha ocurrido un error al actualizar los datos en la tabla $tabla");
        }
        return $consul;
    }

}

?>
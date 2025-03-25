<?php
include_once '../Conexion/Conexion.php';
class configuracionDAO
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
     * La función "cargarInformacion" recupera todas las filas de la tabla "configuración" en una base
     * de datos.
     * 
     * @return una matriz de objetos que contienen la información obtenida de la tabla de
     * "configuración" en la base de datos.
     */
    function cargarInformacion()
    {
        $sql = "SELECT * FROM configuracion";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    /**
     * La función `guardarDatosBasicos` actualiza los datos de configuración en una tabla de base de
     * datos.
     * 
     * @param Configuracion obj El parámetro `` es una instancia de la clase `Configuración`. Se
     * utiliza para pasar los valores que deben actualizarse en la tabla `configuración`. La clase
     * `Configuración` probablemente tenga métodos getter (`getNombre()`, `getDireccion()`, etc.) para
     * recuperar
     */
    function guardarDatosBasicos(Configuracion $obj)
    {
        $sql = "UPDATE configuracion SET nombre=:nombre, url_back=:url_back, url_front=:url_front, hosting=:hosting, nit=:nit, email_carta=:email_carta, direccion=:direccion, tel_contacto=:tel_contacto WHERE id=1";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':nombre' => $obj->getNombre(), ':url_back' => $obj->getUrlBack(), ':url_front' => $obj->getUrlFront(), ':hosting' => $obj->getHosting(), ':nit' => $obj->getNit(), ':email_carta' => $obj->getEmailCarta(), ':direccion' => $obj->getDireccion(), ':tel_contacto' => $obj->getTelContacto()))) {
            echo 'update';
        }
    }

    /**
     * La función "guardarDatosEmail" actualiza los ajustes de configuración del correo electrónico en
     * una tabla de base de datos.
     * 
     * @param Configuracion obj El parámetro `` es un objeto de la clase `Configuracion`. Se
     * utiliza para pasar los valores de las propiedades driver, cifrado, host, port, email y
     * pass_email a la función. Estos valores luego se utilizan para actualizar los campos
     * correspondientes en la tabla `configuración`
     * 
     * @return una serie de objetos.
     */
    function guardarDatosEmail(Configuracion $obj)
    {
        $sql = "UPDATE configuracion SET driver=:driver,cifrado=:cifrado,host=:host,port=:port,email=:email,pass_email=:pass_email";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':driver' => $obj->getDriver(), ':cifrado' => $obj->getCifrado(), ':host' => $obj->getHost(), ':port' => $obj->getPort(), ':email' => $obj->getEmail(), ':pass_email' => $obj->getPassEmail()));
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }

    /**
     * La función "guardarLogo" actualiza el campo "logo" en la tabla "configuracion" con el valor
     * proporcionado por el objeto "Configuracion".
     * 
     * @param Configuracion obj El parámetro "obj" es una instancia de la clase "Configuración".
     */
    function guardarLogo(Configuracion $obj)
    {
        $sql = "UPDATE configuracion SET logo=:logo WHERE id=1";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':logo' => $obj->getLogo()));
    }

    /**
     * La función "guardarLogo" actualiza el campo "logo_blanco" en la tabla "configuracion" con el valor
     * proporcionado por el objeto "Configuracion".
     * 
     * @param Configuracion obj El parámetro "obj" es una instancia de la clase "Configuración".
     */
    function guardarLogoBlanco(Configuracion $obj)
    {
        $sql = "UPDATE configuracion SET logo_blanco=:logo_blanco WHERE id=1";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':logo_blanco' => $obj->getLogoBlanco()));
    }

    /**
     * La función `guardarfaticon` actualiza el campo `faticon` en la tabla `configuracion` con el
     * valor del objeto `Configuracion`.
     * 
     * @param Configuracion obj El parámetro "obj" es una instancia de la clase "Configuración".
     */
    function guardarfaticon(Configuracion $obj)
    {
        $sql = "UPDATE configuracion SET faticon=:faticon";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':faticon' => $obj->getFavicon()))) {
            echo 'update';
        } else {
            echo 'Error al actualizar la información';
        }
    }

    /**
     * La función `guardarImgLogin` actualiza el campo `img_login` en la tabla `configuracion` con el
     * valor de inicio de sesión de imagen proporcionado.
     * 
     * @param Configuracion obj El parámetro "obj" es una instancia de la clase "Configuración".
     */
    function guardarImgLogin(Configuracion $obj)
    {
        $sql = "UPDATE configuracion SET img_login=:img_login";
        $query = $this->acceso->prepare($sql);
        if ($query->execute(array(':img_login' => $obj->getImgLogin()))) {
            echo 'update';
        } else {
            echo 'Error al actualizar la información';
        }
    }

    /**
     * La función "eliminarLogo" actualiza el campo "logo" en la tabla "configuración" a nulo.
     */
    function eliminarLogo()
    {
        $sql = "UPDATE configuracion SET logo=null";
        $query = $this->acceso->prepare($sql);
        if ($query->execute()) {
            echo 'update';
        } else {
            echo 'Error al actualizar la información';
        }
    }

    /**
     * La función "eliminarLogo" actualiza el campo "logo" en la tabla "configuración" a nulo.
     */
    function eliminarLogoBlanco()
    {
        $sql = "UPDATE configuracion SET logo_blanco=null";
        $query = $this->acceso->prepare($sql);
        if ($query->execute()) {
            echo 'update';
        } else {
            echo 'Error al actualizar la información';
        }
    }

    /**
     * La función "eliminarFaticon" actualiza el campo "faticon" en la tabla "configuracion" a nulo.
     */
    function eliminarFaticon()
    {
        $sql = "UPDATE configuracion SET faticon=null";
        $query = $this->acceso->prepare($sql);
        if ($query->execute()) {
            echo 'update';
        } else {
            echo 'Error al actualizar la información';
        }
    }

    /**
     * La función "eliminarImgLogin" actualiza el campo "img_login" en la tabla "configuracion" a nulo.
     */
    function eliminarImgLogin()
    {
        $sql = "UPDATE configuracion SET img_login=null";
        $query = $this->acceso->prepare($sql);
        if ($query->execute()) {
            echo 'update';
        } else {
            echo 'Error al actualizar la información';
        }
    }

    function vencimientoHosting()
    {
        $sql = "SELECT C.hosting FROM configuracion C WHERE 
                    C.hosting BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 40 DAY);";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchall();
        return $this->objetos;
    }
}

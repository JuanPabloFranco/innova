<?php
class Configuracion
{
    private $id;
    private $logo;
    private $logo_blanco;
    private $nombre;
    private $faticon;
    private $img_login;
    private $driver;
    private $cifrado;
    private $host;
    private $port;
    private $email;
    private $pass_email;
    private $direccion;
    private $tel_contacto;
    private $facebook;
    private $instagram;
    private $youtube;
    private $tiktok;
    private $google_analitycs;
    private $url_back;
    private $url_front;
    private $nit;
    private $slogan;
    private $horario;
    private $mapa;
    private $rut;
    private $servicio;
    private $hosting;
    private $impresora;
    private $email_carta;

    public function __CONSTRUCT() {}

    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function getNombre()
    {
        return $this->nombre;
    }

    function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    function getLogo()
    {
        return $this->logo;
    }

    function setLogo($logo)
    {
        $this->logo = $logo;
    }

    function getFavicon()
    {
        return $this->faticon;
    }

    function setFavicon($faticon)
    {
        $this->faticon = $faticon;
    }

    function getImgLogin()
    {
        return $this->img_login;
    }

    function setImgLogin($img_login)
    {
        $this->img_login = $img_login;
    }

    function getDriver()
    {
        return $this->driver;
    }

    function setDriver($driver)
    {
        $this->driver = $driver;
    }

    function getCifrado()
    {
        return $this->cifrado;
    }

    function setCifrado($cifrado)
    {
        $this->cifrado = $cifrado;
    }

    function getHost()
    {
        return $this->host;
    }

    function setHost($host)
    {
        $this->host = $host;
    }

    function getPort()
    {
        return $this->port;
    }

    function setPort($port)
    {
        $this->port = $port;
    }

    function getEmail()
    {
        return $this->email;
    }

    function setEmail($email)
    {
        $this->email = $email;
    }

    function getPassEmail()
    {
        return $this->pass_email;
    }

    function setPassEmail($pass_email)
    {
        $this->pass_email = $pass_email;
    }

    function getDireccion()
    {
        return $this->direccion;
    }

    function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    function getTelContacto()
    {
        return $this->tel_contacto;
    }

    function setTelContacto($tel_contacto)
    {
        $this->tel_contacto = $tel_contacto;
    }

    function getFacebook()
    {
        return $this->facebook;
    }

    function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }

    function getInstagram()
    {
        return $this->instagram;
    }

    function setInstagram($instagram)
    {
        $this->instagram = $instagram;
    }

    function getYoutube()
    {
        return $this->youtube;
    }

    function setYoutube($youtube)
    {
        $this->youtube = $youtube;
    }

    function getTiktok()
    {
        return $this->tiktok;
    }

    function setTiktok($tiktok)
    {
        $this->tiktok = $tiktok;
    }

    function getGoogleAnalitycs()
    {
        return $this->google_analitycs;
    }

    function setGoogleAnalitycs($google_analitycs)
    {
        $this->google_analitycs = $google_analitycs;
    }

    function getUrlBack()
    {
        return $this->url_back;
    }

    function setUrlBack($url_back)
    {
        $this->url_back = $url_back;
    }

    function getUrlFront()
    {
        return $this->url_front;
    }

    function setUrlFront($url_front)
    {
        $this->url_front = $url_front;
    }

    function getLogoBlanco()
    {
        return $this->logo_blanco;
    }

    function setLogoBlanco($logo_blanco)
    {
        $this->logo_blanco = $logo_blanco;
    }

    function getNit()
    {
        return $this->nit;
    }

    function setNit($nit)
    {
        $this->nit = $nit;
    }

    function getSlogan()
    {
        return $this->slogan;
    }

    function setSlogan($slogan)
    {
        $this->slogan = $slogan;
    }

    function getHorario()
    {
        return $this->horario;
    }

    function setHorario($horario)
    {
        $this->horario = $horario;
    }

    function getMapa()
    {
        return $this->mapa;
    }

    function setMapa($mapa)
    {
        $this->mapa = $mapa;
    }

    function getRut()
    {
        return $this->rut;
    }

    function setRut($rut)
    {
        $this->rut = $rut;
    }

    function getServicio()
    {
        return $this->servicio;
    }

    function setServicio($servicio)
    {
        $this->servicio = $servicio;
    }

    function getHosting()
    {
        return $this->hosting;
    }

    function setHosting($hosting)
    {
        $this->hosting = $hosting;
    }
    function getImpresora()
    {
        return $this->impresora;
    }

    function setImpresora($impresora)
    {
        $this->impresora = $impresora;
    }

    function getEmailCarta()
    {
        return $this->email_carta;
    }

    function setEmailCarta($email_carta)
    {
        $this->email_carta = $email_carta;
    }
}

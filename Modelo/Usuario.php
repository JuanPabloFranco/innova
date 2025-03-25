<?php
class Usuario
{
     private $id;
     private $estado;
     private $id_cargo;
     private $id_empresa;
     private $id_tipo_usuario;
     private $nombre_completo;
     private $doc_id;
     private $direccion;
     private $telefono;
     private $fecha_nacimiento;
     private $genero;
     private $avatar;
     private $usuario_login;
     private $pass_login;
     private $email;
     private $fecha_creacion;
     private $ciudad_residencia;
     private $facebook;
     private $instagram;
     private $youtube;
     private $tiktok;
     private $inf_usuario;
     private $firma_digital;
     private $menu;
     private $calendar;
     //Salud
     private $contacto_emergencia;
     private $parentezco_contacto;
     private $telefono_contacto;
     private $eps;
     private $tipo_sangre;


     //academico - laboral
     private $nivel_academico;
     private $profesion;
     private $experiencia;
     private $fondo;
     private $cesantias;

     //Familiar
     private $nombre_madre;
     private $telefono_madre;
     private $nombre_padre;
     private $telefono_padre;

     //Sociodemografica
     private $estrato;
     private $estado_civil;
     private $grupo_etnico;
     private $personas_cargo;
     private $cabeza_familia;
     private $hijos;
     private $fuma;
     private $fuma_frecuencia;
     private $bebidas;
     private $bebidas_frecuencia;
     private $deporte;
     private $talla_camisa;
     private $talla_pantalon;
     private $talla_calzado;
     private $tipo_vivienda;
     private $licencia_conduccion;
     private $licencia_descr;
     private $act_tiempo_libre;

     public function __CONSTRUCT() {}

     function getId()
     {
          return $this->id;
     }

     function setId($id)
     {
          $this->id = $id;
     }

     function getEstado()
     {
          return $this->estado;
     }

     function setEstado($estado)
     {
          $this->estado = $estado;
     }

     function getIdCargo()
     {
          return $this->id_cargo;
     }

     function setIdCargo($id_cargo)
     {
          $this->id_cargo = $id_cargo;
     }

     function getIdTipoUsuario()
     {
          return $this->id_tipo_usuario;
     }

     function setIdTipoUsuario($id_tipo_usuario)
     {
          $this->id_tipo_usuario = $id_tipo_usuario;
     }

     function getNombreCompleto()
     {
          return $this->nombre_completo;
     }

     function setNombreCompleto($nombre_completo)
     {
          $this->nombre_completo = $nombre_completo;
     }

     function getDocId()
     {
          return $this->doc_id;
     }

     function setDocId($doc_id)
     {
          $this->doc_id = $doc_id;
     }

     function getDireccion()
     {
          return $this->direccion;
     }

     function setDireccion($direccion)
     {
          $this->direccion = $direccion;
     }

     function getTelefono()
     {
          return $this->telefono;
     }

     function setTelefono($telefono)
     {
          $this->telefono = $telefono;
     }

     function getFechaNacimiento()
     {
          return $this->fecha_nacimiento;
     }

     function setFechaNacimiento($fecha_nacimiento)
     {
          $this->fecha_nacimiento = $fecha_nacimiento;
     }

     function getGenero()
     {
          return $this->genero;
     }

     function setGenero($genero)
     {
          $this->genero = $genero;
     }

     function getAvatar()
     {
          return $this->avatar;
     }

     function setAvatar($avatar)
     {
          $this->avatar = $avatar;
     }

     function getUsuarioLogin()
     {
          return $this->usuario_login;
     }

     function setUsuarioLogin($usuario_login)
     {
          $this->usuario_login = $usuario_login;
     }

     function getPassLogin()
     {
          return $this->pass_login;
     }

     function setPassLogin($pass_login)
     {
          $this->pass_login = $pass_login;
     }

     function getEmail()
     {
          return $this->email;
     }

     function setEmail($email)
     {
          $this->email = $email;
     }

     function getFechaCreacion()
     {
          return $this->fecha_creacion;
     }

     function setFechaCreacion($fecha_creacion)
     {
          $this->fecha_creacion = $fecha_creacion;
     }

     function getCiudadResidencia()
     {
          return $this->ciudad_residencia;
     }

     function setCiudadResidencia($ciudad_residencia)
     {
          $this->ciudad_residencia = $ciudad_residencia;
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

     function getInfUsuario()
     {
          return $this->inf_usuario;
     }

     function setInfUsuario($inf_usuario)
     {
          $this->inf_usuario = $inf_usuario;
     }

     function getFirmaDigital()
     {
          return $this->firma_digital;
     }

     function setFirmaDigital($firma_digital)
     {
          $this->firma_digital = $firma_digital;
     }

     function getMenu()
     {
          return $this->menu;
     }

     function setMenu($menu)
     {
          $this->menu = $menu;
     }

     function getCalendar()
     {
          return $this->calendar;
     }

     function setCalendar($calendar)
     {
          $this->calendar = $calendar;
     }

     function getContactoEmergencia()
     {
          return $this->contacto_emergencia;
     }

     function setContactoEmergencia($contacto_emergencia)
     {
          $this->contacto_emergencia = $contacto_emergencia;
     }

     function getParentezcoContacto()
     {
          return $this->parentezco_contacto;
     }

     function setParentezcoContacto($parentezco_contacto)
     {
          $this->parentezco_contacto = $parentezco_contacto;
     }

     function getTelefonoContacto()
     {
          return $this->telefono_contacto;
     }

     function setTelefonoContacto($telefono_contacto)
     {
          $this->telefono_contacto = $telefono_contacto;
     }

     function getEps()
     {
          return $this->eps;
     }

     function setEps($eps)
     {
          $this->eps = $eps;
     }

     function getTipoSangre()
     {
          return $this->tipo_sangre;
     }

     function setTipoSangre($tipo_sangre)
     {
          $this->tipo_sangre = $tipo_sangre;
     }

     function getNivelAcademico()
     {
          return $this->nivel_academico;
     }

     function setNivelAcademico($nivel_academico)
     {
          $this->nivel_academico = $nivel_academico;
     }

     function getProfesion()
     {
          return $this->profesion;
     }

     function setProfesion($profesion)
     {
          $this->profesion = $profesion;
     }

     function getExperiencia()
     {
          return $this->experiencia;
     }

     function setExperiencia($experiencia)
     {
          $this->experiencia = $experiencia;
     }

     function getFondo()
     {
          return $this->fondo;
     }

     function setFondo($fondo)
     {
          $this->fondo = $fondo;
     }

     function getCesantias()
     {
          return $this->cesantias;
     }

     function setCesantias($cesantias)
     {
          $this->cesantias = $cesantias;
     }

     function getNombreMadre()
     {
          return $this->nombre_madre;
     }

     function setNombreMadre($nombre_madre)
     {
          $this->nombre_madre = $nombre_madre;
     }

     function getTelefonoMadre()
     {
          return $this->telefono_madre;
     }

     function setTelefonoMadre($telefono_madre)
     {
          $this->telefono_madre = $telefono_madre;
     }

     function getNombrePadre()
     {
          return $this->nombre_padre;
     }

     function setNombrePadre($nombre_padre)
     {
          $this->nombre_padre = $nombre_padre;
     }

     function getTelefonoPadre()
     {
          return $this->telefono_padre;
     }

     function setTelefonoPadre($telefono_padre)
     {
          $this->telefono_padre = $telefono_padre;
     }

     function getEstrato()
     {
          return $this->estrato;
     }

     function setEstrato($estrato)
     {
          $this->estrato = $estrato;
     }

     function getEstadoCivil()
     {
          return $this->estado_civil;
     }

     function setEstadoCivil($estado_civil)
     {
          $this->estado_civil = $estado_civil;
     }

     function getGrupoEtnico()
     {
          return $this->grupo_etnico;
     }

     function setGrupoEtnico($grupo_etnico)
     {
          $this->grupo_etnico = $grupo_etnico;
     }

     function getPersonasCargo()
     {
          return $this->personas_cargo;
     }

     function setPersonasCargo($personas_cargo)
     {
          $this->personas_cargo = $personas_cargo;
     }

     function getCabezaFamilia()
     {
          return $this->cabeza_familia;
     }

     function setCabezaFamilia($cabeza_familia)
     {
          $this->cabeza_familia = $cabeza_familia;
     }

     function getHijos()
     {
          return $this->hijos;
     }

     function setHijos($hijos)
     {
          $this->hijos = $hijos;
     }

     function getFuma()
     {
          return $this->fuma;
     }

     function setFuma($fuma)
     {
          $this->fuma = $fuma;
     }

     function getFumaFrecuencia()
     {
          return $this->fuma_frecuencia;
     }

     function setFumaFrecuencia($fuma_frecuencia)
     {
          $this->fuma_frecuencia = $fuma_frecuencia;
     }

     function getBebidas()
     {
          return $this->bebidas;
     }

     function setBebidas($bebidas)
     {
          $this->bebidas = $bebidas;
     }

     function getBebidasFrecuencia()
     {
          return $this->bebidas_frecuencia;
     }

     function setBebidasFrecuencia($bebidas_frecuencia)
     {
          $this->bebidas_frecuencia = $bebidas_frecuencia;
     }

     function getTallaCamisa()
     {
          return $this->talla_camisa;
     }

     function setTallaCamisa($talla_camisa)
     {
          $this->talla_camisa = $talla_camisa;
     }

     function getTallaPantalon()
     {
          return $this->talla_pantalon;
     }

     function setTallaPantalon($talla_pantalon)
     {
          $this->talla_pantalon = $talla_pantalon;
     }

     function getTallaCalzado()
     {
          return $this->talla_calzado;
     }

     function setTallaCalzado($talla_calzado)
     {
          $this->talla_calzado = $talla_calzado;
     }

     function getDeporte()
     {
          return $this->deporte;
     }

     function setDeporte($deporte)
     {
          $this->deporte = $deporte;
     }

     function getTipoVivienda()
     {
          return $this->tipo_vivienda;
     }

     function setTipoVivienda($tipo_vivienda)
     {
          $this->tipo_vivienda = $tipo_vivienda;
     }

     function getLicenciaConduccion()
     {
          return $this->licencia_conduccion;
     }

     function setLicenciaConduccion($licencia_conduccion)
     {
          $this->licencia_conduccion = $licencia_conduccion;
     }

     function getDescripcionLicencia()
     {
          return $this->licencia_descr;
     }

     function setDescripcionLicencia($licencia_descr)
     {
          $this->licencia_descr = $licencia_descr;
     }

     function getActTiempoLibre()
     {
          return $this->act_tiempo_libre;
     }

     function setActTiempoLibre($act_tiempo_libre)
     {
          $this->act_tiempo_libre = $act_tiempo_libre;
     }

     function getIdEmpresa()
     {
          return $this->id_empresa;
     }

     function setIdEmpresa($id_empresa)
     {
          $this->id_empresa = $id_empresa;
     }
}

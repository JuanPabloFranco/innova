<?php
include_once '../Conexion/Conexion.php';
include_once '../Modelo/Usuario.php';
include_once '../Modelo/PersonaCargo.php';
include_once '../Modelo/Medicamento.php';
include_once '../Modelo/Enfermedad.php';
include_once '../Modelo/Alergia.php';
include_once '../Modelo/Cirugia.php';
include_once '../Modelo/Lesion.php';
include_once '../Modelo/Antecedente.php';
include_once '../Modelo/Estudio.php';
include_once '../Modelo/Curso.php';
class UsuarioDAO
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

     function loguearse(Usuario $obj)
     {
          $sql = "SELECT U.id, U.nombre_completo, T.nombre_tipo, U.id_tipo_usuario, U.id_cargo, U.usuario_login, U.estado, C.nombre_cargo, T.estado AS estado_tipo_usuario, C.estado AS estado_cargo, U.id_empresa FROM usuarios U JOIN tipo_usuarios T ON U.id_tipo_usuario=T.id LEFT JOIN cargos C ON U.id_cargo=C.id  WHERE U.usuario_login=:usuario AND U.pass_login=:pass";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':usuario' => $obj->getUsuarioLogin(), ':pass' => $obj->getPassLogin()));
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function datos($id)
     {
          $sql = "SELECT U.id, U.estado, U.id_tipo_usuario, U.nombre_completo, U.genero, U.avatar, C.nombre_cargo, TU.nombre_tipo, C.id AS id_cargo, U.menu, C.historias, C.soporte, E.nombre AS nombre_empresa, U.id_empresa FROM usuarios U LEFT JOIN cargos C ON U.id_cargo=C.id JOIN tipo_usuarios TU ON U.id_tipo_usuario=TU.id LEFT JOIN empresas E ON U.id_empresa=E.id WHERE U.id=:id";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id' => $id));
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function registrar_conexion($id_usuario, $fecha_hora)
     {
          $sql = "INSERT INTO conexiones (id_usuario, fecha_hora) VALUES (:id_usuario, :fecha_hora)";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id_usuario' => $id_usuario, ':fecha_hora' => $fecha_hora))) {
               echo 'creado';
          } else {
               echo 'Error al crear';
          }
     }

     function buscar_avatar($id)
     {
          $sql = "SELECT avatar FROM usuarios WHERE id=:id";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id' => $id));
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function buscar_datos_adm_full($id_cargo)
     {
          $condicion = '';
          if ($id_cargo > 6) {
               $condicion = ' AND U.estado=1 ';
          }
          if (!empty($_POST['consulta'])) {
               $sql = "SELECT U.id, U.nombre_completo, U.fecha_nacimiento, U.avatar, U.telefono, U.direccion, U.email, T.nombre_tipo, C.nombre_cargo, U.facebook, U.instagram, U.youtube, U.tiktok, U.estado, U.id_tipo_usuario, U.genero, M.nombre AS municipio, D.nombre AS departamento, U.inf_usuario, U.id_empresa, S.nombre AS nombre_empresa                    
                    FROM usuarios U JOIN cargos C ON U.id_cargo=C.id 
                    LEFT JOIN tipo_usuarios T ON U.id_tipo_usuario=T.id 
                    LEFT JOIN municipios M ON U.ciudad_residencia=M.id 
                    LEFT JOIN departamentos D ON M.departamento_id=D.id LEFT JOIN empresas S ON U.id_empresa=S.id 
                    WHERE U.id<>1 AND (U.nombre_completo LIKE :consulta OR U.telefono LIKE :consulta OR D.nombre LIKE :consulta OR M.nombre LIKE :consulta OR T.nombre_tipo LIKE :consulta ) " . $condicion . " ORDER BY U.nombre_completo ASC";
               $consulta = $_POST['consulta'];
               $query = $this->acceso->prepare($sql);
               $query->execute(array(':consulta' => "%$consulta%"));
               $this->objetos = $query->fetchall();
               return $this->objetos;
          } else {
               $sql = "SELECT U.id, U.nombre_completo, U.fecha_nacimiento, U.avatar, U.telefono, U.direccion, U.email, T.nombre_tipo, C.nombre_cargo, U.facebook, U.instagram, U.youtube, U.tiktok, U.estado, U.id_tipo_usuario, U.genero, M.nombre AS municipio, D.nombre AS departamento, U.inf_usuario, U.id_empresa, S.nombre AS nombre_empresa                    
                    FROM usuarios U JOIN cargos C ON U.id_cargo=C.id 
                    LEFT JOIN tipo_usuarios T ON U.id_tipo_usuario=T.id 
                    LEFT JOIN municipios M ON U.ciudad_residencia=M.id 
                    LEFT JOIN departamentos D ON M.departamento_id=D.id LEFT JOIN empresas S ON U.id_empresa=S.id 
                    WHERE U.id<>1 AND U.nombre_completo NOT LIKE '' " . $condicion . " ORDER BY U.nombre_completo ASC";
               $query = $this->acceso->prepare($sql);
               $query->execute();
               $this->objetos = $query->fetchall();
               return $this->objetos;
          }
     }
     function buscar_usuarios_chat()
     {
          if (!empty($_POST['consulta'])) {
               $sql = "SELECT U.id, U.nombre_completo, U.avatar, C.nombre_cargo, CH1.id AS chat FROM usuarios U LEFT JOIN cargos C ON U.id_cargo=C.id LEFT JOIN chat_conversacion CH1 ON (CH1.id_usuario_1=U.id OR CH1.id_usuario_2=U.id)  WHERE U.estado=1 AND (U.nombre_completo LIKE :consulta OR U.telefono LIKE :consulta) ORDER BY U.nombre_completo ASC";
               $consulta = $_POST['consulta'];
               $query = $this->acceso->prepare($sql);
               $query->execute(array(':consulta' => "%$consulta%"));
               $this->objetos = $query->fetchall();
               return $this->objetos;
          } else {
               $sql = "SELECT U.id, U.nombre_completo, U.avatar, C.nombre_cargo, CH1.id AS chat FROM usuarios U LEFT JOIN cargos C ON U.id_cargo=C.id LEFT JOIN chat_conversacion CH1 ON (CH1.id_usuario_1=U.id OR CH1.id_usuario_2=U.id)  WHERE U.estado=1 AND U.nombre_completo NOT LIKE '' ORDER BY U.nombre_completo ASC";
               $query = $this->acceso->prepare($sql);
               $query->execute();
               $this->objetos = $query->fetchall();
               return $this->objetos;
          }
     }

     function buscar_usuario_existente(Usuario $obj)
     {
          $sql = "SELECT id FROM usuarios WHERE email=:email OR doc_id=:doc_id";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':email' => $obj->getEmail(), ':doc_id' => $obj->getDocId()));
          $this->objetos = $query->fetchAll();
          $cant = count($this->objetos);
          return $cant;
     }

     function crear_usuario(Usuario $obj)
     {
          $sql = "INSERT INTO usuarios(estado, id_cargo, id_tipo_usuario, nombre_completo, doc_id, telefono, avatar, usuario_login, pass_login, email, fecha_creacion,  id_empresa) 
        VALUES (:estado, :id_cargo, :id_tipo_usuario, :nombre_completo, :doc_id, :telefono, :avatar, :usuario_login, :pass_login, :email, :fecha_creacion, :id_empresa )";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(
               ':estado' => $obj->getEstado(), ':id_cargo' => $obj->getIdCargo(), ':id_tipo_usuario' => $obj->getIdTipoUsuario(), ':nombre_completo' => $obj->getNombreCompleto(),
               ':doc_id' => $obj->getDocId(), ':telefono' => $obj->getTelefono(), ':avatar' => $obj->getAvatar(), ':usuario_login' => $obj->getUsuarioLogin(),
               ':pass_login' => $obj->getPassLogin(), ':email' => $obj->getEmail(), ':fecha_creacion' => $obj->getFechaCreacion(), ':id_empresa' => $obj->getIdEmpresa()))) {
               return true;
          } else {
               return false;
          }
     }

     function activacion(Usuario $obj, $id_usuario)
     {
          $sql = "SELECT estado FROM usuarios WHERE pass_login=:pass AND id=:id_usuario";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':pass' => $obj->getPassLogin(), ':id_usuario' => $id_usuario));
          $this->objetos = $query->fetch();
          if (!empty($this->objetos)) {
               if ($obj->getEstado() == 0) {
                    $sql2 = "UPDATE usuarios SET estado=1 WHERE id=:id";
               } else {
                    $sql2 = "UPDATE usuarios SET estado=0 WHERE id=:id";
               }
               $query2 = $this->acceso->prepare($sql2);
               if ($query2->execute(array(':id' => $obj->getId()))) {
                    echo 'update ';
               } else {
                    echo 'Error';
               }
          } else {
               echo 'no_actualizado';
          }
     }

     function restablecer_login(Usuario $obj, $id_usuario)
     {
          $sql = "SELECT id, doc_id FROM usuarios WHERE pass_login=:pass AND id=:id_usuario";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':pass' => $obj->getPassLogin(), ':id_usuario' => $id_usuario));
          if (!empty($query->fetchall())) {
               $sql = "SELECT doc_id FROM usuarios WHERE id=:id";
               $query = $this->acceso->prepare($sql);
               $query->execute(array(':id' => $obj->getId()));
               while ($row = $query->fetch(PDO::FETCH_OBJ)) {
                    $usuario = $row->doc_id;
                    $pass = md5($row->doc_id);
               }
               $sql2 = "UPDATE usuarios SET usuario_login='$usuario', pass_login='$pass' WHERE id=:id";
               $query2 = $this->acceso->prepare($sql2);
               if ($query2->execute(array(':id' => $obj->getId()))) {
                    echo 'update';
               } else {
                    echo 'Error al restablecer el login';
               }
          } else {
               echo 'Error al validar las credenciales de administrador';
          }
     }

     function cargarCc(Usuario $obj)
     {
          $sql = "SELECT U.doc_id, U.id_tipo_usuario, U.id_cargo, U.nombre_completo, U.id_empresa, U.email FROM usuarios U WHERE U.id=:id";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id' => $obj->getId()));
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function update_cc(Usuario $obj)
     {
          $sql2 = "UPDATE usuarios SET doc_id=:doc, id_tipo_usuario=:id_tipo_usuario, id_cargo=:id_cargo, id_empresa=:id_empresa  WHERE id=:id";
          $query2 = $this->acceso->prepare($sql2);
          if ($query2->execute(array(':id' => $obj->getId(), ':doc' => $obj->getDocId(), ':id_tipo_usuario' => $obj->getIdTipoUsuario(), ':id_cargo' => $obj->getIdCargo(), ':id_empresa' => $obj->getIdEmpresa()))) {
               echo 'update';
          } else {
               echo "Error al actualizar los datos";
          }
     }

     function cargarUserFull(Usuario $obj)
     {
          $sql = "SELECT IF(U.id_tipo_usuario=1, (SELECT C.fecha_hora FROM conexiones C WHERE C.id_usuario=:id ORDER BY C.id DESC LIMIT 1), 'N/A') AS conexion, T.nombre_tipo, U.avatar, U.nombre_completo, U.direccion, M.nombre AS municipio, D.nombre AS depto, U.telefono, U.fecha_nacimiento, TIMESTAMPDIFF(YEAR,U.fecha_nacimiento,CURDATE()) AS edad, 
               U.genero, U.doc_id, U.email, U.inf_usuario, U.estado, U.fecha_creacion, U.facebook, U.instagram, U.youtube, U.tiktok, U.inf_usuario, CA.nombre_cargo, U.id_tipo_usuario, U.firma_digital, U.usuario_login, CA.descripcion, U.ciudad_residencia, U.contacto_emergencia, U.parentezco_contacto, U.telefono_contacto, U.eps, U.tipo_sangre, U.nivel_academico,
               U.profesion, U.experiencia, U.fondo, U.cesantias, U.nombre_madre, U.telefono_madre, U.nombre_padre, U.telefono_padre, U.estrato, U.estado_civil, U.grupo_etnico, U.personas_cargo, U.cabeza_familia, U.hijos, U.fuma, U.fuma_frecuencia, U.bebidas, U.bebidas_frecuencia, U.deporte, U.talla_camisa, U.talla_pantalon, U.talla_calzado, U.tipo_vivienda, 
               U.licencia_conduccion, U.licencia_descr, U.act_tiempo_libre, CA.nombre_cargo, S.nombre AS nombre_sede, U.empresa, U.id_area, A.nombre AS nombre_area, U.arl, U.correo_institucional, U.clave_email_institucional, U.tipo_cuenta, U.numero_cuenta, U.banco, CA.descripcion AS funciones, U.id_cargo, U.hora_entrada, U.verificar_asistencia, U.telefono_corporativo, U.verificar_contrato
               FROM usuarios U JOIN tipo_usuarios T ON U.id_tipo_usuario=T.id JOIN municipios M ON U.ciudad_residencia=M.id JOIN departamentos D ON M.departamento_id=D.id JOIN cargos CA ON U.id_cargo=CA.id LEFT JOIN sedes S ON U.empresa=S.id LEFT JOIN areas A ON U.id_area=A.id WHERE U.id=:id";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id' => $obj->getId()));
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function conexiones_usuario(Usuario $obj)
     {
          $sql = "SELECT DATE(C.fecha_hora) AS fecha, TIME(C.fecha_hora) AS hora FROM conexiones C JOIN usuarios U ON C.id_usuario=U.id WHERE U.id = :id ORDER BY C.id DESC LIMIT 10";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id' => $obj->getId()));
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function editar_usuario(Usuario $obj)
     {
          $sql = "UPDATE usuarios SET nombre_completo=:nombre_completo, doc_id=:doc_id, fecha_nacimiento=:fecha_nacimiento, telefono=:telefono, direccion=:direccion, email=:email, inf_usuario=:inf_usuario, genero=:genero, ciudad_residencia=:ciudad_residencia WHERE id=:id";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id' => $obj->getId(), ':nombre_completo' => $obj->getNombreCompleto(), ':doc_id' => $obj->getDocId(), ':fecha_nacimiento' => $obj->getFechaNacimiento(), ':telefono' => $obj->getTelefono(), ':direccion' => $obj->getDireccion(), ':email' => $obj->getEmail(), ':inf_usuario' => $obj->getInfUsuario(), ':genero' => $obj->getGenero(), ':ciudad_residencia' => $obj->getCiudadResidencia()))) {
               echo 'editado';
          } else {
               echo 'noEditado';
          }
     }

     function update_pass($id, $nameUser, $oldpass, $newpass)
     {
          $sql = "SELECT id FROM usuarios WHERE usuario_login=:nameUser AND id=:id";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id' => $id, ':nameUser' => $nameUser));
          $this->objetos = $query->fetchall();
          if (!empty($this->objetos)) {
               //Guardar cambiando usuario
               $sql = "SELECT id FROM usuarios WHERE usuario_login=:nameUser";
               //Buscar si existe un usuario con ese nombre
               $query = $this->acceso->prepare($sql);
               $query->execute(array(':nameUser' => $nameUser));
               $this->objetos = $query->fetchall();
               if (!empty($this->objetos)) {
                    //Guardar cambios
                    $sql = "SELECT id FROM usuarios WHERE pass_login=:oldpass AND id=:id";
                    $query = $this->acceso->prepare($sql);
                    $query->execute(array(':id' => $id, ':oldpass' => $oldpass));
                    $this->objetos = $query->fetchall();
                    if (!empty($this->objetos)) { // Si el password coincide continua guardando
                         $sql = "UPDATE usuarios SET usuario_login=:nameUser, pass_login=:newpass WHERE id=:id";
                         $query = $this->acceso->prepare($sql);
                         if ($query->execute(array(':id' => $id, ':nameUser' => $nameUser, ':newpass' => $newpass))) {
                              echo 'update';
                         } else {
                              echo 'Error al actualizar el usuario';
                         }
                    } else {
                         echo 'Error al verificar el password actual';
                    }
               } else {
                    echo 'Ya existe un usuario con ese nombre de usuario';
               }
          } else {
               //Guardar sin cambiar usuario
               $sql = "SELECT id FROM usuarios WHERE pass_login=:oldpass AND id=:id";
               $query = $this->acceso->prepare($sql);
               $query->execute(array(':id' => $id, ':oldpass' => $oldpass));
               $this->objetos = $query->fetchall();
               if (!empty($this->objetos)) { // Si el password coincide continua guardando
                    $sql = "UPDATE usuarios SET usuario_login=:nameUser, pass_login=:newpass WHERE id=:id";
                    $query = $this->acceso->prepare($sql);
                    if ($query->execute(array(':id' => $id, ':nameUser' => $nameUser, ':newpass' => $newpass))) {
                         echo 'update';
                    } else {
                         echo 'Error al actualizar el usuario';
                    }
               } else {
                    echo 'Error al verificar el password actual';
               }
          }
     }

     function cambiar_avatar(Usuario $obj)
     {
          $sql = "SELECT avatar FROM usuarios WHERE id=:id";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id' => $obj->getId()));
          $this->objetos = $query->fetchall();

          $sql = "UPDATE usuarios SET avatar=:avatar WHERE id=:id";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id' => $obj->getId(), ':avatar' => $obj->getAvatar()));
          return $this->objetos;
     }

     function cambiar_firma(Usuario $obj)
     {
          $sql = "UPDATE usuarios SET firma_digital=:firma_digital WHERE id=:id";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id' => $obj->getId(), ':firma_digital' => $obj->getFirmaDigital()));
     }

     function buscar_datos_gerente()
     {
          $sql = "SELECT U.id, U.nombre_completo, U.telefono, U.email FROM usuarios U WHERE U.id_cargo<=3";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function actualizar_menu(Usuario $obj)
     {
          $sql = "UPDATE usuarios SET menu=:menu WHERE id=:id";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id' => $obj->getId(), ':menu' => $obj->getMenu()));
     }

     function buscar_menu(Usuario $obj)
     {
          $sql = "SELECT U.menu FROM usuarios U WHERE U.id=:id";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id' => $obj->getId()));
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function actualizar_calendario(Usuario $obj)
     {
          $sql = "UPDATE usuarios SET calendar=:calendar WHERE id=:id";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id' => $obj->getId(), ':calendar' => $obj->getCalendar()));
     }

     function buscar_calendario(Usuario $obj)
     {
          $sql = "SELECT U.calendar FROM usuarios U WHERE U.id=:id";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id' => $obj->getId()));
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function activosEmail()
     {
          $sql = "SELECT U.email FROM usuarios U WHERE U.estado=1 AND (U.id_cargo<=4 OR U.id_tipo_usuario<=2)";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     // Actualizar datos adicionales

     function editar_salud(Usuario $obj)
     {
          $sql = "UPDATE usuarios SET eps=:eps, tipo_sangre=:tipo_sangre, contacto_emergencia=:contacto_emergencia, parentezco_contacto=:parentezco_contacto, telefono_contacto=:telefono_contacto WHERE id=:id";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id' => $obj->getId(), ':eps' => $obj->getEps(), ':tipo_sangre' => $obj->getTipoSangre(), ':contacto_emergencia' => $obj->getContactoEmergencia(), ':parentezco_contacto' => $obj->getParentezcoContacto(), ':telefono_contacto' => $obj->getTelefonoContacto()))) {
               echo 'editado';
          } else {
               echo 'noEditado';
          }
     }

     function editar_academico(Usuario $obj)
     {   
          $sql = "UPDATE usuarios SET nivel_academico=:nivel_academico, profesion=:profesion, experiencia=:experiencia, fondo=:fondo, cesantias=:cesantias, correo_institucional=:correo_institucional, clave_email_institucional=:clave_email_institucional, arl=:arl, tipo_cuenta=:tipo_cuenta, numero_cuenta=:numero_cuenta, banco=:banco, hora_entrada=:hora_entrada, verificar_asistencia=:verificar_asistencia, telefono_corporativo=:telefono_corporativo, verificar_contrato=:verificar_contrato WHERE id=:id";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id' => $obj->getId(), ':nivel_academico' => $obj->getNivelAcademico(), ':profesion' => $obj->getProfesion(), ':experiencia' => $obj->getExperiencia(), ':fondo' => $obj->getFondo(), ':cesantias' => $obj->getCesantias()))) {
               echo 'editado';
          } else {
               echo 'noEditado';
          }
     }

     function editar_familiar(Usuario $obj)
     {
          $sql = "UPDATE usuarios SET nombre_madre=:nombre_madre, telefono_madre=:telefono_madre, nombre_padre=:nombre_padre, telefono_padre=:telefono_padre WHERE id=:id";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id' => $obj->getId(), ':nombre_madre' => $obj->getNombreMadre(), ':telefono_madre' => $obj->getTelefonoMadre(), ':nombre_padre' => $obj->getNombrePadre(), ':telefono_padre' => $obj->getTelefonoPadre()))) {
               echo 'editado';
          } else {
               echo 'noEditado';
          }
     }

     function editar_sociodemografico(Usuario $obj)
     {
          $sql = "UPDATE usuarios SET estrato=:estrato, estado_civil=:estado_civil, grupo_etnico=:grupo_etnico, personas_cargo=:personas_cargo, cabeza_familia=:cabeza_familia, hijos=:hijos, fuma=:fuma, fuma_frecuencia=:fuma_frecuencia, bebidas=:bebidas, bebidas_frecuencia=:bebidas_frecuencia, 
          deporte=:deporte, talla_camisa=:talla_camisa, talla_calzado=:talla_calzado, talla_pantalon=:talla_pantalon, tipo_vivienda=:tipo_vivienda, licencia_conduccion=:licencia_conduccion, licencia_descr=:licencia_descr, act_tiempo_libre=:act_tiempo_libre WHERE id=:id";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(
               ':id' => $obj->getId(), ':estrato' => $obj->getEstrato(), ':estado_civil' => $obj->getEstadoCivil(), ':grupo_etnico' => $obj->getGrupoEtnico(), ':personas_cargo' => $obj->getPersonasCargo(), ':cabeza_familia' => $obj->getCabezaFamilia(),
               ':hijos' => $obj->getHijos(), ':fuma' => $obj->getFuma(), ':fuma_frecuencia' => $obj->getFumaFrecuencia(), ':bebidas' => $obj->getBebidas(), ':bebidas_frecuencia' => $obj->getBebidasFrecuencia(), ':deporte' => $obj->getDeporte(), ':talla_camisa' => $obj->getTallaCamisa(),
               ':talla_calzado' => $obj->getTallaCalzado(), ':talla_pantalon' => $obj->getTallaPantalon(), ':tipo_vivienda' => $obj->getTipoVivienda(), ':licencia_conduccion' => $obj->getLicenciaConduccion(), ':licencia_descr' => $obj->getDescripcionLicencia(), ':act_tiempo_libre' => $obj->getActTiempoLibre()
          ))) {
               echo 'editado';
          } else {
               echo 'noEditado';
          }
     }

     // Personas a Cargo

     function crear_persona_a_cargo(PersonaCargo $obj)
     {
          $sql = "INSERT INTO usuario_personas_cargo (id_usuario, nombre, fecha_nac, parentezco) VALUES (:id_usuario, :nombre, :fecha_nac, :parentezco)";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id_usuario' => $obj->getIdUsuario(), ':fecha_nac' => $obj->getFechaNac(), ':nombre' => $obj->getNombre(), ':parentezco' => $obj->getParentezco()))) {
               echo 'creado';
          } else {
               echo 'Error al crear';
          }
     }

     function eliminar_persona_a_cargo(PersonaCargo $obj)
     {
          $sql = "DELETE FROM usuario_personas_cargo WHERE id=:id";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id' => $obj->getId()))) {
               echo 'eliminado';
          } else {
               echo 'noEditado';
          }
     }

     function listar_persona_a_cargo(PersonaCargo $obj)
     {
          $sql = "SELECT * FROM usuario_personas_cargo WHERE id_usuario=:id_usuario";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id_usuario' => $obj->getIdUsuario()));
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     // Medicamentos
     function crear_medicamentos(Medicamento $obj)
     {
          $sql = "INSERT INTO medicamentos (id_usuario, nombre, indicaciones) VALUES (:id_usuario, :nombre, :indicaciones)";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id_usuario' => $obj->getIdUsuario(), ':nombre' => $obj->getNombre(), ':indicaciones' => $obj->getIndicaciones()))) {
               echo 'creado';
          } else {
               echo 'Error al crear';
          }
     }

     function eliminar_medicamentos(Medicamento $obj)
     {
          $sql = "DELETE FROM medicamentos WHERE id=:id";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id' => $obj->getId()))) {
               echo 'eliminado';
          } else {
               echo 'noEditado';
          }
     }

     function listar_medicamentos(Medicamento $obj)
     {
          $sql = "SELECT * FROM medicamentos WHERE id_usuario=:id_usuario";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id_usuario' => $obj->getIdUsuario()));
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     // Enfermedades
     function crear_enfermedades(Enfermedad $obj)
     {
          $sql = "INSERT INTO enfermedades (id_usuario, nombre) VALUES (:id_usuario, :nombre)";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id_usuario' => $obj->getIdUsuario(), ':nombre' => $obj->getNombre()))) {
               echo 'creado';
          } else {
               echo 'Error al crear';
          }
     }

     function eliminar_enfermedades(Enfermedad $obj)
     {
          $sql = "DELETE FROM enfermedades WHERE id=:id";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id' => $obj->getId()))) {
               echo 'eliminado';
          } else {
               echo 'noEditado';
          }
     }

     function listar_enfermedades(Enfermedad $obj)
     {
          $sql = "SELECT * FROM enfermedades WHERE id_usuario=:id_usuario";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id_usuario' => $obj->getIdUsuario()));
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     // Alergias
     function crear_alergias(Alergia $obj)
     {
          $sql = "INSERT INTO alergias (id_usuario, tipo, nombre) VALUES (:id_usuario, :tipo, :nombre)";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id_usuario' => $obj->getIdUsuario(), ':tipo' => $obj->getTipo(), ':nombre' => $obj->getNombre()))) {
               echo 'creado';
          } else {
               echo 'Error al crear';
          }
     }

     function eliminar_alergias(Alergia $obj)
     {
          $sql = "DELETE FROM alergias WHERE id=:id";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id' => $obj->getId()))) {
               echo 'eliminado';
          } else {
               echo 'noEditado';
          }
     }

     function listar_alergias(Alergia $obj)
     {
          $sql = "SELECT * FROM alergias WHERE id_usuario=:id_usuario";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id_usuario' => $obj->getIdUsuario()));
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     // Cirugias
     function crear_cirugia(Cirugia $obj)
     {
          $sql = "INSERT INTO cirugias (id_usuario, nombre) VALUES (:id_usuario, :nombre)";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id_usuario' => $obj->getIdUsuario(), ':nombre' => $obj->getNombre()))) {
               echo 'creado';
          } else {
               echo 'Error al crear';
          }
     }

     function eliminar_cirugia(Cirugia $obj)
     {
          $sql = "DELETE FROM cirugias WHERE id=:id";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id' => $obj->getId()))) {
               echo 'eliminado';
          } else {
               echo 'noEditado';
          }
     }

     function listar_cirugias(Cirugia $obj)
     {
          $sql = "SELECT * FROM cirugias WHERE id_usuario=:id_usuario";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id_usuario' => $obj->getIdUsuario()));
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     // Lesiones
     function crear_lesion(Lesion $obj)
     {
          $sql = "INSERT INTO lesiones (id_usuario, nombre, tipo) VALUES (:id_usuario, :nombre, :tipo)";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id_usuario' => $obj->getIdUsuario(), ':nombre' => $obj->getNombre(),  ':tipo' => $obj->getTipo()))) {
               echo 'creado';
          } else {
               echo 'Error al crear';
          }
     }

     function eliminar_lesion(Lesion $obj)
     {
          $sql = "DELETE FROM lesiones WHERE id=:id";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id' => $obj->getId()))) {
               echo 'eliminado';
          } else {
               echo 'noEditado';
          }
     }

     function listar_lesion(Lesion $obj)
     {
          $sql = "SELECT * FROM lesiones WHERE id_usuario=:id_usuario";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id_usuario' => $obj->getIdUsuario()));
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     // Antecedentes
     function crear_antecedente(Antecedente $obj)
     {
          $sql = "INSERT INTO antecedentes (id_usuario, nombre) VALUES (:id_usuario, :nombre)";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id_usuario' => $obj->getIdUsuario(), ':nombre' => $obj->getNombre()))) {
               echo 'creado';
          } else {
               echo 'Error al crear';
          }
     }

     function eliminar_antecedente(Antecedente $obj)
     {
          $sql = "DELETE FROM antecedentes WHERE id=:id";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id' => $obj->getId()))) {
               echo 'eliminado';
          } else {
               echo 'noEditado';
          }
     }

     function listar_antecedente(Antecedente $obj)
     {
          $sql = "SELECT * FROM antecedentes WHERE id_usuario=:id_usuario";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id_usuario' => $obj->getIdUsuario()));
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     // Estudios Academicos
     function crear_estudio(Estudio $obj)
     {
          $sql = "INSERT INTO estudios (id_usuario, nivel, tipo_nivel, titulo, institucion, ano, ciudad) VALUES (:id_usuario, :nivel, :tipo_nivel, :titulo, :institucion, :ano, :ciudad)";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id_usuario' => $obj->getIdUsuario(), ':nivel' => $obj->getNivel(), ':tipo_nivel' => $obj->getTipoNivel(), ':titulo' => $obj->getTitulo(), ':institucion' => $obj->getInstitucion(), ':ano' => $obj->getAño(), ':ciudad' => $obj->getCiudad()))) {
               echo 'creado';
          } else {
               echo 'Error al crear';
          }
     }

     function eliminar_estudio(Estudio $obj)
     {
          $sql = "DELETE FROM estudios WHERE id=:id";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id' => $obj->getId()))) {
               echo 'eliminado';
          } else {
               echo 'noEditado';
          }
     }

     function listar_estudio(Estudio $obj)
     {
          $sql = "SELECT * FROM estudios WHERE id_usuario=:id_usuario";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id_usuario' => $obj->getIdUsuario()));
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     // Cursos
     function crear_curso(Curso $obj)
     {
          $sql = "INSERT INTO cursos (id_usuario, fecha, institucion, descripcion, horas) VALUES (:id_usuario, :fecha, :institucion, :descripcion, :horas)";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id_usuario' => $obj->getIdUsuario(), ':fecha' => $obj->getFecha(), ':institucion' => $obj->getInstitucion(), ':descripcion' => $obj->getDescripcion(), ':horas' => $obj->getHoras()))) {
               echo 'creado';
          } else {
               echo 'Error al crear';
          }
     }

     function eliminar_curso(Curso $obj)
     {
          $sql = "DELETE FROM cursos WHERE id=:id";
          $query = $this->acceso->prepare($sql);
          if ($query->execute(array(':id' => $obj->getId()))) {
               echo 'eliminado';
          } else {
               echo 'noEditado';
          }
     }

     function listar_curso(Curso $obj)
     {
          $sql = "SELECT * FROM cursos WHERE id_usuario=:id_usuario";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id_usuario' => $obj->getIdUsuario()));
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function reporteGeneral()
     {
          $sql = "SELECT S.nombre AS nombre_sede, C.nombre_cargo, U.nombre_completo, U.doc_id, TIMESTAMPDIFF(YEAR, U.fecha_nacimiento, CURDATE()) AS edad, U.telefono, U.email, U.eps, U.tipo_sangre, U.fondo, U.cesantias, 
          CONCAT('<a href=\'../Vista/usuario.php?id=', U.id, '&modulo=usuarios\'><button class=\'state btn btn-sm btn-success mr-1\' type=\'button\' title=\'Ver Perfil\'>
                                                                          <i class=\'fas fa-address-card\'></i>
                                                                      </button>
                                                                </a>') AS boton
          FROM usuarios U LEFT JOIN sedes S ON U.empresa=S.id LEFT JOIN cargos C ON U.id_cargo=C.id WHERE U.id <> 1 AND U.estado=1 ORDER BY U.nombre_completo";

          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function estadisticas()
     {

          $sql = "SELECT (SELECT COUNT(U.id) FROM usuarios U WHERE estado=1 AND U.id<>1) AS activos,
          (SELECT COUNT(I.id) FROM incapacidades I WHERE I.estado=1) AS incapacidades,
          (SELECT COUNT(U.id) FROM usuario_solicitudes U WHERE U.estado=1) AS solicitudes,
          (SELECT COUNT(U.id) FROM usuario_asistencia U WHERE U.tipo = 'Entrada' AND DATE(U.fecha_hora) = CURDATE()) AS asistencia
          FROM usuarios GROUP BY activos, incapacidades, solicitudes, asistencia";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function vacacionesAutogestion($id_usuario)
     {

          $sql = "SELECT (SELECT SUM(S1.cantidad) FROM usuario_solicitudes S1 WHERE S1.tipo='Vacaciones' AND S1.estado=2 AND S1.id_usuario=$id_usuario AND S1.fecha_inicial <= NOW()) AS disfrutados,
          (SELECT SUM(CD.dias) FROM usuario_compensacion C JOIN compensacion_detalle CD ON CD.id_compensacion=C.id WHERE C.fecha_creacion<= NOW() AND CD.tipo='Compensado' AND C.id_usuario=$id_usuario) AS compensados,
          (SELECT S1.cantidad FROM usuario_solicitudes S1 WHERE S1.tipo='Vacaciones' AND S1.estado=2 AND S1.id_usuario=$id_usuario AND S1.fecha_inicial <= NOW() ORDER BY S.id DESC LIMIT 1) AS ultimos_disfrutados,
          (SELECT S1.fecha_final FROM usuario_solicitudes S1 WHERE S1.tipo='Vacaciones' AND S1.estado=2 AND S1.id_usuario=$id_usuario AND S1.fecha_inicial <= NOW() ORDER BY S.id DESC LIMIT 1)  AS ultimas_vacaciones,
          (SELECT DATEDIFF(NOW(), C.fecha_inicio) FROM contratos C WHERE C.id_usuario = $id_usuario AND C.estado = 1 ) AS dias_contratado,
          (SELECT  FLOOR(TIMESTAMPDIFF(MONTH, C.fecha_inicio, NOW()) / 12) FROM contratos C WHERE C.id_usuario = $id_usuario AND C.estado = 1 AND (C.tipo_contrato = 'Término Indefinido' OR C.tipo_contrato ='Término Definido')) AS periodos,
          (SELECT FLOOR(TIMESTAMPDIFF(MONTH, C.fecha_inicio, NOW()) * 1.3) FROM contratos C WHERE C.id_usuario = $id_usuario AND C.estado = 1 AND (C.tipo_contrato = 'Término Indefinido' OR C.tipo_contrato ='Término Definido')) AS dias_acumulados,
          (SELECT DATEDIFF(DATE_ADD(C.fecha_inicio, INTERVAL FLOOR(TIMESTAMPDIFF(MONTH, C.fecha_inicio, NOW()) / 12) + 1 YEAR), NOW()) FROM contratos C WHERE C.id_usuario = $id_usuario AND C.estado = 1 AND (C.tipo_contrato = 'Término Indefinido' OR C.tipo_contrato ='Término Definido')) AS dias_nuevo_periodo 
          FROM usuario_solicitudes S GROUP BY disfrutados, compensados, ultimos_disfrutados, dias_contratado, periodos, dias_acumulados, dias_nuevo_periodo";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function buscarUsersTalentoHumanoFull()
     {
          $sql = "SELECT U.nombre_completo, U.email, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id JOIN modulos_cargos MC ON MC.id_cargo=C.id WHERE MC.id_modulo=10 AND MC.crear=1 AND MC.editar=1";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function buscarUsersConfiguracionFull()
     {
          $sql = "SELECT U.nombre_completo, U.email, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id JOIN modulos_cargos MC ON MC.id_cargo=C.id WHERE MC.id_modulo=1 AND MC.crear=1 AND MC.editar=1";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function buscarUsersContratosFull()
     {
          $sql = "SELECT U.nombre_completo, U.email, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id JOIN modulos_cargos MC ON MC.id_cargo=C.id WHERE MC.id_modulo=11 AND MC.crear=1 AND MC.editar=1";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function listarActivos()
     {
          $sql = "SELECT U.nombre_completo, U.email, U.avatar, U.id, U.doc_id FROM usuarios U WHERE U.estado=1 AND U.id<>1";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function buscarUsersEncuestas()
     {
          $sql = "SELECT U.nombre_completo, U.email, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id JOIN modulos_cargos MC ON MC.id_cargo=C.id WHERE MC.id_modulo=16 AND MC.crear=1 AND MC.editar=1";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function buscarUsersBodega()
     {
          $sql = "SELECT U.nombre_completo, U.email, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id WHERE C.id=9 OR C.id=3";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function buscarUsersSalasServicio()
     {
          $sql = "SELECT U.nombre_completo, U.email, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id WHERE C.id=4";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function buscarUsersJefeRecursoHumano()
     {
          $sql = "SELECT U.nombre_completo, U.email, C.nombre_cargo FROM usuarios U JOIN cargos C ON U.id_cargo=C.id WHERE C.id=6";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function cargarPorDocumento(Usuario $obj)
     {
          $sql = "SELECT U.doc_id, U.id_tipo_usuario, U.id_cargo, U.nombre_completo, U.empresa, U.email FROM usuarios U WHERE U.doc_id=:doc_id";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':doc_id' => $obj->getDocId()));
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }
     function morosos()
     {
          $sql = "SELECT S.nombre AS nombre_sede, 
                              C.nombre_cargo, 
                              U.nombre_completo, 
                              U.doc_id,
                              IF (IFNULL(U.direccion, '') != '' AND IFNULL(U.telefono, '') != '' AND IFNULL(U.fecha_nacimiento, '') != '' AND IFNULL(U.genero, '') != '', 1, 0) AS personal,
                              IF (IFNULL(U.nombre_madre, '') != '' AND IFNULL(U.nombre_padre, '') != '', 1, 0) AS familiar,
                              IF (IFNULL(U.tipo_sangre, '') != '' AND IFNULL(U.eps, '') != '' AND IFNULL(U.contacto_emergencia, '') != '' AND IFNULL(U.telefono_contacto, '') != '', 1, 0) AS salud,
                              IF (IFNULL(U.nivel_academico, '') != '' AND IFNULL(U.profesion, '') != '' AND IFNULL(U.experiencia, '') != '', 1, 0) AS academica,
                              (SELECT COUNT(I.id) FROM estudios I WHERE I.id_usuario = U.id) AS estudios,
                              IF (IFNULL(U.estrato, '') != '' AND IFNULL(U.estado_civil, '') != '' AND IFNULL(U.grupo_etnico, '') != '' AND IFNULL(U.personas_cargo, '') != '' AND IFNULL(U.cabeza_familia, '') != '' AND IFNULL(U.hijos, '') != '' AND IFNULL(U.fuma, '') != '' AND IFNULL(U.bebidas, '') != '' AND IFNULL(U.talla_camisa, '') != '' AND IFNULL(U.talla_pantalon, '') != '' AND IFNULL(U.talla_calzado, '') != '' AND IFNULL(U.tipo_vivienda, '') != '' AND IFNULL(U.licencia_conduccion, '') != '', 1, 0) AS sociodemografica,
                              CONCAT('<a href=\'../Vista/usuario.php?id=', U.id, '&modulo=usuarios\'><button class=\'state btn btn-sm btn-success mr-1\' type=\'button\' title=\'Ver Perfil\'><i class=\'fas fa-address-card\'></i></button></a>') AS boton
                    FROM usuarios U 
                    LEFT JOIN sedes S ON U.empresa = S.id 
                    LEFT JOIN cargos C ON U.id_cargo = C.id 
                    WHERE U.id <> 1 AND U.estado = 1
                    ORDER BY U.nombre_completo;
   
           ";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function usuariosPorCargo()
     {
          $sql = "SELECT C.nombre_cargo AS valor, COUNT(U.id) AS cantidad_usuarios
          FROM cargos C
          LEFT JOIN usuarios U ON C.id = U.id_cargo
          WHERE U.id<>1
          GROUP BY C.id, C.nombre_cargo;";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }
     function usuariosPorSedes()
     {
          $sql = "SELECT C.nombre  AS valor, COUNT(U.id) AS cantidad_usuarios
          FROM sedes C
          LEFT JOIN usuarios U ON C.id = U.empresa
          WHERE U.id<>1
          GROUP BY C.id, C.nombre;";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }
     function usuariosPorArea()
     {
          $sql = "SELECT C.nombre  AS valor, COUNT(U.id) AS cantidad_usuarios
          FROM areas C
          LEFT JOIN usuarios U ON C.id = U.id_area
          WHERE U.id<>1
          GROUP BY C.id, C.nombre;";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }
     function usuariosPorEstrato()
     {
          $sql = "SELECT U.estrato  AS valor, COUNT(*) AS cantidad_usuarios
          FROM usuarios U
          WHERE U.estrato IS NOT NULL AND U.estrato!= 0
          GROUP BY U.estrato
          ORDER BY U.estrato ASC;";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }
     function usuariosPorNivelAcademico()
     {
          $sql = "SELECT U.nivel_academico  AS valor, COUNT(*) AS cantidad_usuarios
          FROM usuarios U
          WHERE U.nivel_academico IS NOT NULL
          GROUP BY U.nivel_academico
          ORDER BY U.nivel_academico ASC;";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }
     function usuariosPorGrupoEtnico()
     {
          $sql = "SELECT U.grupo_etnico  AS valor, COUNT(*) AS cantidad_usuarios
          FROM usuarios U
          WHERE U.grupo_etnico IS NOT NULL AND U.grupo_etnico!=''
          GROUP BY U.grupo_etnico
          ORDER BY U.grupo_etnico ASC;";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }
     function usuariosPorEstadoCivil()
     {
          $sql = "SELECT U.estado_civil  AS valor, COUNT(*) AS cantidad_usuarios
          FROM usuarios U
          WHERE U.estado_civil IS NOT NULL AND U.estado_civil!=''
          GROUP BY U.estado_civil
          ORDER BY U.estado_civil ASC;";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }
     function usuariosPorTipoSangre()
     {
          $sql = "SELECT U.tipo_sangre  AS valor, COUNT(*) AS cantidad_usuarios
          FROM usuarios U
          WHERE U.tipo_sangre IS NOT NULL AND U.tipo_sangre!=''
          GROUP BY U.tipo_sangre
          ORDER BY U.tipo_sangre ASC;";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function usuariosPorFuma()
     {
          $sql = "SELECT U.fuma  AS valor, COUNT(*) AS cantidad_usuarios
          FROM usuarios U
          WHERE U.fuma IS NOT NULL
          GROUP BY U.fuma
          ORDER BY U.fuma ASC;";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function usuariosPorBebidas()
     {
          $sql = "SELECT U.bebidas  AS valor, COUNT(*) AS cantidad_usuarios
          FROM usuarios U
          WHERE U.bebidas IS NOT NULL AND U.bebidas!=''
          GROUP BY U.bebidas
          ORDER BY U.bebidas ASC;";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }
     function usuariosPorLicencia()
     {
          $sql = "SELECT U.licencia_conduccion  AS valor, COUNT(*) AS cantidad_usuarios
          FROM usuarios U
          WHERE U.licencia_conduccion IS NOT NULL AND U.licencia_conduccion!=''
          GROUP BY U.licencia_conduccion
          ORDER BY U.licencia_conduccion ASC;";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }
     function usuariosPorTipoVivienda()
     {
          $sql = "SELECT U.tipo_vivienda  AS valor, COUNT(*) AS cantidad_usuarios
          FROM usuarios U
          WHERE U.tipo_vivienda IS NOT NULL AND U.tipo_vivienda!=''
          GROUP BY U.tipo_vivienda
          ORDER BY U.tipo_vivienda ASC;";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }
     function usuariosPorCabezaFlia()
     {
          $sql = "SELECT U.cabeza_familia  AS valor, COUNT(*) AS cantidad_usuarios
          FROM usuarios U
          WHERE U.cabeza_familia IS NOT NULL AND U.cabeza_familia!=''
          GROUP BY U.cabeza_familia
          ORDER BY U.cabeza_familia ASC;";
          $query = $this->acceso->prepare($sql);
          $query->execute();
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }

     function numerosCargo(Usuario $obj)
     {

          $sql = "SELECT (SELECT COUNT(U.id) FROM usuario_asistencia U JOIN usuarios US ON U.id_usuario = US.id WHERE U.tipo = 'Entrada' AND DATE(U.fecha_hora) = CURDATE() AND U.permiso = 0 AND TIMESTAMPDIFF(MINUTE, CONCAT(DATE(U.fecha_hora), ' ', US.hora_entrada), U.fecha_hora) > 5 AND US.id=:id_usuario) AS llegadas_tarde,
          (SELECT COUNT(C.id) FROM colaboradores_mes C WHERE C.id_usuario=:id_usuario) AS colaboradores_mes
          FROM usuarios GROUP BY llegadas_tarde, colaboradores_mes";
          $query = $this->acceso->prepare($sql);
          $query->execute(array(':id_usuario' => $obj->getId()));
          $this->objetos = $query->fetchall();
          return $this->objetos;
     }
}

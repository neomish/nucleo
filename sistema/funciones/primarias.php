<?php
  #incluir el archivo de configuración, que aún probando mucho no me sirven como globales al final
  include "sistema/configuracion/sistema.php";
  #incluyo las funciones para poder hacer ejecución de instrucciones a la base de datos.
  include "sistema/funciones/basededatos.php";

  #Con esta función listo los ficheros de un directorio con una extensión en particular
  function listar_directorio( $ruta, $tipo ) {
    $archivos = array();
    $directorio = opendir($ruta);
    while (($archivo = readdir($directorio)) !== false) {
      $extension = substr(strrchr($archivo, '.'), 1);
      for ( $i = 0 ; $i < count ( $tipo ) ; $i ++ ) {
        if ( $extension == $tipo[$i] ) {
          //$nombre_de_archivo = substr( $archivo , 0 , -4 );
          $archivos[] = $ruta . $archivo;
        }
      }
    }
    closedir($directorio);
    sort($archivos);
    return $archivos;
  }

  #Con esta función lo que hago es buscar en el directorio que almacena los estilos css para
  #incluirlos en los encabezados de las páginas generadas
  function colocar_estilos() {
    $salida = listar_directorio ( "./recursos/estilos/" , array("css") );
    for ( $i = 0 ; $i < count($salida) ; $i++ ) {
      echo "
        <link rel='stylesheet' href='$salida[$i]' type='text/css' />
      \n";
    }
  }

  #La siguiente función busca los guiones de javascript apra incluirlos en las páginas
  #a partir de lo que encuentra en el directorio de guiones
  function colocar_guiones() {
    $salida = listar_directorio ( "./recursos/guiones/" , array("js") );
    for ( $i = 0 ; $i < count($salida) ; $i++ ) {
      echo "
        <script type='text/javascript' src='$salida[$i]'></script>
      \n";
    }
  }

  #esta función me permite incluir un archivo si existe, es útil para enviar mensajes de error
  #cuando el archivo no existe y es llamado por los menúes del sistema
  function incluir_archivo( $archivo ){
    if ( file_exists( $archivo ) ) {
      include_once( $archivo );
    } else {
      echo "
        El archivo $archivo no existe
        <script language='JavaScript'>
          ponerError('El archivo $archivo no existe');
        </script>
      \n";
    }
  }

  #Este código coloca un encabezado en las páginas a partir de la estructura general de páginas.
  function colocar_encabezado(){
    include "./sistema/configuracion/sistema.php";
    if( isset($_SESSION[ $NOMBRE_DEL_SISTEMA ."ingreso"] ) ) {
      if ($_SESSION[ $NOMBRE_DEL_SISTEMA ."ingreso"] == "autenticado") {
        echo "
          <div id='menu'>
            <ul>
              <li>
                <a href='./'>
                  <image src='./recursos/imagenes/hogar.png' title='Ir al Inicio' />
                  Inicio
                </a>
              </li>
            </ul>
        \n";
        colocar_menu_administrador();
        if ( existe_conexion() ) {
          crear_menu();
        }
        echo "
            <ul>
              <li>
                <a href='./?orden_de_ingreso=salida'>
                  <image src='./recursos/imagenes/salir.png' title='Salir del sistema' />
                  Salir
                </a>
              </li>
            </ul>
            <br/>
          </div>
        \n";
      }
    }
  }

  #La funcion siguiente obteine la perición de lso contenidos a mostrar para poder mostrar las
  #páginas o aplicaciones solicitadas
  function colocar_contenido(){
    $contenido = $_REQUEST["contenido"];
    incluir_archivo($contenido);
  }

  #Para que todas las páginas puedan tener el mismo pié de página se coloca el mismo contenido de
  #la estructura con esta funcion.
  function colocar_pedestal(){
    #Aún no hay definición de algo dinámico para esta parte del núcleo, pero podría tener algún detalle especial
    #para que en un futuro pueda agregarse en esta sección.
  }

  #Con la siguiete función se evalua si el usuario existe en el núcleo o no
  function entrar_salir( $orden_de_ingreso = "salida" ){
    include "./sistema/configuracion/sistema.php";
    $resultado = FALSE;
    #La primera evaluación es comprobar si se desea salir, de ser cierto se limpian las variables de sesión
    #Y destruye las sessiones para evitar acceder a contenido del nucleo
    if ( $orden_de_ingreso == "salida" ) {
      # Ejecutar salida del sistema
      $_SESSION[ $NOMBRE_DEL_SISTEMA ."ingreso"]   = NULL;
      $_SESSION[ $NOMBRE_DEL_SISTEMA ."usuario"]   = NULL;
      $_SESSION[ $NOMBRE_DEL_SISTEMA ."idusuario"] = NULL;
      #session_destroy();
      #En caso de no querer salir se evalua la petición de acceso con las variables enviadas.
    } else {
      #Acá se busca en el archivo de configuración las credenciales del administrador del núcleo
      include "./sistema/configuracion/sistema.php";
      $usuario = $_REQUEST["usuario"];
      $clave   = $_REQUEST["clave"];
      #La clave se transforma con el algoritmo MD5 de PHP esto puede cambiar a futuro por un SHA1 u otro
      #modificando este código donde dice md5($clave) por sha1($clave) u otra función, aca se comprueba sí
      #el usuario que se ha enviado es el que está en el fichero de configuración, por lo que hay que
      #procurar no crear nunca un usuario igual al del archivo de configuración en nombre y clave.
      if ( $USUARIO_ADMINISTRADOR == $usuario && $CLAVE_DE_ADMINISTRADOR == md5 ( $clave) ) {
        $_SESSION[ $NOMBRE_DEL_SISTEMA ."ingreso"]   = "autenticado";
        $_SESSION[ $NOMBRE_DEL_SISTEMA ."usuario"]   = "administrador";
        $_SESSION[ $NOMBRE_DEL_SISTEMA ."idusuario"] = "0";
        $resultado = TRUE;
      } else {
        #En caso de que no sea igual al usuario de la configuración se procede a la búsuqeda en la base
        #de datos para encontrar el usuario y su identificador.
        $conexion = conectar ();
        $sql = "
          select
            *
          from
            usuario
          where
            nombre = '$usuario'          and
            clave  = '". md5($clave) ."'
        ";
        $buscar = consultar ( $sql , $conexion );
        #Sí la búsqueda es efectiva, es porque encontró al usuario con la clave que por cierto es otro
        #lugar donde se debería cambiar md5($clave) por el algoritmo que se desee.
        if ( $buscar ) {
          $_SESSION[ $NOMBRE_DEL_SISTEMA ."ingreso"]   = "autenticado";
          $_SESSION[ $NOMBRE_DEL_SISTEMA ."usuario"]   = "$usuario";
          $_SESSION[ $NOMBRE_DEL_SISTEMA ."idusuario"] = $buscar[0]['idusuario'];
          $resultado = TRUE;
        }
      }
    }
    return $resultado;
  }

  #Esta funcion espera a ser remplazada en el futuro... mas al no seguri patrones MVC permanecerá acá
  #Simplemente construye el menú de administración del núcleo, lo que compete a usuarios roles y permisos
  function colocar_menu_administrador() {
    include "./sistema/configuracion/sistema.php";
    #Valida si existe una sesión de usuario
    if ( isset( $_SESSION[ $NOMBRE_DEL_SISTEMA ."usuario"] ) ) {
      #Verifica que el usuario sea el administrador, esto puede ser conflicto aún si el usuario se llama
      #administrador por lo que se comprueba tambien el identificador, lo cual podría ser problema también.
      if ( $_SESSION[ $NOMBRE_DEL_SISTEMA ."usuario"] == "administrador" && $_SESSION[ $NOMBRE_DEL_SISTEMA ."idusuario"] == "0") {
        if ( existe_conexion() ){
          incluir_archivo("./sistema/nucleo/menu-administracion.php");
        }
      }
    }
  }

  #El siguiente procedimiento construye un menu con <ul> y <li> para los usuarios.
  #fue el rescate de una vieja serendipia por lo que no lo he documentado bien.
  function crear_menu() {
    include "./sistema/configuracion/sistema.php";
    $conexion = conectar ();
    $idusuario = $_SESSION[ $NOMBRE_DEL_SISTEMA ."idusuario"];
    /** Vieja sentencia
    $sql = "
      select
        *
      from
        menu
      order by
        orden
    ";
    */
    $sql = "
      select
        menu.idmenu,
        orden,
        nivel,
        opcion,
        imagen,
        url,
        menu.descripcion
      from
        usuario,
        rol,
        usuario_juega_rol,
        rol_accede_menu,
        menu
      where
        usuario.idusuario      = $idusuario                  and
        usuario.idusuario      = usuario_juega_rol.idusuario and
        rol.idrol              = usuario_juega_rol.idrol     and
        rol.idrol              = rol_accede_menu.idrol       and
        rol_accede_menu.idmenu = menu.idmenu
      order by
        orden
    ";
    $elementos = consultar ( $sql , $conexion );
    $nivel_anterior = - 1;
    for ( $i = 0 ; $i < count( $elementos ) ; $i++) {
        if ( $elementos[ $i ][ 'url' ] != '#' ) {
            $elemento  = "\n<a href='?contenido=".$elementos[ $i ][ 'url' ]."'>\n";
        } else {
            $elemento  = "\n<a href='#'>\n";
        }
        $elemento .= "\n<img src='".$elementos[ $i ][ 'imagen' ]."' />\n";
        $elemento .= "\n".$elementos[ $i ][ 'opcion' ]."\n";
        $elemento .= "\n</a>\n";
        $ubicado = $nivel_anterior - $elementos[ $i ][ 'nivel' ];
        if ( $ubicado == 0 ) {
            echo "\n</li>\n<li>\n$elemento\n";
        }
        if ( $ubicado < 0 ) {
            echo "\n<ul>\n<li>\n$elemento\n";
        }
        if ( $ubicado > 0 ) {
            if ( $elementos[ $i ][ 'nivel' ] == 1 ) {
                for ( $j = 0 ; $j < $ubicado ; $j++ ) {
                    echo "\n</li>\n</ul>\n";
                }
                echo "\n</li>\n<li>\n$elemento\n";
            } else {
                for ( $j = 0 ; $j <= $ubicado ; $j++ ) {
                    echo "\n</li>\n</ul>\n";
                }
                echo "\n<ul>\n<li>\n$elemento\n";
            }
        }
        $nivel_anterior = $elementos[ $i ][ 'nivel' ] ;
    }
    $ubicado = $nivel_anterior - 0;
    for ( $j = 0 ; $j <= $ubicado ; $j++ ) {
        echo "\n</li>\n</ul>\n";
    }
  }

  function evaluar_contenido() {
    include "./sistema/configuracion/sistema.php";
    if ( isset( $_REQUEST["orden_de_ingreso"] ) ) {
      if ( entrar_salir( $_REQUEST["orden_de_ingreso"] ) != TRUE ) {
        $_REQUEST["contenido"] = "./sistema/nucleo/autenticacion.php";
      }
    }
    if ( isset( $_SESSION[ $NOMBRE_DEL_SISTEMA ."usuario"] ) ) {
      if ( !isset( $_REQUEST["contenido"] ) ) {
        if ( $_SESSION[ $NOMBRE_DEL_SISTEMA ."usuario"] == "administrador" ) {
          # Sí no existe conexíón a la base, en su primera apretura deberá mostrar la pantalla que
          # permita la edición del archivo de configuración del sistema
          if ( existe_conexion() ) {
            $_REQUEST["contenido"] = "./sistema/nucleo/administracion-principal.php";
          } else {
            $_REQUEST["contenido"] = "./sistema/nucleo/administracion-configurar-sistema.php";
          }
        } else {
          $_REQUEST["contenido"] = "./sistema/nucleo/contenido-principal.php";
        }
      } else {
        $contenido = str_replace( "../", "", $_REQUEST["contenido"] );
        if ( $_SESSION[ $NOMBRE_DEL_SISTEMA ."usuario"] == "administrador" ) {
          switch ( $contenido ) {
              case "administracion-usuarios":
                $_REQUEST["contenido"] = "./sistema/nucleo/administracion-usuarios.php";
                break;
              case "administracion-roles":
                $_REQUEST["contenido"] = "./sistema/nucleo/administracion-roles.php";
                break;
              case "administracion-asignaciones":
                $_REQUEST["contenido"] = "./sistema/nucleo/administracion-asignaciones.php";
                break;
              case "administracion-menues":
                $_REQUEST["contenido"] = "./sistema/nucleo/administracion-menues.php";
                break;
              case "administracion-permisos":
                $_REQUEST["contenido"] = "./sistema/nucleo/administracion-permisos.php";
                break;
              case "administracion-recursos":
                $_REQUEST["contenido"] = "./sistema/nucleo/administracion-recursos.php";
                break;
              case "administracion-imagenes":
                $_REQUEST["contenido"] = "./sistema/nucleo/administracion-imagenes.php";
                break;
              case "administracion-aplicaciones":
                $_REQUEST["contenido"] = "./sistema/nucleo/administracion-aplicaciones.php";
                break;
              case "administracion-configurar-sistema":
                $_REQUEST["contenido"] = "./sistema/nucleo/administracion-configurar-sistema.php";
                break;
              default:
                $_REQUEST["contenido"] = "./sistema/nucleo/administracion-principal.php";
                break;
          }
        } else {
          $idusuario = $_SESSION[ $NOMBRE_DEL_SISTEMA ."idusuario"];
          $contenido = $_REQUEST["contenido"];
          $conexion = conectar ();
          $sql = "
            select
              menu.idmenu,
              orden,
              nivel,
              opcion,
              imagen,
              url,
              menu.descripcion
            from
              usuario,
              rol,
              usuario_juega_rol,
              rol_accede_menu,
              menu
            where
              usuario.idusuario      = $idusuario                  and
              usuario.idusuario      = usuario_juega_rol.idusuario and
              rol.idrol              = usuario_juega_rol.idrol     and
              rol.idrol              = rol_accede_menu.idrol       and
              rol_accede_menu.idmenu = menu.idmenu                 and
              url                    = '$contenido'
          ";
          $resultado = consultar ( $sql , $conexion );
          if ( !$resultado ) {
            $_REQUEST["contenido"] = "./sistema/nucleo/acceso-prohibido.php";
          } else {
            $_REQUEST["contenido"] = "./sistema/aplicaciones/$contenido";
          }
        }
      }
    } else {
      $_REQUEST["contenido"] = "./sistema/nucleo/autenticacion.php";
    }
  }

?>

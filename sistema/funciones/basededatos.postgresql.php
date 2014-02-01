<?php
  /**
    Se espera que el sql de postgres constructor del nucleo sea así:

    DROP TABLE rol_accede_aplicacion;
    DROP TABLE usuario_juega_rol;
    DROP TABLE menu;
    DROP TABLE usuario;
    DROP TABLE rol;

    CREATE TABLE rol (
      idrol serial   NOT NULL ,
      nombre TEXT   NOT NULL UNIQUE ,
      descripcion TEXT   NOT NULL   ,
    PRIMARY KEY(idrol));

    CREATE TABLE usuario (
      idusuario serial   NOT NULL ,
      nombre TEXT   NOT NULL UNIQUE ,
      clave TEXT   NOT NULL   ,
    PRIMARY KEY(idusuario));

    CREATE TABLE menu (
      idmenu serial   NOT NULL ,
      orden INTEGER   NOT NULL   ,
      nivel INTEGER   NOT NULL ,
      opcion TEXT   NOT NULL UNIQUE,
      imagen TEXT   NOT NULL ,
      url TEXT  NOT NULL,
      descripcion TEXT   NOT NULL ,
    PRIMARY KEY(idmenu));

    CREATE TABLE usuario_juega_rol (
      idusuario serial   NOT NULL ,
      idrol serial   NOT NULL   ,
    PRIMARY KEY(idusuario, idrol)    ,
      FOREIGN KEY(idusuario)
        REFERENCES usuario(idusuario),
      FOREIGN KEY(idrol)
        REFERENCES rol(idrol));

    CREATE INDEX usuario_juega_rol_FKIndex1 ON usuario_juega_rol (idusuario);
    CREATE INDEX usuario_juega_rol_FKIndex2 ON usuario_juega_rol (idrol);

    CREATE INDEX IFK_juega ON usuario_juega_rol (idusuario);
    CREATE INDEX IFK_incluido ON usuario_juega_rol (idrol);

    CREATE TABLE rol_accede_menu (
      idrol serial   NOT NULL ,
      idmenu serial   NOT NULL   ,
    PRIMARY KEY(idrol, idmenu)    ,
      FOREIGN KEY(idrol)
        REFERENCES rol(idrol),
      FOREIGN KEY(idmenu)
        REFERENCES menu(idmenu));

    CREATE INDEX rol_accede_menu_FKIndex1 ON rol_accede_menu (idrol);
    CREATE INDEX rol_accede_menu_FKIndex2 ON rol_accede_menu (idmenu);

    CREATE INDEX IFK_accede ON rol_accede_menu (idrol);
    CREATE INDEX IFK_permitido ON rol_accede_menu (idmenu);
  **/

  function conectar() {
    include "sistema/configuracion/sistema.php";
    $parametros  = "host='$SERVIDOR_DE_BASE_DE_DATOS' ";
    $parametros .= "port='5432' ";
    $parametros .= "dbname='$BASE_DE_DATOS' ";
    $parametros .= "user='$USUARIO_DE_BASE_DE_DATOS' ";
    $parametros .= "password='$CLAVE_DE_BASE_DE_DATOS'";
    $conexion = @ pg_connect( $parametros );
    if ( !$conexion ) {
      echo "<br>No se pudo establecer la conexi&oacute;n a la base de datos<br>";
    }
    return $conexion;
  };

  function existe_conexion () {
    include "sistema/configuracion/sistema.php";
    $parametros  = "host='$SERVIDOR_DE_BASE_DE_DATOS' ";
    $parametros .= "port='5432' ";
    $parametros .= "dbname='$BASE_DE_DATOS' ";
    $parametros .= "user='$USUARIO_DE_BASE_DE_DATOS' ";
    $parametros .= "password='$CLAVE_DE_BASE_DE_DATOS'";
    $conexion = @ pg_connect( $parametros );
    if ( $conexion ) {
      $resultado = TRUE;
      pg_close( $conexion );
    } else {
      $resultado = FALSE;
    }
    return $resultado;
  }

  function consultar( $sql , $conexion ){
    $resultado = array();
    if ( $conexion ) {
      $consulta = @ pg_query( $conexion, $sql );
      if ( $consulta ) {
        while ( $fila = pg_fetch_array( $consulta ) ) {
            $resultado[] = $fila;
        }
      } else {
        # Esta parte la hice para depurado, comentar esta linea si no se desea ver los resultados
        # echo "<br>No se ejecuto la sentencia <br><pre>$sql</pre> <br>";
      }
    } else {
      echo "<br>No hay conexi&oacute;n<br>";
    }
    return $resultado;
  }

  function ejecutar( $sql , $conexion ){
    $resultado = FALSE;
    if ( $conexion ) {
      $consulta = @ pg_query( $conexion, htmlentities($sql) );
      if ( $consulta ) {
        $resultado = TRUE;
      } else {
        # Esta parte la hice para depurado, comentar esta linea si no se desea ver los resultados
        # echo "<br>No se ejecuto la sentencia <br><pre>$sql</pre> <br>";
      }
    } else {
      echo "<br>No hay conexi&oacute;n<br>";
    }
    return $resultado;
  }

  function construir_base_de_datos () {
    $conexion = conectar();
    if ( $conexion ) {
      /**
        Se excluyen las siguientes instrucciones para que en su primera ejecución se limpia.
        En un futuro podrá existir una función para eliminar estas tablas.

        DROP TABLE rol_accede_aplicacion;
        DROP TABLE usuario_juega_rol;
        DROP TABLE menu;
        DROP TABLE usuario;
        DROP TABLE rol;
      */
      $sql = "
        CREATE TABLE rol (
          idrol serial   NOT NULL ,
          nombre TEXT   NOT NULL UNIQUE ,
          descripcion TEXT   NOT NULL   ,
        PRIMARY KEY(idrol));

        CREATE TABLE usuario (
          idusuario serial   NOT NULL ,
          nombre TEXT   NOT NULL UNIQUE ,
          clave TEXT   NOT NULL   ,
        PRIMARY KEY(idusuario));

        CREATE TABLE menu (
          idmenu serial   NOT NULL ,
          orden INTEGER   NOT NULL   ,
          nivel INTEGER   NOT NULL ,
          opcion TEXT   NOT NULL UNIQUE,
          imagen TEXT   NOT NULL ,
          url TEXT  NOT NULL,
          descripcion TEXT   NOT NULL ,
        PRIMARY KEY(idmenu));

        CREATE TABLE usuario_juega_rol (
          idusuario serial   NOT NULL ,
          idrol serial   NOT NULL   ,
        PRIMARY KEY(idusuario, idrol)    ,
          FOREIGN KEY(idusuario)
            REFERENCES usuario(idusuario),
          FOREIGN KEY(idrol)
            REFERENCES rol(idrol));

        CREATE INDEX usuario_juega_rol_FKIndex1 ON usuario_juega_rol (idusuario);
        CREATE INDEX usuario_juega_rol_FKIndex2 ON usuario_juega_rol (idrol);

        CREATE INDEX IFK_juega ON usuario_juega_rol (idusuario);
        CREATE INDEX IFK_incluido ON usuario_juega_rol (idrol);

        CREATE TABLE rol_accede_menu (
          idrol serial   NOT NULL ,
          idmenu serial   NOT NULL   ,
        PRIMARY KEY(idrol, idmenu)    ,
          FOREIGN KEY(idrol)
            REFERENCES rol(idrol),
          FOREIGN KEY(idmenu)
            REFERENCES menu(idmenu));

        CREATE INDEX rol_accede_menu_FKIndex1 ON rol_accede_menu (idrol);
        CREATE INDEX rol_accede_menu_FKIndex2 ON rol_accede_menu (idmenu);

        CREATE INDEX IFK_accede ON rol_accede_menu (idrol);
        CREATE INDEX IFK_permitido ON rol_accede_menu (idmenu);
      ";
      $resultado = ejecutar( $sql, $conexion );
      if ( !$resultado ) {
        echo "
          <br>
            El gui&oacute;n de creaci&oacute;n de la base de datos <b>no</b> se ejecut&oacute; correctamente, por favor revise lospar&aacute;metros brindados en la configuraci&oacute;n y el estado de la base de datos.
          <br>
        ";
      }
    } else {
      echo "<br>No hay conexi&oacute;n <br>";
    }
  }

?>
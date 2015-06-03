<?php
  /**
    Se espera que el sql de sqlite constructor del nucleo sea así:

    CREATE TABLE rol (
            idrol integer not null PRIMARY KEY,
            nombre text NOT NULL UNIQUE ,
            descripcion TEXT NOT NULL
        );
        
        CREATE TABLE usuario (
            idusuario integer not null PRIMARY KEY,
            nombre TEXT NOT NULL UNIQUE ,
            clave TEXT NOT NULL
        );
        
        CREATE TABLE menu (
            idmenu integer not null PRIMARY KEY,
            orden INTEGER NOT NULL   ,
            nivel INTEGER NOT NULL ,
            opcion TEXT NOT NULL UNIQUE,
            imagen TEXT NOT NULL ,
            url TEXT NOT NULL,
            descripcion TEXT NOT NULL
        );
        
        CREATE TABLE usuario_juega_rol (
            idusuario INTEGER NOT NULL ,
            idrol INTEGER NOT NULL ,
            FOREIGN KEY(idusuario) REFERENCES usuario(idusuario),
            FOREIGN KEY(idrol) REFERENCES rol(idrol) ,
            primary key (idusuario, idrol)
        );

        CREATE TABLE rol_accede_menu (
            idrol integer NOT NULL,
            idmenu integer NOT NULL,
            FOREIGN KEY(idrol) REFERENCES rol(idrol),
            FOREIGN KEY(idmenu) REFERENCES menu(idmenu),
            PRIMARY KEY(idrol, idmenu)
        );
  **/

  function conectar() {
    include "sistema/configuracion/sistema.php";
    $archivo = "./sistema/base/" . $SERVIDOR_DE_BASE_DE_DATOS . ".db" ;
    try {
        $conexion = @ new SQLite3( $archivo , SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE , "$USUARIO_DE_BASE_DE_DATOS $CLAVE_DE_BASE_DE_DATOS" );
    } catch  ( Exception $e ) {
        $conexion = NULL ;
    }
    if ( !$conexion ) {
        echo "<br>No se pudo establecer la conexi&oacute;n a la base de datos<br>";
    } else {
        $conexion->exec('PRAGMA foreign_keys = ON;');
    }
    return $conexion;
  };

  function existe_conexion () {
    include "sistema/configuracion/sistema.php";
    $archivo = "./sistema/base/" . $SERVIDOR_DE_BASE_DE_DATOS . ".db" ;
    if ( !file_exists( $archivo ) ) {
        $conexion = NULL ;
    } else {
        try {
            $conexion = @ new SQLite3( $archivo , SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE , "$USUARIO_DE_BASE_DE_DATOS $CLAVE_DE_BASE_DE_DATOS" );
        } catch  ( Exception $e ) {
            $conexion = NULL ;
        }
    }
    if ( $conexion ) {
        $resultado = TRUE;
    } else {
        $resultado = FALSE;
    }
    return $resultado;
  }

  function consultar( $sql , $conexion ){
    $resultado = array();
    if ( $conexion ) {
        $consulta = @ $conexion->query( $sql );
        if ( $consulta ) {
            while ( $fila = $consulta->fetchArray( ) ) {
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
        $consulta = @ $conexion->exec( htmlentities($sql) );
        if ( $consulta ) {
            $resultado = TRUE;
        } else {
            # Esta parte la hice para depurado, comentar esta linea si no se desea ver los resultados
            echo "<br>No se ejecuto la sentencia <br><pre>$sql</pre> <br>";
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
                idrol integer not null PRIMARY KEY,
                nombre text NOT NULL UNIQUE ,
                descripcion TEXT NOT NULL
            );
            
            CREATE TABLE usuario (
                idusuario integer not null PRIMARY KEY,
                nombre TEXT NOT NULL UNIQUE ,
                clave TEXT NOT NULL
            );
            
            CREATE TABLE menu (
                idmenu integer not null PRIMARY KEY,
                orden INTEGER NOT NULL   ,
                nivel INTEGER NOT NULL ,
                opcion TEXT NOT NULL UNIQUE,
                imagen TEXT NOT NULL ,
                url TEXT NOT NULL,
                descripcion TEXT NOT NULL
            );
            
            CREATE TABLE usuario_juega_rol (
                idusuario INTEGER NOT NULL ,
                idrol INTEGER NOT NULL ,
                FOREIGN KEY(idusuario) REFERENCES usuario(idusuario),
                FOREIGN KEY(idrol) REFERENCES rol(idrol) ,
                primary key (idusuario, idrol)
            );

            CREATE TABLE rol_accede_menu (
                idrol integer NOT NULL,
                idmenu integer NOT NULL,
                FOREIGN KEY(idrol) REFERENCES rol(idrol),
                FOREIGN KEY(idmenu) REFERENCES menu(idmenu),
                PRIMARY KEY(idrol, idmenu)
            );
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

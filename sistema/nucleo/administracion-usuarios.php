<?php
  $conexion = conectar ();
  if ( isset( $_REQUEST["accion"] ) ) {
    $accion = $_REQUEST["accion"];
  } else {
    $accion = "";
    $nombre = "";
    $clave  = "";
  }
  $confirmacion = "
    <input type='hidden' name='accion' value='Agregar' />
    <button type='submit' class='success' >
    <img class='icono' src='./recursos/imagenes/agregar usuario.png' title='Agregar usuario' />
    </button>
  \n";
  if ( $accion == "preModificar" or $accion == "preEliminar") {
    $idusuario = $_REQUEST["idusuario"];
    $sql = "
      select
        *
      from
        usuario
      where
        idusuario = $idusuario
    ";
    $buscar = consultar ( $sql , $conexion );
    $nombre = $buscar[0]['nombre'];
    $clave  = $buscar[0]['clave'];
  }
  switch( $accion ){
    case "preModificar":
      $confirmacion = "
        <input type='hidden' name='idusuario' value='$idusuario' />
        <input type='hidden' name='accion' value='Modificar' />
        <button type='submit' class='warning'>
        <img class='icono' src='./recursos/imagenes/modificar usuario.png' title='Modificar usuario' />
        </button>
      \n";
      break;
    case "preEliminar":
      $confirmacion = "
        <input type='hidden' name='idusuario' value='$idusuario' />
        <input type='hidden' name='accion' value='Eliminar' />
        <button type='submit' class='error'>
        <img class='icono' src='./recursos/imagenes/eliminar usuario.png' title='Eliminar usuario' />
        </button>
      \n";
      break;
    case "Modificar":
      $nombre    = $_REQUEST["nombre"];
      $clave     = $_REQUEST["clave"];
      $idusuario = $_REQUEST["idusuario"];
      if ( $nombre && $clave && $idusuario) {
        $clave = md5 ( $clave );
        $sql = "
          update
            usuario
          set
            nombre = '$nombre',
            clave  = '$clave'
          where
            idusuario = $idusuario
        ";
        $respuesta = ejecutar( $sql , $conexion );
      } else {
        $respuesta = FALSE;
      }
      break;
    case "Eliminar":
      $idusuario = $_REQUEST["idusuario"];
      if ( $idusuario) {
        $sql = "
          delete from
            usuario
          where
            idusuario = $idusuario
        ";
        $respuesta = ejecutar( $sql , $conexion );
      } else {
        $respuesta = FALSE;
      }
      break;
    case "Agregar":
      $nombre = $_REQUEST["nombre"];
      $clave  = $_REQUEST["clave"];
      if ( $nombre && $clave ) {
        $clave = md5 ( $clave );
        $sql = "
          insert into
            usuario (
              nombre ,
              clave
            )
          values (
            '$nombre' ,
            '$clave'
          )
        ";
        $respuesta = ejecutar( $sql , $conexion );
      } else {
        $respuesta = FALSE;
      }
      break;
  }

  if ( $accion == "Agregar" || $accion == "Modificar" || $accion == "Eliminar" ) {
    $nombre = "";
    $clave  = "";
    if ( !$respuesta ) {
      echo "
        <h3>
          No se pudo $accion el usuario.
        </h3>
        <script language='JavaScript'>
            ponerError('No se pudo $accion el usuario.');
        </script>
      \n";
    }
  }
?>

<h2>
  Administraci&oacute;n de los Usuarios
</h2>
<form action="./" method="post">
  <input type="hidden" name="contenido" value="administracion-usuarios" />
  <center>
    <div class='card color-contenido flex two five-500'>
        <div>
            <label class='derecho'>
                Usuario
            </label>
        </div>
        <div>
            <input type="text" value="<?php echo $nombre ?>" name="nombre" id="nombre"/>
            <script language='JavaScript'>
                validaNombreUsuario( 'nombre' );
            </script>
        </div>
        <div>
            <label class='derecho'>
                Clave
            </label>
        </div>
        <div>
            <input type="password" value="<?php echo $clave ?>" name="clave" id="clave"/>
            <script language='JavaScript'>
                validaClave ( 'clave' );
            </script>
        </div>
        <div>
            <?php echo $confirmacion ?>
        </div>
    </div>
  </center>
</form>

<hr/>

<center>
  <table border="1">
    <thead>
        <tr>
          <th>
            No.
          </th>
          <th>
            Usuario
          </th>
          <th>
            Clave
          </th>
          <th>
            Modificar
          </th>
          <th>
            Eliminar
          </th>
          <th>
            Asignar Rol
          </th>
        </tr>
     </thead>
     <tbody>
    <?php
      $sql = "
        select
          *
        from
          usuario
        order by
          nombre
      ";
      $lista = consultar ( $sql , $conexion );
      for ( $i = 0 ; $i < count( $lista ) ; $i++) {
        echo "
          <tr>
            <td>
              " . ( $i + 1 ) . "
            </td>
            <td>
              " . $lista[$i]['nombre'] . "
            </td>
            <td>
              " . $lista[$i]['clave'] . "
            </td>
            <td>
              <form action='./' method='post'>
                <input type='hidden' name='contenido' value='administracion-usuarios' />
                <input type='hidden' name='idusuario' value='" . $lista[$i]['idusuario'] . "' />
                <input type='hidden' name='accion' value='preModificar' />
                <button type='sumbit' class='warning'>
                <img class='icono' src='./recursos/imagenes/modificar usuario.png' title='Modificar usuario' />
                </button>
              </form>
            </td>
            <td>
              <form action='./' method='post'>
                <input type='hidden' name='contenido' value='administracion-usuarios' />
                <input type='hidden' name='idusuario' value='" . $lista[$i]['idusuario'] . "' />
                <input type='hidden' name='accion' value='preEliminar' />
                <button type='submit' class='error'>
                <img class='icono' src='./recursos/imagenes/eliminar usuario.png' title='Eliminar usuario' />
                </button>
              </form>
            </td>
            <td>
              <form action='./' method='post'>
                <input type='hidden' name='contenido' value='administracion-asignaciones' />
                <input type='hidden' name='idusuario' value='" . $lista[$i]['idusuario'] . "' />
                <input type='hidden' name='accion' value='seleccion' />
                <button type='submit' class='success'>
                <img class='icono' src='./recursos/imagenes/credencial.png' title='Asignar Rol' />
                </button>
              </form>
            </td>
          </tr>
        \n";
      }
    ?>
    <tbody>
  </table>
</center>
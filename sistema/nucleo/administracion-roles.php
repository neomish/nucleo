<?php
  $conexion = conectar ();
  if ( isset( $_REQUEST["accion"] ) ) {
    $accion = $_REQUEST["accion"];
  } else {
    $accion       = "";
    $nombre       = "";
    $descripcion  = "";
  }
  $confirmacion = "
    <input type='hidden' name='accion' value='Agregar' />
    <input type='image' src='./recursos/imagenes/agregar rol.png' title='Agregar rol' />
  \n";
  if ( $accion == "preModificar" or $accion == "preEliminar") {
    $idrol = $_REQUEST["idrol"];
    $sql = "
      select
        *
      from
        rol
      where
        idrol = $idrol
    ";
    $buscar       = consultar ( $sql , $conexion );
    $nombre       = $buscar[0]['nombre'];
    $descripcion  = $buscar[0]['descripcion'];
  }
  switch( $accion ){
    case "preModificar":
      $confirmacion = "
        <input type='hidden' name='idrol' value='$idrol' />
        <input type='hidden' name='accion' value='Modificar' />
        <input type='image' src='./recursos/imagenes/modificar rol.png' title='Modificar rol' />
      \n";
      break;
    case "preEliminar":
      $confirmacion = "
        <input type='hidden' name='idrol' value='$idrol' />
        <input type='hidden' name='accion' value='Eliminar' />
        <input type='image' src='./recursos/imagenes/eliminar rol.png' title='Eliminar rol' />
      \n";
      break;
    case "Modificar":
      $nombre      = $_REQUEST["nombre"];
      $descripcion = $_REQUEST["descripcion"];
      $idrol       = $_REQUEST["idrol"];
      if ( $nombre && $descripcion && $idrol) {
        $descripcion = $descripcion;
        $sql = "
          update
            rol
          set
            nombre       = '$nombre',
            descripcion  = '$descripcion'
          where
            idrol = $idrol
        ";
        $respuesta = ejecutar( $sql , $conexion );
      } else {
        $respuesta = FALSE;
      }
      break;
    case "Eliminar":
      $idrol = $_REQUEST["idrol"];
      if ( $idrol) {
        $sql = "
          delete from
            rol
          where
            idrol = $idrol
        ";
        $respuesta = ejecutar( $sql , $conexion );
      } else {
        $respuesta = FALSE;
      }
      break;
    case "Agregar":
      $nombre       = $_REQUEST["nombre"];
      $descripcion  = $_REQUEST["descripcion"];
      if ( $nombre && $descripcion ) {
        $descripcion = $descripcion;
        $sql = "
          insert into
            rol (
              nombre ,
              descripcion
            )
          values (
            '$nombre' ,
            '$descripcion'
          )
        ";
        $respuesta = ejecutar( $sql , $conexion );
      } else {
        $respuesta = FALSE;
      }
      break;
  }

  if ( $accion == "Agregar" || $accion == "Modificar" || $accion == "Eliminar" ) {
    $nombre       = "";
    $descripcion  = "";
    if ( !$respuesta ) {
      echo "
        <h3>
          No se pudo $accion el rol.
        </h3>
        <script language='JavaScript'>
            ponerError('No se pudo $accion el rol.');
        </script>
      \n";
    }
  }
?>
<h2>
  Administraci&oacute;n de los roles
</h2>
<form action="./" method="post">
  <input type="hidden" name="contenido" value="administracion-roles" />
  <center>
    <table>
      <tr>
        <td>
          rol
        </td>
        <td>
          <input type="text" value="<?php echo $nombre ?>" name="nombre" id="nombre"/>
          <script language='JavaScript'>
            validaRequerido( 'nombre' );
          </script>
        </td>
        <td>
        </td>
      <tr>
      </tr>
        <td>
          descripci&oacute;n
        </td>
        <td>
          <textarea name="descripcion" cols="40" rows="4" id="descripcion"><?php echo $descripcion ?></textarea>
          <script language='JavaScript'>
            colocarEditor ( 'descripcion' );
            validaRequerido( 'descripcion' );
          </script>
        </td>
        <td>
          <?php echo $confirmacion ?>
        </td>
      </tr>
    </table>
  </center>
</form>

<hr/>

<center>
  <table border="1">
    <tr>
      <td>
        No.
      </td>
      <td>
        rol
      </td>
      <td>
        descripci&oacute;n
      </td>
      <td>
        Modificar
      </td>
      <td>
        Eliminar
      </td>
    </tr>
    <?php
      $sql = "
        select
          *
        from
          rol
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
              " . html_entity_decode( $lista[$i]['descripcion'] ) . "
            </td>
            <td>
              <form action='./' method='post'>
                <input type='hidden' name='contenido' value='administracion-roles' />
                <input type='hidden' name='idrol' value='" . $lista[$i]['idrol'] . "' />
                <input type='hidden' name='accion' value='preModificar' />
                <input type='image' src='./recursos/imagenes/modificar rol.png' title='Modificar rol' />
              </form>
            </td>
            <td>
              <form action='./' method='post'>
                <input type='hidden' name='contenido' value='administracion-roles' />
                <input type='hidden' name='idrol' value='" . $lista[$i]['idrol'] . "' />
                <input type='hidden' name='accion' value='preEliminar' />
                <input type='image' src='./recursos/imagenes/eliminar rol.png' title='Eliminar rol' />
              </form>
            </td>
          </tr>
        \n";
      }
    ?>
  </table>
</center>
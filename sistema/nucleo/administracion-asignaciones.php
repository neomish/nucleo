<?php
  $conexion = conectar ();
  $mostrar_listado = TRUE;
  if ( isset( $_REQUEST["accion"] ) ) {
    $accion = $_REQUEST["accion"] ;
    $idusuario = $_REQUEST["idusuario"] ;
    $mostrar_listado = FALSE;
    switch( $accion ){
      case "agregar":
        if ( isset( $_REQUEST["idrol"] ) ) {
          $idrol = $_REQUEST["idrol"];
          $sql = "
            insert into
              usuario_juega_rol (
                idusuario,
                idrol
              )
              values(
                $idusuario,
                $idrol
              )
          ";
          $respuesta = ejecutar( $sql , $conexion );
        } else {
          $respuesta = FALSE;
        }
        break;
      case "eliminar":
        if ( isset( $_REQUEST["idrol"] ) ) {
          $idrol = $_REQUEST["idrol"];
          $sql = "
            delete from
              usuario_juega_rol
            where
              idusuario = $idusuario and
              idrol = $idrol
          ";
          $respuesta = ejecutar( $sql , $conexion );
        } else {
          $respuesta = FALSE;
        }
        break;
      case "seleccion":
        $respuesta = TRUE;
        break;
    }
    if ( !$respuesta ) {
      echo "
        <h3>
          No se pudo $accion la asignaci&oacute;n del rol.
        </h3>
        <script language='JavaScript'>
            ponerError('No se pudo $accion la asignaci&oacute;n del rol.');
        </script>
      \n";
    }
  }
?>

<?php
if ( $mostrar_listado ){
?>
  <h2>
    Elecci&oacute;n de Usuario
  </h2>
  <center>
    <table border="1">
      <tr>
        <td>
          No.
        </td>
        <td>
          Usuario
        </td>
        <td>
          Asignar Rol
        </td>
      </tr>
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
                <form action='./' method='post'>
                  <input type='hidden' name='contenido' value='administracion-asignaciones' />
                  <input type='hidden' name='idusuario' value='" . $lista[$i]['idusuario'] . "' />
                  <input type='hidden' name='accion' value='seleccion' />
                  <input type='image' src='./recursos/imagenes/credencial.png' title='Asignar Rol' />
                </form>
              </td>
            </tr>
          \n";
        }
      ?>
    </table>
  </center>
<?php
} else {
  $sql = "
    select
      *
    from
      usuario
    where
      idusuario = $idusuario
  ";
  $buscar = consultar ( $sql , $conexion );
  $usuario = $buscar[0]['nombre'];
  $sql = "
    select
      *
    from
      rol
    order by
      nombre
  ";
  $buscar_roles = consultar ( $sql , $conexion );
  $sql = "
    select
      usuario.idusuario,
      usuario.nombre as nombre_usuario,
      rol.idrol,
      rol.nombre as nombre_rol
    from
      usuario,
      rol,
      usuario_juega_rol
    where
      usuario_juega_rol.idusuario = $idusuario and
      rol.idrol = usuario_juega_rol.idrol and
      usuario.idusuario = usuario_juega_rol.idusuario
    order by
      nombre_rol
  ";
  $buscar_asignaciones = consultar ( $sql , $conexion );
  $vector1 = array(  );
  $vector2 = array(  );
  for ( $i = 0 ; $i < count( $buscar_roles ) ; $i++) {
    $vector1[$buscar_roles[$i]['idrol']]=$buscar_roles[$i]['nombre'];
  }
  for ( $i = 0 ; $i < count( $buscar_asignaciones ) ; $i++) {
    $vector2[$buscar_asignaciones[$i]['idrol']]=$buscar_asignaciones[$i]['nombre_rol'];
  }
  $resultado = array_diff_assoc($vector1,$vector2);
?>
  <h2>
    Asignaci&oacute;n de roles a &lt;<?php echo $usuario;?>&gt;
  </h2>
  <table>
    <tr>
      <td>
        <h3>Roles</h3>
        <form action="./" method="post">
          <input type="hidden" name="contenido" value="administracion-asignaciones" />
          <input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>" />
          <select name="idrol" size="10" id="idrolA">
          <option selected="selected">Elija un rol...</option>
          <?php
              while ($valor = current($resultado)) {
                echo "
                  <option value='" . key($resultado) . "'>
                    " . $valor . "
                  </option>
                ";
                next($resultado);
              }
          ?>
          </select>
          <script language='JavaScript'>
            validaLista( 'idrolA' , 'Elija un rol...' );
          </script>
        </td>
        <td>
          Agregar Rol <br/>
          <input type="hidden" name="accion" value="agregar" />
          <input type="image" src="./recursos/imagenes/agregar.png" title="Agregar rol" />
        </form>
      </td>
      <td>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      </td>
      <td>
        <h3>Roles Asignados</h3>
        <form action="./" method="post">
          <input type="hidden" name="contenido" value="administracion-asignaciones" />
          <input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>" />
          <select name="idrol" size="10" id="idrolB">
          <option selected="selected">Elija un rol...</option>
          <?php
              for ( $i = 0 ; $i < count( $buscar_asignaciones ) ; $i++) {
                echo "
                  <option value='" . $buscar_asignaciones[$i]['idrol'] . "'>
                    " . $buscar_asignaciones[$i]['nombre_rol'] . "
                  </option>
                ";
              }
          ?>
          </select>
          <script language='JavaScript'>
            validaLista( 'idrolB' , 'Elija un rol...' );
          </script>
        </td>
        <td>
          Eliminar Rol <br/>
          <input type="hidden" name="accion" value="eliminar" />
          <input type="image" src="./recursos/imagenes/eliminar.png" title="Eliminar rol" />
        </form>
      </td>
    </tr>
  </table>
<?php
}
?>
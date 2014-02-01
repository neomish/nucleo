<?php
  $conexion = conectar ();
  $mostrar_listado = TRUE;
  if ( isset( $_REQUEST["accion"] ) ) {
    $accion = $_REQUEST["accion"] ;
    $idrol = $_REQUEST["idrol"] ;
    $mostrar_listado = FALSE;
    switch( $accion ){
      case "agregar":
        if ( isset( $_REQUEST["idmenu"] ) ) {
          $idmenu = $_REQUEST["idmenu"];
          $sql = "
            insert into
              rol_accede_menu (
                idrol,
                idmenu
              )
              values(
                $idrol,
                $idmenu
              )
          ";
          $respuesta = ejecutar( $sql , $conexion );
        } else {
          $respuesta = FALSE;
        }
        break;
      case "eliminar":
        if ( isset( $_REQUEST["idmenu"] ) ) {
          $idmenu = $_REQUEST["idmenu"];
          $sql = "
            delete from
              rol_accede_menu
            where
              idrol = $idrol and
              idmenu = $idmenu
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
          No se pudo $accion la asignaci&oacute;n de permiso al rol.
        </h3>
        <script language='JavaScript'>
            ponerError('No se pudo $accion la asignaci&oacute;n de permiso al rol.');
        </script>
      \n";
    }
  }
?>

<?php
if ( $mostrar_listado ){
?>
  <h2>
    Elecci&oacute;n de Rol
  </h2>
  <center>
    <table border="1">
      <tr>
        <td>
          No.
        </td>
        <td>
          Rol
        </td>
        <td>
          Asignar Permiso
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
                <form action='./' method='post'>
                  <input type='hidden' name='contenido' value='administracion-permisos' />
                  <input type='hidden' name='idrol' value='" . $lista[$i]['idrol'] . "' />
                  <input type='hidden' name='accion' value='seleccion' />
                  <input type='image' src='./recursos/imagenes/permisos.png' title='Asignar Permiso' />
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
      rol
    where
      idrol = $idrol
  ";
  $buscar = consultar ( $sql , $conexion );
  $rol = $buscar[0]['nombre'];
  $sql = "
    select
      *
    from
      menu
    order by
      orden
  ";
  $buscar_menues = consultar ( $sql , $conexion );
  $sql = "
    select
      rol.idrol,
      rol.nombre,
      menu.idmenu,
      menu.opcion,
      menu.url,
      menu.orden
    from
      rol,
      menu,
      rol_accede_menu
    where
      rol_accede_menu.idrol = $idrol and
      rol.idrol = rol_accede_menu.idrol and
      menu.idmenu = rol_accede_menu.idmenu
    order by
      menu.orden
  ";
  $buscar_permisos = consultar ( $sql , $conexion );
  $vector1 = array(  );
  $vector2 = array(  );
  for ( $i = 0 ; $i < count( $buscar_menues ) ; $i++) {
    $vector1[$buscar_menues[$i]['idmenu']]=$buscar_menues[$i]['opcion'];
  }
  for ( $i = 0 ; $i < count( $buscar_permisos ) ; $i++) {
    $vector2[$buscar_permisos[$i]['idmenu']]=$buscar_permisos[$i]['opcion'];
  }
  $resultado = array_diff_assoc($vector1,$vector2);
?>
  <h2>
    Asignaci&oacute;n de permisos al rol &lt;<?php echo $rol;?>&gt;
  </h2>
  <table>
    <tr>
      <td>
        <h3>Men&uacute;es</h3>
        <form action="./" method="post">
          <input type="hidden" name="contenido" value="administracion-permisos" />
          <input type="hidden" name="idrol" value="<?php echo $idrol; ?>" />
          <select name="idmenu" size="10" id="idmenuA">
          <option selected="selected">Elija un menu...</option>
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
            validaLista( 'idmenuA' , 'Elija un menu...' );
          </script>
        </td>
        <td>
          Agregar Men&uacute; <br/>
          <input type="hidden" name="accion" value="agregar" />
          <input type="image" src="./recursos/imagenes/agregar.png" title="Agregar men&uacute;" />
        </form>
      </td>
      <td>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      </td>
      <td>
        <h3>Men&uacute;es Permitidos</h3>
        <form action="./" method="post">
          <input type="hidden" name="contenido" value="administracion-permisos" />
          <input type="hidden" name="idrol" value="<?php echo $idrol; ?>" />
          <select name="idmenu" size="10" id="idmenuB">
          <option selected="selected">Elija un menu...</option>
          <?php
              for ( $i = 0 ; $i < count( $buscar_permisos ) ; $i++) {
                echo "
                  <option value='" . $buscar_permisos[$i]['idmenu'] . "'>
                    " . $buscar_permisos[$i]['opcion'] . "
                  </option>
                ";
              }
          ?>
          </select>
          <script language='JavaScript'>
            validaLista( 'idmenuB' , 'Elija un menu...' );
          </script>
        </td>
        <td>
          Eliminar Men&uacute; <br/>
          <input type="hidden" name="accion" value="eliminar" />
          <input type="image" src="./recursos/imagenes/eliminar.png" title="Eliminar men&uacute;" />
        </form>
      </td>
    </tr>
  </table>
<?php
}
?>
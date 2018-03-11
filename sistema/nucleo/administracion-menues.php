<?php
  $conexion = conectar ();
  if ( isset( $_REQUEST["accion"] ) ) {
    $accion = $_REQUEST["accion"];
  } else {
    $accion      = "";
    $orden       = "";
    $nivel       = "";
    $opcion      = "";
    $imagen      = "";
    $url         = "";
    $descripcion = "";
  }
  $confirmacion = "
    <input type='hidden' name='accion' value='Agregar' />
    <input type='image' src='./recursos/imagenes/agregar menu.png' title='Agregar men&uacute;' />
  \n";
  if ( $accion == "preModificar" or $accion == "preEliminar") {
    $idmenu = $_REQUEST["idmenu"];
    $sql = "
      select
        *
      from
        menu
      where
        idmenu = $idmenu
    ";
    $buscar      = consultar ( $sql , $conexion );
    $orden       = $buscar[0]['orden'];
    $nivel       = $buscar[0]['nivel'];
    $opcion      = $buscar[0]['opcion'];
    $imagen      = $buscar[0]['imagen'];
    $url         = $buscar[0]['url'];
    $descripcion = $buscar[0]['descripcion'];
  }
  switch( $accion ){
    case "preModificar":
      $confirmacion = "
        <input type='hidden' name='idmenu' value='$idmenu' />
        <input type='hidden' name='accion' value='Modificar' />
        <input type='image' src='./recursos/imagenes/modificar menu.png' title='Modificar men&uacute;' />
      \n";
      break;
    case "preEliminar":
      $confirmacion = "
        <input type='hidden' name='idmenu' value='$idmenu' />
        <input type='hidden' name='accion' value='Eliminar' />
        <input type='image' src='./recursos/imagenes/eliminar menu.png' name='accion' value='Eliminar' title='Eliminar men&uacute;' />
      \n";
      break;
    case "Modificar":
      $orden       = $_REQUEST['orden'];
      $nivel       = $_REQUEST['nivel'];
      $opcion      = $_REQUEST["opcion"];
      $imagen      = $_REQUEST["imagen"];
      $url         = $_REQUEST["url"];
      if ( !$url ) { $url = "#"; }
      $descripcion = $_REQUEST["descripcion"];
      $idmenu      = $_REQUEST["idmenu"];
      if ( $opcion && $descripcion && $idmenu) {
        $descripcion = $descripcion;
        $sql = "
          update
            menu
          set
            orden       = $orden,
            nivel       = $nivel,
            opcion      = '$opcion',
            imagen      = '$imagen',
            url         = '$url',
            descripcion = '$descripcion'
          where
            idmenu = $idmenu
        ";
        $respuesta = ejecutar( $sql , $conexion );
      } else {
        $respuesta = FALSE;
      }
      break;
    case "Eliminar":
      $idmenu = $_REQUEST["idmenu"];
      if ( $idmenu) {
        $sql = "
          delete from
            menu
          where
            idmenu = $idmenu
        ";
        $respuesta = ejecutar( $sql , $conexion );
      } else {
        $respuesta = FALSE;
      }
      break;
    case "Agregar":
      $orden       = $_REQUEST['orden'];
      $nivel       = $_REQUEST['nivel'];
      $opcion      = $_REQUEST["opcion"];
      $imagen      = $_REQUEST["imagen"];
      $url         = $_REQUEST["url"];
      if ( !$url ) { $url = "#"; }
      $descripcion = $_REQUEST["descripcion"];
      if ( $opcion && $descripcion ) {
        $descripcion = $descripcion;
        $sql = "
          insert into
            menu (
              orden ,
              nivel ,
              opcion ,
              imagen ,
              url ,
              descripcion
            )
          values (
            $orden ,
            $nivel ,
            '$opcion' ,
            '$imagen' ,
            '$url' ,
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
    $orden       = "";
    $nivel       = "";
    $opcion      = "";
    $imagen      = "";
    $url         = "";
    $descripcion = "";
    if ( !$respuesta ) {
      echo "
        <h3>
          No se pudo $accion el men&uacute;.
        </h3>
        <script language='JavaScript'>
            ponerError('No se pudo $accion el men&uacute;.');
        </script>
      \n";
    }
  }
?>

<h2>
  Administraci&oacute;n de los men&uacute;es
</h2>
<form action="./" method="post">
  <input type="hidden" name="contenido" value="administracion-menues" />
  <center>
    <table>
      <tr>
        <td>
          Orden
        </td>
        <td>
          <input type="text" value="<?php echo $orden ?>" name="orden" size='4' id="orden"/>
          <script language='JavaScript'>
            validaEnteros1( 'orden' );
          </script>
          Nivel
          <input type="text" value="<?php echo $nivel ?>" name="nivel" size='4' id="nivel"/>
          <script language='JavaScript'>
            validaEnteros0( 'nivel' );
          </script>
        </td>
        <td>
        </td>
      </tr>
      <tr>
        <td>
          Opci&oacute;n
        </td>
        <td>
          <input type="text" value="<?php echo $opcion ?>" name="opcion" id="opcion"/>
          <script language='JavaScript'>
            validaRequerido( 'opcion' );
          </script>
        </td>
        <td>
        </td>
      </tr>
      <tr>
        <td>
          Imagen
        </td>
        <td>
          <select id="imagen" name="imagen" onchange="document.getElementById('elIdDeLaImagen').src=this.options[this.selectedIndex].value">
            <option value="">- Elija una im&aacute;gen -</option>
            <?php
              $archivo = listar_directorio( './recursos/imagenes/' , array('png','gif','jpg','svg') );
              for ( $i = 0 ; $i < count ( $archivo ) ; $i++ ) {
                if ( $imagen == "$archivo[$i]" ) {
                  echo "
                    <option value='$archivo[$i]' selected='selected'>
                  \n";
                } else {
                  echo "
                    <option value='$archivo[$i]'>
                  \n";
                }

                echo "
                  " . substr(strrchr( $archivo[$i] , '/'), 1) . "
                  </option>
                \n";
              }
            ?>
          </select>
          <script language='JavaScript'>
            validaLista( 'imagen' , '- Elija una im&aacute;gen -' );
          </script>
          <img id="elIdDeLaImagen" alt="imagen" width="48" />
        </td>
        <td>
        </td>
      </tr>
      <tr>
        <td>
          Aplicaci&oacute;n
        </td>
        <td>
          <select name="url">
            <?php
              if ( $url == "" || $url == "#" ) {
            ?>
                <option value='#' selected='selected'>
                  #
                </option>
            <?php
              } else {
            ?>
                <option value='#'>
                  #
                </option>
            <?php
              }
                $archivo = listar_directorio( './sistema/aplicaciones/' , array('php') );
                for ( $i = 0 ; $i < count ( $archivo ) ; $i++ ) {
                  $solo_archivo = substr(strrchr( $archivo[$i] , '/'), 1) ;
                  if ( $url == $solo_archivo ) {
                    echo "
                      <option value='$solo_archivo' selected='selected'>
                    \n";
                  } else {
                    echo "
                      <option value='$solo_archivo'>
                    \n";
                  }
                  echo "
                      $solo_archivo
                    </option>
                  \n";
                }
            ?>
          </select>
        </td>
        <td>
        </td>
      </tr>
      <tr>
        <td>
          descripci&oacute;n
        </td>
        <td>
          <textarea id="descripcion" name="descripcion" cols="40" rows="4"><?php echo $descripcion ?></textarea>
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
        Orden
      </td>
      <td>
        Nivel
      </td>
      <td>
        Opci&oacute;n
      </td>
      <td>
        Imagen
      </td>
      <td>
        Aplicaci&oacute;n
      </td>
      <td>
        Descripci&oacute;n
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
          menu
        order by
          orden
      ";
      $lista = consultar ( $sql , $conexion );
      for ( $i = 0 ; $i < count( $lista ) ; $i++) {
        echo "
          <tr>
            <td>
              " . $lista[$i]['orden'] . "
            </td>
            <td>
              " . $lista[$i]['nivel'] . "
            </td>
            <td>
              " . $lista[$i]['opcion'] . "
            </td>
            <td>
              <img src='" . $lista[$i]['imagen'] . "' />
            </td>
            <td>
              " . $lista[$i]['url'] . "
            </td>
            <td>
              " . html_entity_decode( $lista[$i]['descripcion'] ) . "
            </td>
            <td>
              <form action='./' method='post'>
                <input type='hidden' name='contenido' value='administracion-menues' />
                <input type='hidden' name='idmenu' value='" . $lista[$i]['idmenu'] . "' />
                <input type='hidden' name='accion' value='preModificar' />
                <input type='image' src='./recursos/imagenes/modificar menu.png' title='Modificar men&uacute;' />
              </form>
            </td>
            <td>
              <form action='./' method='post'>
                <input type='hidden' name='contenido' value='administracion-menues' />
                <input type='hidden' name='idmenu' value='" . $lista[$i]['idmenu'] . "' />
                <input type='hidden' name='accion' value='preEliminar' />
                <input type='image' src='./recursos/imagenes/eliminar menu.png' title='Eliminar men&uacute;' />
              </form>
            </td>
          </tr>
        \n";
      }
    ?>
  </table>
</center>

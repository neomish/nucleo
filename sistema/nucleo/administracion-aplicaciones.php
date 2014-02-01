<?php
  $mensaje          = "";
  $ContenidoArchivo = "";
  $archivo          = "";
  if ( isset( $_REQUEST["accion"] ) ) {
    if ( $_REQUEST["accion"] == "SubirAplicacion" ) {
      # obtenemos los datos del archivo
      $tamano  = $_FILES["archivo"]['size'];
      $tipo    = $_FILES["archivo"]['type'];
      $archivo = $_FILES["archivo"]['name'];
      if ($archivo != "") {
        # guardamos el archivo a la carpeta correspondiente
        $destino = "";
        if ( substr( $archivo , -4) == ".php" ) {
          $destino =  "./sistema/aplicaciones/".$archivo;
        }
        if ( $destino ) {
          if ( copy( $_FILES['archivo']['tmp_name'],$destino ) ) {
            $mensaje="Archivo subido con &eacute;xito.";
          } else {
            $mensaje="No se pudo almacenar el archivo.";
          }
        } else {
          $mensaje="Archivo no v&aacute;lido.";
        }
        $archivo = "";
      } else {
        $mensaje="Error al subir el archivo.";
      }
    }
    if ( $_REQUEST["accion"] == "BorrarArchivo" ) {
      $archivo = str_replace( "../", "", $_REQUEST['archivo'] );
      if ( unlink($archivo) ) {
        $mensaje="Archivo borrado con &eacute;xito.";
      } else {
        $mensaje="No se pudo borrar el archivo.";
      }
      $archivo = "";
    }
    if ( $_REQUEST["accion"] == "GuardarArchivo" ) {
      if ( isset( $_REQUEST['archivo'] ) ) {
        if ( isset( $_REQUEST["ContenidoArchivo"] ) ) {
          $archivo          = str_replace( "../", "", $_REQUEST['archivo'] );
          $ContenidoArchivo = $_REQUEST["ContenidoArchivo"];
          $gestorArchivo    = @ fopen( "./sistema/aplicaciones/$archivo", "w");
          if ( @ fwrite ( $gestorArchivo, $ContenidoArchivo  ) ) {
            fclose ( $gestorArchivo );
            $mensaje="Archivo guardado con &eacute;xito.";
          } else {
            $mensaje="No se pudo guardar el archivo.";
          }
          $ContenidoArchivo = "";
          $archivo          = "";
        }
      }
    }
    if ( $_REQUEST["accion"] == "EditarArchivo" ) {
      if ( isset( $_REQUEST['archivo'] ) ) {
        $archivo          = str_replace( "../", "", $_REQUEST['archivo'] );
        $gestorArchivo    = @ fopen( "./sistema/aplicaciones/$archivo", "r");
        $ContenidoArchivo = @ fread( $gestorArchivo, filesize( "./sistema/aplicaciones/$archivo" ) );
        if ( $gestorArchivo ) {
           fclose($gestorArchivo);
         } else {
           $mensaje="No se pudo abrir el archivo: $archivo. ";
         }
      }
    }
  }
  if ( $mensaje ) {
    echo "
      <h3>
        $mensaje
      </h3>
      <script language='JavaScript'>
          ponerAviso('$mensaje');
      </script>
    \n";
  }
?>
<h2>
  Administraci&oacute;n de aplicaciones
</h2>
<table border="1" width="100%">
  <tr>
    <td width="50%">
      <h3>Subir</h3>
      Aplicaciones
    </td>
  </tr>
  <tr>
    <td>
      <form action="./" method="post" enctype="multipart/form-data">
        <input name="archivo" type="file" size="35" />
        <input name="accion" type="hidden" value="SubirAplicacion" />
        <input type="hidden" name="contenido" value="administracion-aplicaciones" />
        <input name="enviar" type="submit" value="Enviar" />
      </form>
    </td>
  </tr>
  <tr>
    <table>
      <tr>
        <td>
          <h3>Crear / Editar</h3>
          <script language="Javascript" type="text/javascript">
            // initialisation
            editAreaLoader.init({
                id: "ContenidoArchivo"
                ,start_highlight: true
                ,allow_resize: "both"
                ,allow_toggle: true
                ,word_wrap: true
                ,language: "es"
                ,syntax: "php"
            });
          </script>
          <form action="./" method="post">
            Nombre: <input type="text" name="archivo" id="archivo" value="<?php echo $archivo; ?>" size="50"><br/>
            Contenido :<br/>
            <textarea cols="120" rows="20" name="ContenidoArchivo" id="ContenidoArchivo"><?php
              echo $ContenidoArchivo;
            ?></textarea><br/>
            <input type="hidden" name="contenido" value="administracion-aplicaciones" />
            <input type="submit" name="accion" id="accion" value="GuardarArchivo" />
            <a href='./'><input type='button' name='cancelar' value='cancelar' /></a>
          </form>
        </td>
      </tr>
    </table>
  </tr>
  <tr>
    <td>
      <hr />
      <h2>Listado de aplicaciones disponibles</h2>
      <?php
        $archivo = listar_directorio( './sistema/aplicaciones/' , array('php') );
        for ( $i = 0 ; $i < count ( $archivo ) ; $i++ ) {
          echo "
            <a href='./?contenido=administracion--aplicaciones&accion=BorrarArchivo&archivo=$archivo[$i]' title='eliminar'>&nbsp;X&nbsp;</a>
            &nbsp;
            <a href='./?contenido=administracion-aplicaciones&accion=EditarArchivo&archivo=" . substr(strrchr( $archivo[$i] , '/'), 1) . " ' title='eliminar'>&nbsp;E&nbsp;</a>
            <img src='./recursos/imagenes/php.png' width='24'>
            $archivo[$i] <br/>
          \n";
        }
      ?>
    </td>
  </tr>
</table>

<?php
  $mensaje = "";
  if ( isset( $_REQUEST["accion"] ) ) {
    if ($_REQUEST["accion"] == "SubirImagen" || $_REQUEST["accion"] == "SubirAplicacion") {
      # obtenemos los datos del archivo
      $tamano  = $_FILES["archivo"]['size'];
      $tipo    = $_FILES["archivo"]['type'];
      $archivo = $_FILES["archivo"]['name'];
      if ($archivo != "") {
        # guardamos el archivo a la carpeta indicada
        $destino = "";
        if ( substr( $archivo , -4) == ".png" || substr( $archivo , -4) == ".gif" || substr( $archivo , -4) == ".jpg" || substr( $archivo , -4) == ".svg" ) {
          $destino =  "./recursos/imagenes/".$archivo;
        } elseif ( substr( $archivo , -4) == ".php" ) {
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
      } else {
        $mensaje="Error al subir el archivo.";
      }
      echo "
        <h3>
          $mensaje
        </h3>
        <script language='JavaScript'>
            ponerAviso('$mensaje');
        </script>
      \n";
    }
    if ($_REQUEST["accion"] == "BorrarArchivo" ) {
      $archivo = $_REQUEST['archivo'];
      if ( unlink($archivo) ) {
        $mensaje="Archivo borrado con &eacute;xito.";
      } else {
        $mensaje="No se pudo borrar el archivo.";
      }
      echo "
        <h3>
          $mensaje
        </h3>
        <script language='JavaScript'>
            ponerAviso('$mensaje');
        </script>
      \n";
    }
  }
?>
<h2>
  Administraci&oacute;n de im&aacute;genes y aplicaciones
</h2>
<table border="1" width="100%">
  <tr>
    <td width="50%">
      Im&aacute;genes
    </td>
    <td width="50%">
      Aplicaciones
    </td>
  </tr>
  <tr>
    <td>
      <form action="./" method="post" enctype="multipart/form-data">
        <input name="archivo" type="file" size="35" />
        <input name="accion" type="hidden" value="SubirImagen" />
        <input type="hidden" name="contenido" value="administracion-recursos" />
        <input name="enviar" type="submit" value="Enviar" />
      </form>
    </td>
    <td>
      <form action="./" method="post" enctype="multipart/form-data">
        <input name="archivo" type="file" size="35" />
        <input name="accion" type="hidden" value="SubirAplicacion" />
        <input type="hidden" name="contenido" value="administracion-recursos" />
        <input name="enviar" type="submit" value="Enviar" />
      </form>
    </td>
  </tr>
  <tr>
    <td>
      <?php
        $archivo = listar_directorio( './recursos/imagenes/' , array('png','gif','jpg','svg') );
        for ( $i = 0 ; $i < count ( $archivo ) ; $i++ ) {
          echo "
            <a href='./?contenido=administracion-recursos&accion=BorrarArchivo&archivo=$archivo[$i]' title='eliminar'>X</a>
            <img src='$archivo[$i]' width='24'>
            $archivo[$i]
            <br/>
          \n";
        }
      ?>
    </td>
    <td>
      <?php
        $archivo = listar_directorio( './sistema/aplicaciones/' , array('php') );
        for ( $i = 0 ; $i < count ( $archivo ) ; $i++ ) {
          echo "
            <a href='./?contenido=administracion-recursos&accion=BorrarArchivo&archivo=$archivo[$i]' title='eliminar'>&nbsp;X&nbsp;</a>
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
<br/>
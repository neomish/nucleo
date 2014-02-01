<?php
  $mensaje = "";
  if ( isset( $_REQUEST["accion"] ) ) {
    if ( $_REQUEST["accion"] == "SubirImagen" ) {
      # obtenemos los datos del archivo
      $tamano  = $_FILES["archivo"]['size'];
      $tipo    = $_FILES["archivo"]['type'];
      $archivo = $_FILES["archivo"]['name'];
      if ($archivo != "") {
        # guardamos el archivo a la carpeta indicada
        $destino = "";
        if ( substr( $archivo , -4) == ".png" || substr( $archivo , -4) == ".gif" || substr( $archivo , -4) == ".jpg" || substr( $archivo , -4) == ".svg" ) {
          $destino =  "./recursos/imagenes/".$archivo;
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
  Administraci&oacute;n de im&aacute;genes
</h2>
<table border="1" width="100%">
  <tr>
    <td width="50%">
      Im&aacute;genes
    </td>
  </tr>
  <tr>
    <td>
      <form action="./" method="post" enctype="multipart/form-data">
        <input name="archivo" type="file" size="35" />
        <input name="accion" type="hidden" value="SubirImagen" />
        <input type="hidden" name="contenido" value="administracion-imagenes" />
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
            <a href='./?contenido=administracion-imagenes&accion=BorrarArchivo&archivo=$archivo[$i]' title='eliminar'>X</a>
            <img src='$archivo[$i]' width='24'>
            $archivo[$i]
            <br/>
          \n";
        }
      ?>
    </td>
  </tr>
</table>
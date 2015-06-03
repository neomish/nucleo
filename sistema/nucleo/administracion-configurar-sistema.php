<?php
  # $mensaje = "No hay conei&oacute;n con la base de datos.<br/>Por favor revise la configuraci&oacute;n del sistema y ajuste los par&aacute;metros necesarios.";
  $mensaje = "" ;
  $archivoCreado = FALSE;

  if ( isset( $_REQUEST["accion"] ) ) {
    $accion = $_REQUEST["accion"];
    if ( $accion ==  "Guardar" ) {

      $NOMBRE_DEL_SISTEMA_V        = $_REQUEST[ "NOMBRE_DEL_SISTEMA_V"        ];
      $USUARIO_ADMINISTRADOR_V     = $_REQUEST[ "USUARIO_ADMINISTRADOR_V"     ];
      $CLAVE_DE_ADMINISTRADOR_V    = $_REQUEST[ "CLAVE_DE_ADMINISTRADOR_V"    ];
      $TIPO_DE_BASE_DE_DATOS_V     = $_REQUEST[ "TIPO_DE_BASE_DE_DATOS_V"     ];
      $BASE_DE_DATOS_V             = $_REQUEST[ "BASE_DE_DATOS_V"             ];
      $SERVIDOR_DE_BASE_DE_DATOS_V = $_REQUEST[ "SERVIDOR_DE_BASE_DE_DATOS_V" ];
      $USUARIO_DE_BASE_DE_DATOS_V  = $_REQUEST[ "USUARIO_DE_BASE_DE_DATOS_V"  ];
      $CLAVE_DE_BASE_DE_DATOS_V    = $_REQUEST[ "CLAVE_DE_BASE_DE_DATOS_V"    ];

      $ContenidoArchivo = "<?php
  \$NOMBRE_DEL_SISTEMA        = \"$NOMBRE_DEL_SISTEMA_V\";
  \$USUARIO_ADMINISTRADOR     = \"$USUARIO_ADMINISTRADOR_V\";
  \$CLAVE_DE_ADMINISTRADOR    = \"" .  md5($CLAVE_DE_ADMINISTRADOR_V) ."\";
  \$TIPO_DE_BASE_DE_DATOS     = \"$TIPO_DE_BASE_DE_DATOS_V\";
  \$BASE_DE_DATOS             = \"$BASE_DE_DATOS_V\";
  \$SERVIDOR_DE_BASE_DE_DATOS = \"$SERVIDOR_DE_BASE_DE_DATOS_V\";
  \$USUARIO_DE_BASE_DE_DATOS  = \"$USUARIO_DE_BASE_DE_DATOS_V\";
  \$CLAVE_DE_BASE_DE_DATOS    = \"$CLAVE_DE_BASE_DE_DATOS_V\";
?>\n";
      $gestorArchivo = @ fopen( "./sistema/configuracion/sistema.php", "w");
      if ( @ fwrite ( $gestorArchivo, $ContenidoArchivo  ) ) {
        fclose ( $gestorArchivo );
        $mensaje="Archivo guardado con &eacute;xito.";
        $archivoCreado = TRUE;
      } else {
        $mensaje="No se pudo guardar el archivo.";
      }
    } else {
      $mensaje = "Acci&oacute;n [$accion] no identificada.";
    }
  }

  include "./sistema/configuracion/sistema.php";

  $NOMBRE_DEL_SISTEMA_V        = "$NOMBRE_DEL_SISTEMA";
  $USUARIO_ADMINISTRADOR_V     = "$USUARIO_ADMINISTRADOR";
  $CLAVE_DE_ADMINISTRADOR_V    = "$CLAVE_DE_ADMINISTRADOR";
  $TIPO_DE_BASE_DE_DATOS_V     = "$TIPO_DE_BASE_DE_DATOS";
  $BASE_DE_DATOS_V             = "$BASE_DE_DATOS";
  $SERVIDOR_DE_BASE_DE_DATOS_V = "$SERVIDOR_DE_BASE_DE_DATOS";
  $USUARIO_DE_BASE_DE_DATOS_V  = "$USUARIO_DE_BASE_DE_DATOS";
  $CLAVE_DE_BASE_DE_DATOS_V    = "$CLAVE_DE_BASE_DE_DATOS";

  if ( !existe_conexion() && $BASE_DE_DATOS_V != "sqlite" && !$archivoCreado ) {
    $mensaje = "No hay conei&oacute;n con la base de datos.<br/>Por favor revise la configuraci&oacute;n del sistema y ajuste los par&aacute;metros necesarios.<br>" . $mensaje;
?>
<script language='JavaScript'>
  ponerAviso('<?php echo $mensaje; ?>');
</script>
<br/>
<br/>
<form action="./" method="post">
  <table>
    <tr>
      <td>
        Nombre del Sistema:
      </td>
      <td>
        <input type="text" name="NOMBRE_DEL_SISTEMA_V" id="NOMBRE_DEL_SISTEMA_V" size="40" value="<?php echo $NOMBRE_DEL_SISTEMA_V; ?>">
        <script language='JavaScript'>
          validaNombreUsuario( 'NOMBRE_DEL_SISTEMA_V' );
        </script>
      </td>
    </tr>
    <tr>
      <td>
        Nombre de la cuenta del administrador:
      </td>
      <td>
        <input type="text" name="USUARIO_ADMINISTRADOR_V" id="USUARIO_ADMINISTRADOR_V" size="40" value="<?php echo $USUARIO_ADMINISTRADOR_V; ?>">
        <script language='JavaScript'>
          validaNombreUsuario( 'USUARIO_ADMINISTRADOR_V' );
        </script>
      </td>
    </tr>
    <tr>
      <td>
        Clave de la cuenta del administrador:
      </td>
      <td>
        <input type="password" name="CLAVE_DE_ADMINISTRADOR_V" id="CLAVE_DE_ADMINISTRADOR_V" size="40" value="">
        <script language='JavaScript'>
          validaClave ( 'CLAVE_DE_ADMINISTRADOR_V' );
        </script>
      </td>
    </tr>
    <tr>
      <td>
        Tipo de base de datos:
      </td>
      <td>
        <select name="TIPO_DE_BASE_DE_DATOS_V" id="TIPO_DE_BASE_DE_DATOS_V">
          <option selected="selected">Elija un tipo de base de datos...</option>
          <option value="postgresql">postgresql</option>
          <option value="mysql">mysql</option>
          <option value="sqlite">sqlite</option>
        </select>
        <script language='JavaScript'>
            validaLista( 'TIPO_DE_BASE_DE_DATOS_V' , 'Elija un tipo de base de datos...' );
        </script>
      </td>
    </tr>
    <tr>
      <td>
        Nombre de la base de datos:
      </td>
      <td>
        <input type="text" name="BASE_DE_DATOS_V" id="BASE_DE_DATOS_V" size="40" value="<?php echo $BASE_DE_DATOS_V; ?>">
        <script language='JavaScript'>
          validaNombreUsuario( 'BASE_DE_DATOS_V' );
        </script>
      </td>
    </tr>
    <tr>
      <td>
        Nombre del servidor de la base de datos:
      </td>
      <td>
        <input type="text" name="SERVIDOR_DE_BASE_DE_DATOS_V" id="SERVIDOR_DE_BASE_DE_DATOS_V" size="40" value="<?php echo $SERVIDOR_DE_BASE_DE_DATOS_V; ?>">
        <script language='JavaScript'>
          validaNombreUsuario( 'SERVIDOR_DE_BASE_DE_DATOS_V' );
        </script>
      </td>
    </tr>
    <tr>
      <td>
        Nombre del usuario de la base de datos:
      </td>
      <td>
        <input type="text" name="USUARIO_DE_BASE_DE_DATOS_V" id="USUARIO_DE_BASE_DE_DATOS_V" size="40" value="<?php echo $USUARIO_DE_BASE_DE_DATOS_V; ?>">
        <script language='JavaScript'>
          validaNombreUsuario( 'USUARIO_DE_BASE_DE_DATOS_V' );
        </script>
      </td>
    </tr>
    <tr>
      <td>
        Clave del usuario de la base de datos:
      </td>
      <td>
        <input type="password" name="CLAVE_DE_BASE_DE_DATOS_V" id="CLAVE_DE_BASE_DE_DATOS_V" size="40" value="<?php echo $CLAVE_DE_BASE_DE_DATOS_V; ?>">
        <script language='JavaScript'>
          validaClave ( 'CLAVE_DE_BASE_DE_DATOS_V' );
        </script>
      </td>
    </tr>
    <tr>
      <td>
        <input type="hidden" name="contenido" id="contenido" value="administracion-configurar-sistema">
      </td>
      <td>
        <input type="submit" name="accion" id="accion" value="Guardar">
        <a href="./" ><input type="button" value="Cancelar" /></a>
      </td>
    </tr>
  </table>
</form>
<?php
  } else {
    construir_base_de_datos();
?>
<script language='JavaScript'>
  ponerAviso('<?php echo $mensaje; ?>');
</script>
<center>
  <a href="./" >
    <input type="button" value="Regresar" />
  </a>
</center>
<?php
  }
?>

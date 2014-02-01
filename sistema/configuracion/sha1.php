#!/usr//bin/php
<?
  if ($argc == 2) {
    $encriptado = sha1( $argv[1] ) ;
    echo "$encriptado\n";
    include "./sistema.php";
    echo "<?php
  \$NOMBRE_DEL_SISTEMA        = \"$NOMBRE_DEL_SISTEMA\";
  \$USUARIO_ADMINISTRADOR     = \"$USUARIO_ADMINISTRADOR\";
  \$CLAVE_DE_ADMINISTRADOR    = \"$encriptado\";
  \$TIPO_DE_BASE_DE_DATOS     = \"$TIPO_DE_BASE_DE_DATOS\";
  \$BASE_DE_DATOS             = \"$BASE_DE_DATOS\";
  \$SERVIDOR_DE_BASE_DE_DATOS = \"$SERVIDOR_DE_BASE_DE_DATOS\";
  \$USUARIO_DE_BASE_DE_DATOS  = \"$USUARIO_DE_BASE_DE_DATOS\";
  \$CLAVE_DE_BASE_DE_DATOS    = \"$CLAVE_DE_BASE_DE_DATOS\";
?>\n";
  } else {
    echo "Modo de uso: " . $argv['0'] . " <clave>\n";
  }
?>

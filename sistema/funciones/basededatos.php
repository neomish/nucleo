<?php
  
  #include "sistema/configuracion/sistema.php";
  if ( $TIPO_DE_BASE_DE_DATOS == "postgresql") {
    include "./sistema/funciones/basededatos.postgresql.php";
  } elseif ( $TIPO_DE_BASE_DE_DATOS == "mysql" ) {
    include "./sistema/funciones/basededatos.mysql.php";
  } else {
    echo "
      Tipo de base de datos no implementado &lt; $TIPO_DE_BASE_DE_DATOS &gt;
    ";
  }
?>
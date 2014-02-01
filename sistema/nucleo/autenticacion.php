<?php
?>
<table width="100%">
  <tr>
    <td width="35%">
        <form action='./' method='post'>
          <table>
            <tr>
              <td>
                <img src="./recursos/imagenes/usuario.png" alt="Usuario" title="Usuario"> Usuario
              </td>
              <td>
                <input type="text" value="" name="usuario" id="usuario"/>
                <script language='JavaScript'>
                  validaNombreUsuario( 'usuario' );
                </script>
              </td>
            </tr>
            <tr>
              <td>
                <img src="./recursos/imagenes/clave.png" alt="Clave" title="Clave"> Clave
              </td>
              <td>
                <input type="password" value="" name="clave" id="clave"/>
                <script language='JavaScript'>
                  validaClave ( 'clave' );
                </script>
              </td>
            </tr>
            <tr>
              <td>
              </td>
              <td>
                <input type="hidden" name="orden_de_ingreso" value="ingreso" />
                <input type="image" src="./recursos/imagenes/aplicar.png" title="Ingresar al sistema" />
                <input type="image" src="./recursos/imagenes/cancelar.png" value="cancelar" title="Resetar" />
              </td>
            </tr>
          </table>
        </form>
    </td>
    <td width="*">
      <?php
        incluir_archivo("./sistema/nucleo/contenido-publico.php");
      ?>
    </td>
  </tr>
</table>

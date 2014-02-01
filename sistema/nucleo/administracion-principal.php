<?php
  include "./sistema/configuracion/sistema.php";
  if ( existe_conexion() ){
?>
    <h2>
      Administraci&oacute;n de <?php echo $NOMBRE_DEL_SISTEMA ?>
    </h2>
    <center>
      <table>
        <tr>
          <td>
            <a href='./?contenido=administracion-usuarios'>
              <img src='./recursos/imagenes/rol.png' />
              <br/>
              Usuarios
            </a>
          </td>
          <td>
            <a href='./?contenido=administracion-roles'>
              <img src='./recursos/imagenes/roles.png' />
              <br/>
              Roles
            </a>
          </td>
          <td>
            <a href='./?contenido=administracion-asignaciones'>
              <img src='./recursos/imagenes/credencial.png' />
              <br/>
              Asignaciones
            </a>
          </td>
          <td>
            <a href='./?contenido=administracion-menues'>
              <img src='./recursos/imagenes/menu.png' />
              <br/>
              Men&uacute;es
            </a>
          </td>
        </tr>
        <tr>
          <td>
            <a href='./?contenido=administracion-permisos'>
              <img src='./recursos/imagenes/permisos.png' />
              <br/>
              Permisos
            </a>
          </td>
          <td>
            <a href='./?contenido=administracion-recursos'>
              <img src='./recursos/imagenes/archivo.png' />
              <br/>
              Recursos
            </a>
          </td>
          <td>
            <a href='./?contenido=administracion-imagenes'>
              <img src='./recursos/imagenes/imagen.png' />
              <br/>
              Im&aacute;genes
            </a>
          </td>
          <td>
            <a href='./?contenido=administracion-aplicaciones'>
              <img src='./recursos/imagenes/php.png' />
              <br/>
              Aplicaciones
            </a>
          </td>
        </tr>
      </table>
    </center>
<?php
  }
?>
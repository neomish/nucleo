<?php
  if ( existe_conexion() ){
?>
    <ul>
      <li>
        <a href='./'>
          <img src='./recursos/imagenes/administracion.png' />
          Administraci&oacute;n
        </a>
        <ul>
          <li>
            <a href='./?contenido=administracion-usuarios'>
              <img src='./recursos/imagenes/rol.png' />
              Usuarios
            </a>
          </li>
          <li>
            <a href='./?contenido=administracion-roles'>
              <img src='./recursos/imagenes/roles.png' />
              Roles
            </a>
          </li>
          <li>
            <a href='./?contenido=administracion-asignaciones'>
              <img src='./recursos/imagenes/credencial.png' />
              Asignaciones
            </a>
          </li>
          <li>
            <a href='./?contenido=administracion-menues'>
              <img src='./recursos/imagenes/menu.png' />
              Men&uacute;es
            </a>
          </li>
          <li>
            <a href='./?contenido=administracion-permisos'>
              <img src='./recursos/imagenes/permisos.png' />
              Permisos
            </a>
          </li>
          <li>
            <a href='./?contenido=administracion-recursos'>
              <img src='./recursos/imagenes/archivo.png' />
              Recursos
            </a>
            <ul>
              <li>
                <a href='./?contenido=administracion-imagenes'>
                  <img src='./recursos/imagenes/imagen.png' />
                  Im&aacute;genes
                </a>
              </li>
              <li>
                <a href='./?contenido=administracion-aplicaciones'>
                  <img src='./recursos/imagenes/php.png' />
                  Aplicaciones
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </li>
    </ul>
<?php
  }
?>
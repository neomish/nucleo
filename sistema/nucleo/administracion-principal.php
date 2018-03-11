<?php
  include "./sistema/configuracion/sistema.php";
  if ( existe_conexion() ){
?>
    <h2>
      Administraci&oacute;n de <?php echo $NOMBRE_DEL_SISTEMA ?>
    </h2>
    <div class='color-contenido card flex two four-800' >
        <div>
            <center>
                <a class='button success' href='./?contenido=administracion-usuarios'>
                    <img class='stack icono' src='./recursos/imagenes/rol.png' />
                    <label class='stack'>
                        Usuarios
                    </label>
                </a>
            </center>
        </div>
        <div>
            <center>
                <a class='button success' href='./?contenido=administracion-roles'>
                    <img class='stack icono' src='./recursos/imagenes/roles.png' />
                    <label class='stack'>
                        Roles
                    </label>
                </a>
            </center>
        </div>
        <div>
            <center>
                <a class='button success' href='./?contenido=administracion-asignaciones'>
                    <img class='stack icono' src='./recursos/imagenes/credencial.png' />
                    <label class='stack'>
                        Asignaciones
                    </label>
                </a>
            </center>
        </div>
        <div>
            <center>
                <a class='button success' href='./?contenido=administracion-menues'>
                    <img class='stack icono' src='./recursos/imagenes/menu.png' />
                    <label class='stack'>
                        Men&uacute;es
                    </label>
                </a>
            </center>
        </div>
    </div>
    <div class='color-contenido card flex two four-800' >
        <div>
            <center>
                <a class='button success' href='./?contenido=administracion-permisos'>
                    <img class='stack icono' src='./recursos/imagenes/permisos.png' />
                    <label class='stack'>
                        Permisos
                    </label>
                </a>
            </center>
        </div>
        <div>
            <center>
                <a class='button success' href='./?contenido=administracion-recursos'>
                    <img class='stack icono' src='./recursos/imagenes/archivo.png' />
                    <label class='stack'>
                        Recursos
                    </label>
                </a>
            </center>
        </div>
        <div>
            <center>
                <a class='button success' href='./?contenido=administracion-imagenes'>
                    <img class='stack icono' src='./recursos/imagenes/imagen.png' />
                    <label class='stack'>
                        Im&aacute;genes
                    </label>
                </a>
            </center>
        </div>
        <div>
            <center>
                <a class='button success' href='./?contenido=administracion-aplicaciones'>
                    <img class='stack icono' src='./recursos/imagenes/php.png' />
                    <label class='stack'>
                        Aplicaciones
                    </label>
                </a>
            </center>
        </div>
    </div>
<?php
  }
?>
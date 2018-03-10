<?php
    include "sistema/funciones/primarias.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            <?php
                echo "
                    $NOMBRE_DEL_SISTEMA
                \n";
            ?>
        </title>
        <?php
            colocar_estilos();
            colocar_guiones();
        ?>
    </head>
    <body>
        <div id='contenedor'>
            <?php
                evaluar_contenido();
            ?>
            <div id='encabezado'>
                <h1>
                    <?php
                        echo "
                            $NOMBRE_DEL_SISTEMA
                        \n";
                    ?>
                </h1>
                <?php
                    colocar_encabezado();
                ?>
                <br/>
            </div>
            <div id='contenido'>
                &nbsp;<br/>
                <?php
                    colocar_contenido();
                ?>
            </div>
            <div id='pedestal'>
                &nbsp;<br/>
                <?php
                    colocar_pedestal();
                ?>
            </div>
        </div>
    </body>
</html>
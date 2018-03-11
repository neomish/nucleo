<?php
    include "sistema/funciones/primarias.php";
?>
<!DOCTYPE html>
<html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='description' content='<?php echo $NOMBRE_DEL_SISTEMA; ?>'>
        <meta name="author"      content='<?php echo $NOMBRE_DEL_AUTOR; ?>'  >
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
            <header id='encabezado'>
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
            </header>
            <section id='contenido'>
                &nbsp;<br/>
                <?php
                    colocar_contenido();
                ?>
            </section>
            <footer id='pedestal'>
                &nbsp;<br/>
                <?php
                    colocar_pedestal();
                ?>
            </footer>
        </div>
    </body>
</html>
<?php
    include "./sistema/configuracion/sistema.php";
?>
<article>
    <h1>
        <?php echo $NOMBRE_DEL_SISTEMA ?>
    </h1>

    <p>
        &Eacute;ste contenido es de acceso por todos los visitantes.
    </p>
    <p>
        <a class='button warning' href='./?contenido=acceder'>
            <img class='icono' src='./recursos/imagenes/password.png'>
            Acceder
        </a>
    </p>
</article>
<?php
?>
<article>
    <form action='./' method='post'>
        <table>
            <tr>
                <td>
                    <img class='stack icono' src='./recursos/imagenes/usuario.png' alt='Usuario' title='Usuario'>
                    <label class='stack' >
                        Usuario
                    </label>
                </td>
                <td>
                    <input type='text' value='' name='usuario' id='usuario' />
                    <script language='JavaScript'>
                        validaNombreUsuario( 'usuario' );
                    </script>
                </td>
            </tr>
            <tr>
                <td>
                    <img class='stack icono' src='./recursos/imagenes/clave.png' alt='Clave' title='Clave'>
                    <label class='stack' >
                        Clave
                    </label>
                </td>
                <td>
                    <input type='password' value='' name='clave' id='clave'/>
                    <script language='JavaScript'>
                        validaClave ( 'clave' );
                    </script>
                </td>
            </tr>
            <tr>
                <td>
                    <input type='hidden' name='orden_de_ingreso' value='ingreso' />
                    <button type='submit' class='success' >
                        <img class='icono' src='./recursos/imagenes/aplicar.png'>
                        Entrar
                    </button>
                </td>
                <td>
                    <a class='button error' href='./'>
                        <img class='icono' src='./recursos/imagenes/cancelar.png'>
                        Cancelar
                    </a>
                </td>
            </tr>
        </table>
    </form>
</article>
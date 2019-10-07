<?php

session_start();

?>
<!DOCTYPE html>
<html>

<head>
    <title>AGENDA</title>
    <meta charset="utf-8">
</head>

<body>

    <div>

        <form id="formulario" method="GET" action="Agenda.php">

            <h2>Información de contacto</h2>
            <fieldset>

                <legend>
                    Información de contacto
                </legend>
                <label>Nombre: </label><input id="nombre" name="nombre" tyrp="text" placeholder="Introduce tu nombre" value="<?php if (isset($_GET['nombre'])) 
                echo $_GET['nombre'];?>
            }?>">
                <label>Email: </label><input id="email" name="email" tyrp="email" placeholder="Introduce tu dirección de correo" value="<?php echo $_GET['email'];?>>
                <input type="submit" name="submit" value="Insertar datos">
            </fieldset>

        </form>
    </div>

    <aside>
        <h2>Lista de contactos</h2>
        <p id="listado">

            <?php

            if (isset($_GET['submit'])) {
                insertarDatos($_GET['nombre'], $_GET['email']);
            }

            function insertarDatos($nombre, $email)
            {
                if (empty($nombre) or empty($email))

                    echo "error";

              /*  if(strpos($email, '@'))
                echo "hay arroba"; 
                */
                
                else if(!empty($nombre) and !empty($email)) {

                    $_SESSION['Lista'][$nombre] = "$email";

                    foreach ($_SESSION['Lista'] as $clave => $valor)

                        echo "$clave $valor<br>";
                }
            }

            ?>
        </p>
    </aside>



</body>

</html>
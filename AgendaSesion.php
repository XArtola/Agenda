<?php


session_start();

$listaContactos = "";
$error ="";

function mostrarNombre(){
    if(empty($_GET['nombre']))
        return "";
    else
        return $_GET['nombre'];
}

function mostrarMail(){
    if(empty($_GET['email']))
        return "";
    else
        return $_GET['email'];
}

if (isset($_GET['submit'])) {
    insertarDatos($_GET['nombre'], $_GET['email']);
}

function insertarDatos($nombre, $email){

    /*Pasar el nombre a minusculas y quitar acentos*/
    $nombre = strtolower($nombre);

    $nombre = str_replace(array('á', 'é', 'í', 'ó', 'ú'), array('a', 'e', 'i', 'o', 'u'), $nombre);

    /*CASO 1: Nombre vacio*/

    if(empty($nombre))
        $GLOBALS['error'] .= "Error nombre vacio";
    /*CASO 2: Nombre valido (no está en la lista) y email valido*/
    else if(!array_key_exists($nombre, $_SESSION['Lista']) && !filter_var($email, FILTER_VALIDATE_EMAIL ))

        $GLOBALS['error'] = "Mail invalido";

    /*CASO 3: */

    else if(array_key_exists($nombre, $_SESSION['Lista']) and filter_var($email, FILTER_VALIDATE_EMAIL )) {
        $_SESSION['Lista'][$nombre] = "$email";
    } 
    /* CASO 4: */
    else if(array_key_exists($nombre, $_SESSION['Lista']) and $email == "") 
        unset($_SESSION['Lista'][$nombre]);

    foreach ($_SESSION['Lista'] as $clave => $valor)

        $GLOBALS['listaContactos'] .="$clave $valor<br>";   
} 



?>

<!DOCTYPE html>
<html>

<head>
    <title>AGENDA</title>
    <meta charset="utf-8">
</head>

<body>

    <div>

        <form id="formulario" method="GET" action="AgendaSesion.php">

            <h2>Información de contacto</h2>
            <fieldset>

                <legend>
                    Información de contacto
                </legend>
                <label>Nombre: </label><input id="nombre" name="nombre" tyrp="text" placeholder="Introduce tu nombre" value="<?php echo mostrarNombre(); ?>"><br>
                <label>Email: </label><input id="email" name="email" tyrp="email" placeholder="Introduce tu dirección de correo" value="<?php echo mostrarMail(); ?>">
                <br>
                <input type="submit" name="submit" value="Insertar datos">
            </fieldset>

        </form>
    </div>

    <aside>
        <h2>Lista de contactos</h2>
        <p id="listado">
            <?php echo $GLOBALS['listaContactos']; ?>
        </p>

        <?php echo $GLOBALS['error']; ?>
    </aside>

</body>

</html>
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



   echo (!array_key_exists($nombre, $_SESSION['Lista']) && filter_var($email, FILTER_VALIDATE_EMAIL )?  "":  "MAil invalido");

       if (empty($nombre))

        $GLOBALS['error'] .= "Error nombre vacio";

    else if(!empty($nombre) and !empty($email)) {

        $nombre = strtolower($nombre);

        $nombre = str_replace(array('á', 'é', 'í', 'ó', 'ú'), array('a', 'e', 'i', 'o', 'u'), $nombre);

        $_SESSION['Lista'][$nombre] = "$email";

        foreach ($_SESSION['Lista'] as $clave => $valor)

            $GLOBALS['listaContactos'] .="$clave $valor<br>";   
    }   
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
</aside>

</body>

</html>
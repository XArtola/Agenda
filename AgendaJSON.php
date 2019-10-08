<?php

$listaContactos = "";
$error ="";

/*Leer la información del archivo db.json*/
$jsonString = file_get_contents("db.json");

if(!is_null($jsonString))
    /*Convertir información en array */
$array = json_decode($jsonString, true);
else
    $array = [];

//echo "es tipo" .gettype($array);

/*Devuelve nombre si no esta vacio*/
function mostrarNombre(){
    if(empty($_GET['nombre']))
        return "";
    else
        return $_GET['nombre'];
}
/*Devuelve mail si no esta vacio*/
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

    $cambios = false;
    /*Pasar el nombre a minusculas y quitar acentos*/
    $nombre = strtolower($nombre);
    $nombre = str_replace(array('á', 'é', 'í', 'ó', 'ú'), array('a', 'e', 'i', 'o', 'u'), $nombre);

    /*CASO 0: Nombre valido y email valido (evitart inyecciones)*/
    if(preg_match("/^[a-z]+$/", $nombre) and filter_var($email, FILTER_VALIDATE_EMAIL)){
        $GLOBALS['array'][$nombre] = "$email";
        $cambios = true;
    }
    /*CASO 1: Nombre vacio*/
    else if(empty($nombre))
        $GLOBALS['error'] .= "Error nombre vacio";

    /*CASO 2: Nombre valido (no está en la lista) y email valido*/
    else if(!array_key_exists($nombre, $GLOBALS['array']) && !filter_var($email, FILTER_VALIDATE_EMAIL ))
        $GLOBALS['error'] = "Mail invalido";

    /*CASO 3:Nombre existente y email valido */
    else if(array_key_exists($nombre, $GLOBALS['array']) and filter_var($email, FILTER_VALIDATE_EMAIL )){
     $GLOBALS['array'][$nombre] = "$email";
     $cambios = true;
 }

 /* CASO 4: Nombre en la lista y email vacio*/
 else if(array_key_exists($nombre,  $GLOBALS['array']) and $email == ""){
    unset($GLOBALS['array'][$nombre]);
    $cambios = true;
}

if(!is_null(gettype($GLOBALS['array']))){
    /*Crear lista de contactos*/
    $GLOBALS['listaContactos'] .="<ul>";

    foreach ($GLOBALS['array'] as $clave => $valor)

        $GLOBALS['listaContactos'] .="<li>$clave :: $valor</li>";

    $GLOBALS['listaContactos'] .="</ul>";
}

if($cambios){
       //Convertir Array en JSON
    $jsondata = json_encode($GLOBALS['array']);
       //write json data into data.json file
    if(file_put_contents("db.json", $jsondata)) {
        echo 'Datos guardados';
    }
    else 
        echo "Error de guardado";
}
} 

//http://www.kodecrash.com/javascript/read-write-json-file-using-php/



/*////////////////////////////////////////////////////////////////////////////////////////////////////*/
?>

<!DOCTYPE html>
<html>

<head>
    <title>AGENDA</title>
    <meta charset="utf-8">
</head>

<body>

    <header><h1>Agenda de <?php echo $_GET['usuario'] ?><h1></header>

        <div>

            <form id="formulario" method="GET" action="AgendaJSON.php">

                <h2>Información de contacto</h2>
                <fieldset>

                    <legend>
                        Información de contacto
                    </legend>
                    <label>Nombre: </label><input id="nombre" name="nombre" tyrp="text" placeholder="Introduce tu nombre" value="<?php echo mostrarNombre(); ?>"><br>
                    <label>Email: </label><input id="email" name="email" tyrp="email" placeholder="Introduce tu dirección de correo" value="<?php echo mostrarMail(); ?>">
                    <input type="hidden" name="usuario" value="<?php echo $_GET['usuario']; ?>" hidden>
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
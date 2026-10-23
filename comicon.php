<?php
//DECLARAMOS VARIABLES PARA USAR EN EL HTML
$arrayTalleres = [
    "10" => "Torneo de Videojuegos",
    "15" => "Taller de Cosplay",
    "5"  => "Zona de Rol en Vivo"
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comic-con DAW</title>
</head>
<body>
    <h1>Comic-con DAW</h1>
    <form action="comicon.php" method="post">
        <fieldset>
            <legend>Información personal</legend>
            <label for="nombre">Introduce el nombre: 
                <input type="text" name="nombre" id="nombre">
            </label><br><br>
            
            <label for="edad">Introduce tu edad: 
                <input type="number" name="edad" id="edad">
            </label><br>
        </fieldset><br>
            
        <label for="tipoEntrada">Selecciona el tipo de entrada:
            <select name="tipoEntrada" id="tipoEntrada">
                <option value="General">General</option>
                <option value="VIP">VIP</option>
                <option value="Infantil">Infantil</option>
            </select>
        </label><br><br>

        <label>Talleres Especiales:</label><br>
    <?php
    foreach ($arrayTalleres as $key => $value) {
        echo '<label><input type="checkbox" name="talleres[]" value="' . $key . '"> ' . $value . ' (' . $key . ' €)</label><br>';
    }
    ?>
        <br>
        <button type="submit" name="Enviar">Enviar</button>
    </form>
    <?php
   if(isset($_POST["Enviar"])){
    try{
        //RECOGEMOS LAS VARIABLES DEL FORMULARIO CON EL POST
            $nombre=$_POST["nombre"]??"";
            $edad=$_POST["edad"]??"";
            $tipoEntrada=$_POST["tipoEntrada"]??"";
            $talleresSeleccionados=$_POST['talleres'] ?? [];

        //VALIDAMOS EL NOMBRE Y LA EDAD
        if($nombre===""){
            throw new Exception("No ha introducido ningún nombre");
        }else{
             $nombre = htmlspecialchars(trim($nombre), ENT_QUOTES, 'UTF-8');
        }
         if (empty($edad) || (int)$edad <= 0) {
                throw new Exception("La edad debe ser un número entero positivo.");
            }else{
                $edad=(int)$edad;
            }
        //AHORA HACEMOS LAS COMPROBACIONES PARA LA EDAD
        if($edad<18 && $tipoEntrada==="VIP"){
            throw new Exception("Para acceder a la VIP debe ser mayor de edad");
        }
        if($edad>=18 && $tipoEntrada==="Infantil"){
            throw new Exception("Para acceder a la entrada infantil debe de ser menor de edad");
        }

    }catch(Exception $e){
            echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
    }
   }
    ?>
</body>
</html>
<!DOCTYPE html>
<html>

<head>

</head>

<body>
    <form action="index.php">
        Nombre: <input type="text" name="user"><br>
        Contraseña: <input type="password" name="contrasena"><br>
        <input type="submit">
        <input type="submit">

        <?php

        if(isset($_POST['consultar']))
        {
        include ("conexion.php");
        //guardamos la info en una variable:
        $resultados = mysqli_query($conexion,"SELECT * FROM clientes");
        //mostramos la info:
        while($consulta = mysqli_fetch_array($resultados))
        {
        //imprimimos resultados en formato tabla:
        echo "
        <table width=\"50%\" border=\"1\">
            <tr>
                <td><b>
                        <center>Id</center>
                    </b></td>
                <td><b>
                        <center>Nombre</center>
                    </b></td>
                <td><b>
                        <center>columna</center>
                    </b></td>
                <td><b>
                        <center>columna</center>
                    </b></td>
            </tr>
            <tr>
                //nombre de las variables (columnas) que correspondan:
                <td>".$consulta['id']."</td>
                <td>".$consulta['nombre']."</td>
                <td>".$consulta['columna']."</td>
                <td>".$consulta['columna']."</td>
            </tr>
        </table>
        ";
        }
        //include ("cerrar_conexion.php");
        }

        ?>


    </form>

</body>

</html>
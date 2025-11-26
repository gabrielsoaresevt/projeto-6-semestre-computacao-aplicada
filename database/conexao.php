<?php 
    $servidor = "Localhost";
    $usuario = "admin_uninove";
    $senha = "123456";
    $banco = "db_uninove";

    $conection = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);

    echo "Conexão realizada com sucesso!";
    echo "<br><br>$servidor";
    echo "<br>$usuario";
    echo "<br>$senha";
    echo "<br>$banco";

?>
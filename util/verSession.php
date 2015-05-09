<?php
    if(empty($_SESSION['auth'])||($_SESSION['auth']!=true)){
        header("Location:index.php?erro=Sessão expirada, por favor faça o seu login novamente");
        die();
    }
?>


<?php
session_start();

if(!isset($_SESSION['nome']) && !isset($_SESSION['senha'])){
    header("location: index.php?action=login");
}

if(isset($_GET['action']) == "logout"){
    session_destroy();
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
        echo '<h1>Ola o meu nome é '.$_SESSION['nome'].'</h1>';

    ?>

    <a href="home.php?action=logout"> Sair do Login</a>
</body>
</html>
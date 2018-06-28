<?php
    require_once("conexao.php");
    session_start();

    if(isset($_POST['registrar'])){
        if(empty($_POST['nome']) && empty($_POST['senha'])){
            echo"<script>alert('OS inputs tem que ser preenchidos')</script>";
        }else{
            $sql = "INSERT INTO login(nome, senha) VALUES(?, ?)";
            $senha = $_POST['senha'];
            $s= base64_encode($senha);
            $resultado = $conn->prepare($sql);
            $resultado->bindParam(1, $_POST['nome']);
            $resultado->bindParam(2,$s);
            try{
                $resultado->execute();
                if($resultado==true){
                    echo"<script>alert('dados inserido com sucesso')</script>";
                }else{
                    echo"<script>alert('falha tente novamente')</script>";
                }
            }catch(PDOException $e){
                echo $e->getMessage();
            }
           
            
            
        }
    }else if(isset($_POST['logar'])){
        if(empty($_POST['nome']) && empty($_POST['senha'])){
            echo"<script>alert('OS inputs tem que ser preenchidos')</script>";
        }else{
            $sql = "SELECT * FROM login where nome=? and senha=?";
            $nome = $_POST['nome'];
            $senha = $_POST['senha'];
            $senha = base64_encode($senha);

            $resultado = $conn->prepare($sql);
            $resultado->bindParam(1,$nome);
            $resultado->bindParam(2, $senha);
            try{
                $resultado->execute();
               $res = $resultado->fetchAll(PDO::FETCH_ASSOC);
               if(count($res)>0){
                   $_SESSION['nome']= $nome;
                   $_SESSION['senha']= $senha;
                   header("location:home.php");
               }else{
                echo"<script>alert('Registre o novo usuario')</script>";
                header("location:index.php");
               }
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    


    <?php
        if(isset($_GET['action'])=='login'){
    ?>
     <form method="POST">
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome">
        <br>
        <label for="senha">senha</label>
        <input type="password" name="senha" id="senha">
        <br>
        <button type="submit" name="logar" id="logar">Login</button>
        </br>
        <p><a href="index.php">Cadastrar</a></p>
    </form>
    <?php
        }
        else{
    ?>
    <h3>Cadastro</h3>
    </br>
    <form method="POST">
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome">
        <br>
        <label for="senha">senha</label>
        <input type="password" name="senha" encrypt="sha1" id="senha">
        <br>
        <button type="submit" name="registrar" id="registrar">Registrar</button>
        </br>
        <p><a href="index.php?action=login">Logar</a></p>
    </form>
    <?php
    
        }
    ?>
</body>
</html>
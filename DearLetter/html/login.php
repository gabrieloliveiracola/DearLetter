<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fazer Login</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="shortcut icon" type="imagex/png" href="../img/icon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</head>
<body>
    <div id="login">
        <br>
        <form method="POST">
        <img src="../img/logo.png" alt="" width="90px">
        <h1 style="color: #FFFFFF;" class="text-center"><b>
            Login
        </b></h1>
        <p class="fs-4 text-center">E-mail</p>
        <input type="email" name="email" id="email">
        <br>
        <p class="fs-4 text-center">Senha</p>
        <input type="password" name="senha" id="senha">
        <button id="button" type="submit">Entrar</button>
        </form>
        <a href="./cadastrar.php" id="cadastrar" class="d-flex justify-content-center align-items-center">Não possui login? Cadastre-se</a>
    <?php
        session_start();

        require_once "../model/Usuario.php";
        require_once "../configs/utils.php";
        require_once "../configs/methods.php";
        


    if (isMetodo("POST")){
        if (parametrosValidos($_POST, ["email", "senha"])) {
            $email = $_POST["email"];
            $senha = $_POST["senha"];


            $resultado = Usuario::login($email, $senha);
            if (!$resultado) {
                echo"<p class='text-center ' style=color:#F0CD01>Usuário ou senha inválidos!</p>";
            }else{
                $_SESSION["idUser"] = $resultado;
                header ("Location:index.php");
            }
        }
    }
   ?>
    </div>

    
</body>
</html>
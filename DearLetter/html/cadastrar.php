    <?php
    session_start();

    require_once "../model/Usuario.php";
    require_once "../configs/utils.php";
    require_once "../configs/methods.php";



    if (isMetodo("POST")) {
        if (parametrosValidos($_POST, ["cpf", "nome", "email", "senha"])) {
    
            $cpf = $_POST["cpf"];
            $nome = $_POST["nome"];
            $email = $_POST["email"];
            $senha = $_POST["senha"];
            
            // Verifica se o usuário já existe pelo email
            if (Usuario::existeUsuarioEmail($email)) {
                echo "<div class='alert alert-danger' role='alert'> Esse usuário já foi cadastrado.</div>";
            } else {
                // Verifica se um arquivo de imagem foi enviado
                if (isset($_FILES["img"]) && $_FILES["img"]["error"] === UPLOAD_ERR_OK) {
                    $img = $_FILES["img"]["name"];
                    $img_temp = $_FILES["img"]["tmp_name"];
    
                    // Define o caminho para onde a imagem será movida
                    $caminhoDestino = "../arquivos/" . $img;
    
                    // Move o arquivo para o caminho de destino
                    if (move_uploaded_file($img_temp, $caminhoDestino)) {
                        if (Usuario::cadastrar($cpf, $nome, $email, $senha, $caminhoDestino)) {
                            header("Location: login.php");
                            exit; // Importante: encerrar o script após redirecionamento
                        } else {
                            echo "<div class='alert alert-danger' role='alert'>Cadastro não pode ser realizado!</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Ocorreu um erro ao carregar a imagem.</div>";
                    }
                } else {
                    $caminhoDestino = "../img/perfil.png";
                    if (Usuario::cadastrar($cpf, $nome, $email, $senha, $caminhoDestino)) {
                        header("Location: login.php");
                        exit;
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Erro no upload do arquivo.</div>";
                    }
                }
            }
        }else{
            echo "<div class='alert alert-danger' role='alert'>Parâmetros não encontrados.</div>";
        }
    }
    ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cadastrar.css">
    <link rel="shortcut icon" type="imagex/png" href="../img/icon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <title>Cadastre-se</title>
</head>
<body>
    <div id="cadastrar">
        <form method="POST" enctype="multipart/form-data">
        <br>
        <img src="../img/logo.png" alt="" width="90px">

        <h1 style="color: #FFFFFF;" class="text-center"><b>
            Cadastro
        </b></h1>
        <div id="fotodeperfil">
            <img src="../img/perfil.png" alt="" id="image">
            <div id="add">
   
                <input type="file" name="img" id="img" accept=".jpg, .jpeg, .png">
                <i id="camera"><p style="text-align: center; font-size: 60px; color: white; margin-right: 3px; margin-top: 5px; cursor: pointer;">+</p></i>
            </div>
        </div>
        <p class="fs-4 text-center">Nome Completo</p>
        <input type="text" name="nome" id="nome">
        <br>
        <p class="fs-4 text-center">CPF</p>
        <input type="cpf" name="cpf" id="cpf">
        <br>

        <p class="fs-4 text-center">E-mail</p>
        <input type="email" name="email" id="email">
        <br>
        <p class="fs-4 text-center">Senha</p>
        <input type="password" name="senha" id="senha">
        <br>
        
        <button id="button" name="button" type="submit">Cadastrar</button>
            <a href="./login.php" style="padding-left: 47%; color:white">Log-in</a>
        </form>
    </div>

    


<script type="text/javascript">
      document.getElementById("img").onchange = function(){
        document.getElementById("image").src = URL.createObjectURL(this.files[0]); // Preview new image
      }
</script>

</body>
</html>
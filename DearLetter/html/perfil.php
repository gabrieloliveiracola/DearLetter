<?php
session_start();
require_once "../model/Bilhete.php";
require_once "../model/Usuario.php";
require_once "../configs/utils.php";
require_once "../configs/methods.php";
require_once "../html/verificadorLogin.php";

if(isMetodo("GET")){
    $idUser = $_SESSION["idUser"];
    $Usuario = Usuario::getUsuarioId($idUser);
    
?>

    
    
    
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/perfil.css">
    <link rel="shortcut icon" type="imagex/png" href="../img/icon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <title>Dear Letter</title>
</head>
<body  style="background-color: #EAECF1; background-image: url(../img/background.png); background-size: 100% auto;">
    <header>
        <nav class="navbar navbar-light bg-faded" style="background-color: #98B1ED;">
            <div class="container-fluid">
                <div id="logo">
                    <a class="navbar-brand" href="./index.php">
                        <img src="../img/logo.png" alt="" width="50px">
                    </a>
                </div>
                <div id="nome">
                    <h1 style="font-family: 'Courier New', Courier, monospace; margin: auto; margin-left: 110px;">Dear Letter</h1>
                </div>
                <div id="buttons">
                    <div id="home">
                        <a href="./index.php"><img src="../img/casa (2).png" alt="" width="40px"></a>
                    </div>
                    <div id="escrever">
                        <a href="./escrever.php"><img src="../img/pena.png" alt="" width="40px"></a>
                    </div>
                    <div id="perfil">
                        <div class="dropdown">
                            <a data-bs-toggle="dropdown" aria-expanded="false" href=""><img src="../img/do-utilizador (1).png" alt="" width="40px"></a>
                                    <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuButton" style="left: auto; right: 0;">
                    
                                        <li><a class="dropdown-item text-danger" href="logout.php">Log-out</a></li>
                                    </ul>
                        </div>
                    </div>
                </div> 
            </div>
        </nav>
    </header>
    
    <div id="content">
        <div id="col-middle">
            <br><br>
            <h2><b>Meu Perfil</b></h2>
            <br>
            <div id="fotodeperfil">
                <img src="<?php echo $Usuario[0]["img"]; ?>" alt="" id="imagePreview">
                <div id="add">
                    <form method="POST" enctype="multipart/form-data">
                        <input type="file" name="nova_imagem" accept=".jpg, .jpeg, .png" onchange="executarFuncoesOnChange(this);">
                        <i id="camera"><p style="text-align: center; font-size: 60px; color: white; margin-right: 3px; margin-top: 5px; cursor: pointer; font-family: Arial, Helvetica, sans-serif;">+</p></i>
                    </div>
                    <button type="submit" class="btn btn-primary" style=" display:block; margin:20px auto; " id="btnAtualizarImagem" disabled>Atualizar Imagem</button>
                </form>
            </div>
            <div id="nome">
                <br><br>
                <p style="font-family: Arial, Helvetica, sans-serif; color: #5153A8;"><?php echo $Usuario[0]["nome"];?></p>
            </div>
            <br>
            <div id="bilhetes">
                <h2><b>Meus Bilhetes</b></h2>
                <?php $resultado = Bilhete::bilhetesUsuario($idUser);
                    
                            if($resultado == []){
                                echo "<p>Não há bilhetes cadastrados";
                            }else{
                                foreach($resultado as $bilhete){?>
                <?php echo"<div id='color-card' style='background-color: ".$bilhete["cor"].";' >";?>
                    <div id="options">
                        <div class="dropdown">
                        <a data-bs-toggle="dropdown" aria-expanded="false" href=""><img src="../img/pontos.png" alt="" width="30px"></a>
                        <form method="POST">
                            <ul class="dropdown-menu">
                                    <?php
                                        echo"<li><a class='dropdown-item text-danger' href='perfil.php?deletarBilhete=".$bilhete["id"]."'>Excluir</a></li>";
                                    ?>
                                </ul>
                            </form>
                        </div>
                    </div>
                    <div id="white-card" style="background-color: white;">
                        <?php
                        echo"<p style='margin: 3px;'>".$bilhete['texto']."</p>";
                        ?>
                    </div>
                    <div id="destinatario" style="margin: auto;" class="text-center">
                        <h6>TO:</h6>
                        <p style="font-family: 'Courier New', Courier, monospace; font-size: 20px;">
                            <?php
                                echo $bilhete['destinatario'];
                            ?>
                        </p></div>
                </div>
            <?php
                    }
                }
            }
            ?>
            </div>
        </div>
    </div>

    <footer>

    </footer>

    <?php
    if (isMetodo("POST")) {
        if (isset($_FILES["nova_imagem"]) && $_FILES["nova_imagem"]["error"] === UPLOAD_ERR_OK) {
            $novaImgNome = $_FILES["nova_imagem"]["name"];
            $novaImgTemp = $_FILES["nova_imagem"]["tmp_name"];
            
            $novoCaminhoDestino = "../arquivos/" . $novaImgNome;
    
            if (move_uploaded_file($novaImgTemp, $novoCaminhoDestino)) {
                // Atualize o caminho da imagem no banco de dados para $novoCaminhoDestino
                $idUser = $_SESSION["idUser"];
                Usuario::atualizarCaminhoImagem($idUser, $novoCaminhoDestino);
    
                // Redirecione para a página de perfil novamente
                header("Location: perfil.php");
                exit; // Encerre o script após o redirecionamento
            } else {
                echo "<p>Ocorreu um erro ao atualizar a imagem.</p>";
            }
        }
    }

    if (isMetodo("GET")){
        if(isset($_GET["deletarBilhete"]) and !empty($_GET["deletarBilhete"])){
            $id = $_GET["deletarBilhete"];
            $idUser = $_SESSION["idUser"];
            Bilhete::deleteById($id, $idUser);
        }
    }
    
    ?>
<script>
function visualizarImagem(input) {
    var imagePreview = document.getElementById("imagePreview");
    
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            imagePreview.src = e.target.result; // Atualiza a origem da imagem de pré-visualização
        };
        
        reader.readAsDataURL(input.files[0]); // Lê o arquivo de imagem selecionado
    } else {
        imagePreview.src = ""; // Limpa a imagem de pré-visualização se nenhum arquivo for selecionado
    }
}

function atualizarBotao(input) {
    var btnAtualizarImagem = document.getElementById("btnAtualizarImagem");
    
    if (input.files && input.files[0]) {
        btnAtualizarImagem.removeAttribute("disabled"); // Habilita o botão se uma imagem for selecionada
    } else {
        btnAtualizarImagem.setAttribute("disabled", "disabled"); // Desabilita o botão se nenhuma imagem for selecionada
    }
}

function executarFuncoesOnChange(input) {
    atualizarBotao(input); // Chama a primeira função que atualiza o estado do botão
    visualizarImagem(input);   // Chama a segunda função que atualiza a pré-visualização da imagem
}
</script>

</body>
</html>
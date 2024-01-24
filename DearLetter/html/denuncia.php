<!DOCTYPE html>
    <?php
    session_start();
    require_once "../model/Denuncia.php";
    require_once "../model/BilheteDenunciado.php";
    require_once "../model/Bilhete.php";
    require_once "../model/Usuario.php";
    require_once "../configs/utils.php";
    require_once "../configs/methods.php";
    require_once "../html/verificadorLogin.php";

    $idBilhete = 0;
    $bilhete = [];

    if (parametrosValidos($_GET, ["idBilhete"])){
        $idBilhete = $_GET["idBilhete"];
        $bilhete = Bilhete::bilheteId($idBilhete);
    }

    
if (isMetodo("POST")) {
    if (parametrosValidos($_POST, ["motivo"])) {
        $idUser = $_SESSION["idUser"];
        $motivo = $_POST["motivo"];

        // Verificar se já existe uma denúncia para esse usuário e bilhete
        if (!Denuncia::existeDenuncia($idUser, $idBilhete)) {
            if (Denuncia::cadastrarDenuncia($idUser, $idBilhete, $motivo)) {
                // Denúncia cadastrada com sucesso
                echo "<div class='alert alert-primary text-center' role='alert'>
                        Sua Denúncia foi cadastrada. 
                        <a href=../html/index.php>Ir para página inicial.</a>
                      </div>";
                      $numDenuncias = Denuncia::quantDenuncia($idBilhete);
                        if(Denuncia::quantDenuncia($idBilhete) == 3){
                            $motivos = Denuncia::getDenunciasMotivo($idBilhete);
                            $motivosString = implode("/", [$motivos[0]["motivo"],$motivos[1]["motivo"],$motivos[2]["motivo"]]);
                            $ids = Denuncia::getDenunciasIdUser($idBilhete);
                  
                            Denuncia::deleteById($ids[0]["idUser"], $idBilhete);
                            Denuncia::deleteById($ids[1]["idUser"], $idBilhete);
                            Denuncia::deleteById($ids[2]["idUser"], $idBilhete);
                  
                            $bilhete = Bilhete::bilheteId($idBilhete);
                  
                            BilheteDenunciado::cadBilheteDenunciado($bilhete[0]["id"],$bilhete[0]["idUser"],$bilhete[0]["texto"],$bilhete[0]["cor"],$bilhete[0]["destinatario"],$bilhete[0]["data"],$bilhete[0]["hora"],$motivosString);
                            Bilhete::removeById($idBilhete);
                        }
                // Restante do código...
            } else {
                // Erro ao cadastrar denúncia
                echo "<div class='alert alert-danger' role='alert'>
                        Sua Denúncia não foi cadastrada. Certifique-se de que não tenha denunciado esse bilhete antes, cada usuário só pode fazer uma denúncia por bilhete.
                      </div>";
            }
        } else {
            // Mensagem informando que o usuário já denunciou esse bilhete
            echo "<div class='alert alert-danger' role='alert'>
                    Você já denunciou esse bilhete anteriormente.
                  </div>";
        }
    } else {
        // Parâmetros de denúncia não encontrados
        echo "<div class='alert alert-danger' role='alert'>Parâmetros de denúncia não encontrados</div>";
    }
}


            ?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/denuncia.css">
    <link rel="shortcut icon" type="imagex/png" href="../img/icon.ico">
    <title>Denúncia</title>
    <style>
        body{
           
            background-color: #EAECF1;
        }
        #textarea{
            display: block;
            margin: auto;
            width: 50%;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-light bg-faded" style="background-color: #98B1ED;">
            <div class="container-fluid">
                <div id="logo">
                    <a class="navbar-brand" href="./index.php">
                        <img src="../img/logo.png" alt="" width="50px">
                    </a>
                </div>
                <div id="nome">
                    <h1 style="font-family: 'Courier New', Courier, monospace; margin: auto;  margin-left: 10px;">Dear Letter</h1>
                </div>
                <div id="buttons">
                    <div id="home">
                        
                    </div>
                    <div id="escrever">
                        
                    </div>
                    <div id="perfil">
                        
                    </div>
                </div> 
            </div>
          </nav>
    </header>
    <br><br>
    <h1 class="display-6 text-danger text-center">Denúncia</h1>

                    <div class="cards">
                        <?php echo "<div id='color-card' style='background-color:".$bilhete[0]["cor"].";'>";?>
                        <div id="options">
                            <div class="dropdown">
                                <a data-bs-toggle='dropdown' aria-expanded='false' href=''><img src='../img/pontos.png' width='30px'></a>
                                <ul class='dropdown-menu'>
                                <li><a class='dropdown-item text-danger' href='#'>Denunciar</a></li>
                                </ul>
                            </div>
                        </div>
                        <div id='white-card' style='background-color: white;'>
                        <?php
                            echo"<p style='margin: 3px;'>".$bilhete[0]['texto']."</p>";
                        ?>
                        </div>
                        <div id='destinatario' style='margin: auto;' class='text-center'>
                            <h6>TO:</h6>
                                
                                <p style="font-family: 'Courier New', Courier, monospace; font-size: 20px;">
                                    <?php
                                    echo $bilhete[0]['destinatario'];
                                    ?>
                                </p>
                                
                        </div>
                    </div>

    <br><br>
    <form method="POST">
        <div class="form-floating " id="textarea">
            <textarea class="form-control" id="floatingTextarea2" style="height: 200px" name="motivo"></textarea>
            <label for="floatingTextarea2">O que aconteceu?</label>
        </div>
        <br><br><br>
        <div class="d-flex justify-content-center align-items-center">
            <button type="submit" class="btn btn-danger " style="height:50px;">Enviar Denúncia</button>
        </div>
    </form>
    <br><br>

</body>
</html>
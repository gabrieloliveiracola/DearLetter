<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="shortcut icon" type="imagex/png" href="../img/icon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <title>Dear Letter</title>
</head>
<body style="background-color: #EAECF1; background-image: url(../img/background.png); background-size: 100% auto;">
    <header>
        <nav class="navbar navbar-light bg-faded" style="background-color: #98B1ED;">
            <div class="container-fluid">
                <div id="logo">
                    <a class="navbar-brand" href="./index.php">
                        <img src="../img/logo.png" alt="" width="50px">
                    </a>
                </div>
                <div id="nome">
                    <h1 style="font-family: 'Courier New', Courier, monospace; margin: auto;  margin-left: 110px;">Dear Letter</h1>
                </div>
                <div id="buttons">
                    <div id="home">
                        <a href="#"><img src="../img/casa (1).png" alt="" width="40px"></a>
                    </div>
                    <div id="escrever">
                        <a href="./escrever.php"><img src="../img/pena.png" alt="" width="40px"></a>
                    </div>
                    <div id="perfil">
                        <div class="dropdown">
                            <a data-bs-toggle="dropdown" aria-expanded="false" href=""><img src="../img/do-utilizador.png" alt="" width="40px"></a>
                                    <ul class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuButton" style="left: auto; right: 0;">
                                        <li><a class="dropdown-item text-primary" href="./perfil.php">Meu Perfil</a></li>
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
            <div id="search">
                <form method="GET">
                    <input type="text" name="destinatario" placeholder="Alguém...">
                    <input type="submit" name="enviar" value="Pesquisar">
                </form>
            </div>
            <div id="cards">
                <br><br><br>

    <?php

        require_once "../model/Bilhete.php";
        require_once "../model/Usuario.php";
        require_once "../configs/utils.php";
        require_once "../configs/methods.php";

        if(isMetodo("GET")){
            if (parametrosValidos($_GET, ["destinatario"])){
                $destinatario = $_GET["destinatario"];
                $resultado = Bilhete::bilhetesDestinatario($destinatario);
                    if($resultado == []){
                    
                            echo "Não há bilhetes cadastrados com este nome";
                    }else{
                    foreach($resultado as $bilhete){?>
                    <?php echo "<div id='color-card' style='background-color:".$bilhete["cor"].";'>";?>
                        <div id="options">
                            <div class="dropdown">
                                <a data-bs-toggle='dropdown' aria-expanded='false' href=''><img src='../img/pontos.png' width='30px'></a>
                                <ul class='dropdown-menu'>
                                <?php
                                    echo"<li><a class='dropdown-item text-danger' href='../html/denuncia.php?idBilhete=".$bilhete["id"]."'>Denunciar</a></li>";
                                ?>
                                </ul>
                            </div>
                        </div>
                        <div id='white-card' style='background-color: white;'>
                        <?php
                            echo"<p style='margin: 3px;'>".$bilhete['texto']."</p>";
                        ?>
                        </div>
                        <div id='destinatario' style='margin: auto;' class='text-center'>
                            <h6>TO:</h6>
                                
                                <p style="font-family: 'Courier New', Courier, monospace; font-size: 20px;">
                                    <?php
                                    echo $bilhete['destinatario'];
                                    ?>
                                </p>
                                
                        </div>
                    </div>
                        <?php
                    }
                }
    ?>                    
                        <?php
            }else{
                $resultado = Bilhete::listarTodos();
        
                if($resultado == []){
                    echo "<p>Não há bilhetes cadastrados";
                }else{
                    foreach($resultado as $bilhete){
                        ?>
                        <?php
                        echo "<div id='color-card' style='background-color:".$bilhete["cor"].";'>";
                        ?>
                            <div id="options">
                                <div class="dropdown">
                                    <a data-bs-toggle='dropdown' aria-expanded='false' href=''><img src='../img/pontos.png' width='30px'></a>
                                    <ul class='dropdown-menu'>
                                    <?php
                                    echo"<li><a class='dropdown-item text-danger' href='../html/denuncia.php?idBilhete=".$bilhete["id"]."'>Denunciar</a></li>";
                                    ?>
                                    </ul>
                                </div>
                            </div>
                            <div id='white-card' style='background-color: white;'>
                            <?php
                                echo"<p style='margin: 3px;'>".$bilhete['texto']."</p>";
                            ?>
                            </div>
                            <div id='destinatario' style='margin: auto;' class='text-center'>
                                <h6>TO:</h6>
                                
                                    <p style="font-family: 'Courier New', Courier, monospace; font-size: 20px;">
                                        <?php
                                        echo $bilhete['destinatario'];
                                        ?>
                                    </p>
                                
                            </div>
                        </div>
                        <?php
                    }
                }
            }
        }
    
    ?>
            </div>
        </div>
    </div>

    <footer>

    </footer>

</body>
</html>
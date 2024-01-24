<?php
require_once __DIR__ . "/../configs/BancoDados.php";

class Usuario
{

    public static function getUsuarios()
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT * FROM usuario");
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function getUsuarioId($idUser)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT * FROM usuario WHERE idUser = ?");
            $stmt->execute([$idUser]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function cadastrar($cpf, $nome, $email, $senha, $img)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("INSERT INTO usuario(cpf, nome, email, senha, img) VALUES (?,?,?,?,?)");

            $senha = password_hash($senha, PASSWORD_BCRYPT);
            $stmt->execute([$cpf, $nome, $email, $senha, $img]);

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function existeUsuarioEmail($email)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT COUNT(*) FROM usuario WHERE email=?");
            $stmt->execute([$email]);

            if ($stmt->fetchColumn() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function existeUsuarioId($idUser)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT COUNT(*) FROM usuario WHERE idUser = ?");
            $stmt->execute([$id]);

            if ($stmt->fetchColumn() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function login($email, $senha)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT * FROM usuario WHERE email = ?");
            $stmt->execute([$email]);
            $resultado = $stmt->fetchAll();

            if (count($resultado) != 1) {
                return false;
            }
            if (password_verify($senha, $resultado[0]["senha"])) {
                return $resultado[0]["idUser"];
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function atualizarCaminhoImagem($idUser, $novoCaminho) {
        // Conecte-se ao banco de dados
        $conexao = Conexao::getConexao();
    
        // Prepare e execute a consulta SQL para atualizar o caminho da imagem
        $sql = "UPDATE usuario SET img = :novoCaminho WHERE idUser = :idUser";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":novoCaminho", $novoCaminho, PDO::PARAM_STR);
        $stmt->bindValue(":idUser", $idUser, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return true; // Sucesso
        } else {
            return false; // Falha
        }
    }
}

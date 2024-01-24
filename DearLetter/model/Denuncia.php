<?php
require_once __DIR__ . "/../configs/BancoDados.php";

class Denuncia
{
    public static function cadastrarDenuncia($idUser, $idBilhete, $motivo)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("INSERT INTO denuncia(idUser, idBilhete, motivo) VALUES (?,?,?)");
            $stmt->execute([$idUser, $idBilhete, $motivo]);
            
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

    public static function quantDenuncia($idBilhete){
        try{
            $conexao = Conexao::getConexao();
            $sql = $conexao->prepare("
                select count(*) from denuncia where idBilhete = ?;
            ");
            $sql->execute([$idBilhete]);
    
            $numDenuncias = $sql->fetchColumn();
            return $numDenuncias;

        }catch(Exception $e){
            echo $e->getMessage();
            exit;
        }
    }

    public static function getDenunciasIdUser($idBilhete)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT idUser FROM denuncia WHERE idBilhete = ?");
            $stmt->execute([$idBilhete]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function getDenunciasMotivo($idBilhete)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT motivo FROM denuncia WHERE idBilhete = ?");
            $stmt->execute([$idBilhete]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function deleteById($idUser, $idBilhete)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("DELETE FROM denuncia WHERE idUser = ? and idBilhete = ?");
            $stmt->execute([$idUser,$idBilhete]);

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

    public static function existeDenuncia($idUser, $idBilhete)
{
    try {
        $conexao = Conexao::getConexao();
        $stmt = $conexao->prepare("SELECT COUNT(*) FROM denuncia WHERE idUser = ? AND idBilhete = ?");
        $stmt->execute([$idUser, $idBilhete]);

        return $stmt->fetchColumn() > 0;
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }
}
}

<?php

require_once __DIR__ . "/../configs/BancoDados.php";

class BilheteDenunciado
{
    public static function cadBilheteDenunciado($idBilhete, $idUser, $texto, $cor, $destinatario, $data, $hora, $motivos)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("INSERT INTO bilheteDenunciado(id, idUser, texto, cor, destinatario, data, hora, motivos) VALUES (?,?,?,?,?,?,?,?)");
            $stmt->execute([$idBilhete, $idUser, $texto, $cor, $destinatario, $data, $hora, $motivos]);
            
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

}
<?php

require_once __DIR__ . "/../configs/BancoDados.php";

class Auditoria
{
    public static function cadastrarAuditoria($ip, $user_agent, $idUser, $data, $hora)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("INSERT INTO auditoria(ip, user_agent, idUser, data, hora) VALUES (?,?,?,?,?)");
            $stmt->execute([$ip, $user_agent, $idUser, $data, $hora]);
            
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
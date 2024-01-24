<?php
require_once __DIR__ . "/../configs/BancoDados.php";

class Bilhete
{
    public static function cadastrar($idUser, $texto, $cor, $destinatario, $data, $hora)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("INSERT INTO bilhete(idUser, texto, cor, destinatario, data, hora) VALUES (?,?,?,?,?,?)");
            $stmt->execute([$idUser, $texto, $cor, $destinatario, $data, $hora]);
            
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
    
    public static function listarTodos(){
        try{
            $conexao = Conexao::getConexao();
            $sql = $conexao->prepare("
                select * from bilhete order by data desc, hora desc;
            ");
            $sql->execute();
    
            return $sql->fetchAll();
        }catch(Exception $e){
            echo $e->getMessage();
            exit;
        }
    }
    
    
        //Listar os bilhetes de um determinado destinatario
        public static function bilhetesDestinatario($destinatario){
            try {
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    SELECT * FROM bilhete WHERE destinatario = ? order by data desc, hora desc;
                ");
                $sql->execute([$destinatario]);
    
                return $sql->fetchAll();
            }catch(Exception $e) {
                echo $e->getMessage();
                exit;
            }
        }
        
    
        //Listar os bilhetes de um determinado usuario
        public static function bilhetesUsuario($idUser){
            try {
                $conexao = Conexao::getConexao();
                $sql = $conexao->prepare("
                    SELECT b.* FROM bilhete b, usuario u WHERE  u.idUser = ? and b.idUser = u.idUser order by data desc, hora desc;
                ");
                $sql->execute([$idUser]);
    
                return $sql->fetchAll();
            }catch(Exception $e) {
                echo $e->getMessage();
                exit;
            }
        }

    public static function deleteById($id, $idUser)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("DELETE FROM bilhete WHERE id = ? AND idUser = ?");
            $stmt->execute([$id, $idUser]);

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

    public static function removeById($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("DELETE FROM bilhete WHERE id = ?" );
            $stmt->execute([$id]);

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

    public static function existeBilhete($id){
        try{
            $conexao = Conexao::getConexao();
            $sql = $conexao->prepare("
                select count(*) from bilhete where id = ?
            ");
            $sql->execute([$id]);

            if($sql->fetchColumn() > 0){
                return true;
            }else{
                return false;
            }
        }catch(Exception $e){
            echo $e->getMessage();
            exit;
        }
    }

    public static function bilheteId($id){
        try {
            $conexao = Conexao::getConexao();
            $sql = $conexao->prepare("
                SELECT * FROM bilhete WHERE id = ?;
            ");
            $sql->execute([$id]);
    
            return $sql->fetchAll();
        }catch(Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
    public static function VerificaPalavroes($texto) {
        // Array em Filtro de Palavrões
        $array = array(
            'arrombado',
            'arrombada',
            'arombado',
            'arombada',
            'buceta',
            'boceta',
            'bucetao',
            'bocetao',
            'bucetaum',
            'bocetaum',
            'bucetinha',
            'bocetinha',
            'blowjob',
            '#@?$%~',
            'caralinho',
            'caralhao',
            'caralhudo',
            'caralhaum',
            'caralho',
            'caralhos',
            'caralhex',
            'cacete',
            'cacetinho',
            'cacetao',
            'cacetaum',
            'epenis',
            'ehpenis',
            'penis',
            'pênis',
            'cu',
            'c*',
            'c*',
            'c*',
            'cuzinho',
            'cúzinho',
            'cuzão',
            'cúzao',
            'cuzudo',
            'cúzudo',
            'cusinho',
            'cúsinho',
            'cúsão',
            'cusão',
            'cúsao',
            'cusao',
            'cusudo',
            'cúsudo',
            'foder',
            'f****',
            'fodase',
            'f***-se',
            'fodasse',
            'f***-sse',
            'fodasi',
            'f***-si',
            'fodassi',
            'f***-ssi',
            'fodassa',
            'f***ça',
            'fodinha',
            'fodao',
            'fodaum',
            'f***',
            'fodona',
            'f***',
            'fude',
            'fode',
            'foder',
            'f****',
            'fodeu',
            'fuckoff',
            'fuckyou',
            'fuck',
            'filhodaputa',
            'filho-da-#@?$%~',
            'fdp',
            'filhadaputa',
            'filha-da-#@?$%~',
            'filho de uma egua',
            'filho de uma égua',
            'filho-de-uma-egua',
            'filho-de-uma-égua',
            'filhodeumaegua',
            'filhodeumaégua',
            'filha de uma egua',
            'filha de uma égua',
            'filha-de-uma-egua',
            'filha-de-uma-égua',
            'filhadeumaegua',
            'filhadeumaégua',
            'gozo',
            'goza',
            'gozar',
            'gozada',
            'gozadanacara',
            'm*****',
            'merda',
            'merdao',
            'merdaum',
            'merdinha',
            'vadia',
            'vasefoder',
            'venhasefoder',
            'voufoder',
            'vasefuder',
            'venhasefuder',
            'voufuder',
            'vaisefoder',
            'vaisefuder',
            'venhasefuder',
            'vaisifude',
            'v****',
            'vaisifuder',
            'vasifuder',
            'vasefuder',
            'vasefoder',
            'pirigueti',
            'piriguete',
            'p****',
            'p****',
            'porra',
            'porraloca',
            'porraloka',
            'porranacara',
            '#@?$%~',
            'putinha',
            'putona',
            'puta',
            'putassa',
            'putao',
            'punheta',
            'putamerda',
            'putaquepariu',
            'putaquemepariu',
            'putaquetepariu',
            'putavadia',
            'pqp',
            'putaqpariu',
            'putaqpario',
            'putaqparil',
            'peido',
            'peidar',
            'xoxota',
            'xota',
            'xoxotinha',
            'xoxotona'
        );
    
        // Divide a string em palavras
        $palavras = preg_split('/\s+/', $texto);
    
        foreach ($palavras as $palavra) {
            // Retira espaços, hífens e pontuações da palavra
            $arrayRemover = array('.', '-', ' ');
            $arrayNormal = array('', '', '');
            $palavraNormalizada = str_replace($arrayRemover, $arrayNormal, $palavra);
    
            // Remove os acentos da palavra
            $de = 'àáãâéêíóõôúüç';
            $para = 'aaaaeeiooouuc';
            $palavraNormalizada = strtr(strtolower($palavraNormalizada), $de, $para);
    
            if (in_array($palavraNormalizada, $array)) {
                return true; // Encontrou um palavrão
            }
        }
    
        return false; // Não encontrou nenhum palavrão
    }
}

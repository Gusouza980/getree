<?php
    require "classes/Url.php";
    $slug_academia = Url::getUrl(0);
    $host = '127.0.0.1';
    $user = 'gefit2';
    $pass = 'Adm77gefit2';
    $dbname = 'gefit2';
    // $user = 'root';
    // $pass = '';
    // $dbname = 'gefit';
    $url = 'https://gefit.com.br/';
    // $url = 'gefit.test/';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    if(isset($_POST["visitante"])){
        echo "entrou 1";
        $visitante = $_POST["visitante"];
        $acesso = $_POST["acesso"];
        if(isset($_POST["elemento"])){
            $elemento = $_POST["elemento"];
            $is_elemento = true;
            $is_rede = false;
        }else{
            $tipo_rede = $_POST["tipo_rede"];
            $is_elemento = false;
            $is_rede = true;
        }

        if($is_elemento){
            echo "entrou 2";
            try{
                $stmt = $pdo->prepare('INSERT INTO getree_clicks (getree_visitante_id, getree_acesso_id, getree_elemento_id, elemento, rede, created_at) 
                                        VALUES(:getree_visitante_id, :getree_acesso_id, :elemento_id, :elemento, :rede, :created_at)');
                $stmt->execute(array(
                    ':getree_visitante_id' => $visitante,
                    ':getree_acesso_id' => $acesso,
                    ':elemento_id' => $elemento,
                    ':elemento' => 1,
                    ':rede' => 0,
                    ':created_at' => date("Y-m-d H:i:s"),
                    
                ));
                var_dump($stmt->errorInfo());
            }catch(PDOException $e){
                var_dump($e);
            }
        }else{
            echo "entrou 3";
            $stmt = $pdo->prepare('INSERT INTO getree_clicks (getree_visitante_id, getree_acesso_id, tipo_rede, elemento, rede, created_at) 
                                    VALUES(:getree_visitante_id, :getree_acesso_id, :tipo_rede, :elemento, :rede, :created_at)');
            $stmt->execute(array(
                ':getree_visitante_id' => $visitante,
                ':getree_acesso_id' => $acesso,
                ':tipo_rede' => $tipo_rede,
                ':elemento' => 0,
                ':rede' => 1,
                ':created_at' => date("Y-m-d H:i:s"),
            ));

            var_dump($stmt->errorInfo());
        }
        
        
    }

?>
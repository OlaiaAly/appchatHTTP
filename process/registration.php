<?php 
include("connection/connect.php");

    if(isset($_POST["username"]) &&  isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["repPassword"])){
         $username = $_POST["username"];
         $password = $_POST["password"];
         $repassoword = $_POST["repPassword"];
         $email = $_POST["email"];

        $checkUserName = $conn->prepare("SELECT `ID` FROM `USER` WHERE (`USERNAME` LIKE ? )");
        $checkUserName->bind_param('s', $username);
        $checkUserName->execute();
        $count = $checkUserName->get_result()->num_rows;

        if($count > 0){
            die(header("HTTP/1.0 401 ERRO Username ja existe!"));
        }

        $checkUserEmail = $conn->prepare("SELECT `ID` FROM `USER` WHERE (`EMAIL` LIKE ? )");
        $checkUserEmail->bind_param('s', $email);
        $checkUserEmail->execute();
        $count = $checkUserEmail->get_result()->num_rows;
        
        if($count > 0){
            die(header("HTTP/1.0 401 ERRO Email ja existe!"));
        }

        if($password != $repassoword){
            die(header("HTTP/1.0 401 ERRO Passwords diferentes!"));
        }

       
        //O METODO ACTULIZA a ENCRITIZACAO AUTOMATICAMENTE
        $password = password_hash($password, PASSWORD_DEFAULT);

        // O METODO CRIA UMA detamanha 20 STRING COMPLETAMENTE ALEATORIA
        $token = bin2hex(openssl_random_pseudo_bytes(20));
        $secure = rand(1000000, 99999999999);
        
        //Inserindo o usuario no DB
        $stmt = $conn->prepare("INSERT INTO `USER` (`USERNAME`, `EMAIL`, `PASSWORD`, `ONLINE`, `TOKEN`, `SECURE`, `CREATION`) 
                                            VALUES (?, ?, ?, NOW(), ?, ?, NOW())"); 
        $stmt->bind_param("ssssi", $username, $email, $password, $token, $secure);
        $stmt->execute();
        $userId = $stmt->insert_id;

        //Fechado a connexao
        $stmt->close();
        $conn->close();
        
        if($stmt && $userId){
            setcookie("ID", $user['id'], time() + (10 * 365 * 24 * 60 * 60));
            setcookie("TOKEN", $token, time() + (10 * 365 * 24 * 60 * 60));
            setcookie("SECURE", $secure, time() + (10 * 365 * 24 * 60 * 60));
        }
        else
            die(header("HTTP/1.0 401 ERRO Ocorreu um erro na base de dados!"));
    }
    else{
       die(header("HTTP/1.0 401 ERRO Preecha os dados do formualario!"));
    }
?>
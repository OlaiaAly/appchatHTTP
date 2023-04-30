<?php
    include('check.php');

    if( isset($_POST['message']) && isset($_POST['id'])){

        $user_id = $_POST['id'];
        $message = $_POST['message'];
        $image = "";
       
        //se nao hover errros na imagem
        if($_FILES['image']['error'] <= 0){
            //retorna a extencao em lowcase
            $imageFileType = strtolower(pathinfo($user_picture,PATHINFO_EXTENSION));
            $image = md5(rand(999, 999999).$_FILES['image']['name'].date(DATE_RFC822)).".".$imageFileType;
            $imagetemp = $_FILES['image']['tmp_name'];
            $imagepath = "../uploads/";

            if(is_uploaded_file($imagetemp)){//Retorna true caso a imagem estaja uploaded
                if(move_uploaded_file($imagetemp, $imagepath.$image)){
                    echo "
                        <script> 
                            Swal.fire({
                                title: 'Erro!',
                                text: 'Imagem carregada com sucesso!',
                                icon: 'success',
                                confirmButtonText: false
                            });
                        </script>";
                }
                else
                    die(header("HTTP/1.0 401 Erro ao guardar imagem!"));
            }
            else
                die(header("HTTP/1.0 401 Erro no upload da imagem!"));

        }
        elseif($message == "" && $user_id == "")
            die(header("HTTP/1.0 401 Escreva uma messagem!"));

           
        $checkConversations = $conn->prepare("SELECT id FROM `CONVERSATIONS` WHERE (`MAINUSER` = ? AND `OTHERUSER` = ?)");
        $checkConversations->bind_param('ii', $uid, $user_id);
        $checkConversations->execute();
        $count = $checkConversations->get_result()->num_rows;
       
 

        if($count < 1){
            //Creado a primeira conversa
            $creatChat = $conn->prepare("INSERT INTO `CONVERSATIONS` (`MAINUSER`, `OTHERUSER`, `UNREAD`,`CREATION`) VALUES (?,?, 'n', NOW())");
            $creatChat->bind_param('ii', $uid, $user_id);
            $creatChat->execute(); 
            $creatChatLastId = $creatChat->insert_id;
            if(!$creatChatLastId)
                die(header("HTTP/1.0 401 Erro ao criar a conversa no emissor!"));

            //Criando a segunda conversa
            $creatChat2 = $conn->prepare("INSERT INTO `CONVERSATIONS` (`MAINUSER`, `OTHERUSER`, `UNREAD`,`CREATION`) VALUES (?,?, 'y', NOW())");
            $creatChat2->bind_param('ii',$user_id,  $uid);
            $creatChat2->execute(); 

            if( !$creatChat || !$creatChat2)
                die(header("HTTP/1.0 401 Ocorreu um erro ao criar a conversa!"));
        }
        else{

            $update = $conn->prepare("UPDATE `conversations` SET `unread` = 'y', `modification` = NOW()  WHERE  (`mainuser` = ? AND `otheruser` = ?)");
            $update->bind_param('ii', $user_id, $uid);
            $update->execute();
            if(!$update)
                die(header("HTTP/1.0 401 Ocorreu um erro ao criar a sua conversa!"));
        }

        //Criando o chat
        $stmt = $conn->prepare("INSERT INTO `chat` (`sender`, `reciever`, `message`,`image`, `creation`) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param('iiss', $uid, $user_id, $message, $image);
        $stmt->execute(); 
        if(!$stmt)
            die(header("HTTP/1.0 401 Ocorreu um erro ao enviar a sua mensagem!!"));
    }
    else
        die(header("HTTP/1.0 401 ERro Faltam Parametros!"));
    


?>